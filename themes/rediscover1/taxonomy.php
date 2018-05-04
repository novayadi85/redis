<?php
/**
* The template for displaying all pages.
*/

get_header();
?>	
<div class="business-flex" id="business-slide">
<?php  $popular_categories = Coksbusiness_Library_PopularCategories::getPopularCategories(); ?>
	<ul class="grid-slide">
		
		<?php 								
		$i=0; 
		$_catCount = count($popular_categories);
		if( $_catCount > 0  ):
		foreach($popular_categories as $cat): 								
		
			$i++;
			$image = wp_get_attachment_image_src(  $cat->image_id ); 
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
<?php
	get_footer(); 
?>