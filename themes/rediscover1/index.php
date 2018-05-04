<?php get_header(); ?>
	<?php if ( !is_search() && !isset($_GET['s'])) : ?>
		<?php get_template_part( 'content', '2columnsright' ); ?>
	<?php else: ?>
		<div class="entry-summary">
			<?php get_template_part( 'content', 'search' ); ?>
		</div>
	<?php endif; ?>
<?php get_footer(); ?>