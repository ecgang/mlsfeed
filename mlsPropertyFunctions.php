<?php 

add_action( 'wp_ajax_nopriv_advmls_currency_converter', 'advmls_currency_converter' );
add_action( 'wp_ajax_advmls_currency_converter', 'advmls_currency_converter' );
function advmls_currency_converter(){

    $from_curr = isset($_POST['from_curr']) ? $_POST['from_curr'] : '' ;
    $to_curr = isset($_POST['to_curr']) ? $_POST['to_curr'] : '' ;
    $price = isset($_POST['price']) ? $_POST['price'] : 0 ;
    $keyConverter = get_option('advmls_key_converter_curr', null);

    if (!$keyConverter or empty($keyConverter)){
        echo json_encode(array(
            'success' => false,
            'msg' => esc_html__("Something was wrong", 'advmls')
        ));
        wp_die();
    }

    $currFind = strtoupper(urlencode($from_curr)."_".urlencode($to_curr));
    #$getCurrency = wp_remote_get("https://free.currencyconverterapi.com/api/v4/convert?q=".$currFind."&compact=y&apiKey=".$keyConverter."",FILE_USE_INCLUDE_PATH);
    $getCurrency = wp_remote_get("https://api.currconv.com/api/v7/convert?q=".$currFind."&compact=y&apiKey=".$keyConverter."",FILE_USE_INCLUDE_PATH);

    if (is_wp_error($getCurrency)) {
        echo json_encode(array(
            'success' => false,
            'msg' => esc_html__("Something was wrong", 'advmls')
        ));
        
        wp_die();
    }

    $converted_currency = json_decode(wp_remote_retrieve_body($getCurrency));

    if(!isset($converted_currency->{$currFind})) {
        echo json_encode(array(
            'success' => false,
            'msg' => esc_html__("Something was wrong", 'advmls')
        ));
        wp_die();
    }
    
    $newPrice = $price * $converted_currency->{$currFind}->val;
    $txtPrice = strtoupper($to_curr).' '. mlsUtility::getInstance()->showNumberFormat($newPrice);

    echo json_encode( array(
        'success' => true,
        'msg' => esc_html__('Change Successfully', 'advmls'),
        'price_converted' => $newPrice ,
        'txt_price_converted' => $txtPrice ,
        'txt_curr' => $to_curr
    ));
    wp_die();
}

function advmls_getCompanyDetails(){

	$company = json_decode(get_option('advmls_company'));

	if ( $company == null or !isset($company->company_name)) {
		$queryUrlArr = array(
		    "token" => mlsUtility::getInstance()->getActivationToken(),
		    "source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl())
		);

		$queryUrl = http_build_query($queryUrlArr);
		$companyDetails = wp_remote_get(getUrlMlsMember().'api/getcompanydetails?'.$queryUrl);
        if ( !is_wp_error($companyDetails) and isset($companyDetails['body']) ) {
            $company = json_decode($companyDetails['body']);		
        }else{
            $company = array();
        }
		update_option('advmls_company', json_encode($company));
	}

	return $company;
}

function advmls_getListRegions($selected = ""){

	//property type
	$queryUrlArr = array(
	    "token" => mlsUtility::getInstance()->getActivationToken(),
	    "source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl())
	);

	if ( is_array($selected) ) {
		$selected = $selected[0];
	}

	$queryUrl = http_build_query($queryUrlArr);
	$resultRegions = wp_remote_get(getUrlMlsMember().'api/getlistregions?'.$queryUrl);

    if ( !is_wp_error($resultRegions) and isset($resultRegions['body']) ) {
        $regions = json_decode($resultRegions['body']);
    }else{
        $regions = array();
    }

	$output = '';
	foreach ($regions as $key => $region) {
		
	    $selectedItem = ($selected === $region->id ? 'selected="selected"': '');
        if (!empty($region->name)) {
	       $output.= '<option data-belong="'.esc_attr((int)$region->city_id > 0 ? $region->city_id : 0 ).'" data-ref="'.esc_attr($region->name).'"  value="' . esc_attr($region->id) . '" '.$selectedItem.' > '. esc_attr($region->name) . '</option>';
        }
	}

	return $output;

}

