<?php
/**
 * @package Wordpress Registry
 * @version 1.0
 */
/*
Plugin Name: Wordpress Registry
Description: Use this plugin to store anything in registry such as variable/values, objects, array etc which you can get from plugins and theme files. As the plugin runs (most probably) before any plugins is initialized. So you use it to get/store values even from plugins.
Author: Rubin Shrestha
Version: 1.0
Author URI: http://www.rubin.com.np
*/

add_action( 'init', 'registry_init', -1000 );

function registry_init(){
	if( ! is_object($GLOBALS['_system_registry_']) ) $GLOBALS['_system_registry_'] = new stdClass;
}

function registry(){
	return $GLOBALS['_system_registry_'];
}
