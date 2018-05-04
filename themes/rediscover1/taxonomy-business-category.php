<?php
/**
* The template for displaying all pages.
*/

get_header();
?>	
<?php $businessPost = new Coksbusiness_Library_Shortcode; ?>
<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>
<?php $array = array("count" => 12, "order" => "ASC", "term_id" => $term->term_id, 'type' => 'Premium'); ?>
<?php $businessPost->setBusinessPostsByCat($array); ?>		
<div id="page-content">
	<div id="columns-page" class="two-colums column-left regular-page container">	
		<div class="section-web">			
			<div class="left-column">
				<?php echo get_sidebar('categories'); ?>
			</div>
			<div class="main-column">
				<?php if($businessPost->count_business_cat_posts() > 0): ?>
				<h4 class="page-title"><?php echo $term->name; ?> (<?php echo $businessPost->count_business_cat_posts(); ?> result<?php echo ($businessPost->count_business_cat_posts() > 1) ? 's' : ''; ?>)</h4>
				<p><?php echo $term->description; ?></p>
				<?php else: ?>
					<h4 class="page-title"><?php echo $term->name; ?></h4>
				<?php endif; ?>
				<div class="text-content">										  
					<?php echo $businessPost->getBusinessPostsByCat(); ?>
					
					<p>&nbsp;</p>
					<?php $array = array("count" => 20, "order" => "ASC", "term_id" => $term->term_id, 'type' => ''); ?>
					<?php $businessPost->setBusinessPostsByCat($array); ?>
					<?php if($businessPost->count_business_cat_posts() > 0): ?>
					<p><b>More User Suggested (<?php echo $businessPost->count_business_cat_posts(); ?> result<?php echo ($businessPost->count_business_cat_posts() > 1) ? 's' : ''; ?>)</b></p>
												
					<?php echo $businessPost->getBusinessPostsByCat(); ?>	
					<?php endif; ?>				  
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="claimBusiness" tabindex="-1" role="dialog" aria-labelledby="ClaimBusinessLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	  <h4 class="modal-title" id="exampleModalLabel">New message</h4>
	</div>
	<div class="modal-body business">
	  <?php echo do_shortcode('[contact-form-7 title="Form Claim Business"]'); ?>
	</div>
	<div class="modal-footer business">
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
  </div>
</div>
</div>
<script type="text/javascript">
	(function($){
		$('#claimBusiness').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var businessName = button.data('whatever') 
		  var modal = $(this)
		  modal.find('#exampleModalLabel').text('Claim for ' + businessName)
		  modal.find('input#business_name').val(businessName)
		})
	})(jQuery);

</script>
<?php
	get_footer(); 
?>