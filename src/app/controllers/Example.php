<?php
/**
 * Example WordPress Controller
 * An example of how to use wordpress with erdiko (Hello World)
 *
 * @category 	erdiko
 * @package   	wordpress
 * @copyright	Copyright (c) 2016, Arroyo Labs, www.arroyolabs.com
 * @author 		John Arroyo, john@arroyolabs.com
 */
namespace erdiko\wordpress\app\controllers;

use Erdiko;
use erdiko\core\Config;

/**
 * Wordpress example controller class
 */
class Example extends \erdiko\core\Controller
{
	/** Before */
	public function _before()
	{
		$this->setThemeName('bootstrap');
		$this->prepareTheme();
	}

	/**
	 * Wordpress example
	 */
	public function getIndex()
	{
		$model = new \erdiko\wordpress\model\Wordpress;

		$post = $model->getPost(1);
		$content = "<pre>".print_r($post, true)."</pre>";

		$this->setContent( $content );
	}
}
