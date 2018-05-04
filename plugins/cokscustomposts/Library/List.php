<?php 
class Cokscustomposts_Library_List extends Cokscustomposts_Core_All{ 
	public function __construct(){
		
	}

	public static function showAds($count = 2)
	{
		$args = array(
			'posts_per_page' => $count,
			'post_type' => 'ad',
			'orderby' => 'menu_order ID',
			'order'   => 'ASC',
			
		);

		$html[] = "<div class='row-ads'>";
		$query = new WP_Query( $args );
		if ( $query->have_posts() ){	
			$i = 1;
			while ( $query->have_posts() ) {
				$query->the_post();
				$getFeatured = wp_get_attachment_image_src( get_post_thumbnail_id($query->post->ID), 'full');
				$html[] = "<div class='image-ads-thumb'>";
					$html[] = "<img src='" . $getFeatured[0] ."' alt='" . get_the_title(). "' class='img-responsive' />";
				$html[] = "</div>";
			}
		}		
		wp_reset_postdata();	
		
		$html[] = "</div>";

		return join($html);
	}
	
}