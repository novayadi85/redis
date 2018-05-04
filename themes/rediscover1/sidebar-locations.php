<?php 
function catAsChild($locations, $open = ' close'){
	$categories = get_terms( 'business-category', 
			array(
				'hide_empty' => 0,
				'orderby' => 'name',
				'order' => 'ASC',
			)
	);

	$html[] = '<ul class="children' . $open . '">';
	foreach($categories as $category){
		$isCatOpen = (!empty($_GET['keycategory']) && urldecode($_GET['keycategory']) == $category->name) ? ' open' : '';
		$bold = ($isCatOpen == ' open') ? ' f-bold' : '';
		$html[] = "<li class='item'><a href='". homeUrl(sprintf('searchbusiness?keyname=&keycategory=%s&locations=%s',urlencode($category->name), urlencode($locations))) . "' class='a-lick-cat" . $bold . "'>{$category->name} ({$category->count})</a> </li>";
	}
	$html[] = "</ul>";

	return join($html);
}
?>

<div class="block block-left">
	<div class="block-title">
		<?php echo __('By Location'); ?>
	</div>
	<div class="block-content">
		<ul class="term-lists-bc">
		<?php 
			$locations = get_terms( 'business-location', array(
				'hide_empty' => 0,
				'orderby' => 'name',
				'order' => 'ASC',
				'parent' => 9
			) );
			foreach($locations as $location){
				$isOpen = (!empty($_GET['locations']) && $_GET['locations'] == $location->name) ? ' open' : ' close';
				$plus = ($isOpen == ' open') ? 'minus' : 'plus';
				$bold = ($isOpen == ' open') ? ' f-bold' : '';
				echo "<li class='item has-children'><a href='". get_term_link($location->term_id) . "' class='f-left loc-title a-block{$bold}'>{$location->name} ({$location->count})</a> <a href='#' class='f-right a-block loc-colapse'><i class='fa fa-{$plus}'> </i></a> " ;
				echo catAsChild($location->name,$isOpen );
				echo "</li>";
			}
		?>
		</ul>
	</div>
</div>