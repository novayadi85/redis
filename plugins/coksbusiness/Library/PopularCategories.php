<?php 
class Coksbusiness_Library_PopularCategories extends Coksbusiness_Core_All{ 
	public function __construct()
	{
		//add_filter( 'popular-categories-business', array($this,'getPopularCategories'), 10, 2 );
	}

	public static function getPopularCategories($number = 4)
	{

		$args = array(
		    'orderby'           => 'random', 
		    'order'             => 'ASC',
		    'hide_empty'        => true, 
		    'exclude'           => array(), 
		    'exclude_tree'      => array(), 
		    'include'           => array(),
		    'number'            => ($number == 'all') ? '' : $number, 
		    'fields'            => 'all',  
		    'slug'              => '',
		    'parent'            => '',
		    'hierarchical'      => true, 
		    'child_of'          => 0,
		    'childless'         => false,
		    'get'               => '', 
		    'name__like'        => '',
		    'description__like' => '',
		    'pad_counts'        => false, 
		    'offset'            => '', 
		    'search'            => '', 
		    'cache_domain'      => 'core'
		); 
		$taxonomies = array( 
		    'taxonomy' => 'business-category',
		    'term_args' => $args,
		    'cache_images'  => true,
			'having_images' => false,
		);

		//$terms = get_terms($taxonomies, $args);
		$terms = apply_filters( 'taxonomy-images-get-terms', '', $taxonomies );

		return $terms;
	}
}

