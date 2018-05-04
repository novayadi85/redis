<?php $slide = new Cokslider_Library_Sliderfunction; ?>
<div id="otherpage-slider">
	<?php $pAttrCust = get_post_meta( $post->ID, '__slider_rel', true ); ?>
	<?php if($pAttrCust): ?>
	<?php echo $slide->big_slider(array('id' => $pAttrCust)); ?>
	<?php endif; ?>
</div>
<div id="page-content">	
	<div id="columns-page" class="two-colums regular-page container">
		<div class="section-web">			
			<div class="left-column">
				<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d6303.414419012854!2d144.9463033!3d-37.8203265!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d5086855555%3A0x480bb31885a9b7ab!2sRegus!5e0!3m2!1sen!2sid!4v1472739467468" width="285" height="433" frameborder="0" style="border:0" allowfullscreen></iframe>
			</div>
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
		</div>	
		<div class="clear">&nbsp;</div>
	</div>
	<div class="grey-brutton">
		<div class="whyus-hatches container">
			<div class="whyus-content">
				<h2 class="whyus-title"><?php _e('Why Us?'); ?></h2>
				<?php echo add_whyus(); ?>
				<div class="action-service-whyus">
					<a href="<?php echo get_permalink(16); ?>" class="requestquote"><?php echo ('Request a quote'); ?></a>
				</div>
			</div>
			<div class="whyus-images">
				<img src="<?php echo get_template_directory_uri() . '/images/whyus_03.jpg'; ?>" alt="Why Us Image" class="img-responsive" />
			</div>
		</div>
		<div class="home-testimonial">
			<div class="container">
				<h2 class="brutton-title"><?php print __('Testimonial'); ?></h2>
				<div class="wrapper-carousel">
					<?php $carousel = new Cokslider_Library_Sliderfunction; ?> 
					<?php echo $carousel->testimonial_slider(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

