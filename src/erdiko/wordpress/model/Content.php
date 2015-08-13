<?php
/**
 * Wordpress Model
 * Base model every Wordpress model should inherit
 *
 * @category  	erdiko
 * @package   	wordpress
 * @copyright 	Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author		John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\model;

use \Erdiko;


class Content extends Wordpress
{
    /**
     * Generic function call.  Allows you call any drupal api function from the object.
     * example usage: $model->
     */
    public function getAllPosts() {
        // get a list of all posts
        $args = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'category'         => '',
            'category_name'    => '',
            'orderby'          => 'date',
            'order'            => 'ASC',
            'include'          => '',
            'exclude'          => '',
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => 'post',
            'post_mime_type'   => '',
            'post_parent'      => '',
            'author'	   => '',
            'post_status'      => 'publish',
            'suppress_filters' => true
        );
        $posts_array = \get_posts( $args );
        // return lists of posts as an array
        return $posts_array;
    }
    public function getPost($args) {
        global $wpdb;
        $args = rtrim($args,"\/");
        if(strstr($args, '/')){
            // get post based on provided Post URL: year/month/day/post_name
            list($year, $month, $day, $post_name)= explode("/", $args);
            $date = $year.'-'.$month.'-'.$day;
            $sql = "select * from wp_posts where post_date like'".$date."%' and post_name = '".$post_name."' and
            post_status = 'publish' and post_type = 'post'";
        } else {
            // get post based on provided Post ID
            $sql = "select * from wp_posts where ID = '" . $args . "' and
            post_status = 'publish' and post_type = 'post'";
        }
        $data = $wpdb->get_results($sql);
        $newData = $this->wordPressParseData($data);
        return $newData;
    }
    public function getAllPages() {
        // get a list of all pages
        $args = array(
            'sort_order' => 'asc',
            'sort_column' => 'post_title',
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'meta_key' => '',
            'meta_value' => '',
            'authors' => '',
            'child_of' => 0,
            'parent' => -1,
            'exclude_tree' => '',
            'number' => '',
            'offset' => 0,
            'post_type' => 'page',
            'post_status' => 'publish'
        );
        $pages_array = \get_pages($args);
        return $pages_array;
    }
    public function getPage($args) {
        global $wpdb;
        $args = rtrim($args,"\/");
        // get page based on provided Page ID or post_name
        $sql = "select * from wp_posts where (post_name = '".$args."' or ID = '".$args."') and
            post_status = 'publish' and post_type = 'page'";
        $data = $wpdb->get_results($sql);
        $newData = $this->wordPressParseData($data);
        return $newData;
    }
    protected function wordPressParseData($data) {
        $pattern = get_shortcode_regex();
        //\[(\[?)(embed|wp_caption|caption|gallery|playlist|audio|video)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)
        if ( preg_match_all( '/'. $pattern .'/s', $data[0]->post_content, $matches ) && array_key_exists( 2, $matches )){
            for($i = 0; $i< count($matches[2]); $i++){
                $newTag = "";
                switch ($matches[2][$i]) {
                    case 'video':
                        $newTag = $this->wordPressParseVideo($matches,$i);
                        break;
                    case 'audio':
                        $newTag = $this->wordPressParseAudio($matches,$i);
                        break;
                    case 'playlist':
                        $newTag = $this->wordPressParsePlaylist($matches,$i);
                        break;
                    case 'gallery':
                        $newTag = $this->wordPressParseGallery($matches,$i);
                        break;
                    case 'caption':
                        $newTag = $this->wordPressParseCaption($matches,$i);
                        break;
                    case 'embed':
                        $newTag = $this->wordPressParseEmbed($matches,$i);
                        break;
                    default:
                        echo '';
                }
                if($newTag!="")
                    $data[0]->post_content = str_replace($matches[0][$i], $newTag, $data[0]->post_content);
            }
        }
        return $data;
    }
    protected function wordPressParseVideo($matches, $i){
        //video
        list($width, $height, $typeURL) = explode(" ", trim($matches[3][$i]));
        list($type, $url) = explode("=", $typeURL);
        $newTag = Erdiko::getView('video', array('width' => $width, 'height' => $height,
            'url' => $url, 'type' => $type), dirname(__DIR__));
        return $newTag;
    }
    protected function wordPressParseAudio($matches, $i){
        //audio
        list($type, $url) = explode("=", trim($matches[3][$i]));
        $newTag = Erdiko::getView('audio', array('url' => $url, 'type' => $type), dirname(__DIR__));
        return $newTag;
    }
    protected function wordPressParsePlaylist($matches,$i){
        if(strpos($matches[3][$i], 'type="video"')!= false) {
            //video playlist
            preg_match_all('!\d+!', $matches[3][$i], $itemIDs);
            $videoItem = "";
            foreach($itemIDs[0] as $id){
                $videoItem .= Erdiko::getView('playlistItem', array('url' => wp_prepare_attachment_for_js($id)['url'],
                    'name' => wp_prepare_attachment_for_js($id)['name']), dirname(__DIR__));
            }
            $newTag = Erdiko::getView('playlistVideo', array('videoItem' => $videoItem), dirname(__DIR__));
        } else {
            //audio playlist
            preg_match_all('!\d+!', $matches[3][$i], $itemIDs);
            $audioItem = "";
            foreach($itemIDs[0] as $id){
                $audioItem .= Erdiko::getView('playlistItem', array('url' => wp_prepare_attachment_for_js($id)['url'],
                    'name' => wp_prepare_attachment_for_js($id)['name']), dirname(__DIR__));
            }
            $newTag = Erdiko::getView('playlistAudio', array('audioItem' => $audioItem), dirname(__DIR__));
        }
        return $newTag;
    }
    protected function wordPressParseGallery($matches,$i){
        //image gallery
        list($type, $ids)= explode("=", $matches[3][$i]);
        preg_match_all('!\d+!', $ids, $imgIDs);
        $imgItem = "";
        foreach ($imgIDs[0] as $id) {
            $imgItem .= Erdiko::getView('imgGalleryItem', array('url' => wp_get_attachment_link($id),
                'caption' => wp_prepare_attachment_for_js($id)['caption']), dirname(__DIR__));
        }
        $newTag = Erdiko::getView('imgGalleryCarousel', array('imgItem' => $imgItem), dirname(__DIR__));
        return $newTag;
    }
    protected function wordPressParseCaption($matches,$i){
        //image caption
        $caption = end(explode(" ", $matches[5][$i]));
        preg_match_all('/<(.*?)>/s', $matches[5][$i], $imgURL);
        $newTag = Erdiko::getView('imgCaption', array('url' => $imgURL[0][1],
            'caption' => $caption), dirname(__DIR__));
        return $newTag;
    }
    protected function wordPressParseEmbed($matches,$i){
        if (strpos($matches[5][$i], 'youtube') > 0) {
            //youtube
            preg_match("/v=([^&]+)/i", $matches[5][$i], $id);
            $newTag = Erdiko::getView('embedYoutube', array('url' => $id[1],
                'size' => $matches[3][$i]), dirname(__DIR__));
        } else if (strpos($matches[5][$i], 'vimeo') > 0){
            //vimeo
            preg_match("/^.*\/(.*)$/", $matches[5][$i], $id);
            $newTag = Erdiko::getView('embedVimeo', array('url' => $id[1],
                'size' => $matches[3][$i]), dirname(__DIR__));
        } else if (strpos(get_headers($matches[5][$i])[8], 'audio') > 0){
            //Content-Type: audio/
            preg_match("/^.*\/(.*)$/", get_headers($matches[5][$i])[8], $type);
            $newTag = Erdiko::getView('audio', array('url' => $matches[5][$i], 'type' => $type[1]), dirname(__DIR__));
        } else {
            $newTag = "";
        }
        return $newTag;
    }
}