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
namespace erdiko\wordpress;
require_once __DIR__."/bootstrap.php";

use \Erdiko;

class Model extends \erdiko\core\ModelAbstract
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

	public function print_post()
	{
		$post = \get_post(1); 
		$title = $post->post_title;

		return $post;
	}
}