<?php
$prop_bed  = advmls_get_listing_data('property_bedrooms');
$prop_bed_label = ($prop_bed > 1 ) ? advmls_option('glc_beds', 'Beds') : advmls_option('glc_bed', 'Bed');

$output = '';
if( $prop_bed != '' ) { 
	$output .= '<li class="h-beds">';

		if(advmls_option('icons_type') == 'font-awesome') {
			$output .= '<i class="'.advmls_option('fa_bed').' mr-1"></i>';

		} elseif (advmls_option('icons_type') == 'custom') {
			$cus_icon = advmls_option('bed');

			if(!empty($cus_icon['url'])) {

				$alt = isset($cus_icon['title']) ? $cus_icon['title'] : '';
				$output .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($alt).'">';
			}
		} else {
			$output .= '<i class="advmls-icon icon-hotel-double-bed-1 mr-1"></i>';
		}
		
		$output .= '<span class="item-amenities-text">'.esc_attr($prop_bed_label).':</span> <span class="hz-figure">'.esc_attr($prop_bed).'</span>';
	$output .= '</li>';
}
echo $output;