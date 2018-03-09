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

function initHandlers()
{
	error_reporting(E_ALL & ~E_NOTICE & E_WARNING & ~E_STRICT & ~E_DEPRECATED);
	ini_set('html_errors',0); // @todo review this line

	set_error_handler("errorHandler");
	register_shutdown_function("fatalErrorShutdownHandler");
}

/**
 * errorHandler
 *
 * @param $errno
 * @param $errstr
 * @param $errfile
 * @param $errline
 *
 * @return bool
 * @throws Exception
 */
function errorHandler($errno, $errstr, $errfile, $errline) {
	if ( empty( $errstr ) && empty( $errfile ) && empty( $errline ) ) {
		return true;
	}
	$msg = $errstr . " in file " . $errfile . " line: " . $errline;
	// throw new \Exception($msg, -104);
	throw new \Exception($msg);
}

/**
 * fatalErrorShutdownHandler
 * 
 * @throws Exception
 */
function fatalErrorShutdownHandler()
{
	$last_error = error_get_last();
	errorHandler(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
}

initHandlers();

// define('WP_USE_THEMES', true);
define('WP_USE_THEMES', false);   

// if not set in the appstrap.php (or elsewhere) default it to lib/wordpress
if(empty(WORDPRESS_ROOT)) {
	define('WORDPRESS_ROOT', ERDIKO_ROOT.'/lib/wordpress');
}

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
