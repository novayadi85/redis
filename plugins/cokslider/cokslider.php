<?php
/*
Plugin Name: Cokdi Slider
Plugin URI: http://cokdei.com/

Description: Cokde sliders is a plugin to dynamic custom slider. To use this plugin you can visit my site. Thank you. Version 3.0 is add relation to page.
Version: 3.0 (stable)
Author: Cokdei  
Author URI: http://cokdei.com
License: GPL
*/

function cokde_aLoderSlider ($class_name ) {
  if ( false !== strpos( $class_name, 'Cokslider' ) ) {
    $classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR ;
    $pageRemove = str_replace( 'Cokslider_', '', $class_name );
    $class_file = str_replace( '_', DIRECTORY_SEPARATOR, $pageRemove ) . '.php';
    require_once $classes_dir . $class_file;
  }
}

spl_autoload_register( 'cokde_aLoderSlider' );

if(is_admin()) {
	
	new Cokslider_Core_Cokslider(__FILE__);
	new Cokslider_Library_Metaboxes;
	
}
	$slider = new Cokslider_Core_All;
	if(get_option( $slider->getPluginName() ) != null || get_option(  $slider->getPluginName() ) != ''){
		$sliderpostType = new Cokslider_Library_Sliderposttype;
		add_action( 'init', array( &$sliderpostType, 'add_slider_post' ) );
		function set_custom_edit_slider_columns($columns) {
			unset( $columns['author'] );
			$columns['featured_image'] = __( 'Image', 'your_text_domain' );

			return $columns;
		}

		function custom_slider_column( $column, $post_id ) {
			switch ( $column ) {
				case 'featured_image':
					echo the_post_thumbnail( 'thumbnail' );
				break;
			}
		}
		
		
		add_filter( 'manage_slider_posts_columns', 'set_custom_edit_slider_columns' );
		add_action( 'manage_slider_posts_custom_column' , 'custom_slider_column', 10, 2 );
		
		$sliderShortCode = new Cokslider_Library_Slidershortcode;
		add_shortcode( 'slider_incept', array(&$sliderShortCode,'slider_shortcode' ));
		
		new Cokslider_Core_Addscript;
	}
