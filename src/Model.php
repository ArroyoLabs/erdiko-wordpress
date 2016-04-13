<?php
/**
 * Wordpress Model
 * Base model every Wordpress model should inherit
 * 
 * @category  	erdiko
 * @package   	wordpress
 * @copyright 	Copyright (c) 2016, Arroyo Labs, http://www.arroyolabs.com
 * @author		John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress;
require_once __DIR__."/bootstrap.php";

use \Erdiko;

class Model
{	
	/** 
	 * Generic function call.  Allows you call any WordPress api function from the object.
	 * example usage: $model->get_post($id)
	 */
	public function __call ( $wordpressFunction, $arguments = array() )
	{
		$wordpressFunction += "\\";
		return call_user_func_array($wordpressFunction, $arguments);
	}

	/**
	 * This is a hello world type example
	 * 
	 */
	public function getPost($id)
	{
		$post = \get_post($id);
		// $title = $post->post_title;

		return $post;
	}
}