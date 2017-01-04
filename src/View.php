<?php
/**
 * View
 * Convenient functions for manipulating WordPress data in erdiko views
 *
 * @category   Erdiko
 * @package    WordPress
 * @copyright  Copyright (c) 2017, Arroyo Labs, http://www.arroyolabs.com
 * @author     John Arroyo
 */
namespace erdiko\wordpress;
require_once __DIR__."/bootstrap.php";


class View extends \erdiko\core\View
{
    /**
     * Get rendered category links
     *
     * @param string $html
     */
    public function getCategoryLinks($post)
    {
        $html = "";
        // $html = "<pre>".print_r($post->categories, true)."</pre>";

        foreach($post->categories as $category)
        {
            $html .= "<a href=\"/category/{$category->slug}\">{$category->name}</a> ";
        }

        return $html;
    }

    /**
     * Get rendered tag links
     * 
     * @param string $html
     */
    public function getTagLinks($post)
    {
        $html = "";

        foreach($post->tags as $tag)
        {
            $html .= "<a href=\"/tag/{$tag->slug}\">{$tag->name}</a> ";
        }

        return $html;
    }

    /**
     * Get excert of the body html
     * 
     * @param string $body
     * @param int $length
     */
    public function getBodyExcerpt($body, $length = 255)
    {
        $post = strip_tags($body);

        // old method
        // $post = preg_replace("/(\[.*\])/","",$body);
        // $post = preg_replace("/(\<img.*\>)/","",$post);
        return substr($post, 0, $length);
    }

    /**
     *
     */
    public function getPostThumbnail($postId)
    {
        return \wp_get_attachment_url( \get_post_thumbnail_id($postId) );
    }

    /**
     * Get headless friendly permalink
     * @param int $postId
     * @return string $link
     */
    function getHeadlessPermalink($postId)
    {
        $url = get_permalink($postId);
        return str_replace( home_url(), "", $url ); // strip domain (since it's headless)
    }
}