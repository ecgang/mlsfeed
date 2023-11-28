<?php global $property; ?>
<ul class="item-amenities item-amenities-with-icons">
	<?php

	$listing_data_composer = array('enabled' => array(
			array("key" => "bed_room", "label" => "Bed", "icon" => 'bed'),
			array("key" => "bath_room", "label" => "Bath", "icon" => 'bath'),
			#array("key" => "rooms", "label" => "Floors", "icon" => ''),
			array("key" => "square_feet", "label" => "Cons. m²", "icon" => 'building'),
			array("key" => "lot_size", "label" => "Lot", "icon" => 'vector-square'),
        ));
	$data_composer = $listing_data_composer['enabled'];

	$i = 0;
	if ($data_composer) {
		foreach ($data_composer as $key => $value) { $i ++;
			$meta_type = false;
			$field_title = $value['label'];
			
	        $custom_field_value = is_numeric($property->{$value['key']}) ? mlsUtility::getInstance()->showNumberFormat($property->{$value['key']}) : $property->{$value['key']} ;

			$output = '';
	        if ($custom_field_value > 0 and is_numeric($custom_field_value)) {
				$output .= '<li class="h-'.$value['key'].'" style="text-align:center;">';
					$output .= '<span class="hz-figure">';
						$output .= esc_attr($custom_field_value);
						$output .= '<i class="fa fa-'.$value['icon'].' ml-1"></i>';
					$output .= '</span>';
						$output .= esc_attr($field_title);
				$output .= '</li>';
	        }elseif($custom_field_value != '' and !is_numeric($custom_field_value)){
	        	$output = '';
				$output .= '<li class="h-'.$value['key'].'" style="text-align:center;">';
					$output .= '<span class="hz-figure">';
						$output .= esc_attr($custom_field_value);
						$output .= '<i class="fa fa-'.$value['icon'].' ml-1"></i>';
					$output .= '</span>';
						$output .= esc_attr($field_title);
				$output .= '</li>';
	        }
			echo $output;
		}
	}
	?>
</ul>