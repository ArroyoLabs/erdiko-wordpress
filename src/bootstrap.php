<?php
/**
 * WordPress bootstrap
 * Assumes Wordpress is installed in the lib folder in the /lib/wordpress folder.
 * If you want to run wordpress from another folder you need to change the WORDPRESS_ROOT below
 *
 * @category  	erdiko/wordpress
 * @copyright 	Copyright (c) 2017, Arroyo Labs, http://www.arroyolabs.com
 * @author		John Arroyo, john@arroyolabs.com
 */

define('WP_USE_THEMES', false);

// If not set in the appstrap.php (or elsewhere) default it to vendor/wordpress
if(empty(getenv("WORDPRESS_ROOT")))
    putenv("WORDPRESS_ROOT=".getenv("ERDIKO_ROOT")."/vendor/wordpress");

define("WORDPRESS_ROOT", getenv("WORDPRESS_ROOT")); // legacy support

if ( !isset($wp_did_header) ) {
	$wp_did_header = true;
    $wpBootstrap = getenv("WORDPRESS_ROOT") . '/wp-load.php';

    if (file_exists($wpBootstrap))
	   require_once($wpBootstrap);

    if (function_exists('wp')) {
		wp();
	} else {
		throw new \Exception("There was an error trying to load WordPress",-104);
	}
}
