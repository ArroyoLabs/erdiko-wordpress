<?php
/**
 * Wordpress Author model
 *
 * @package   	erdiko/wordpress/models
 * @copyright 	Copyright (c) 2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author		John Arroyo <john@arroyolabs.com>
 */
namespace erdiko\wordpress\models;


class Author extends \erdiko\wordpress\Model
{
    /**
     * get path for views
     */
    public function getViewPath()
    {
        return dirname(__DIR__);
    }

    public function getGravitarUrl($user, $size = 100)
    {
        $default = "http://www.somewhere.com/homestar.jpg"; // @todo put this somewhere
        return "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->user_email ) ) ) . 
            "?d=" . urlencode( $default ) . "&s=" . $size;
    }

    public function getAuthor($name)
    {
        $user = get_user_by('slug', $name);
        $meta = get_user_meta($user->ID);
        $gravitar = $this->getGravitarUrl($user);

        return (object)['user' => $user, 'meta' => $meta, 'gravitar' => $gravitar];
    }
}
