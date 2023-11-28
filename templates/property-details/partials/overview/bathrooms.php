<?php
$bathrooms 	= advmls_get_listing_data('property_bathrooms');

if(!empty($bathrooms)) {

	$bath_label = ($bathrooms > 1 ) ? advmls_option('spl_bathrooms', 'Bathrooms') : advmls_option('spl_bathroom', 'Bathroom');

	$output_bath = '';
	$output_bath .= '<ul class="list-unstyled flex-fill">';
			$output_bath .= '<li class="property-overview-item">';
				
				if(advmls_option('icons_type') == 'font-awesome') {
					$output_bath .= '<i class="'.advmls_option('fa_bath').' mr-1"></i> ';

				} elseif (advmls_option('icons_type') == 'custom') {
					$cus_icon = advmls_option('bath');
					if(!empty($cus_icon['url'])) {

						$alt_title = isset($cus_icon['title']) ? $cus_icon['title'] : '';
						$output_bath .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($alt_title).'"> ';
					}
				} else {
					$output_bath .= '<i class="advmls-icon icon-bathroom-shower-1 mr-1"></i> ';
				}

				$output_bath .= '<strong>'.esc_attr($bathrooms).'</strong>';
			$output_bath .= '</li>';
			$output_bath .= '<li class="hz-meta-label h-baths">'.esc_attr($bath_label).'</li>';
		$output_bath .= '</ul>';

	echo $output_bath;
}