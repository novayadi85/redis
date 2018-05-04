<?php 
class Coksbusiness_Library_Taxonomies extends Coksbusiness_Core_All{ 
	public function __construct()
	{
		add_action( 'init', array(&$this, 'business_taxonomies'), 0 );
	}
	
	public function business_taxonomies()
	{
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'Categories', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Categories', 'textdomain' ),
			'all_items'         => __( 'All Categories', 'textdomain' ),
			'parent_item'       => __( 'Parent Category', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Category:', 'textdomain' ),
			'edit_item'         => __( 'Edit Category', 'textdomain' ),
			'update_item'       => __( 'Update Category', 'textdomain' ),
			'add_new_item'      => __( 'Add New Category', 'textdomain' ),
			'new_item_name'     => __( 'New Category Name', 'textdomain' ),
			'menu_name'         => __( 'Category', 'textdomain' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'has_archive'		=> true,
			'public'        	=> true,
			'publicly_queryable' => true,
			'rewrite'           => array( 'slug' => 'business-category' ),
		);

		register_taxonomy( 'business-category', array( 'business' ), $args );
		
		$labels = array(
			'name'              => _x( 'Locations', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Location', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Locations', 'textdomain' ),
			'all_items'         => __( 'All Locations', 'textdomain' ),
			'parent_item'       => __( 'Parent Location', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Location:', 'textdomain' ),
			'edit_item'         => __( 'Edit Location', 'textdomain' ),
			'update_item'       => __( 'Update Location', 'textdomain' ),
			'add_new_item'      => __( 'Add New Location', 'textdomain' ),
			'new_item_name'     => __( 'New Location Name', 'textdomain' ),
			'menu_name'         => __( 'Location', 'textdomain' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'has_archive' 		=> true,
			'publicly_queryable' => true,
			'rewrite'           => array( 'slug' => 'business-location' ),
		);

		$labels = array(
			'name' => _x( 'Package', 'taxonomy general name' ),
			'singular_name' => _x( 'Package', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Package' ),
			'all_items' => __( 'All Packagess' ),
			'parent_item' => __( 'Parent Package' ),
			'parent_item_colon' => __( 'Parent Package:' ),
			'edit_item' => __( 'Edit Package' ), 
			'update_item' => __( 'Update Package' ),
			'add_new_item' => __( 'Add New Package' ),
			'new_item_name' => __( 'New Package Name' ),
			'menu_name' => __( 'Packages' ),
		  ); 	

		  register_taxonomy('packages',array('post','business'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'package' ),
		  ));
		
		register_taxonomy( 'business-location', array( 'business' ), $args );
	}
}