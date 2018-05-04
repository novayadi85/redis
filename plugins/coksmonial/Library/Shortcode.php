<?php 
class Coksmonial_Library_Shortcode extends Coksmonial_Core_All{ 
	public function __construct(){
		
	}	
	public function getTestimonial($count)
	{
		$args = array(
			'posts_per_page' => $count,
			'nopaging' => false,
			'update_post_term_cache' => false, 
			'update_post_meta_cache' => false, 
			'post_type' => 'testimonial',
			'orderby' => 'menu_order ID',
			'order'   => 'DESC',
			
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {	
			$i = 1;
			while ( $query->have_posts() ) {
				$query->the_post();
				$list[] = "<li>" . $query->post->post_content . "</li>";
			}
			wp_reset_postdata();
		}else{
			$list[] = "No testimonial available.";
		}
		
		return $list;
	}
	public function render_testimonial( $atts,  $content = null  ) {
		$adiv = shortcode_atts( array(
			'id' => 1,
			'class' => 'testimonial-flex',
		), $atts );
		ob_start();			
		$getTestimonial = $this->getTestimonial(5);
		if(!empty($getTestimonial)){
			$html[] = '<div id="testimonial-slide" class="' .esc_attr($adiv['class']).'">';
			$html[] = '<ul class="test-slide">';
			$html[] = join($getTestimonial);	
			$html[] = '</ul>';
			$html[] = '</div>';
		}else{
			$html[] = "";
		}		
		wp_reset_postdata();	
		$html[] = $this->add_script();
		echo join($html);
		return ob_get_clean();
	}
	
	public function add_script()
	{
		ob_start();
		?>
		<script>
		(function($) {
		$(window).load(function() {
		 
		  $('#testimonial-slide').flexslider({
			animation: "slide"
			,selector: ".test-slide > li"
			,directionNav: true
			,start: function(){
				$('.test-slide').show(); 
			}
		  });
		});
		})(jQuery);
		</script>
	<?php 
		return ob_get_clean();
	}
}