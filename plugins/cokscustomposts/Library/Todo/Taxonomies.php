<?php 
class Cokscustomposts_Library_Todo_Taxonomies extends Cokscustomposts_Core_All{ 

	public function __construct()
	{
		add_action( 'init', array(&$this, 'todlist_taxonomies'), 0 );
	}
	
	public function todlist_taxonomies()
	{

		$catName = 'To do category';
		$catNames = 'To do Categories';

		$catSlug = 'todo-category';

		$todoPost = $this->todoPosts();

		$labels = array(
				'name'              => _x( $catNames, 'taxonomy general name', 'textdomain' ),
				'singular_name'     => _x( $catName, 'taxonomy singular name', 'textdomain' ),
				'search_items'      => __( 'Search '. $catName, 'textdomain' ),
				'all_items'         => __( 'All ' . $catNames, 'textdomain' ),
				'parent_item'       => __( 'Parent ' . $catName, 'textdomain' ),
				'parent_item_colon' => __( 'Parent' . $catName. ':', 'textdomain' ),
				'edit_item'         => __( 'Edit ' . $catName, 'textdomain' ),
				'update_item'       => __( 'Update ' . $catName, 'textdomain' ),
				'add_new_item'      => __( 'Add New ' . $catName, 'textdomain' ),
				'new_item_name'     => __( 'New ' . $catName .  ' Name', 'textdomain' ),
				'menu_name'         => __( $catName, 'textdomain' ),
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
				'rewrite'           => array( 'slug' => 'todo-category' ),
			);
			register_taxonomy( $catSlug , array( $todoPost->name ), $args );
	}
}