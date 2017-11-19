=== Wordpress Registry ===
Contributors: rbncha
Tags: registry, globals, scope, $_POST, $_GET, request, http, session
Requires at least: 1.5
Tested up to: 4.9
Stable tag: 2.4

Makes variables and values globally accessible from everywhere. Better handling of $_GET and $_POST. Session data management.

== Description ==

The main reason for building this plugin is because wordpress doesn't readily have a central registry system where things can be stored such as variable values, objects, arrays. Which can be retrieved from a global space. This plugin basically tries to  lessen the repeating declarations of variables and etc. It is something quite similar to Magento registry "Mage_Registry", but very light version.

This plugin can also be used as GET and POST request parameters handler. The benefit is, you don't have to check isset($_GET['myparam']) or isset($_POST['myparam']). If the param is not set, it will return a default value you supplied in second param. By default, the default value is false.

Handle the session data as easy as never before. Save to session, check existance, get, unset it easily using dynamic methods.

Hope this could be of some use.

Usage is very easy, neat and straight forward:

Register a dynamic method on the fly:
	registry()->setDynamicMethodName('this is my value');
	registry()->setMyName('My Name is Rubin Shrestha');

Validate existance of your method and echo:
	if( registry()->hasDynamicMethodName() ) echo 'Has ' . registry()->getDynamicMethodName();

Unset the dynamic method:
registry()->unsDynamicMethodName(); after this, if you echo registry()->getDynamicMethodName() it will return null;

For GET and POST request handler use it like this:

* For $_GET, you can simply call registry()->request()->getParam('param_key', [default value if any, else blank, will return false]);
* To check if the page type is $_POST use if( registry()->request()->isPost() ) { //do your stuffs here }
* For $_POST, you can simply call registry()->request()->getPost('param_key', [default value if any, else blank; will return false]);
* You can also do registry()->request()->getParams() and registry()->request()->getPosts();
* You can also add request object scope variable, registry()->request()->setVariableName('this is my value');. Get the value by registry()->request()->getVariableName();

Session handler:

Handle the data in session as easy as registry()->session()->setDynamicMethodName('this is my value'); and get it as registry()->session()->getDynamicMethodName(); Unset it registry()->session()->unsDynamicMethodName();
	
== Installation ==

1. Upload Wordpress Registry to the '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress

Compatible with Wordpress 4.9

== Changelog ==
= 2.4 =
* registry()->request()->session() handler hadded
= 2.3 =
* registry()->request()->isPost() method added to check if a page request is 
= 2.2 =
* Quick fix for POST values not being retrieved

= 2.1 =
* Introduction of better GET and POST request hanlder.
* Notice error removed while initializing plugin itself
= 2.0 =
* Introduced method based implementation as set/get/has Data so that you can use registry()->setObjectName(new stdObject), registry()->hasObjectName() registry()->getObjectName() etc.

= 1.0 =
* Initial Release
