<?php
/**
 * WordPress Content Model
 * Service model to query content from wordpress and render/theme that content
 *
 * @package     erdiko\wordpress\models
 * @copyright 	Copyright (c) 2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author      John Arroyo <john@arroyolabs.com>
 */
namespace erdiko\wordpress\models;

use \erdiko\Helper as Erdiko;

class Content extends \erdiko\wordpress\Model
{
    public $defaultFeatImg = '/themes/clean-blog/img/post-bg.jpg';

    /**
     * Get posts list
     */
    public function getPosts($args)
    {
        $posts = \get_posts( $args );

        return $posts;
    }

    /**
     * Get posts list
     * @deprecated
     */
    public function getAllPosts($postType = 'post', $pageSize = 10, $offset = 0, $category = '', $tag = '')
    {
        $args = array(
            'numberposts'   => $pageSize,
            'offset'           => $offset,
            'category'         => '',
            'category_name'    => $category,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'include'          => '',
            'exclude'          => '',
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => $postType,
            'post_mime_type'   => '',
            'post_parent'      => '',
            'author'	       => '',
            'post_status'      => 'publish',
            'suppress_filters' => true,
        );
        $posts_array = \get_posts( $args );
        // error_log("posts: ".print_r($posts_array, true));

        return $posts_array;
    }

    /**
     * Get posts list
     */
    public function getPostsByTag($pageSize = -1, $offset = 0, $tag = '', $taxonomy = 'post_tag')
    {
        $args = array(
            'posts_per_page'   => $pageSize,
            'offset'           => $offset,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'tax_query' => array(
              array(
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $tag,
              ),
            ),
        );
        $posts_array = \get_posts( $args );
        return $posts_array;
    }

    public function getPostThemed($args, $renderWP = false)
    {
        $post = $this->getPost($args, $renderWP);
    }

    public function getPost404()
    {
      return (object)['post_title' => '404', 'post_content' => "<p>Sorry, page not found :-(</p>", 'post_type' => "none"];
    }

    public function getCategories($postId)
    {
        $categories = \get_the_category($postId);
        return empty($categories) ? array() : $categories;
    }

    public function getTags($postId)
    {
        $tags = \get_the_tags($postId);
        return empty($tags) ? array() : $tags;
    }

    public function getCustomFields($postId)
    {
        return \get_post_custom($postId);
    }

    /**
     * Get post/page content
     *
     * @param Post id || Post URL: year/month/day/post_name
     */
    public function getPost($args, $renderWP = false)
    {
        // global $wpdb;
        $args = rtrim($args,"\/");

        // Determine the post id
        if(is_numeric($args))
          $postId = $args;
        else
          $postId = \url_to_postid($args);

        $post = \get_post($postId);

        if(empty($post)) {
          $post = $this->getPost404();
        } else {
          // Decorate basic post with additional post data
          $post->feat_image = $this->getFeaturedImage($postId);
          $post->categories = $this->getCategories($postId);
          $post->tags = $this->getTags($postId);
          $post->author = $this->getAuthorShort($post->post_author);
          $post->custom_fields = get_post_custom($postId);
          // $post->custom_fields = $this->getCustomFields($postId);
        }

        return $post;
    }

    /**
     * Get the featured image for a post
     * @param int $postId
     * @param boolean $useDefault if true return default image if none found
     * @return string $imageUrl
     */
    public function getFeaturedImage($postId, $useDefault = true)
    {
        $featImg = \wp_get_attachment_url( \get_post_thumbnail_id($postId) );
        if(empty($featImg) && $useDefault)
            $featImg = $this->defaultFeatImg;

        return $featImg;
    }

