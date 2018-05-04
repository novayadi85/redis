<?php 
function create_select_tax($array = array()){
	if(empty($array)){
		$array = array('label' => "Select category", 'name'=> 'keycategory', 'tax' => 'category' , 'class' => "");
	} 
	$array = (object) $array;
	$locations = get_terms( 'business-' . $array->tax, array(
		'hide_empty' => false,
		'orderby' => 'name',
		'order' => 'ASC',
		'parent' => empty($array->parent) ? '' : $array->parent,
	) );

	$html[] = "<select name='{$array->name}' id='{$array->name}' class='f-left s-location s-customs form-control {$array->class}'>";
		$html[] = "<option value=''>{$array->label}</option>";
	foreach ($locations as $location) {
		$html[] = "<option value='{$location->name}'>{$location->name}</option>";
	}
	$html[] = "</select>";
	return join($html);
}