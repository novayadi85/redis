<?php get_header(); ?>
<div id="page-content">	
	<div id="columns-page" class="two-colums regular-page container">
		<div class="section-web">
			<div class="main-column">
				<?php while ( have_posts() ) : 
					the_post();
					?>
					<div class="page-title"><h2><?php the_title(); ?><br /><small><?php echo get_the_date() ." by " . get_the_author(); ?></small></h2></div>
					<div class="text-content">
					<?php the_content(); ?>
					</div> 
					<?php
					endwhile;
				?>
			</div>			
			<div class="right-column">
				<?php echo get_sidebar('ads'); ?>
			</div>
		</div>	
		<div class="clear">&nbsp;</div>
	</div>
</div>
<?php get_footer(); ?>