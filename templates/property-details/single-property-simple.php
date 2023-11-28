<?php 

if ($layout): foreach ($layout as $key=>$value) {

    switch($key) {

        case 'overview':
            if($top_area != 'v6') {
			    include_once($pathTemplate.'property-details/overview.php'); 
			}
            break;

        case 'description':
            include_once($pathTemplate.'property-details/description.php'); 
            break;

        case 'open_house':
            include_once($pathTemplate.'property-details/open-house.php'); 
            break;

        case 'address':
            include_once($pathTemplate.'property-details/address.php');
            break;

        case 'details':
            include_once($pathTemplate.'property-details/detail.php');
            break;

        case 'features':
            include_once($pathTemplate.'property-details/features.php');
            break;

        case 'video':
            include_once($pathTemplate.'property-details/video.php');
            break;

        case 'similar_properties':
            include_once($pathTemplate.'property-details/similar-properties.php');
            break;

    }
}
endif;
?>