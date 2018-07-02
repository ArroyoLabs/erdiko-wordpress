<?php
/**
 * WordPress Author model
 *
 * @package   	erdiko\wordpress\models
 * @copyright 	Copyright (c) 2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author		John Arroyo <john@arroyolabs.com>
 */
namespace erdiko\wordpress\models;


class Author extends \erdiko\wordpress\Model
    implements \erdiko\wordpress\AuthorInterface
{
    /**
     * get path for views
     */
    public function getViewPath()
    {
        return dirname(__DIR__);
    }

    public function getGravitarUrl($user, $size)
    {
        return "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->user_email ) ) ) .
            "?d=" . urlencode( getenv("WORDPRESS_DEFAULT_USER_IMG") ) . "&s=" . $size;
    }

    public function getAuthor($name, $size = 200)
    {
        $user = get_user_by('slug', $name);
        $meta = get_user_meta($user->ID);
        $gravitar = $this->getGravitarUrl($user, $size);

        return (object)['user' => $user, 'meta' => $meta, 'gravitar' => $gravitar];
    }
}
