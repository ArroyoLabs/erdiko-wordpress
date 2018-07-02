<?php
/**
 * Wordpress Content Helper
 * Helper methods to aid in theming
 *
 * @package     erdiko\wordpress\helpers
 * @copyright 	Copyright (c) 2018 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author      John Arroyo <john@arroyolabs.com>
 */
namespace erdiko\wordpress\helpers;

class Content
{
    /**
     * Get author meta data
     */
    public static function getAuthorData($api, $post) 
    {
        $author = array();
        if( !empty( $post->_links->author[0]->href ) ) {
            $author = $api->get( $post->_links->author[0]->href, false );
        }

        return $author;
    }

    /**
     * 
     */
    public static function getTermData($api, $post)
    {
        $terms = array();

        foreach( $post->_links->{'wp:term'} as $idx => $term) {
            // Get term data
            $response = $api->get( $term->href, false );
            $terms[] = $response;
        }

        return $terms;
    }

    /**
     * Get the featured image associated to the post
     */
    public static function getFeatImage($api, $post)
    {
        $image = array();
        if( !empty( $post->_links->{'wp:featuredmedia'}[0]->href ) ) {
            $image = $api->get( $post->_links->{'wp:featuredmedia'}[0]->href, false );
        }

        return $image;
    }

    /**
     * Get rendered category links
     *
     * @param string $html
     */
    public static function getCategoryHtml($api, $post, $urlPath="/post/category")
    {
        $categories = array();
        $html = "";

        if( !empty( $post->categories ) ) {
            $requestUrl = $post->_links->{'wp:term'}[0]->href;
            $response = $api->get( $requestUrl, false );
        }

        foreach($response as $idx => $category)
        {
            $html .= "<a href=\"{$urlPath}/{$category->slug}\">{$category->name}</a>";
            if($idx < (count( $response ) - 1)) {
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
    public static function getTagHtml($api, $post, $path="/post/tag")
    {
        $html = "";

        if( !empty( $post->tags ) ) {
            $requestUrl = $post->_links->{'wp:term'}[0]->href;
            $response = $api->get( $requestUrl, false );
        }

        foreach($post->tags as $idx => $tag)
        {
            $html .= "<a href=\"{$path}/{$tag->slug}\">{$tag->name}</a>";
            if($idx < (count( $post->tags ) - 1)) {
                $html .= ", ";
            }
        }

        return $html;
    }
}
