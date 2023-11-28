<?php
global $property;
$address_composer = array(
	"enabled" => array(
	"address" => "Address",
	#"country" => "Country",
	"city" => "City",
	"state" => "State",
	"postcode" => "Postcode",
	"area" => "Region",
	)
);
$enabled_data = $address_composer['enabled'];
$temp_array = array();

echo '<address class="item-address">';

if ($enabled_data) {
	unset($enabled_data['placebo']);
	foreach ($enabled_data as $key=>$value) {

		if( $key == 'address' ) {
			$temp_array[] = !empty($property->address) ? $property->address : '';
		}

		if( $key == 'country' ) {
			$temp_array[] = !empty($property->country_name) ? $property->country_name : '';
		}

		if( $key == 'state' ) {
			$temp_array[] = !empty($property->state_name) ? $property->state_name : '';
		}

		if( $key == 'city' ) {
			$temp_array[] = !empty($property->city_name) ? $property->city_name : '';
		}

		if( $key == 'area' ) {
			$temp_array[] = !empty($property->region) ? $property->region : '';
		}

		if( $key == 'postcode' ) {
			$temp_array[] = !empty($property->postcode) ? $property->postcode : '';
		}

	}

	$result = join( ", ", $temp_array );
	echo $result;
}

echo '</address>';