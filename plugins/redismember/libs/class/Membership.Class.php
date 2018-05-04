<?php 

Class Membership {
	
	public function __construct()
	{
		add_action( 'wp_enqueue_scripts', array(&$this, 'member_script') );
	}
	public function member_script() {
		wp_enqueue_style( 'style-member2', 'https://rawgit.com/enyo/dropzone/master/dist/dropzone.css');
		//wp_enqueue_style( 'style-awesome', 'http://fontawesome.io/assets/font-awesome/css/font-awesome.css');
		wp_enqueue_style( 'style-jcf', REDIS_WP_MEMBERSHIP_URL .'/skin/frontend/css/jcf.css');
		wp_enqueue_style( 'style-member', REDIS_WP_MEMBERSHIP_URL .'/skin/frontend/css/redismember.css');
		wp_enqueue_script( 'script-member', REDIS_WP_MEMBERSHIP_URL . '/skin/frontend/js/redismember.js',  array(), rand(), true);
		wp_enqueue_script( 'script-dropzone', REDIS_WP_MEMBERSHIP_URL . '/skin/frontend/js/dropzone.js'); 
		wp_enqueue_script( 'script-editor', "//cdn.tinymce.com/4/tinymce.min.js");
		//wp_enqueue_script( 'script-editor2', "https://rawgit.com/enyo/dropzone/master/dist/dropzone.js");
		//wp_enqueue_style( 'style-editor', get_template_directory_uri() . '/js/editor/bootstrap-wysihtml5-0.0.2.css');
		//wp_enqueue_script( 'script-jcf-jquery', REDIS_WP_MEMBERSHIP_URL . '/skin/frontend/js/jcf/jquery.js');
		wp_enqueue_script( 'script-jcf', REDIS_WP_MEMBERSHIP_URL . '/skin/frontend/js/jcf/jcf.js');
		wp_enqueue_script( 'script-radio', REDIS_WP_MEMBERSHIP_URL . '/skin/frontend/js/jcf/jcf.radio.js');
		wp_enqueue_script( 'script-check', REDIS_WP_MEMBERSHIP_URL . '/skin/frontend/js/jcf/jcf.checkbox.js');
	}
	
	
	
}