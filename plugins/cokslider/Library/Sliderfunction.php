<?php 
class Cokslider_Library_Sliderfunction extends Cokslider_Core_All{ 
	public function __construct(){
		
	}	
	public function getChildImages($parent_id)
	{
		$args = array(
			'posts_per_page' => -1,
			'nopaging' => true,
			'post_type' => 'slider',
			'post_parent' => $parent_id,
			'orderby' => 'menu_order ID',
			'order'   => 'DESC'
			
		);
		$query = new WP_Query( $args );
		$count = $query->post_count;
		$found = $query->found_posts;
		
		if ( $query->have_posts() ) {	
			$i = 1;
			while ( $query->have_posts() ) {
				$query->the_post();
				$thumb_id = get_post_thumbnail_id();
				
				$pAttrCust = get_post_meta( $query->post->ID, '__page_extlink', true );
				$pAttrCust2 = get_post_meta( $query->post->ID, '__page_intlink', true );
				$uri = empty($pAttrCust2) ? $pAttrCust:get_permalink($pAttrCust2) ; 
				
				$linking_open = '';
				$linking_close = '';
				if(!empty($uri)){
					$linking_open = '<a href="'.$uri.'">';
					$linking_close = '</a>';
				}
				$html[] = '<li>';
				$html[] = $linking_open . '<img src="'.wp_get_attachment_url( $thumb_id ).'" class="img-courusel" alt="'.$query->post_title.'"/>'.$linking_close;				
				$html[] = "<div class='slide-caption'><div class='caption-content'>" . do_shortcode(get_the_content()) . "</div></div>";
				$html[] = '</li>';
			}
			
		}else{
			$html[] = "<h2> No post available</h2>";
		}		
	
		wp_reset_postdata();	
		
		return join($html);
	}
	public function getTestimonials($postMax)
	{
		$args = array(
			'posts_per_page' => $postMax,
			'nopaging' => true,
			'post_type' => 'testimonial',
			'orderby' => 'menu_order ID',
			'post_status' => 'publish',
			'order'   => 'ASC'
			
		);
		$query = new WP_Query( $args );
		$count = $query->post_count;
		$found = $query->found_posts;
		
		if ( $query->have_posts() ) {	
			$i = 1;
			while ( $query->have_posts() ) {
				$query->the_post();
				$pAttrCust = unserialize(get_post_meta( $query->post->ID, '__testimonial_attr', true ));
				$company = empty($pAttrCust['_company']) ? '' : $pAttrCust['_company'];
				$staff_position = empty($pAttrCust['_staff_position']) ? '' : $pAttrCust['_staff_position'];
				
				$html[] = '<div>';
					$html[] = '<div class="testimonial-excerpt">';
					$html[] = trim($query->post->post_excerpt) . "...<a href='". esc_url( home_url( '/testimonial' ) ) . "'>Read more</a>";
					$html[] = '</div>';
					$html[] = '<div class="testimonial-from">';
					$html[] = "<h2>" . $query->post->post_title . "</h2>" . $staff_position . "<br />" .  $company; 
					$html[] = '</div>';
				$html[] = '</div>';
			}
			
		}else{
			$html[] = "<h2> No post available</h2>";
		}		
	
		wp_reset_postdata();	
		
		return join($html);
	}
	public function big_slider($atts = array()) {
		$adiv = shortcode_atts( array(
			'id' => 1,
			'class' => 'flexslider',
		), $atts );
		ob_start();			
		$getImages = $this->getChildImages($adiv['id']);
		if(!empty($getImages)){
			$html[] = '<div id="slider" class="' .esc_attr($adiv['class']).'">';
			$html[] = '<ul class="slides">';
			$html[] = $getImages;	
			$html[] = '</ul>';
			$html[] = '</div>';
			
		}else{
			$html[] = "";
		}		
		wp_reset_postdata();	
		$html[] = $this->slider_script_custom();
		echo join($html);
		return ob_get_clean();
	}
	
	public function testimonial_slider($atts = array()) {
		$adiv = shortcode_atts( array(
			'id' => 1,
			'class' => 'slider-testimonial',
			'postmax' => 5,
		), $atts );
		ob_start();			
		$getTestimonials = $this->getTestimonials((int)$adiv['postmax']);
		if(!empty($getTestimonials)){
			$html[] = '<div id="carousel" class="' .esc_attr($adiv['class']).'">';
			$html[] = $getTestimonials;	
			$html[] = '</div>';
			
		}else{
			$html[] = "";
		}		
		wp_reset_postdata();	
		$html[] = $this->carousel_script();
		echo join($html);
		return ob_get_clean();
	}
	
	public function slider_script_custom()
	{
		ob_start();
		?>
		<script>
		(function($) {
		$(window).load(function() {
		 
		  $('#slider').flexslider({
			animation: "fade",
			controlNav: false,
			animationLoop: true,
			slideshow: true,
			slideshowSpeed: 7000,
			pauseOnHover: false,
			directionNav: true
			,start: function(){
				$('.flexslider .slides img').show(); 
				$('.flexslider .slides > li').css('background','none'); 
			}
		  });
		});
		})(jQuery);
		</script>
	<?php 
		return ob_get_clean();
	}
	public function carousel_script()
	{
		ob_start();
		?>
		<script>
		(function($) {
			$("#carousel").slick({
			dots: true,
			infinite: true,
			arrows: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 6000
		  });
		})(jQuery);
		</script>
	<?php 
		return ob_get_clean();
	}
}