<?php 
class Cokslider_Core_Addscript extends Cokslider_Core_All
{ 
	public function __construct()
	{
		add_action( 'wp_enqueue_scripts', array(&$this, 'flexslider_script') );
	}
	public function flexslider_script() {
		wp_enqueue_style( 'style-sliderflex', plugins_url( 'source/slider.css' , dirname(__FILE__ )) );
		wp_enqueue_style( 'style-slick', plugins_url( 'source/slick.css' , dirname(__FILE__ )) );
		wp_enqueue_style( 'style-theme-slick', plugins_url( 'source/slick-theme.css' , dirname(__FILE__ )) );
		wp_enqueue_script( 'script-flexslider', plugins_url( 'source/jquery.flexslider-min.js' , dirname(__FILE__ )) , array(  ), '2.5.0', false );
		wp_enqueue_script( 'script-slick', plugins_url( 'source/slick.js' , dirname(__FILE__ )) , array(  ), '3.0.0', false );
	}
	
}