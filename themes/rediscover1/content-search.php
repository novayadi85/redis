<div id="page-content">	
	<div id="columns-page" class="two-colums listed-page container">
		<div class="section-web">
			<div class="main-column">
				<h2><?php echo __('Search: "'). $_GET['s'] . '"'; ?></h2>
				<?php if( have_posts() ): 
					while ( have_posts() ) : 
						the_post();
					?>
					<div class="box-list archive">
						<div class="text-content">
							<h2><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a><br />
							<small><?php echo get_the_date() ." by " . get_the_author(); ?></small></h2>					
							<p><?php echo get_the_excerpt(); ?></p>
							<div class="btn btn-more f-right"><a href="<?php echo get_permalink(); ?>" class="whitelink">Read More</a></div>
							
						</div> 
						<div class="strip-text-box">
							&nbsp;
						</div>
					</div>
					<?php
					endwhile;
					the_posts_pagination( array(
						'screen_reader_text' => __( ' ' ),
						'prev_text'          => "&laquo;" . __( 'Prev' ),
						'next_text'          => __( 'Next' ) . "&raquo;",
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( '' ) . ' </span>',
					) );					
					
				else: ?>
					<div class="text-content">				
						<?php print _("No post found."); ?>
					</div>
				<?php endif; ?>
			</div>
			
			<?php echo add_right_column(); ?>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
</div>