    /**
     * getMeta
     * Get SEO meta tags for the html page header
     * @param $post
     * @param array $additional, additional meta tags (takes precedence over $post)
     * @return array $meta
     */
    public function getMeta($post, $additional=array())
    {
        if(!is_array($additional))
          throw new \Exception("Error in Content::getMeta(), additional meta tags must be an array");

        // Get description
        if(!empty($post->post_excerpt))
            $description = $post->post_excerpt;
        elseif(!empty($post->custom_fields['erdiko_seo_description'][0]))
            $description = $post->custom_fields['erdiko_seo_description'][0];
        else
            $description = $post->post_title;

        // Get formatted post dates
        $postDate = date('c', strtotime($post->post_date));
        $updateDate = date('c', strtotime($post->post_modified));

        // Description & author
        $meta['description'] = $description;
        $meta['author'] = $post->author->display_name;

        // Open Graph
        // $meta['og:locale'] = 'en_US'; // coming from application.json now
        $meta['og:type'] = 'blog';
        $meta['og:title'] = $post->post_title;
        $meta['og:description'] = $description;
        // @todo remove 'http://' and set dynamically somehow
        $meta['og:url'] = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $meta['og:updated_time'] = $updateDate;
        $meta['og:image'] = $post->feat_image;

        // Article
        // $meta['article:publisher'] = "https://www.facebook.com/yoast";
        // $meta['article:author'] = "https://www.facebook.com/jdevalk";
        $meta['article:section'] = 'Blog';
        $meta['article:published_time'] = $postDate;
        $meta['article:modified_time'] = $updateDate;

        // Article Tags
        $tags = array();
	    if(!empty($post->tags)) {
		    foreach ( $post->tags as $tag ) {
			    $tags[] = $tag->name;
		    } // $tag->slug
		    if ( count( $tags ) > 0 ) {
			    $meta['article:tag'] = $tags;
		    }
	    }

        // Twitter Card
        $meta['twitter:card'] = "summary_large_image";
        $meta['twitter:description'] = $description;
        $meta['twitter:title'] = $post->post_title;
        $meta['twitter:image'] = $post->feat_image;
        // $meta['twitter:creator'] = "@erdiko";

        // Override any default meta values (from post) with $additional meta supplied
        if(!empty($additional))
            $meta = array_merge($meta, $additional);

        return $meta;
    }

    /**
     * Return a safer (themable) version of the user object
     * @param int $userId
     * @return array $shortProfile, abbreviated user profile
     */
    public function getAuthorShort($id)
    {
      $author = \get_user_by('ID', $id);
      $shortProfile = (object)array(
        "id" => $author->ID,
        "user_nicename" => $author->user_nicename,
        "display_name"  => $author->display_name,
        "profile_url"   => "/author/".$author->user_nicename
        );

      return $shortProfile;
    }

    /**
     * Get post directly from the db (via SQL)
     */
    public function getPostDirect($postId)
    {
        $sql = "select * from wp_posts where ID = '" . $postId . "' and
        post_status = 'publish'";
        $data = $wpdb->get_results($sql);

        return $data[0];
    }

