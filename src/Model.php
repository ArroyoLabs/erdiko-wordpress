<?php
/**
 * Wordpress Model
 * Base model every Wordpress model should inherit
 *
 * @category  	erdiko
 * @package   	wordpress
 * @copyright 	Copyright (c) 2017, Arroyo Labs, http://www.arroyolabs.com
 * @author		John Arroyo, john@arroyolabs.com
 * @author		Leo Daidone, leo@arroyolabs.com
 */
namespace erdiko\wordpress;
require_once __DIR__."/bootstrap.php";


class Model
{
	/**
	 * Generic function call.  Allows you call any WordPress api function from the object.
	 * example usage: $model->get_post($id)
	 *
	 * @param       $wordpressFunction
	 * @param array $arguments
	 *
	 * @return bool|mixed
	 * @throws \Exception
	 */
	public function __call ( $wordpressFunction, $arguments = array() )
	{
		$callback = false;
		try {
			$wordpressFunction = "\\{$wordpressFunction}";

			$callback = call_user_func_array( $wordpressFunction, $arguments );
		} catch (\Exception $e) {
			\error_log($e->getMessage());
			throw new \Exception($e->getMessage());
		}
		return $callback;
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
