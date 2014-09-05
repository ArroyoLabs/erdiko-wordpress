<?php
/**
 * Drupal Model
 * Base model every drupal model should inherit
 * 
 * @category  	erdiko
 * @package   	drupal
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
}