    /**
     * Get pages list
     */
    public function getAllPages()
    {
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

    /**
     * Get page content
     *
     * @param Page id || Page post_name
     */
    public function getPage($args)
    {
        global $wpdb;
        $args = rtrim($args,"\/");
        // get page based on provided Page ID or post_name
        $sql = "select * from wp_posts where (post_name = '".$args."' or ID = '".$args."') and
            post_status = 'publish' and post_type = 'page'";
        $data = $wpdb->get_results($sql);
        $newData = $this->themeData($data);
        return $newData;
    }

    /**
     * Get rendered category links
     *
     * @param string $html
     */
    public function getCategoryLinks($post, $path="/category")
    {
        $html = "";

        foreach($post->categories as $idx => $category)
        {
            $html .= "<a href=\"{$path}/{$category->slug}\">{$category->name}</a>";
            if($idx < (count($post->categories) - 1)) {
                $html .= ", ";
            }
        }

        return $html;
    }

    /**
     * Get rendered tag links
     *
     * @param string $html
     */
    public function getTagLinks($post, $path="/tag")
    {
        $html = "";

        foreach($post->tags as $idx => $tag)
        {
            $html .= "<a href=\"{$path}/{$tag->slug}\">{$tag->name}</a>";
            if($idx < (count($post->tags) - 1)) {
                $html .= ", ";
            }
        }

        return $html;
    }

    /**
     * Theme wordpress media content
     *
     * @param object $postContent
     * @param boolean $useWpTheme, true to use WP theme functions, false to use erdiko (recommended)
     * @return mixed $themedPostContent
     */
    public function themeData($data, $useWpTheme = false)
    {
        $pattern = \get_shortcode_regex();
        // echo "<pre>".var_dump($pattern)."</pre>";

        // $data[0]->post_content = \apply_filters('the_content', $data[0]->post_content);

        if($useWpTheme) {
          // bypass erdiko theme and use the built in WP theming templates
          $data->post_content = \apply_filters('the_content', $data->post_content);

        }  else {
          if ( preg_match_all( '/'. $pattern .'/s', $data->post_content, $matches ) && array_key_exists( 2, $matches )) {
            for($i = 0; $i< count($matches[2]); $i++) {
                $newTag = "";
                switch ($matches[2][$i]) {
                    case 'video':
                        $newTag = $this->themeVideo($matches,$i);
                        break;
                    case 'audio':
                        $newTag = $this->themeAudio($matches,$i);
                        break;
                    case 'playlist':
                        $newTag = $this->themePlaylist($matches,$i);
                        break;
                    case 'gallery':
                        $newTag = $this->themeGallery($matches,$i);
                        break;
                    case 'caption':
                        $newTag = $this->themeImage($matches,$i);
                        break;
                    case 'wp_caption':
                        $newTag = $this->themeImage($matches,$i);
                        break;
                    case 'embed':
                        $newTag = $this->themeEmbed($matches,$i);
                        break;
                    default:
                        echo ''; // @note why?
                }
                if($newTag!="")
                    $data->post_content = str_replace($matches[0][$i], $newTag, $data->post_content);
            }
          }
        }

        // This adds additional styling by WordPress (mostly P tags to space out elements/images)
        $data->post_content = \apply_filters('the_content', $data->post_content);

        return $data;
    }

    /**
     * Parse and theme wordpress image caption
     *
     * @param post content
     * @param index
     * @todo clean up: why are we sending all the matches?
     */
    public function themeImage($matches, $i)
    {
        // Strip out image and caption
        $original = $matches[5][$i];
        preg_match_all('/(\<img.*?\/\>)/s', $matches[5][$i], $imgURL);
        preg_match_all('/(?!.*\>)(.*)/s', $matches[5][$i], $caption);

        // echo "<pre>original({$i}): ".print_r($matches[5][$i], true)."</pre>";
        // echo "<pre>parsed({$i}): ".print_r($imgURL, true)."</pre>";
        // echo "<pre>caption({$i}): ".print_r($caption, true)."</pre>";

        $newTag = Erdiko::getView('image_w_caption', array('url' => $imgURL[0][0],
            'caption' => $caption[0][0]), $this->getViewPath());
        return $newTag;
    }

    /**
     * Parse wordpress video
     *
     * @param post content
     * @param index
     */
    public function themeVideo($matches, $i)
    {
        //video
        list($width, $height, $typeURL) = explode(" ", trim($matches[3][$i]));
        list($type, $url) = explode("=", $typeURL);
        $newTag = Erdiko::getView('video', array('width' => $width, 'height' => $height,
            'url' => $url, 'type' => $type), $this->getViewPath());
        return $newTag;
    }

    /**
     * Parse wordpress audio
     *
     * @param post content
     * @param index
     */
    public function themeAudio($matches, $i)
    {
        //audio
        list($type, $url) = explode("=", trim($matches[3][$i]));
        $newTag = Erdiko::getView('audio', array('url' => $url, 'type' => $type), $this->getViewPath());
        return $newTag;
    }

    /**
     * Parse wordpress audio|| video playlist
     *
     * @param post content
     * @param index
     */
    public function themePlaylist($matches, $i)
    {
        if(strpos($matches[3][$i], 'type="video"')!= false) {
            //video playlist
            preg_match_all('!\d+!', $matches[3][$i], $itemIDs);
            $videoItems = "";
            foreach($itemIDs[0] as $id){
                $videoItems .= Erdiko::getView('playlist_item', array('url' => wp_prepare_attachment_for_js($id)['url'],
                    'name' => wp_prepare_attachment_for_js($id)['name']), $this->getViewPath());
            }
            $newTag = Erdiko::getView('playlist_video', array('video_items' => $videoItems), $this->getViewPath());
        } else {
            //audio playlist
            preg_match_all('!\d+!', $matches[3][$i], $itemIDs);
            $audioItems = "";
            foreach($itemIDs[0] as $id) {
                $audioItems .= Erdiko::getView('playlist_item', array('url' => wp_prepare_attachment_for_js($id)['url'],
                    'name' => wp_prepare_attachment_for_js($id)['name']), $this->getViewPath());
            }
            $newTag = Erdiko::getView('playlist_audio', array('audio_items' => $audioItems), $this->getViewPath());
        }
        return $newTag;
    }

    /**
     * Parse wordpress image gallery
     *
     * @param post content
     * @param index
     */
    public function themeGallery($matches, $i)
    {
        list($type, $ids)= explode("=", $matches[3][$i]);
        preg_match_all('!\d+!', $ids, $imgIDs);
        $imgItem = "";
        $imgIndicators = "";
        $ct = 0;
        foreach ($imgIDs[0] as $id) {
            $imgItem .= Erdiko::getView('gallery_carousel_item', array(
              'url' => \wp_get_attachment_url($id),
              'caption' => \wp_prepare_attachment_for_js($id)['caption'],
              'count' => $ct
              ), $this->getViewPath());
            $imgIndicators .= Erdiko::getView('gallery_carousel_indicator', array('count' => $ct), $this->getViewPath());
            $ct++;
        }
        $newTag = Erdiko::getView('gallery_carousel', array('image_items' => $imgItem, 'image_indicators' => $imgIndicators), $this->getViewPath());
        return $newTag;
    }

    /**
     * Parse wordpress video embed from youtube & vimeo, audio embed
     *
     * @param post content
     * @param index
     */
    public function themeEmbed($matches, $i)
    {
        if (strpos($matches[5][$i], 'youtube') > 0) {
            //youtube
            preg_match("/v=([^&]+)/i", $matches[5][$i], $id);
            $newTag = Erdiko::getView('embed_youtube', array('url' => $id[1],
                'size' => $matches[3][$i]), $this->getViewPath());
        } else if (strpos($matches[5][$i], 'vimeo') > 0){
            //vimeo
            preg_match("/^.*\/(.*)$/", $matches[5][$i], $id);
            $newTag = Erdiko::getView('embed_vimeo', array('url' => $id[1],
                'size' => $matches[3][$i]), $this->getViewPath());
        } else if (strpos(get_headers($matches[5][$i])[8], 'audio') > 0){
            //Content-Type: audio/
            preg_match("/^.*\/(.*)$/", get_headers($matches[5][$i])[8], $type);
            $newTag = Erdiko::getView('audio', array('url' => $matches[5][$i], 'type' => $type[1]), $this->getViewPath());
        } else {
            $newTag = "";
        }
        return $newTag;
    }

    public function getOffset($page, $pagesize)
    {
        if(empty($page))
            return 0;

        return $page * $pagesize - $pagesize;
    }

    /**
     * Get pagination data
     * @return array $pager
     */
    public function getPagerData($defaultPagesize = 10)
    {
        $pager = array();
        $pager['pagesize'] = empty($_REQUEST['pagesize'])
            ? $defaultPagesize : $_REQUEST['pagesize'];
        $pager['page'] = empty($_REQUEST['page']) ? 1 : $_REQUEST['page'];
        $pager['offset'] = $pager['page'] * $pager['pagesize'] - $pager['pagesize'];

        return $pager;
    }

    /**
     * Get pager
     */
    public function getPager(int $defaultPagesize = 10, int $count = 0)
    {
        $pagerData = $this->getPagerData($defaultPagesize);

        // Get number of pages
        $pages = ceil($count / $pagerData['pagesize']);

        // Get previous and next
        $previous  = (($pagerData['page'] - 1) < 1) ? null : $pagerData['page'] - 1;
        $next = ($pagerData['page'] == $pages) ? null : $pagerData['page'] + 1;

        return array(
            'pagesize' => $pagerData['pagesize'],
            'page' => $pagerData['page'],
            'pages' => $pages,
            'previous' => $previous,
            'next' => $next,
            'count' => $count,
            'offset' => $pagerData['offset'],
            'url' => explode("?", $_SERVER['REQUEST_URI'])[0]
            );
    }

    /**
     * Get pagination data
     * @return array $pager
     */
    public function getPagination($defaultPagesize = 10, $category=null)
    {
        $pager = array();

        $pager['pagesize'] = empty($_REQUEST['pagesize']) ?
            $defaultPagesize : $_REQUEST['pagesize'];
        $pager['page'] = empty($_REQUEST['page']) ? 1 : $_REQUEST['page'];
        $pager['offset'] = $pager['page'] * $pager['pagesize'] - $pager['pagesize'];
        $pager['pagination'] = $this->getPaginationData($pager['pagesize'], $pager['page']);

        return $pager;
    }

    public function getPostCount()
    {
        $countPosts = \wp_count_posts();
        return $countPosts->publish;
    }

    public function getCategoryCount($category, $catType = 'category')
    {
        $term = \get_term_by('slug', $category, $catType);
        return $term->count;
    }

    public function getTagCount($tag, $tagType = 'post_tag')
    {
        $term = \get_term_by('slug', $tag, $tagType);
        return $term->count;
    }
}
