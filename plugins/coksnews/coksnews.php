<?php
/*
Plugin Name: News Plugin
Plugin URI: http://cokdei.com/

Description: News is a plugin to dynamic custom news. To use this plugin you can visit my site. Thank you.
Version: 1.0 (stable)
Author: Cokdei  
Author URI: http://cokdei.com
License: GPL
*/

function cokde_aLoderNews ($class_name ) {
  if ( false !== strpos( $class_name, 'Coksnews' ) ) {
    $classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR ;
    $pageRemove = str_replace( 'Coksnews_', '', $class_name );
    $class_file = str_replace( '_', DIRECTORY_SEPARATOR, $pageRemove ) . '.php';
    require_once $classes_dir . $class_file;
  }
}

spl_autoload_register( 'cokde_aLoderNews' );

if(is_admin()) {
	
	new Coksnews_Core_Coksnews(__FILE__);
	
}
	$newsClass = new Coksnews_Core_All;
	if(get_option( $newsClass->getPluginName() ) != null || get_option(  $newsClass->getPluginName() ) != ''){
		$newsPostType = new Coksnews_Library_Posttype;
		add_action( 'init', array( &$newsPostType, 'add_new_post' ) );
		
	}
