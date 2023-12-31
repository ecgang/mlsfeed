<?php
$property_id  = advmls_get_listing_data('property_id');
$property_id_label = advmls_option('glc_id', 'ID');

$output = '';
if( $property_id != '' ) { 
	$output .= '<li class="h-property-id">';

		if(advmls_option('icons_type') == 'font-awesome') {
			$output .= '<i class="'.advmls_option('fa_property-id').' mr-1"></i>';

		} elseif (advmls_option('icons_type') == 'custom') {
			$cus_icon = advmls_option('property-id');
			if(!empty($cus_icon['url'])) {

				$alt = isset($cus_icon['title']) ? $cus_icon['title'] : '';
				$output .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($alt).'">';
			}
		} else {
			$output .= '<i class="advmls-icon icon-tags mr-1"></i>';
		}
		
		$output .= '<span class="item-amenities-text">'.esc_attr($property_id_label).':</span> <span class="hz-figure">'.esc_attr($property_id).'</span>';
	$output .= '</li>';
}
echo $output;