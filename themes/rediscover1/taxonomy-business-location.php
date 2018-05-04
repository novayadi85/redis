<?php
/**
* The template for displaying all pages.
*/

get_header();
?>	
<?php $businessPost = new Coksbusiness_Library_Shortcode; ?>
<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>
<?php $array = array("count" => 12, "order" => "ASC", "term_id" => $term->term_id); ?>
<?php $businessPost->setBusinessPostsByCat($array,'location'); ?>		
<div id="page-content">
	<div id="columns-page" class="two-colums column-left regular-page container">	
		<div class="section-web">			
			<div class="left-column">
				<?php echo get_sidebar('locations'); ?>
			</div>
			<div class="main-column">
				<h4 class="page-title"><?php echo $term->name; ?> (<?php echo $businessPost->count_business_cat_posts(); ?> results)</h4>
				<p><?php echo $term->description; ?></p>
				<div class="text-content">										  
					<?php echo $businessPost->getBusinessPostsByCat(); ?>					  
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	get_footer(); 
?>