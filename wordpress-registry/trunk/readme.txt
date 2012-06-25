=== Wordpress Registry ===
Contributors: rbncha
Tags: registry, globals, scope, $_POST, $_GET, request, http
Requires at least: 1.5
Tested up to: 3.4
Stable tag: 2.2

Use this plugin to store anything in registry such as variable/values, objects, array etc which you can get from plugins and theme files. As the plugin runs (most probably) before any plugins is initialized. So you use it to get/store values even from plugins.

== Description ==

The main reason for building this plugin was because wordpress doesn't readily have a central registry system where things can be stored such as variable values, objects, arrays. Which can be retrieved from a global space. This plugin basically tries to  lessen the repeating declarations of variables and etc. It is something quite similar to Magento registry "Mage_Registry", but very light version.

This plugin can also be used as GET and POST request parameters handler. The benefit is, you don't have to check isset($_GET['myparam']) or isset($_POST['myparam']). If the param is not set, it will return a default value you supplied in second param. By default, the default value is false.

Hope this could be of some use.

Usage is very easy, neat and straight forward:

Register a variable method:
	registry()->setVariableName('this is my variable');
	registry()->setMyName('My Name is Rubin Shrestha');

Validate existance of your method and echo:
	if( registry()->hasVaribleName() ) echo 'Has ' . registry()->getVaribleName();

You can still use registry()->myvariableName = 'Some value for this variable';

For GET and POST request handler use it like this:

* For $_GET, you can simply call registry()->request()->getParam('param_key', [default value if any, else blank, will return false]);
* For $_POST, you can simply call registry()->request()->getPost('param_key', [default value if any, else blank; will return false]);
* You can also do registry()->request()->getParams() and registry()->request()->getPosts();
	
== Installation ==

1. Upload Wordpress Registry to the '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 2.2 =
* Quick fix for POST values not being retrieved

= 2.1 =
* Introduction of better GET and POST request hanlder.
* Notice error removed while initializing plugin itself
= 2.0 =
* Introduced method based implementation as set/get/has Data so that you can use registry()->setObjectName(new stdObject), registry()->hasObjectName() registry()->getObjectName() etc.

= 1.0 =
* Initial Release
