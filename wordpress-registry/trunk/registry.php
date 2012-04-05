<?php
/**
 * @package Wordpress Registry
 * @version 2.1
 */
/*
Plugin Name: Wordpress Registry
Description: Use this plugin to store anything in registry such as variable/values, objects, array etc which you can get from plugins and theme files. As the plugin runs (most probably) before any plugins is initialized. So you use it to get/store values even from plugins.
Author: Rubin Shrestha
Version: 2.0
Author URI: http://www.rubin.com.np
*/

add_action( 'init', 'registry_init', -1000 );

function registry_init(){
	if( ! isset($GLOBALS['_system_registry_']) || ! is_object($GLOBALS['_system_registry_']) ) $GLOBALS['_system_registry_'] = new systemRegistry();
}

function registry(){
	return $GLOBALS['_system_registry_'];
}

class systemRegistry
{
	private $_data = array();
	
	public function __construct(){ }
	
	public function getData($key = null, $default = null)
    {
		if (null === $key) {
			return $this->_data;
		}

		return isset($this->_data[$key]) ? $this->_data[$key] : $default;
    }

    public function setData($key, $value)
    {
        $this->_data[$key] = $value;
        return $this;
    }
	
	public function hasData($key)
	{
		return (bool) isset($this->_data[$key]);
	}
	
	public function __get($key)
    {
        return $this->getData($key);
    }

    public function __set($key, $value)
    {
        $this->_data[$key] = $value;
    }

    public function __call($name, $arguments)
    {
		$key = substr($name, 3);
		$key[0] = strtolower($key[0]);
		
		switch (substr($name, 0, 3)) {
			case 'has':
				return $this->hasData($key);
			case 'get':
				return $this->getData($key);
			case 'set':
				$this->setData($key, $arguments[0]);
				return $this;
		}

		throw new Exception("Call to undefined method " . get_class($this) . '::' . $name);
    }
	
	public function request()
	{
		if(! registry()->hasWpRequestHandler_() ){
			registry()->setWpRequestHandler_(new Wordpress_Http_Request);
		}
		
		return registry()->getWpRequestHandler_();
	}
}


/**
 * Better handler for GET, POST requests
 */

class Wordpress_Http_Request
{
	public function getParam ($key, $default = false)
	{
		return isset( $_GET[$key] ) ? $_GET[$key] : $default;
	}
	
	public function getParams()
	{
		return $_GET;
	}
	
	public function getPost ($key, $default = false)
	{
		return isset( $_GET[$key] ) ? $_GET[$key] : $default;
	}
	
	public function getPosts()
	{
		return $_POST;
	}
}