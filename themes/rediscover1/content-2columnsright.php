<?php $slide = new Cokslider_Library_Sliderfunction; ?>
<div id="otherpage-slider">
	<?php $pAttrCust = get_post_meta( $post->ID, '__slider_rel', true ); ?>
	<?php if($pAttrCust): ?>
		<?php echo $slide->big_slider(array('id' => $pAttrCust)); ?>
	<?php else: ?>
		<?php $f_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full'); ?>
			<?php if(!empty($f_image_url)): ?>
			<div class="page-cover-img">
				<img class="img-detail img-responsive" src="<?php print $f_image_url[0]; ?>" />
			</div>
		<?php endif; ?>
	<?php endif; ?>
</div>
<div id="page-content">	
	<div id="columns-page" class="two-colums regular-page container">
		<div class="section-web">				
			<div class="main-column">
				<?php while ( have_posts() ) : 
					the_post();
					?>
					<div class="page-title"><h2><?php the_title(); ?></h2></div>
					<div class="text-content">
					<?php the_content(); ?>
					</div> 
					<?php
					endwhile;
				?>
			</div>
			<div class="right-column">
				<?php $f_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full'); ?>
				<?php if(!empty($f_image_url)): ?>
				<div class="img-det">
					<img class="img-detail img-responsive" src="<?php print $f_image_url[0]; ?>" />
				</div>
				<?php endif; ?>
			</div>
		</div>	
		<div class="clear">&nbsp;</div>
	</div>
</div>

