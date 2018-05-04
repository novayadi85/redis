<?php 
class Cokslider_Library_Slidershortcode extends Cokslider_Core_All{ 
	public function __construct(){
		
	}	
	public function getChildImages( $postID ) {
		$args = array(
			'numberposts' => -1,
			'order' => 'ASC',
			'post_mime_type' => 'image',
			'post_parent' => $postID,
			'post_status' => null,
			'post_type' => 'attachment',
		);
		$attachments = get_children( $args );
		$html = array();
		if ( $attachments ) {
			foreach ( $attachments as $attachment ) {
				$html[] = '<li>';
				$html[] = '<img src="'.wp_get_attachment_url( $attachment->ID ).'" class="img-courusel" />';
				$html[] = '</li>';
			}
		}
		return join($html);
	}
	public function slider_shortcode( $atts,  $content = null  ) {
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
			$html[] = '<div id="carousel" class="' .esc_attr($adiv['class']).'">';
			$html[] = '<ul class="slides thumb-nav">';
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
	
	public function slider_script_custom()
	{
		ob_start();
		?>
		<script>
		(function($) {
		$(window).load(function() {
		  // The slider being synced must be initialized first
		  $('#carousel').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: true,
			slideshow: false,
			itemWidth: 160,
			itemMargin: 10,
			asNavFor: '#slider'
			,start: function(){
				$('.flexslider .slides img').show(); 
				$('.flexslider .slides > li').css('background','none'); 
			}
		  });
		 
		  $('#slider').flexslider({
			animation: "fade",
			controlNav: false,
			animationLoop: true,
			slideshow: true,
			slideshowSpeed: 7000,
			pauseOnHover: false,
			directionNav: false,
			sync: "#carousel"
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
}