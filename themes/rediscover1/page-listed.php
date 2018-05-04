<?php 
/**
 * Template Name: Listed Template
 * Description: A Page Template that showcases Sticky Posts, Asides, and Blog Posts
 *
 */
get_header(); ?>
<div id="page-content">	
	<div id="columns-page" class="two-colums listed-page container">
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
			
			<?php //echo add_right_column(); ?>
		</div>	
		<div class="clear">&nbsp;</div>
	</div>
</div>
<?php get_footer(); ?>