function advmls_getListStates($selected){

	$queryUrlArr = array(
		    "token" => mlsUtility::getInstance()->getActivationToken(),
		    "source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl())
		);
	$queryUrl = http_build_query($queryUrlArr);
	$resultStates = wp_remote_get(getUrlMlsMember().'api/getliststates?'.$queryUrl);

    if ( !is_wp_error($resultStates) and isset($resultStates['body']) ) {
	   $listStates = json_decode($resultStates['body']);
    }else{
        $listStates = array();
    }

	$output = '';

	if ( is_array($selected) ) {
		$selected = $selected[0];
	}
	
	foreach ($listStates as $key => $state) {
		
	    $selectedItem = ($selected === $state->id ? 'selected="selected"': '');

	    $output.= '<option data-ref="'.esc_attr($state->id).'"  value="' . esc_attr($state->id) . '" '.$selectedItem.' > '. esc_attr($state->state_name) . '</option>';
	}

	return $output;
}

if( !function_exists('advmls_get_cities_list') ) {
    function advmls_get_cities_list(int $idselected ) {

        //property type
        $queryUrlArr = array(
            "token" => mlsUtility::getInstance()->getActivationToken(),
            "source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl())
        );
        
        $queryUrl = http_build_query($queryUrlArr);
        $resultCities = wp_remote_get(getUrlMlsMember().'api/getlistcities?'.$queryUrl);
        
        if ( !is_wp_error($resultCities) and isset($resultCities['body']) ) {
            $listCities = json_decode($resultCities['body']);        
        }else{
           return json_encode(array());
        }
        $output = '';
        foreach ($listCities as $key => $city) {

            $selected = ($idselected == $city->id ? 'selected="selected"': '');

            $output.= '<option data-belong="'.esc_attr($city->state_id).'" data-ref="'.esc_attr($city->city_id).'"  value="' . esc_attr($city->id) . '" '.$selected.' > '. esc_attr($city->city) . '</option>';
        }

        return $output;
    }
}

