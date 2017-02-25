<?php
/**
 * Bookmarks Model
 * 
 * @package   	erdiko/wordpress/models
 * @copyright 	Copyright (c) 2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author		  John Arroyo <john@arroyolabs.com>
 */
namespace erdiko\wordpress\models;

use \erdiko\core\Helper as Erdiko;

class Bookmarks extends \erdiko\wordpress\Model
{
    /**
     * get path for views
     */
    public function getViewPath()
    {
        return dirname(__DIR__);
    }

    /**
     * Get bookmarks
     * Wrapper for get_bookmarks
     * https://developer.wordpress.org/reference/functions/get_bookmarks/
     */
    public function getBookmarks($args = null)
    {
        if($args == null) {
            $args = array();
        }

        $bookmarks = \get_bookmarks( $args );
        return $bookmarks;
    }

    /**
     * Get bookmarks by category
     * Convenience function to get bookmarks by category
     */
    public function getBookmarksByCategory($category, $limit = -1, $orderBy = 'name', $order = 'DESC')
    {
        $args = array(
            'orderby'           => $orderBy,
            'order'             => $order,
            'limit'             => $limit,
            'category_name'     => $category,
            'hide_invisible'    => 1
            );

        $bookmarks = \get_bookmarks( $args );
        return $bookmarks;
    }
}