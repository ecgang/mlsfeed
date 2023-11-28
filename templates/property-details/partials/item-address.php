<?php
$address_composer = array("enabled" => array(
	"address" => "Address",
	#"country_name" => "Country",
	"state_name" => "State",
	"city_name" => "City",
	"postcode" => "Postcode",
	"region" => "Region",
));
$enabled_data = $address_composer['enabled'];
$temp_array = array();

echo '<address class="item-address"><i class="advmls-icon icon-pin mr-1"></i>';

if ($enabled_data) {
	unset($enabled_data['placebo']);
	foreach ($enabled_data as $key=>$value) {
		if( $key == 'address' ) {
			$temp_array[] = $this->getDataDetails('address');

		} else if( $key == 'country_name' ) {
			$temp_array[] = $this->getDataDetails('country_name');

		} else if( $key == 'state_name' ) {
			$temp_array[] = $this->getDataDetails('state_name');

		} else if( $key == 'city_name' ) {
			$temp_array[] = $this->getDataDetails('city_name');

		} else if( $key == 'region' ) {
			$temp_array[] = $this->getDataDetails('region');

		} else if ($key == 'postcode') {
			$temp_array[] = $this->getDataDetails('postcode');
		}
	}

	$result = join( ", ", $temp_array );
	echo $result;
}

echo '</address>';