<div id="page-content">	
	<div id="columns-page" class="two-colums listed-page container">
		<div class="section-web">
			<div class="main-column">
				<?php if( have_posts() ): 
					while ( have_posts() ) : 
						the_post();
					?>
					<div class="box-list archive">
						<div class="text-content">
							<h2><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a><br />
							<small><?php echo get_the_date() ." by " . get_the_author(); ?></small></h2>					
							<p><?php echo get_the_excerpt(); ?></p>
							<div class=""><a href="<?php echo get_permalink(); ?>" class="btn btn-warning">Read More</a></div>
							
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
						<?php print _("No business available on this category."); ?>
					</div>
				<?php endif; ?>
			</div>
			
			<?php //echo add_right_column(); ?>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
</div>

