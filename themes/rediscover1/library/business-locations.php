
<?php 
	$locations = get_terms( 'business-category', array(
		'orderby'    => 'count',
		'hide_empty' => 0,
		'orderby' => 'term_id',
		'order' => 'ASC',
		'name__like' => !empty($_GET['query']) ? $_GET['query'] : '',
	) );
	foreach($locations as $location){
		$json[] = array(
			'label' => $location->name,
			'value' => $location->name
			);
	}
	echo json_encode(($json));
?>