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
require_once dirname(__DIR__)."/bootstrap.php";

use \Erdiko;


class Wordpress extends \erdiko\core\ModelAbstract
{
    /**
     * Generic function call.  Allows you call any drupal api function from the object.
     * example usage: $model->
     */
    public function __call ( $wordpressFunction, $arguments = array() )
    {
        $wordpressFunction += "\\";
        return call_user_func_array($wordpressFunction, $arguments);
    }

    /**
     * print_post example
     */
    public function print_post()
    {
        $post = \get_post(4);
        $title = $post->post_title;

        return $post;
    }
}