<?php

$address = $this->getDataDetails('address');
$zipcode = $this->getDataDetails('postcode');

$country = $this->getDataDetails('country_name');
$city = $this->getDataDetails('city_name');
$state = $this->getDataDetails('state_name');
$area = $this->getDataDetails('region');

if( !empty($address) ) {
    echo '<li class="detail-address"><strong>'. 'Address'.'</strong> <span>'.esc_attr( $address ).'</span></li>';
}
if( !empty( $city ) ) {
    echo '<li class="detail-city"><strong>'. 'City' .'</strong> <span>'.esc_attr( $city ).'</span></li>';
}
if( !empty( $state ) ) {
    echo '<li class="detail-state"><strong>'. 'State'.'</strong> <span>'.esc_attr( $state ).'</span></li>';
}
if( !empty($zipcode) ) {
    echo '<li class="detail-zip"><strong>'. 'Zip/Postal Code'.'</strong> <span>'.esc_attr( $zipcode ).'</span></li>';
}
if( !empty( $area ) ) {
    echo '<li class="detail-area"><strong>'. 'Area' .'</strong> <span>'.esc_attr( $area ).'</span></li>';
}
if( !empty($country) ) {
    echo '<li class="detail-country"><strong>'.'Country'.'</strong> <span>'.esc_attr($country).'</span></li>';
}