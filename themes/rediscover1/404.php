<?php
/**
 * The template for displaying 404 pages (not found)
 *
 */

get_header(); ?>
<div id="page-content">	
	<div id="columns-page" class="two-colums regular-page container">
		<div class="section-web">
			<div class="main-column">
				<div class="page-title"><h2><?php _e( 'Oops! That page can&rsquo;t be found.' ); ?></h2></div>
				<div class="text-content">
					<p><?php _e( 'It looks like nothing was found at this location.' ); ?></p>
				</div> 
			</div>
		</div>	
		<div class="clear">&nbsp;</div>
	</div>
</div>

<?php get_footer(); ?>

