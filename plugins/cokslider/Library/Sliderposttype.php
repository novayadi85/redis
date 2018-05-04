<?php 
class Cokslider_Library_Sliderposttype{ 
	public function add_slider_post(){
		$names = "Sliders";
		$name  = "Slider";
	  $labels = array(
		'name'               => $names . ' Posts',
		'singular_name'      => $name . ' Post',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New ' . $name . ' Post',
		'edit_item'          => 'Edit ' . $name . ' Post',
		'new_item'           => 'New ' . $name . ' Post',
		'all_items'          => 'All ' . $name . ' Posts',
		'view_item'          => 'View ' . $name . ' Posts',
		'search_items'       => 'Search ' . $name . ' Posts',
		'not_found'          => 'No ' . strtolower( $name ) . ' posts found',
		'not_found_in_trash' => 'No '.strtolower( $name ).' posts found in Trash',
		'parent_item_colon'  => '',
		'menu_name'          =>  $name . ' Posts'
	  );

	  $args = array(
		'labels'            => $labels,
		'public' 			=> true,
		'has_archive' 		=> false,
		'show_in_menu' 		=> true,
		'capability_type' 	=> 'post',
		'supports'			=> array( 'title', 'page-attributes' ,'editor','thumbnail'),
		'hierarchical' 		=> true,
		'exclude_from_search' 	=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'show_in_nav_menus' 	=> false,
		'query_var' 			=> true,
		'rewrite'            => array( 'slug' => strtolower( $name ) ),
		'menu_icon' => plugins_url( '../images/'.strtolower( $name ).'.png', __FILE__ )
	  );

	  register_post_type( strtolower( $name ), $args);
	  flush_rewrite_rules();
	}
}