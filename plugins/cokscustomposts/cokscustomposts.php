<?php
/*
Plugin Name: Custom Posts Plugin
Plugin URI: http://cokdei.com/

Description: Custom Posts is a plugin to dynamic custom post. To use this plugin you can visit my site. Thank you.
Version: 1.0 (stable)
Author: Cokdei  
Author URI: http://cokdei.com
License: GPL
*/

function cokde_aLoderBlog ($class_name ) {
  if ( false !== strpos( $class_name, 'Cokscustomposts' ) ) {
    $classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR ;
    $pageRemove = str_replace( 'Cokscustomposts_', '', $class_name );
    $class_file = str_replace( '_', DIRECTORY_SEPARATOR, $pageRemove ) . '.php';
    require_once $classes_dir . $class_file;
  }
}

spl_autoload_register( 'cokde_aLoderBlog' );

if(is_admin()) {
	
	new Cokscustomposts_Core_Cokscustomposts(__FILE__);
	
}
	$customPostReg = new Cokscustomposts_Core_All;
	if(get_option( $customPostReg->getPluginName() ) != null || get_option(  $customPostReg->getPluginName() ) != ''){
		$customPostType = new Cokscustomposts_Library_Posttype;
		add_action( 'init', array( &$customPostType, 'add_new_post' ) );
		new Cokscustomposts_Library_Todo_Posts;
		new Cokscustomposts_Library_Todo_Taxonomies;
	}
