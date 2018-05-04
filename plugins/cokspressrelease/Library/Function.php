<?php 
class Cokspressrelease_Library_Function extends Cokspressrelease_Core_All{ 
	protected $post_per_page = 10;
	protected $post_lists = '';
	protected $getAuthor = 1;
	protected $post_type = 'press-release';
	
	public function __construct(){
		
	}	
	public function getThePosts()
	{
		$args = array(
			'posts_per_page' => $this->post_per_page,
			'nopaging' => false,
			'update_post_term_cache' => false, 
			'update_post_meta_cache' => false, 
			'post_type' => $this->post_type,
			'orderby' => 'menu_order ID',
			'order'   => 'DESC',
			'post_author' => $this->getAuthor
			
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {	
			$i = 0;
			$postCount = $query->post_count;
			while ( $query->have_posts() ) {
				$query->the_post();
				if($i++%2 == 0 ){
					$list[] = "<ul class='news-list-items'>";
				}
				$isLast = ($i%2 == 0) ? ' last' : '';
				$getFeatured = wp_get_attachment_image_src( get_post_thumbnail_id($query->ID), 'thumbnail');
				$list[] = "<li class='list-item".$isLast."'><div class='thumb-section'><img src='". $getFeatured[0]."' alt='".get_the_title()."' class='img98scale' /></div><div class='text-section'><p class='news-title-list'><a class='' href='" . get_permalink() . "'>".get_the_title()."</a></p><p class='description-section'>" . $query->post->post_excerpt . "</p><p class='news-date-release'>Date: ".get_the_date()."</p></div></li>";
				if($i%2 == 0 || $i == $postCount){
					$list[] = "</ul>";
				}
			}
			wp_reset_postdata();
		}else{
			$list[] = "No press release available.";
		}
		
		return $list;
	}
	public function renderPosts( $atts,  $content = null  ) {
		$adiv = shortcode_atts( array(
			'id' => 1,
			'class' => 'press-release-flex',
			'per_page' => 10,
			'author' => 1,
		), $atts );
		ob_start();
		$this->post_per_page = 	$adiv['per_page'];	
		$this->getAuthor = 	$adiv['author'];
		$html[] = '';
		$getThePosts = $this->getThePosts();
		if(!empty($getThePosts)){
			$html[] = "<div class='press-release-archive'>";
			$html[] = join($getThePosts);	
			$html[] = '</div>';
		}	
		wp_reset_postdata();	
		echo join($html);
		return ob_get_clean();
	}
}