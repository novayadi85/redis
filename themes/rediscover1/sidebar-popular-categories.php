<div class="block block-left">
	<div class="block-title">
		<?php echo __('By Categories'); ?>
	</div>
	<div class="block-content">
		<ul class="term-lists-bc">
		<?php 
			$categories = get_terms( 'business-category', array(
				'orderby'    => 'count',
				'hide_empty' => 0,
				'orderby' => 'term_id',
				'order' => 'ASC',
			) );
			foreach($categories as $category){
				echo "<li class='item'><a href='". get_term_link($category->term_id) . "'>{$category->name} ({$category->count})</a> </li>" ;
			}
		?>
		</ul>
	</div>
</div>