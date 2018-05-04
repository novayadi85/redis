<?php 
class Coksmonial_Core_Addscript extends Coksmonial_Core_All
{ 
	public function __construct()
	{
		add_action( 'wp_enqueue_scripts', array(&$this, 'flexslider_script') );
	}
	public function flexslider_script() {
		wp_enqueue_style( 'style-sliderflex', plugins_url( 'source/slider.css' , dirname(__FILE__ )) );
		wp_enqueue_script( 'script-flexslider', plugins_url( 'source/jquery.flexslider-min.js' , dirname(__FILE__ )) , array(  ), '2.5.0', false );
	}
	
}