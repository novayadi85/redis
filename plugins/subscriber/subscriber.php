<?php
/*
Plugin Name: Subscriber
Plugin URI: http://cokdi.blogspot.com/
Description: Contact Us is a plugin to dynamic contact us page. To use this plugin you can visit my site. Thank you.
Version: 11.10 Dev
Author: Cokdi 
Author URI: http://cokdi.blogspot.com
License: GPL
*/
/* This calls certificate_list() function when wordpress initializes.*/
/* Note that the certificate_list doesnt have brackets. */
function init_sessions() {
	if (!session_id()) {
		session_start();
	}
}
add_action('init', 'init_sessions');
if(is_admin()) {
	require('backend/backend.php');
	$bvaPlugin = new setSubscriber(__FILE__);
	
}else{
	function full_contact(){
			require('frontend/fcontact.php');	
	}
	function mini_contact(){
			require('frontend/mcontact.php');				
	}
	add_shortcode('fcontact', 'full_contact'); 
	add_shortcode('mcontact', 'mini_contact'); 
	
}

/* add_shortcode('register_process', 'process_reg'); 	 */
	