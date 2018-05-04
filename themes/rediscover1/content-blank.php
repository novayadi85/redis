<div id="page-content">	
	<div id="columns-page" class="two-colums listed-page container">
		<div class="section-web">
			<div class="main-column">
				<h2><?php echo the_title() ?></h2>
				<div class="text-content">
					<?php 
					if( have_posts() ): 
					while ( have_posts() ) : 
						the_post();
					?>
					
					<p><?php  add_filter( 'the_content', the_content()) ; ?></p>
					<?php endwhile;?>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
</div>