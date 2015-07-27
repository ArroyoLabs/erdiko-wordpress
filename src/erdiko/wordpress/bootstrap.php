<?php
/**
 * WordPress bootstrap
 * Assumes Wordpress is installed in the lib folder in the /lib/wordpress folder.
 * If you want to run wordpress from another folder you need to change the WORDPRESS_ROOT below
 * 
 * @category  	erdiko
 * @package   	wordpress
 * @copyright 	Copyright (c) 2014, Arroyo Labs, http://www.arroyolabs.com
 * @author		John Arroyo, john@arroyolabs.com
 */

define('WP_USE_THEMES', true);
define('WORDPRESS_ROOT', ROOT.'/lib/wordpress');

if ( !isset($wp_did_header) ) {

	$wp_did_header = true;

	require_once( WORDPRESS_ROOT . '/wp-load.php' );

	wp();

	//require_once( ABSPATH . WPINC . '/template-loader.php' );
}
