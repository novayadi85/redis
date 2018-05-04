<?php 
class Cokspressrelease_Library_Posttype extends Cokspressrelease_Core_All{ 
	public function add_new_post(){
		$names = "Press Releases";
		$name  = "Press Release";
	  $labels = array(
		'name'               => $names,
		'singular_name'      => $name,
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New ' . $name . ' Post',
		'edit_item'          => 'Edit ' . $name . ' Post',
		'new_item'           => 'New ' . $name . ' Post',
		'all_items'          => 'All ' . $name . ' Posts',
		'view_item'          => 'View ' . $name . ' Posts',
		'search_items'       => 'Search ' . $name . ' Posts',
		'not_found'          => 'No ' . $this->convertName( $name ) . ' posts found',
		'not_found_in_trash' => 'No '.$this->convertName( $name ).' posts found in Trash',
		'parent_item_colon'  => '',
		'menu_name'          =>  $name . ' Posts'
	  );

	  $args = array(
		'labels'            => $labels,
		'public' 			=> true,
		'has_archive' 		=> true,
		'show_in_menu' 		=> true,
		'capability_type' 	=> 'post',
		'supports'			=> array( 'title', 'page-attributes' ,'editor','thumbnail','excerpt'),
		'hierarchical' 		=> false,
		'exclude_from_search' 	=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'show_in_nav_menus' 	=> false,
		'query_var' 			=> true,
		'rewrite'            => array( 'slug' => $this->convertName( $name ) ),
		'menu_icon' => plugins_url( '../images/'.$this->convertName( $name ).'.png', __FILE__ )
	  );

	  register_post_type( $this->convertName( $name ), $args);
	  flush_rewrite_rules();
	}
}