<?php

$prop_id = $this->getDataDetails('ref');
$prop_price = mlsUtility::getInstance()->showNumberFormat($this->getDataDetails('price'));
$prop_size = mlsUtility::getInstance()->showNumberFormat($this->getDataDetails('square_feet'));
$land_area = mlsUtility::getInstance()->showNumberFormat($this->getDataDetails('lot_size'));
$bedrooms = mlsUtility::getInstance()->showNumberFormat($this->getDataDetails('bed_room'));
$rooms = mlsUtility::getInstance()->showNumberFormat($this->getDataDetails('rooms'));
$bathrooms = mlsUtility::getInstance()->showNumberFormat($this->getDataDetails('bath_room'));
$year_built = mlsUtility::getInstance()->showNumberFormat($this->getDataDetails('built_on'),7);
$garage = $this->getDataDetails('garage');
$property_status = $this->getDataDetails('type_name');
$property_type = $this->getDataDetails('category_name');
$garage_size = $this->getDataDetails('garage_size');

?>
<div class="detail-wrap justify-content-between">
	<ul class="list-2-cols list-unstyled">
		<?php
        if( !empty( $prop_id ) ) {
            echo '<li>
	                <strong>'.('Property ID').':</strong> 
	                <span>'.$prop_id.'</span>
                </li>';
        }

        if( !empty( $prop_price ) ) {
            echo '<li>
	                <strong>'.('Price'). ':</strong> 
	                <span>'.$prop_price.'</span>
                </li>';
        }
        
        if( !empty( $property_type )) {
            echo '<li class="prop_type">
                    <strong>'.('Property Type').':</strong> 
                    <span>'.esc_attr( $property_type ).'</span>
                </li>';
        }
        if( !empty( $property_status )) {
            echo '<li class="prop_status">
                    <strong>'.('Property Status').':</strong> 
                    <span>'.esc_attr( $property_status ).'</span>
                </li>';
        }
        if( !empty( $year_built ) ) {
            echo '<li>
                    <strong>'.('Year Built').':</strong> 
                    <span>'.esc_attr( $year_built ).'</span>
                </li>';
        }
        if( !empty( $prop_size ) ) {
            echo '<li>
	                <strong>'.( 'Construction m²'). ':</strong> 
	                <span>'.$prop_size.'</span>
                </li>';
        }

        if( !empty( $land_area ) ) {
            echo '<li>
	                <strong>'.( 'Lot Size m²'). ':</strong> 
	                <span>'.$land_area.'</span>
                </li>';
        }
        if( !empty( $bedrooms ) ) {
            $bedrooms_label = ($bedrooms > 1 ) ? ( 'Bedrooms') : ( 'Bedroom');

            echo '<li>
	                <strong>'.esc_attr($bedrooms_label).':</strong> 
	                <span>'.esc_attr( $bedrooms ).'</span>
                </li>';
        }
        if( !empty( $bathrooms ) ) {

            $bath_label = ($bathrooms > 1 ) ? ( 'Bathrooms') : ('Bathroom');
            echo '<li>
	                <strong>'.esc_attr($bath_label).':</strong> 
	                <span>'.esc_attr( $bathrooms ).'</span>
                </li>';
        }
        if( !empty( $rooms ) ) {
            #$rooms_label = ($rooms > 1 ) ? ( 'Rooms') : ( 'Room');
            $rooms_label = 'Half Baths';
            echo '<li>
                    <strong>'.esc_attr($rooms_label).':</strong> 
                    <span>'.esc_attr( $rooms ).'</span>
                </li>';
        }
        if( $garage != "" ) {

            $garage_label = ($garage > 1 ) ? ( 'Garages') : ( 'Garage');
            echo '<li>
	                <strong>'.esc_attr($garage_label).':</strong> 
	                <span>'.esc_attr( $garage ).'</span>
                </li>';
        }
        if( !empty( $garage_size ) ) {
            echo '<li>
	                <strong>'.('Garage Size').':</strong> 
	                <span>'.esc_attr( $garage_size ).'</span>
                </li>';
        }

        ?>
	</ul>
</div>