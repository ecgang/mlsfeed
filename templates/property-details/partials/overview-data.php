<?php

$overview_data_composer = array('enabled' => array(
           # array("key" => "type_name", "label" => "Pro Type", "icon" => ''),
            array("key" => "bed_room", "label" => "Bed", "icon" => 'bed'),
			array("key" => "bath_room", "label" => "Bath", "icon" => 'bath'),
			array("key" => "number_of_floors", "label" => "Floors", "icon" => 'layer-group'),
			array("key" => "garage", "label" => "Garage", "icon" => ''),
			array("key" => "square_feet", "label" => "Cons. m²", "icon" => 'building'),
			array("key" => "lot_size", "label" => "Lot", "icon" => 'vector-square'),
			array("key" => "built_on", "label" => "Year Built", "icon" => ''),
        ));


$overview_data = $overview_data_composer['enabled'];

$i = 0;
if ($overview_data) {

	foreach ($overview_data as $key => $value) { $i ++;
		$meta_type = false;
		$field_title = $value['label'];

        $custom_field_value = is_numeric($this->getDataDetails($value['key'])) ? mlsUtility::getInstance()->showNumberFormat($this->getDataDetails($value['key']),7) : $this->getDataDetails($value['key']) ;
        
		$output = '';
		if ($custom_field_value > 0 and is_numeric($custom_field_value)) {
			$output .= '<ul class=" h-'.$value['key'].' list-unstyled flex-fill text-center">';
				$output .= '<li class="property-overview-item">';
					
					$output .= esc_attr($custom_field_value);
					$output .= '<i class="fa fa-'.$value["icon"].' ml-1"></i>';
					
				$output .= '</li>';
				$output .= '<li>'.esc_attr($field_title).'</li>';
			$output .= '</ul>';
		}elseif($custom_field_value != '' and !is_numeric($custom_field_value)){
			$output .= '<ul class="list-unstyled flex-fill text-center">';
				$output .= '<li class="property-overview-item">';
					
					$output .= esc_attr($custom_field_value);
					$output .= '<i class="fa fa-'.$value["icon"].' ml-1"></i>';
					
				$output .= '</li>';
				$output .= '<li>'.esc_attr($field_title).'</li>';
			$output .= '</ul>';
		}
		echo $output;
	}
}
