<?php get_header(); ?>
<div id="page-content">	
	<div id="columns-page" class="two-colums column-right regular-page container">
		<div class="section-web">
			<?php while ( have_posts() ) : 
				the_post();
				set_visitor_post();
				$getCustMetaBox = unserialize(get_post_meta( get_the_ID(), '__theme_custom_box', true ));
				$imgHeader = !empty($getCustMetaBox['__page_img_header']) ? $getCustMetaBox['__page_img_header'] : null;
				$imgHeaderSrc = !empty($imgHeader) ? wp_get_attachment_url( $imgHeader ) : homeUrl('/assets/img/add-now.jpg');
				
				$getCustMetaBox = unserialize(get_post_meta( get_the_ID(), '__business_logo', true ));
				$imgLogo = !empty($getCustMetaBox['__business_img_logo']) ? $getCustMetaBox['__business_img_logo'] : null;
				$imgLogoSrc = !empty($imgLogo) ? wp_get_attachment_url( $imgLogo ) : homeUrl('/assets/img/logo-default.jpg');
				
				$pAttrCust = unserialize(get_post_meta( $post->ID, '__business_contact', true ));

				$postMaps = get_post_meta( $post->ID, '__post_maps', true );	

				$get_gallery = get_post_meta( $post->ID, '__galerries_post', true );

				$getAuthor = $post->post_author;
				$unclaim = FALSE;				
			?>
					
			<div class="business-header">
				<div class="black-title">
					<h2><?php the_title(); ?></h2>
					<?php $author = get_userdata( $post->post_author )->roles; ?>
					
				</div>
				<div class="business-cover">
					<?php if($author[0] !== 'member'): ?>
						<button type="button" class="make-enquiry btn claimbusiness-btn" data-toggle="modal" data-target="#claimBusiness" data-whatever="<?php the_title(); ?>"><i class="fa fa-plus"></i> <?php echo __('Claim this business'); ?></button>
						<?php $unclaim = TRUE; ?>
					<?php else: ?>
						<a class="make-enquiry btn"><?php echo __('Make an Enquiry'); ?></a>
					<?php endif; ?>
					<img class="img-responsive" src="<?php echo $imgHeaderSrc; ?>" alt="<?php the_title(); ?>" />
					
					<div class="business-logo">
						<img src="<?php echo $imgLogoSrc; ?>" alt="<?php the_title(); ?> Logo" /> 
					</div>
				</div>
				<div class="business-address">
					<span class="address"><?php echo (!empty($pAttrCust['_address']) ) ? $pAttrCust['_address'] : ''; ?></span>
					<a href="#" class="btn follow"><?php echo __("Follow"); ?></a>
					<?php if(is_user_logged_in() ): ?>
					<a href="#" data-value="<? echo $post->ID;?>" onclick="addRating(this);" class="btn btn-rating rating"><?php echo __("Rate"); ?></a>
					<?php else : ?>
					<a href="<?php echo site_url("members.php");?>"  class="btn btn-rating rating"><?php echo __("Rate"); ?></a>
					
					
					<?php endif;?>
				</div>
				<div class="business-contact">
					<ul class="contact-list">
						<?php if(!empty($pAttrCust['_phone']) ): ?>
						<li><a href="tel:<?php echo $pAttrCust['_phone'] ?>" data-toggle="tooltip" title="<?php echo $pAttrCust['_phone'] ?>">Phone</a></li>
						<?php endif; ?>
						<?php if(!empty($pAttrCust['_email']) ): ?>
						<li><a href="#" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $pAttrCust['_email'] ?>">Email</a></li>
						<?php endif; ?>
						<?php if(!empty($pAttrCust['_website_address']) ): ?>
						<li><a href="<?php echo $pAttrCust['_website_address']; ?>" data-toggle="tooltip" title="Visit Website" target="_blank">Web</a></li>
						<?php endif; ?>
						<?php if(!empty($pAttrCust['_gplus']) ): ?>
						<li><a href="<?php echo $pAttrCust['_gplus']; ?>" data-toggle="tooltip" target="_blank" title="Visit Google Plus">Google +</a></li>
						<?php endif; ?>
						<?php if(!empty($pAttrCust['_facebook']) ): ?>
						<li><a href="<?php echo $pAttrCust['_facebook']; ?>" data-toggle="tooltip" target="_blank" title="Visit Facebook">Facebook</a></li>
						<?php endif; ?>
						<?php if(!empty($pAttrCust['_twitter']) ): ?>
						<li><a href="<?php echo $pAttrCust['_twitter']; ?>" data-toggle="tooltip" target="_blank" title="Visit Twitter">Twitter</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			<div class="main-column">				
				<div class="text-content">
				`
				</div> 			
					
				  <ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#overview">Overview</a></li>
					<li><a data-toggle="tab" href="#menu1">Address/ Maps</a></li>
					<?php if(!empty($get_gallery)): ?>
						<li><a data-toggle="tab" href="#menu2">Galleries</a></li>
					<?php endif; ?>
					<?php /* 
					<li><a data-toggle="tab" href="#menu3">Press Releases</a></li>
					<li><a data-toggle="tab" href="#menu4">News</a></li>
					*/ ?>
				  </ul>

				  <div class="tab-content">
					<div id="overview" class="tab-pane fade in active">
					  <?php the_content(); ?>
					</div>
					<div id="menu1" class="tab-pane fade">
					  <?php echo stripcslashes($postMaps); ?>
					</div>
					<?php if(!empty($get_gallery)): ?>
					<div id="menu2" class="tab-pane fade">
						<div id="gallery">
						  <?php $set_galleries =  explode(',',$get_gallery); 
							$i = 0;
							if(count($set_galleries) > 0):
								foreach($set_galleries as $galery_id){	
									++$i;
									$img_url_thumb =  wp_get_attachment_image_src( $galery_id, 'thumbnail');
									$img_url =  wp_get_attachment_image_src( $galery_id, 'full');
									if(empty($img_url_thumb)){
										$img_url_thumb = array();
									}	
							?>
							
								
									
									<img alt="Preview Image <?=$i;?>"
									 src="<?php echo $img_url_thumb[0]; ?>"
									 data-image="<?=$img_url[0]?>"
									 data-description="<?php the_title(); ?> Image #<?=$i?>">
								
								
								
							<?php } ?>
							<?php endif; ?>
						</div>
					</div>
					<?php endif; ?>
					<?php /*
					<div id="menu3" class="tab-pane fade">
						<?php $args = array('per_page' => 6, 'author' => $getAuthor) ?>
					  <?php $pressrelease = new Cokspressrelease_Library_Function; ?>
					  <?php echo $pressrelease->renderPosts($args); ?>
					</div>
					<div id="menu4" class="tab-pane fade">
					  <?php $args = array(
							'posts_per_page' => 6,
							'nopaging' => false,
							'update_post_term_cache' => false, 
							'update_post_meta_cache' => false, 
							'post_type' => 'news',
							'orderby' => 'menu_order ID',
							'order'   => 'DESC',
							'post_author' => $getAuthor
							
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
							$list[] = "No news available.";
						}
						?>
						<?php echo join($list); ?>
					</div>
					*/ ?>
				  </div>
				</div>
			<?php endwhile;	?>
			<div class="right-column">
				<div class="block block-right">
					<div class="block-title">Stats</div>
					<div class="block-content">
						<div class="pull-right" style="padding-bottom:20px;display:table;height:30px;">
							<div class="visitors float-left" style="padding: 0 15px;display:table-cell;vertical-align:middle;"><?=get_visitors();?> Visits</div>
							<div class="rating float-right" style="display:table-cell;vertical-align:middle;"><?php echo do_shortcode("[rating]");?></div>
						</div>
					</div>
				</div>
				<?php //echo get_sidebar('business'); ?>
				<?php echo get_sidebar('contact'); ?>
			</div>
			
		</div>	
		<div class="clear">&nbsp;</div>
	</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	  <h4 class="modal-title" id="exampleModalLabel">New message</h4>
	</div>
	<div class="modal-body business">
	  <form>
		<div class="form-group">
		  <label for="recipient-name" class="form-control-label">Recipient:</label>
		  <input type="text" class="form-control" id="recipient-name">
		</div>
		<div class="form-group">
		  <label for="message-text" class="form-control-label">Message:</label>
		  <textarea class="form-control" id="message-text"></textarea>
		</div>
	  </form>
	</div>
	<div class="modal-footer business">
	  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	  <button type="button" class="btn btn-danger">Send message</button>
	</div>
  </div>
</div>
</div>

<?php if($unclaim ): ?>
<div class="modal fade" id="claimBusiness" tabindex="-1" role="dialog" aria-labelledby="ClaimBusinessLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	  <h4 class="modal-title" id="exampleModalLabel">New message</h4>
	</div>
	<div class="modal-body business">
	  <?php echo do_shortcode('[contact-form-7 title="Form Claim Business"]'); ?>
	</div>
	<div class="modal-footer business">
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
  </div>
</div>
</div>
<?php endif; ?>

<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" style="width:auto; max-width: 80%;" role="document">
  <div class="modal-content">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	  <h4 class="modal-title" id="exampleModalLabel">Image Gallery</h4>
	</div>
	<div class="modal-body">
	  <center><img src="" id="imagepreview" class="img-responsive"></center>
	</div>
	<div class="modal-footer">
	  <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
	</div>
  </div>
</div>
</div>
<script type="text/javascript">
	(function($){
		jQuery("#gallery").unitegallery({
			gallery_autoplay:true,						//true / false - begin slideshow autoplay on start
			gallery_play_interval: 7000,				//play interval of the slideshow
			gallery_pause_on_mouseover: true,
			slider_scale_mode: "fit",					// Fit or Fill

			slider_enable_progress_indicator: true,				
			slider_progress_indicator_type: "bar",	   //pie, pie2, bar (if pie not supported, it will switch to bar automatically)		
			slider_progressbar_color:"#ffffff",			 //progress bar color
			slider_progressbar_opacity: 0.5,			 //progress bar opacity
			slider_progressbar_line_width: 5,			 //progress bar line width
			slider_progress_indicator_offset_hor:0,		

			slider_enable_play_button: false,
			slider_enable_zoom_panel: false,	

		});
		$('#claimBusiness').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var businessName = button.data('whatever') // Extract info from data-* attributes
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		  var modal = $(this)
		  modal.find('#exampleModalLabel').text('Claim for ' + businessName)
		  modal.find('input#business_name').val(businessName)
		})
	})(jQuery);

</script>
<?php get_footer(); ?>