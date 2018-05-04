<?php //echo do_shortcode("[slider_img]"); ?>
<?php $slide = new Cokslider_Library_Sliderfunction; ?>
<?php $businessPost = new Coksbusiness_Library_Shortcode; ?>
<?php $getSearchImage = wp_get_attachment_image_src( 30, 'full'); ?>
<?php ?>
<div id="home-slider">
	<div class="search-box-holder">
		<div class="search-box-slide">
			<div class="search-canvas">
				<div class="f-left"><b class="s-label"><i><?php echo __('Search'); ?>:</i></b></div>
				<div class="form-search">
					<form method="GET" action="<?php echo homeUrl('searchbusiness'); ?>" id="form-search">
					<input type="text" name="keyname" value="" placeholder="Find Products / Services / Events in Melbourne" class="f-left s-keyword" >
					<?php echo create_select_tax(); ?>
					<?php //echo create_select_tax(array('label' => "Select location", 'name'=> 'locations', 'tax' => 'location' , 'class' => "last")); ?>
					
					<input value="" class="f-left s-button" type="submit" >
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php $pAttrCust = get_post_meta( $post->ID, '__slider_rel', true ); ?>
	<?php echo $slide->big_slider(array('id' => $pAttrCust)); ?>
	
</div>

<div id="page-content">
	<div id="columns-page" class="one-colum home container">		
		<div class="section-web">
			<div class="main-column">
				<?php while ( have_posts() ) : 
					the_post();
					?>
					<div class="text-content">
						<h4><?php echo __('Featured Businesses'); ?></h4>
						<?php echo $businessPost->render_business("ASC",'Premium',12); ?>
						<?php //echo $businessPost->render_business("ASC"); ?>
						<p>&nbsp;</p>
						<h4 class="f-left"><?php echo __('Popular Categories'); ?> </h4><a href="<?php echo homeUrl('business-categories'); ?>" class="btn btn-viewmore">View More</a> 
						<p>&nbsp;</p>
						<div class="business-flex" id="business-slide">
						<?php  $popular_categories = Coksbusiness_Library_PopularCategories::getPopularCategories(); ?>
							<ul class="grid-slide">
								
								<?php 								
								$i=0; 
								$_catCount = count($popular_categories);
								if( $_catCount > 0  ):
								foreach($popular_categories as $cat): 								
								
									$i++;
									$image = wp_get_attachment_image_src(  $cat->image_id, 'medium' ); 
									$imgSrc = empty($image) ? homeUrl('wp-content/plugins/coksbusiness/Source/images/default-logo.jpg') : $image[0]; 
									?>
									<li class="grid-item <?php if ($i == $_catCount) echo " last"; ?>">
										<div class="grid-thumb">
											<a href="<?php echo get_term_link($cat->slug,"business-category");?>"><img alt="<?php echo $cat->name;?>" src="<?php echo $imgSrc;?>"></a>
										</div>
										<div class="grid-text only-title"><h4><a href="<?php echo get_term_link($cat->slug,"business-category");?>"><?php echo $cat->name;?></a></h4></div>
									</li> 
								<?php endforeach; endif; ?>
								
							</ul>
						</div>
						<?php the_content(); ?>
					</div> 
					<?php
					endwhile;
					?>
			</div>
		</div>	
		<div class="clear">&nbsp;</div>
	</div>
</div>


