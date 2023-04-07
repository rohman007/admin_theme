<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if(file_exists('static') && !defined('NO_STATIC')){
	if(file_exists('index_static.php')){
		require_once('index_static.php');
		exit();
	}
}

require( 'config.php' );
require( 'init.php' );
require( 'classes/Collection.php' );
require( 'includes/plugin.php' );

$_wgts = get_option('widgets');
$_wgts = ($_wgts) ? json_decode($_wgts, true) : [];
$stored_widgets = $_wgts;

$lang_code = $options['language'];
$url_params = [];
if (PRETTY_URL && isset($_GET['viewpage']) == 'search' && strpos($_SERVER['REQUEST_URI'], '?viewpage=search')) {
	// If search page with query string URL
	// Then redirect to pretty url version
	header('Location: '.get_permalink('search', $_GET['slug']), true, 301);
	exit();
}
if(PRETTY_URL){
	$url_params = array_values(array_filter(explode('/', urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)))));
} else {
	if (isset($_GET['viewpage'])) {
		$url_params = array_values(array_filter(array_map('trim', $_GET)));
	}
}
if(SUB_FOLDER != ""){
	// Is using sub-folder
	$fname = str_replace("/", "", SUB_FOLDER);
	if(isset($url_params[0]) && $url_params[0] == $fname){
		array_shift($url_params);
	}
}
if (array_key_exists('lang', $_GET)) {
	// Switch language with ?lang=en parameter
	$lang_code = $_GET['lang'];
}
$lang_url_enabled = isset($options['lang_code_in_url']) && filter_var($options['lang_code_in_url'], FILTER_VALIDATE_BOOLEAN);
if($lang_url_enabled && PRETTY_URL){
	// Put language ID on url
	// example: domain.com/en/game
	if (!array_key_exists('lang', $_GET)) {
		$lang_code = isset($url_params[0]) ? $url_params[0] : 'en';
	}
	if (!preg_match('/^[a-z]{2}$/', $lang_code)) {
		$is_search = (isset($url_params[1]) && $url_params[1] == 'search') ? true : false;
		if(!$is_search){
			// Exception for search page
			$lang_code = $options['language']; // Default language code
			$redirect_url = DOMAIN . "$lang_code{$_SERVER['REQUEST_URI']}";
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: $redirect_url");
			exit();
		}
	}
	if(isset($url_params[0]) && $url_params[0] == $lang_code){
		array_shift($url_params);
	}
	$_GET['lang'] = $lang_code;
}

if (PRETTY_URL) {
	$_GET['viewpage'] = isset($url_params[0]) ? $url_params[0] : 'homepage';
	if(isset($url_params[1])) {
		$_GET['slug'] = $url_params[1];
	}
	if(isset($options['trailing_slash']) && filter_var($options['trailing_slash'], FILTER_VALIDATE_BOOLEAN)){
		// If trailing slash is activated
		if(count($url_params)){
			$cur_url = $_SERVER['REQUEST_URI'];
			if(substr($cur_url, -1) != '/' && !strpos($cur_url, '?')){
				// Add trailing slash, then redirect
				header('Location: '.substr(DOMAIN, 0, -1).$cur_url.'/', true, 301);
				exit();
			}
		}
	}
}

load_language('index');
load_plugins('index');

$page_name = isset( $_GET['viewpage'] ) ? $_GET['viewpage'] : 'homepage';

$base_taxonomy = get_base_taxonomy($page_name);
$custom_path = $base_taxonomy;

if($base_taxonomy == 'search'){
	if(PRETTY_URL){
		if(isset($_GET['slug']) && strpos($_SERVER['REQUEST_URI'], 'index.php?viewpage=search')){
			header('Location: '.get_permalink('search', $_GET['slug']), true, 301);
			exit();
		}
	}
}

require_once( TEMPLATE_PATH . '/functions.php' );

if(file_exists( 'includes/page-' . $base_taxonomy . '.php' )){
	require( 'includes/page-' . $base_taxonomy . '.php' );
} else {
	if(file_exists( TEMPLATE_PATH.'/page-' . $page_name . '.php' )){
		require( TEMPLATE_PATH.'/page-' . $page_name . '.php' );
	} else {
		require( 'includes/page-404.php' );
	}
}

?>