<?php
/**
 * WordPress Bookmarks Model
 * https://developer.wordpress.org/reference/functions/get_bookmarks/
 *
 * @package     erdiko\wordpress\models
 * @copyright   Copyright (c) 2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author	    John Arroyo <john@arroyolabs.com>
 */
namespace erdiko\wordpress\models;


class Bookmarks extends \erdiko\wordpress\Model
    implements \erdiko\wordpress\AuthorInterface
{
    /**
     * Get bookmarks
     * Wrapper for get_bookmarks
     * https://developer.wordpress.org/reference/functions/get_bookmarks/
     *
     * @return array $bookmarks
     */
    public function getBookmarks($args = array())
    {
        return \get_bookmarks( $args );
    }

    /**
     * Get bookmarks by category
     * Convenience function to get bookmarks by category
     *
     * @return array $bookmarks
     */
    public function getBookmarksByCategory($category, $limit = -1, $orderBy = 'name', $order = 'DESC')
    {
        $args = array(
            'orderby'           => $orderBy,
            'order'             => $order,
            'limit'             => $limit,
            'category_name'     => $category
            );

        return $this->getBookmarks($args);
    }
}
