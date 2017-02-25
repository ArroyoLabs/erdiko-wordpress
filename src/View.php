<?php
/**
 * View
 * Convenient functions for manipulating WordPress data in erdiko views
 *
 * @package    erdiko/wordpress
 * @copyright  Copyright (c) 2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author     John Arroyo <john@arroyolabs.com>
 */
namespace erdiko\wordpress;
require_once __DIR__."/bootstrap.php";


class View extends \erdiko\core\View
{
    use \erdiko\wordpress\traits\ImageTrait;

    /**
     * Get rendered category links
     *
     * @param string $html
     */
    public function getCategoryLinks($post)
    {
        $html = "";

        foreach($post->categories as $idx => $category)
        {
            $html .= "<a href=\"/category/{$category->slug}\">{$category->name}</a>";
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
    public function getTagLinks($post)
    {
        $html = "";

        foreach($post->tags as $idx => $tag)
        {
            $html .= "<a href=\"/tag/{$tag->slug}\">{$tag->name}</a>";
            if($idx < (count($post->tags) - 1)) {
                $html .= ", ";
            }
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
