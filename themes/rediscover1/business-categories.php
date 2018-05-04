<?php get_header(); ?>	
	
<div id="page-content">
	<div id="columns-page" class="two-colums column-left regular-page container">	
		<div class="section-web">			
			<div class="left-column">
				<?php echo get_sidebar('categories'); ?>
			</div>
			<div class="main-column">
				<h4 class="page-title"><?php echo __('Popular Categories') ?></h4>
				<p>&nbsp;</p>
				<div class="text-content">										  
					<div class="business-flex" id="business-slide">
						<?php  $popular_categories = Coksbusiness_Library_PopularCategories::getPopularCategories('all'); ?>
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
				</div>
			</div>
		</div>
	</div>
</div>
<?php	get_footer(); ?>