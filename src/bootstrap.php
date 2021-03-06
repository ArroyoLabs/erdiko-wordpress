<?php
/**
 * WordPress bootstrap
 * Assumes Wordpress is installed in the lib folder in the /lib/wordpress folder.
 * If you want to run wordpress from another folder you need to change the WORDPRESS_ROOT below
 * 
 * @category  	erdiko
 * @package   	wordpress
 * @copyright 	Copyright (c) 2017, Arroyo Labs, http://www.arroyolabs.com
 * @author		John Arroyo, john@arroyolabs.com
 */

// define('WP_USE_THEMES', true);
define('WP_USE_THEMES', false);   

// if not set in the appstrap.php (or elsewhere) default it to lib/wordpress
if(empty(WORDPRESS_ROOT))
    define('WORDPRESS_ROOT', ERDIKO_ROOT.'/lib/wordpress');

if ( !isset($wp_did_header) ) {

	$wp_did_header = true;

	if (file_exists(WORDPRESS_ROOT . '/wp-load.php')) {
		require_once( WORDPRESS_ROOT . '/wp-load.php' );
	}

	if (function_exists('wp')) {
		wp();
	} else {
		throw new \Exception("There was an error trying to load WordPress",-104);
	}

	//require_once( ABSPATH . WPINC . '/template-loader.php' );
}
