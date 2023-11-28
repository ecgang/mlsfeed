<?php
$property_type = $this->getFielProperty('type_name', $currentKey);

$output = '';
if(!empty($property_type)) {
	$output .= '<li class="h-type">';
		$output .= '<span>'.esc_attr($property_type).'</span>';
	$output .= '</li>';
}

if(get_option('disable_type', 1)) {
	echo $output;
}