add_action( 'wp_ajax_nopriv_advmls_half_map_listings', 'advmls_half_map_listings' );
add_action( 'wp_ajax_advmls_half_map_listings', 'advmls_half_map_listings' );
if( !function_exists('advmls_half_map_listings') ) {
    function advmls_half_map_listings() {
        global $property;
        $pathTemplate = mlsConstants::ADVANTAGEMLSTPLPATH;

        $tax_query = array();
        $meta_query = array();
        $allowed_html = array();
        $keyword_array = '';
        $keyword_field = get_option('keyword_field');
        $search_num_posts = get_option('search_num_posts');

        $number_of_prop = $search_num_posts;
        if(!$number_of_prop){
            $number_of_prop = 9;
        }

        $paged = isset($_GET['paged']) ? ($_GET['paged']) : '';
        $sort_by = isset($_GET['sortby']) ? ($_GET['sortby']) : '';

        $search_qry = array(
            'post_type' => 'property',
            'posts_per_page' => $number_of_prop,
            'paged' => $paged,
            'post_status' => 'publish'
        );

        $search_location = isset($_GET['search_location']) ? esc_attr($_GET['search_location']) : false;
        $item_layout = isset($_GET['item_layout']) ? esc_attr($_GET['item_layout']) : 'v1';
        $use_radius = isset($_GET['use_radius']) ? esc_attr($_GET['use_radius']) : '';
        $search_lat = isset($_GET['lat']) ? (float)$_GET['lat'] : false;
        $search_long = isset($_GET['lng']) ? (float)$_GET['lng'] : false;
        $search_radius = isset($_GET['radius']) ? (int)$_GET['radius'] : false;

        $sort_by = 'price';
        $order_by = 'asc';

        if (isset($_GET['s_sort_by']) and !empty($_GET['s_sort_by'])) {
            if ($_GET['s_sort_by'] == 'a_price') {
                $sort_by = 'price';
                $order_by = 'asc';
            }elseif ($_GET['s_sort_by'] == 'd_price') {
                $sort_by = 'price';
                $order_by = 'desc';
            }
         }

        $queryUrlArr = array(
            "token" => mlsUtility::getInstance()->getActivationToken(),
            "source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl()),
            "page" => $paged,
            "items_per_page" => 20,
            "sort_by" => $sort_by,
            "order_by" => $order_by
        );

        $queryUrl = http_build_query($queryUrlArr).'&'.http_build_query($_REQUEST);

        $resultList = wp_remote_get(getUrlMlsMember().'api/getpropertieslist?'.$queryUrl);

        if (is_wp_error($resultList)) {
            echo json_encode(array(
                'success' => false,
                'msg' =>  esc_html__('No results found', 'advmls')
            ));
            wp_die();
        }

        $propertiesResults = json_decode($resultList['body']);

        $properties_data = array();
        $query_args = new WP_Query( $search_qry );

        ob_start();
        echo '<div class="card-deck">';
        $total_properties = (int)$propertiesResults->pagination->total > 0 ? $propertiesResults->pagination->total : 0;

        foreach ($propertiesResults->properties as $key => $property) {

            $property_array_temp = array();

            $currentCurr =  !empty($property->currency_code) ? $property->currency_code : '';
            $price =  !empty($property->price) ? $property->price : 0;
            $priceFormat = mlsUtility::getInstance()->showNumberFormat($price);
            $pro_title = $property->pro_name.' - '.$property->ref;

            $urlProDetail = mlsUrlFactory::getInstance()->getListingDetailUrl(true);
            $category_name = !empty($property->category_name) ? $property->category_name : '';
            $pro_url = mlsUtility::getInstance()->advmls_esc_url($urlProDetail.$category_name.'/'.$property->pro_alias);

            $property_array_temp[ 'title' ] = $pro_title;
            $property_array_temp[ 'url' ] = $pro_url;
            $property_array_temp['price'] = $currentCurr.' '.$priceFormat;
            $property_array_temp['property_id'] = $property->ref;
            $property_array_temp['pricePin'] =  'yes';
            $property_array_temp['property_type'] = $property->type_name;

            $address = $property->address;
            if(!empty($address)) {
                $property_array_temp['address'] = $address;
            }

            //Property meta
            $property_array_temp['meta'] = $property->metadesc;
            $property_array_temp['lat'] = $property->lat_add;
            $property_array_temp['lng'] = $property->long_add;

            //Se default markers if property type has no marker uploaded
            $property_array_temp[ 'marker' ]       = ADVMLS_IMG.'/map/pin-single-family.png';           
            $property_array_temp[ 'retinaMarker' ] = ADVMLS_IMG.'/map/pin-single-family.png';  

            //Featured image
            $property_array_temp[ 'thumbnail' ] = $property->url_photo.'/'.$property->photos[0]->image;

            $properties_data[] = $property_array_temp;

            include($pathTemplate.'listing/item-v1.php');

        }

        wp_reset_query();
        echo '</div>';

        echo '<div class="clearfix"></div>';
        houzez_ajax_pagination( ceil($propertiesResults->pagination->total / $propertiesResults->pagination->limit) );

        $listings_html = ob_get_contents();
        ob_end_clean();

        $encoded_query = "";

        $search_uri = '';
        $get_search_uri = $_SERVER['HTTP_REFERER'];
        $get_search_uri = explode( '/?', $get_search_uri );
        if(isset($get_search_uri[1]) && $get_search_uri[1] != "") {
            $search_uri = $get_search_uri[1];
        }

        if( count($properties_data) > 0 ) {
            echo json_encode( array( 'getProperties' => true, 'properties' => $properties_data, 'total_results' => $total_properties, 'propHtml' => $listings_html, 'query' => $encoded_query, 'search_uri' => $search_uri ) );
            exit();
        } else {
            echo json_encode( array( 'getProperties' => false, 'total_results' => $total_properties, 'query' => $encoded_query, 'search_uri' => $search_uri ) );
            exit();
        }
        die();

    }
}

?>
