<?php
/*
Plugin Name: Testimonial Plugin
Plugin URI: http://cokdei.com/

Description: Testimonial is a plugin to dynamic custom testimonial. To use this plugin you can visit my site. Thank you.
Version: 1.0 (stable)
Author: Cokdei  
Author URI: http://cokdei.com
License: GPL
*/

function cokde_aLoderMonial ($class_name ) {
  if ( false !== strpos( $class_name, 'Coksmonial' ) ) {
    $classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR ;
    $pageRemove = str_replace( 'Coksmonial_', '', $class_name );
    $class_file = str_replace( '_', DIRECTORY_SEPARATOR, $pageRemove ) . '.php';
    require_once $classes_dir . $class_file;
  }
}

spl_autoload_register( 'cokde_aLoderMonial' );

if(is_admin()) {
	
	new Coksmonial_Core_Coksmonial(__FILE__);
	new Coksmonial_Library_Metaboxes();
	
}
	$monial = new Coksmonial_Core_All;
	if(get_option( $monial->getPluginName() ) != null || get_option(  $monial->getPluginName() ) != ''){
		$monialPostType = new Coksmonial_Library_Posttype;
		add_action( 'init', array( &$monialPostType, 'add_new_post' ) );
		
		$addShortCode = new Coksmonial_Library_Shortcode;
		add_shortcode( 'slide_testimonial', array(&$addShortCode,'render_testimonial' ));
		
		new Coksmonial_Core_Addscript;
	}
