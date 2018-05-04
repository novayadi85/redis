<?php
/*
Plugin Name: Press Release Plugin
Plugin URI: http://konexto.com/

Description: Press release is a plugin to dynamic custom press release. To use this plugin you can visit my site. Thank you.
Version: 1.0 (stable)
Author: Cokdei  
Author URI: http://konexto.com
License: GPL
*/
function cokde_aLoderPressRelease ($class_name ) {	
$pluginName = 'Cokspressrelease';
  if ( false !== strpos( $class_name, $pluginName ) ) {
    $classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR ;
    $pageRemove = str_replace( $pluginName . '_', '', $class_name );
    $class_file = str_replace( '_', DIRECTORY_SEPARATOR, $pageRemove ) . '.php';
    require_once $classes_dir . $class_file;
  }
}

spl_autoload_register( 'cokde_aLoderPressRelease' );

if(is_admin()) {
	
	new Cokspressrelease_Core_Install(__FILE__);
	
}
	$corePressRelease = new Cokspressrelease_Core_All;
	if(get_option( $corePressRelease->getPluginName() ) != null || get_option(  $corePressRelease->getPluginName() ) != ''){
		$pReleasePostType = new Cokspressrelease_Library_Posttype;
		add_action( 'init', array( &$pReleasePostType, 'add_new_post' ) );
		
	}
