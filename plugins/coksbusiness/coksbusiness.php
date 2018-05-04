<?php
/*
Plugin Name: Business Post Plugin
Plugin URI: http://konexto.com/

Description: Business post is a plugin for posting your business. To use this plugin you can visit my site. Thank you.
Version: 1.0 (stable)
Author: Cok Dei  
Author URI: http://konexto.com
License: GPL
*/

function cokde_aLoderBusiness ($class_name ) {
  if ( false !== strpos( $class_name, 'Coksbusiness' ) ) {
    $classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR ;
    $pageRemove = str_replace( 'Coksbusiness_', '', $class_name );
    $class_file = str_replace( '_', DIRECTORY_SEPARATOR, $pageRemove ) . '.php';
    require_once $classes_dir . $class_file;
  }
}

spl_autoload_register( 'cokde_aLoderBusiness' );
add_action('pre_get_posts','bamboo_pre_get_posts');
function bamboo_pre_get_posts( $query ) { 
    if( $query->is_main_query() && !$query->is_feed() && !is_admin() ) { 
        $query->set( 'paged', str_replace( '/', '', get_query_var( 'page' ) ) ); 
    } 
}
if(is_admin()) {
	
	new Coksbusiness_Core_Coksbusiness(__FILE__);
	
}
	$coksbusinessClass = new Coksbusiness_Core_All;
	if(get_option( $coksbusinessClass->getPluginName() ) != null || get_option(  $coksbusinessClass->getPluginName() ) != ''){
		$coksbusinessPostType = new Coksbusiness_Library_Posttype;
		add_action( 'init', array( &$coksbusinessPostType, 'add_new_post' ) );
		new Coksbusiness_Library_Taxonomies;
		new Coksbusiness_Library_Logos;
		new Coksbusiness_Library_Metaboxes;
		new Coksbusiness_Library_Galleries_Metaboxes;
		
	}
