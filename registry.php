<?php
/**
 * @package Wordpress Registry
 * @version 2.4
 */
/*
Plugin Name: Wordpress Registry
Description: Makes variables and values globally accessible from everywhere. Better handling of $_GET and $_POST. Session data management.
Author: Rubin Shrestha
Version: 2.4
Author URI: http://www.rubin.com.np
*/
add_action( 'init', 'registry_init', -1000 );
function registry_init(){
	if( ! isset($GLOBALS['_system_registry_']) || ! is_object($GLOBALS['_system_registry_']) ) $GLOBALS['_system_registry_'] = new Wordpress_Registry();
}
function registry(){
	return $GLOBALS['_system_registry_'];
}
abstract class Wordpress_Registry_Abstract
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
	
	public function unsetData($key)
	{
		if($this->hasData($key)) unset($this->_data[$key]);
		
		return $this;
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
			case 'uns':
				return $this->unsetData($key);
		}
		throw new Exception("Call to undefined method " . get_class($this) . '::' . $name);
    }
}
class Wordpress_Registry extends Wordpress_Registry_Abstract
{
	public function __construct()
	{
		//initialize session
		$this->session();
	}
	
	public function request()
	{
		if(! $this->hasWpRequestHandler_() ){
			$this->setWpRequestHandler_(new Wordpress_Registry_Request);
		}
		
		return $this->getWpRequestHandler_();
	}
	
	public function session()
	{
		if(! $this->hasWpSessionHandler_() ){
			$this->setWpSessionHandler_(new Wordpress_Registry_Session);
		}
		
		return $this->getWpSessionHandler_();
	}
}
/**
 * Better handler for GET, POST requests
 */
class Wordpress_Registry_Request extends Wordpress_Registry_Abstract
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
		return isset( $_POST[$key] ) ? $_POST[$key] : $default;
	}
	
	public function getPosts()
	{
		return $_POST;
	}
	
	public function isPost()
	{
		if( strtolower($_SERVER['REQUEST_METHOD']) == 'post' ) return true;
		
		return false;
	}
}
class Wordpress_Registry_Session extends Wordpress_Registry_Abstract
{
	public function __construct()
	{
		if( !session_id() ) session_start();
		
		if( !isset($_SESSION['_Wordpress_Registry_Session']) ) $_SESSION['_Wordpress_Registry_Session'] = array();
		
		$this->initSessionData();
	}
	
	public function setData($key, $value)
    {
        parent::setData($key, $value);
		$_SESSION['_Wordpress_Registry_Session'][$key] = $value;
		
        return $this;
    }
	
	/**
	 * Maintains session data
	 *
	 */
	protected function initSessionData()
	{
		if( is_array($_SESSION['_Wordpress_Registry_Session']) ){
			foreach($_SESSION['_Wordpress_Registry_Session'] as $key => $value){
				parent::setData($key, $value);
			}
		}
		
		return $this;
	}
	
}
