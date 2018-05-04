<div class="block block-left">
	<div class="block-title">
		<?php echo __('By Categories'); ?>
		<button type="button" class="navbar-toggle collapsed pull-right nav-categories" data-toggle="collapse" data-target="#bs-categories">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	
	<div class="block-content">
		<div class="term-left collapse"  aria-expanded="true" id="bs-categories">
			<ul class="term-lists-bc">
			<?php 
				$categories = get_terms( 'business-category', array(
					'hide_empty' => 0,
					'orderby' => 'name',
					'order' => 'ASC',
				) );
				foreach($categories as $category){
					echo "<li class='item'><a href='". get_term_link($category->term_id) . "'>{$category->name} ({$category->count})</a> </li>" ;
				}
			?>
			</ul>
		</div>
	</div>
</div>