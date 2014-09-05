<?php
/**
 * Wordpress bootstrap
 * Assumes Wordpress is installed in the vendor folder in the /lib/wordpress folder.
 * 
 * @category  	erdiko
 * @package   	wordpress
 * @copyright 	Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author		John Arroyo, john@arroyolabs.com
 */

/*
// Prevent this from running under a webserver (for unit testing only)
if (array_key_exists('REQUEST_METHOD', $_SERVER)) 
{
	echo 'This page is not accessible from a browser.';
	exit(1);
}
*/

// Set the working directory and required Drupal 7 server variables
define('WP_USE_THEMES', true);
define('WORDPRESS_ROOT', ROOT.'/lib/wordpress');
//chdir(WORDPRESS_ROOT);
$wp_did_header = true;

//$_SERVER['REQUEST_METHOD'] = 'get'; // @todo do a check for method first
//$_SERVER['REMOTE_ADDR'] = '127.0.0.1'; // @todo do a check for address

if ( !isset($wp_did_header) ) {

	$wp_did_header = true;

	require_once( WORDPRESS_ROOT . '/wp-load.php' );

	wp();

	require_once( ABSPATH . WPINC . '/template-loader.php' );

}

