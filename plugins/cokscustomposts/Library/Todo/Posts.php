<?php 
class Cokscustomposts_Library_Todo_Posts extends Cokscustomposts_Core_All{ 
	public function __construct()
	{
		add_action( 'init', array( &$this, 'add_new_post' ) );
	}
	public function add_new_post()
	{
		$todoPost = $this->todoPosts();
		$name  = ucfirst($todoPost->name);
		$names = ucfirst($todoPost->names);
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
		'not_found'          => 'No ' . strtolower( $name ) . ' posts found',
		'not_found_in_trash' => 'No '.strtolower( $name ).' posts found in Trash',
		'parent_item_colon'  => '',
		'menu_name'          =>  $name . ' Posts'
		);

		$args = array(
		'labels'            => $labels,
		'public' 			=> true,
		'has_archive' 		=> true,
		'show_in_menu' 		=> true,
		'capability_type' 	=> $todoPost->capability,
		'supports'			=> array( 'title', 'editor', 'page-attributes','thumbnail','post-formats','excerpt'),
		'hierarchical' 		=> false,
		'exclude_from_search' 	=> false,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'show_in_nav_menus' 	=> false,
		'query_var' 			=> true,
		'rewrite'            => array( 'slug' => strtolower( $name ) ),
		'menu_icon' => plugins_url( 'images/'.strtolower( $name ) . '.png', dirname(dirname(__FILE__)) )
		);

		register_post_type( strtolower( $name ), $args);
		flush_rewrite_rules();
	}
}