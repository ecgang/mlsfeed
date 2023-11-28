<?php 

require_once( 'register-scripts.php' );
require_once( 'mlsPropertyFunctions.php' );
require_once( 'mlsEmailFunctions.php' );
require_once( 'mlsFunctionsMaps.php' );

//clear Varibles Company and agent info
update_option('advmls_company', null,'no');
update_option('advmls_contact_info', null,'no');
update_option('advmls_check_version', null,'no');

function advmls_the_date($date = "", $format = 'jS \of M Y h:i A'){
    
    $timeZone = new DateTimeZone( 'UTC' );

    if (!empty($date)) {
        $date = new DateTime($date);
        $timeStamp = $date->getTimestamp();

        return wp_date($format, $timeStamp, $timeZone);
    }

    return false;
}

function getCompanyInfoShortCode($attributes){

    $fields = array();
    $company = advmls_getCompanyDetails();
    
    if (!empty($company) and !isset($company->error)) {

        $fieldsAvailable = 'description, photo, address, website, email, business_hours, social';
        $company_address = !empty($company->address) ? $company->address.', '.$company->city_name.', '. $company->state_name.', '.$company->postcode : '';
        if (!empty($attributes) and is_array($attributes)) {
            foreach ($attributes as $key => $attr) {
                switch ($attr) {
                    case 'description': 
                        $fields[] = '<p class="company_desc">'.$company->company_description .'</p>';
                     break;
                    case 'photo':
                        $fields[] = '<img src="'.$company->url_photo.$company->photo.'" alt="'. $company->company_name.'" title="'.$company->company_name.'">';
                        break;
                    case 'address':
                       $fields[] = '<p class="company_address">'. $company_address. '</p>';
                     break;
                    case 'website':
                        $fields[] = '<a href="'.esc_url($company->website).'"> '. $company->website.'</a>';
                        break;
                    case 'email':
                        $fields[] = ' <a href="mailto:'. esc_url($company->email) .'"><i class="fas fa-envelope mr-2"></i>'. $company->email.'</a>';
                        break;
                    case 'business_hours':
                       $fields[] = '<span class="company_hours">'. !empty($company->business_name) ? $company->business_name : "business_name is empty".' </span>';
                     break;
                    case 'social':
                       $fields[] = '<ul class="list-inline">
                        
                            <li class="list-inline-item">
                                <a target="_blank" class="btn-square" href="'.(!empty($company->facebook) ? $company->facebook : "https://facebook.com").'">
                                    <i class="fab fa-facebook-f"></i>

                                </a>
                            </li><!-- .facebook -->

                            <li class="list-inline-item">
                                <a target="_blank" class="btn-square" href="'.(!empty($company->twitter) ? $company->twitter : "https://twitter.com").'">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li><!-- .twitter -->

                            <li class="list-inline-item">
                                <a target="_blank" class="btn-square" href="'. (!empty($company->instagram) ? $company->instagram : "https://instagram").'">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li><!-- .instagram -->

                            <li class="list-inline-item">
                                <a target="_blank" class="btn-square" href="'.(!empty($company->pinterest) ? $company->pinterest : "https://pinterest").'">
                                    <i class="fab fa-pinterest-p"></i>
                                </a>
                            </li><!-- .pinterest -->

                            <li class="list-inline-item">
                                <a target="_blank" class="btn-square" href="'. (!empty($company->youtube) ? $company->youtube : "https://youtube.com") .'">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </li><!-- .youtube -->

                        </ul>';
                     break;
                    case 'footer':
                        $fields[] = (!empty($company_address) ? '<p><i class="fas fa-map-marker-alt mr-2"></i>'.$company_address.'</p>' : '' )
                         .(!empty($company->email) ? '<p><i class="fas fa-envelope mr-2"></i>'.$company->email.'</p>' : '')
                         .(!empty($company->phone) ? '<p><i class="fas fa-phone mr-2"></i>'. $company->phone.'</p>' : '' )
                         .(!empty($company->phone1) ? '<p><i class="fas fa-phone mr-2"></i>'. $company->phone1.'</p>' : '' )
                         .(!empty($company->phone2) ? '<p><i class="fas fa-phone mr-2"></i>'. $company->phone2.'</p>' : '' )
                         .(!empty($company->business_name) ? '<p><i class="far fa-clock mr-2"></i>'. $company->business_name.'</p>' : '' );

                    break;
                    case 'phone':
                        $fields[] = (!empty($company->phone) ? '<p><i class="fas fa-phone mr-2"></i>'.$company->phone.'</p>' : '');
                        break;
                    case 'phone1':
                        $fields[] = (!empty($company->phone1) ? '<p><i class="fas fa-phone mr-2"></i>'.$company->phone1.'</p>' : '');
                        break;
                    case 'phone2':
                        $fields[] = (!empty($company->phone2) ? '<p><i class="fas fa-phone mr-2"></i>'.$company->phone2.'</p>' : '');
                        break;
                    default: 
                        if (empty($company_field)) { ?>
                          <p class="fiel-empty"><?php echo "Select a field";?></p>
                            
                        <?php }else{?>
                          <p class="fiel-empty"><?php echo $company_field . " is empty or not exist";?></p>

                        <?php } ?>
                    <?php break;
                }

            }
        }
        
    }else{
        $fields[] = isset($company->error_msg) ? $company->error_msg : '';
    }

    return implode(' ', $fields);
}

if( !function_exists('advmls_getContactInfo')){
    function advmls_getContactInfo(){

        $contactInfo = json_decode(get_option('advmls_contact_info'));

        if (!$contactInfo) {
            //property type
            $queryUrlArr = array(
                "token" => mlsUtility::getInstance()->getActivationToken(),
                "source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl())
            );
            
            $queryUrl = http_build_query($queryUrlArr);
            
            $resultContact = wp_remote_get(getUrlMlsMember().'api/getcontactinfo?'.$queryUrl);
            if (is_wp_error($resultContact)) {
                return json_encode(array());
            }
            $contactInfo = json_decode($resultContact['body']);

            update_option("advmls_contact_info", json_encode($contactInfo));
        }

        return $contactInfo;
    }
}

/**
 *   -------------------------------------------------------------
 *   Advantage MLS Pagination
 *   -------------------------------------------------------------
 */
if( !function_exists( 'advmls_pagination' ) ){
    function advmls_pagination( $pages = '' ) {
        
        $paged = 1;
        if ( get_query_var( 'paged' ) ) {
            $paged = get_query_var( 'paged' );
        } elseif ( get_query_var( 'page' ) ) { // if is static front page
            $paged = get_query_var( 'page' );
        }

        $prev = $paged - 1;
        $next = $paged + 1;
        $range = 3; // change it to show more links
        $showitems = ( $range * 2 )+1;

        if( $pages == '' ){
            
            if( !$pages ){
                $pages = 1;
            }
        }

        if( 1 != $pages ){

            $output = "";
            $inner = "";
            $output .= '<div class="pagination-wrap">';
                $output .= '<nav>';
                    $output .= '<ul class="pagination justify-content-center">';
                        
                        if( $paged > 2 && $paged > $range+1 && $showitems < $pages ) { 
                            $output .= '<li class="page-item">';
                                $output .= '<a class="page-link" href="'.get_pagenum_link(1).'" aria-label="Previous">';
                                    $output .= '<i class="advmls-icon arrow-button-left-1"></i>';
                                $output .= '</a>';
                            $output .= '</li>';
                        }

                        if( $paged > 1 ) { 
                            $output .= '<li class="page-item">';
                                $output .= '<a class="page-link" href="'.get_pagenum_link($prev).'" aria-label="Previous">';
                                    $output .= '<i class="advmls-icon icon-arrow-left-1"></i>';
                                $output .= '</a>';
                            $output .= '</li>';
                        } else {
                            $output .= '<li class="page-item disabled">';
                                $output .= '<a class="page-link" aria-label="Previous">';
                                    $output .= '<i class="advmls-icon icon-arrow-left-1"></i>';
                                $output .= '</a>';
                            $output .= '</li>';
                        }

                        for ( $i = 1; $i <= $pages; $i++ ) {
                            if ( 1 != $pages &&( !( $i >= $paged+$range+1 || $i <= $paged-$range-1 ) || $pages <= $showitems ) )
                            {
                                if ( $paged == $i ){
                                    $inner .= '<li class="page-item active"><a class="page-link" href="'.get_pagenum_link($i).'">'.$i.' <span class="sr-only"></span></a></li>';
                                } else {
                                    $inner .= '<li class="page-item"><a class="page-link" href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
                                }
                            }
                        }
                        $output .= $inner;
                        

                        if($paged < $pages) {
                            $output .= '<li class="page-item">';
                                $output .= '<a class="page-link" href="'.get_pagenum_link($next).'" aria-label="Next">';
                                    $output .= '<i class="advmls-icon icon-arrow-right-1"></i>';
                                $output .= '</a>';
                            $output .= '</li>';
                        }

                        if( $paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages ) {
                            $output .= '<li class="page-item">';
                                $output .= '<a class="page-link" href="'.get_pagenum_link( $pages ).'" aria-label="Next">';
                                    $output .= '<i class="advmls-icon arrow-button-right-1"></i>';
                                $output .= '</a>';
                            $output .= '</li>';
                        }
                    $output .= '</ul>';
                $output .= '</nav>';
            $output .= '</div>';
            echo $output;
        }
    }
}

if( !function_exists( 'houzez_ajax_pagination' ) ){
    function houzez_ajax_pagination( $pages = '' ) {

        $paged = 1;

        if ( get_query_var( 'paged' ) ) {
            $paged = get_query_var( 'paged' );
        } elseif ( get_query_var( 'page' ) ) { // if is static front page
            $paged = get_query_var( 'page' );
        }

        if( isset($_GET['paged']) ) {
            $paged = $_GET['paged'];
        }

        if(empty($paged))$paged = 1;

        $prev = $paged - 1;
        $next = $paged + 1;
        $range = 2; // change it to show more links
        $showitems = ( $range * 2 )+1;
        
        if( $pages == '' ){
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if( !$pages ){
                $pages = 1;
            }
        }

        if( 1 != $pages ){

            echo '<div class="pagination-wrap houzez_ajax_pagination">';
            echo '<nav>';
            echo '<ul class="pagination justify-content-center">';
            echo ( $paged > 2 && $paged > $range+1 && $showitems < $pages ) ? '<li class="page-item"><a class="page-link" data-houzepagi="1" rel="First" href="'.get_pagenum_link(1).'"><span aria-hidden="true"><i class="fa fa-angle-double-left"></i></span></a></li>' : '';
            echo ( $paged > 1 ) ? '<li class="page-item"><a class="page-link" data-houzepagi="'.$prev.'" rel="Prev" href="'.get_pagenum_link($prev).'"><i class="houzez-icon icon-arrow-left-1"></i></a></li>' : '<li class="page-item disabled"><a class="page-link" aria-label="Previous"><i class="houzez-icon icon-arrow-left-1"></i></a></li>';
            for ( $i = 1; $i <= $pages; $i++ ) {
                if ( 1 != $pages &&( !( $i >= $paged+$range+1 || $i <= $paged-$range-1 ) || $pages <= $showitems ) )
                {
                    if ( $paged == $i ){
                        echo '<li class="page-item active"><a class="page-link" data-houzepagi="'.$i.'" href="'.get_pagenum_link($i).'">'.$i.' <span class="sr-only"></span></a></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" data-houzepagi="'.$i.'" href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
                    }
                }
            }
            echo ( $paged < $pages ) ? '<li class="page-item"><a class="page-link" data-houzepagi="'.$next.'" rel="Next" href="'.get_pagenum_link($next).'"><i class="houzez-icon icon-arrow-right-1"></i></a></li>' : '';
            echo ( $paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages ) ? '<li class="page-item"><a class="page-link" data-houzepagi="'.$pages.'" rel="Last" href="'.get_pagenum_link( $pages ).'"><span aria-hidden="true"><i class="fa fa-angle-double-right"></i></span></a></li>' : '';
            echo '</ul>';
            echo '</nav>';
            echo '</div>';

        }
    }
}

if ( ! function_exists( 'get_option' ) ) {
    function get_option( $id, $fallback = false, $param = false ) {
        if ( isset( $_GET['fave_'.$id] ) ) {
            if ( '-1' == $_GET['fave_'.$id] ) {
                return false;
            } else {
                return $_GET['fave_'.$id];
            }
        } else {
            global $get_options;
            if ( $fallback == false ) $fallback = '';
            $output = ( isset($get_options[$id]) && $get_options[$id] !== '' ) ? $get_options[$id] : $fallback;
            if ( !empty($get_options[$id]) && $param ) {
                $output = $get_options[$id][$param];
            }
        }
        return $output;
    }
}

if( !function_exists('advmls_get_form_user_type') ) {
    function advmls_get_form_user_type($token) {
    
       $value = '';
       
       if( $token == 'buyer' ) {
            $value = get_option('spl_con_buyer', "I'm a buyer");

       } else if( $token == 'tennant' ) {
            $value = get_option('spl_con_tennant', "I'm a tennant");

       } else if( $token == 'agent' ) {
            $value = get_option('spl_con_agent', "I'm an agent");

       } else if( $token == 'other' ) {
            $value = get_option('spl_con_other', "Other");
       } 

       return $value;
    }
}

if(!function_exists('advmls_search_builtIn_fields')) {
    function advmls_search_builtIn_fields() {
        $array = array(
            'keyword',
            'city',
            'areas',
            'status',
            'type',
            'bedrooms',
            'rooms',
            'bathrooms',
            'min-sqft',
            'max-sqft',
            'min-land-area',
            'max-land-area',
            'min-price',
            'max-price',
            'property-id',
            'label',
            'state',
            'country',
            'price',
            'geolocation',
            'price-range',
            'garage',
            'year-built',
            "parking",
            "with-pool",
            "with-yard",
            "furnished",
            "with-casita",
            "gated-comm",
            "with-view"
        );
        return $array;
    }
}

/*-----------------------------------------------------------------------------------*/
// Number List
/*-----------------------------------------------------------------------------------*/
if( !function_exists('advmls_number_list') ) {
    function advmls_number_list($list_for) {
        $num_array = array(1,2,3,4,5,6,7,8,9,10);
        $searched_num = '';

        if( $list_for == 'bedrooms' ) {
            if( isset( $_GET['nbed'] ) ) {
                $searched_num = $_GET['nbed'];
            }

            $adv_beds_list = get_option('adv_beds_list');
            if( !empty($adv_beds_list) ) {
                $adv_beds_list_array = explode( ',', $adv_beds_list );

                if( is_array( $adv_beds_list_array ) && !empty( $adv_beds_list_array ) ) { 
                    $temp_adv_beds_list_array = array();
                    foreach( $adv_beds_list_array as $beds ) {
                        $temp_adv_beds_list_array[] = $beds;
                    }

                    if( !empty( $temp_adv_beds_list_array ) ) {
                        $num_array = $temp_adv_beds_list_array;
                    }
                }
            }
        }

        if( $list_for == 'bathrooms' ) {
            if( isset( $_GET['nbath'] ) ) {
                $searched_num = $_GET['nbath'];
            }

            $adv_baths_list = get_option('adv_baths_list');
            if( !empty($adv_baths_list) ) {
                $adv_baths_list_array = explode( ',', $adv_baths_list );

                if( is_array( $adv_baths_list_array ) && !empty( $adv_baths_list_array ) ) {
                    $temp_adv_baths_list_array = array();
                    foreach( $adv_baths_list_array as $baths ) {
                        $temp_adv_baths_list_array[] = $baths;
                    }

                    if( !empty( $temp_adv_baths_list_array ) ) {
                        $num_array = $temp_adv_baths_list_array;
                    }
                }
            }
        }

        if( $list_for == 'rooms' ) {
            if( isset( $_GET['rooms'] ) ) {
                $searched_num = $_GET['rooms'];
            }

            $adv_rooms_list = get_option('adv_rooms_list');
            if( !empty($adv_rooms_list) ) {
                $adv_rooms_list_array = explode( ',', $adv_rooms_list );

                if( is_array( $adv_rooms_list_array ) && !empty( $adv_rooms_list_array ) ) {
                    $temp_adv_rooms_list_array = array();
                    foreach( $adv_rooms_list_array as $rooms ) {
                        $temp_adv_rooms_list_array[] = $rooms;
                    }

                    if( !empty( $temp_adv_rooms_list_array ) ) {
                        $num_array = $temp_adv_rooms_list_array;
                    }
                }
            }
        }

        if( !empty( $num_array ) ) {
            $num_array = array_filter($num_array, 'strlen');

            foreach( $num_array as $num ){
                $option_label = '';
                
                $option_label = $num;

                if( $num == '0' ) {
                    $option_label = get_option('srh_studio', 'Studio');
                }

                if( $searched_num == $num ) {
                    echo '<option value="'.esc_attr( $num ).'" selected="selected">'.esc_attr( $option_label ).'</option>';
                } else {
                    echo '<option value="'.esc_attr( $num ).'">'.esc_attr( $option_label ).'</option>';
                }
            }
        }

        $any_text = get_option('srh_any', esc_html__( 'Any', 'advmls'));

        if( $searched_num == 'any' )  {
            echo '<option value="any" selected="selected">'.$any_text.'</option>';
        } else {
            echo '<option value="any">'.$any_text.'</option>';
        }

    }
}

/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
if( !function_exists('advmls_get_status_list') ) {
    function advmls_get_status_list($filter = true, $format = 'select', $nameCheck = "") {

        $statusSel = isset($_GET['pro_types'][0]) ? $_GET['pro_types'][0] : '';

        //property type
        $queryUrlArr = array(
            "token" => mlsUtility::getInstance()->getActivationToken(),
            "source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl())
        );

        $queryUrl = http_build_query($queryUrlArr);
        $resultProStatus = wp_remote_get(getUrlMlsMember().'api/getpropertystatus?'.$queryUrl);

        if (is_wp_error($resultProStatus)) {
            return json_encode(array());
        }

        $proStatus = json_decode($resultProStatus['body']);

        $output = '';

        $statusDefault = array();
        $statusDefault[] = 1;
        $statusDefault[] = 9;

        $statusShow =  get_option('advmls_status_show', $statusDefault);
        foreach ($proStatus as $key => $status) {

            $selected = ($statusSel == $status->id ? 'selected="selected"': '');

            if ($filter and is_array($statusShow) and count($statusShow) > 0) {
                if ($format == 'select') {
                    if (in_array($status->id, $statusShow)) {
                        $output.= '<option data-ref="'.esc_attr($status->type_name).'"  value="' . esc_attr($status->id) . '" '.$selected.' > - '. esc_attr($status->type_name) . '</option>';
                    }
                }
            }else{
                if ($format == 'select') {
                   if ( (is_array($statusShow) and in_array($status->id, $statusShow)) or ($statusSel == $status->id) ){
                     $selected ='selected="selected"';
                   }
                    $output.= '<option data-ref="'.esc_attr($status->type_name).'"  value="' . esc_attr($status->id) . '" '.$selected.' > - '. esc_attr($status->type_name) . '</option>';
                }

                if ($format == 'checkbox') {
                    
                    $checked = ( (is_array( $statusShow) and  in_array($status->id, $statusShow)) ? 'checked': '');
                    $output .= '<div class="form-check">
                              <input class="" name="'.$nameCheck.'" type="checkbox" value="' . esc_attr($status->id) . '" id="flexCheckDefault" '.$checked.'>
                              <label class="form-check-label" for="flexCheckDefault">
                                '. esc_attr($status->type_name) . '
                              </label>
                            </div>';
                }
            }
        }

        return $output;
    }
}

if( !function_exists('advmls_get_type_list') ) {
    function advmls_get_type_list(int $idselected) {

        if ( $idselected <= 0 ) {
            $idselected = isset($_GET['category_ids']) ? $_GET['category_ids'] : '1';
        }

        //property type
        $queryUrlArr = array(
            "token" => mlsUtility::getInstance()->getActivationToken(),
            "source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl())
        );

        $queryUrl = http_build_query($queryUrlArr);
        $resultProType = wp_remote_get(getUrlMlsMember().'api/getpropertytype?'.$queryUrl);
        
        if (is_wp_error($resultProType)) {
            return json_encode(array());
        }

        $proType = json_decode($resultProType['body']);

        $output = '';
        foreach ($proType as $key => $type) {

            $selected = ($idselected == $type->id ? 'selected="selected"': '');

            $output.= '<option data-ref="'.esc_attr($type->category_name).'"  value="' . esc_attr($type->id) . '" '.$selected.' >'. esc_attr($type->category_name) . '</option>';
        }

        return $output;
    }
}


add_action('wp_ajax_load_lightbox_content', 'advmls_listing_model');
add_action('wp_ajax_nopriv_load_lightbox_content', 'advmls_listing_model');

if( !function_exists('advmls_listing_model')) {
    function advmls_listing_model() {
        $listing_id = isset($_POST['listing_id']) ? $_POST['listing_id'] : '';
        echo $listing_id;
        die();
        if(empty($listing_id)) {
            echo esc_html__('Nothing found', 'advmls');
            return;
        }
        

        $lightbox_logo = advmls_option( 'lightbox_logo', false, 'url' );

        $userID      =   get_current_user_id();
        $fav_option = 'advmls_favorites-'.$userID;
        $fav_option = get_option( $fav_option );
        $icon = $key = '';
        if( !empty($fav_option) ) {
            $key = array_search($listing_id, $fav_option);
        }
        if( $key != false || $key != '' ) {
            $icon = 'text-danger';
        }
    
        $prop_id = advmls_get_listing_data_by_id('property_id', $listing_id);
        $prop_size = advmls_get_listing_data_by_id('property_size', $listing_id);
        $land_area = advmls_get_listing_data_by_id('property_land', $listing_id);
        $bedrooms = advmls_get_listing_data_by_id('property_bedrooms', $listing_id);
        $rooms = advmls_get_listing_data_by_id('property_rooms', $listing_id);
        $bathrooms = advmls_get_listing_data_by_id('property_bathrooms', $listing_id);
        $year_built = advmls_get_listing_data_by_id('property_year', $listing_id);
        $garage = advmls_get_listing_data_by_id('property_garage', $listing_id);
        $property_type = advmls_taxonomy_simple_2('property_type', $listing_id);
        $garage_size = advmls_get_listing_data_by_id('property_garage_size', $listing_id);
        $address = advmls_get_listing_data_by_id('property_map_address', $listing_id);

        $term_status = wp_get_post_terms( $listing_id, 'property_status', array("fields" => "all"));
        $term_label = wp_get_post_terms( $listing_id, 'property_label', array("fields" => "all"));

        $size = 'advmls-gallery';
        $properties_images = rwmb_meta( 'fave_property_images', 'type=plupload_image&size='.$size, $listing_id );

        $token = wp_generate_password(5, false, false);

    ?>
    <div class="modal-header">
        <div class="d-flex align-items-center">
            <div class="lightbox-logo flex-grow-1">
                <?php if(!empty($lightbox_logo)) { ?>
                <img class="img-fluid" src="<?php echo esc_url($lightbox_logo); ?>" alt="logo">
                <?php } ?>
            </div><!-- lightbox-logo -->
            <div class="lightbox-tools">
                <ul class="list-inline">
                    <?php if( advmls_option('disable_favorite') != 0 ) { ?>
                    <li class="list-inline-item btn-favorite">
                        <a class="add-favorite-js" data-listid="<?php echo intval($listing_id)?>" href="#"><i class="advmls-icon icon-love-it mr-2 <?php echo esc_attr($icon); ?>"></i> <span class="display-none"><?php esc_html_e('Favorite', 'advmls'); ?></span></a>
                    </li>
                    <?php } ?>
                </ul>
            </div><!-- lightbox-tools -->
        </div><!-- d-flex -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div><!-- modal-header -->

    <div class="modal-body clearfix">

        <div class="lightbox-gallery-wrap">
            <a class="btn-expand">
                <i class="advmls-icon icon-expand-3"></i>
            </a>
            
            <?php  if( !empty($properties_images) && count($properties_images)) { ?>
            <div class="lightbox-gallery">
                <div id="preview-js-<?php echo esc_attr($token); ?>" class="lightbox-slider">
                    
                    <?php
                    $lightbox_caption = advmls_option('lightbox_caption', 0); 
                    foreach( $properties_images as $prop_image_id => $prop_image_meta ) {
                        $output = '';
                        $output .= '<div>';
                            $output .= '<img class="img-fluid" src="'.esc_url( $prop_image_meta['full_url'] ).'" alt="'.esc_attr($prop_image_meta['alt']).'" title="'.esc_attr($prop_image_meta['title']).'">';

                            if( !empty($prop_image_meta['caption']) && $lightbox_caption != 0 ) {
                                $output .= '<span class="hz-image-caption">'.esc_attr($prop_image_meta['caption']).'</span>';
                            }

                        $output .= '</div>';

                        echo $output;
                    }
                    ?>
                    
                </div>
            </div><!-- lightbox-gallery -->
            <?php 
            } else { 
                $featured_image_url = advmls_get_image_url('full', $listing_id);
                echo '<div>
                    <img class="img-fluid" src="'.esc_url($featured_image_url[0]).'">
                </div>';
            } ?>

        </div><!-- lightbox-gallery-wrap -->


        <div class="lightbox-content-wrap lightbox-form-wrap">
        
            <div class="labels-wrap labels-right"> 
                <?php 
                if( !empty($term_status) ) {
                    foreach( $term_status as $status ) {
                        $status_id = $status->term_id;
                        $status_name = $status->name;
                        echo '<a href="'.get_term_link($status_id).'" class="label-status label status-color-'.intval($status_id).'">
                                '.esc_attr($status_name).'
                            </a>';
                    }
                }

                if( !empty($term_label) ) {
                    foreach( $term_label as $label ) {
                        $label_id = $label->term_id;
                        $label_name = $label->name;
                        echo '<a href="'.get_term_link($label_id).'" class="label label-color-'.intval($label_id).'">
                                '.esc_attr($label_name).'
                            </a>';
                    }
                }
                ?>       
            </div>
            
            <h2 class="item-title">
                <a href="<?php echo esc_url(get_permalink($listing_id)); ?>"><?php echo get_the_title($listing_id); ?></a>
            </h2><!-- item-title -->

            <?php 
            if(!empty($address)) {
                echo '<address class="item-address">'.esc_attr($address).'</address>';
            }
            ?>
            
            <ul class="item-price-wrap hide-on-list">
                <?php echo advmls_listing_price_v1($listing_id); ?>
            </ul>

            <p><?php echo advmls_get_excerpt(23, $listing_id); ?></p>

            <div class="property-overview-data">
                <?php
                $listing_data_composer = advmls_option('preview_data_composer');
                $data_composer = $listing_data_composer['enabled'];

                $meta_type = advmls_option('preview_meta_type');

                $bd_output = $b_output = $id_output = $garage_output = $area_size_output = $land_output = $year_output = $icon = $icon_bt = $icon_prop_id = $icon_garage = $icon_areasize = $icon_land = $icon_year = $cus_output = $cus_icon = '';
                $i = 0;
                if ($data_composer) {
                    unset($data_composer['placebo']);
                    foreach ($data_composer as $key=>$value) { $i ++;

                        $listing_area_size = advmls_get_listing_area_size( $listing_id );
                        $listing_size_unit = advmls_get_listing_size_unit( $listing_id );

                        $listing_land_size = advmls_get_land_area_size( $listing_id );
                        $listing_land_unit = advmls_get_land_size_unit( $listing_id );

                        if( $key == 'bed' && $bedrooms != '' ) {

                            $bd_output .= '<ul class="list-unstyled flex-fill">';
                                $bd_output .= '<li class="property-overview-item">';
                                    
                                    if(advmls_option('icons_type') == 'font-awesome') {
                                        $icon .= '<i class="'.advmls_option('fa_bed').' mr-1"></i>';

                                    } elseif (advmls_option('icons_type') == 'custom') {
                                        $cus_icon = advmls_option('bed');
                                        if(!empty($cus_icon['url'])) {
                                            $icon .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $icon .= '<i class="advmls-icon icon-hotel-double-bed-1 mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $bd_output .= $icon;
                                    }
                                    
                                    $bd_output .= '<strong>'.esc_attr($bedrooms).'</strong>';
                                    
                                $bd_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $prop_bed_label = ($bedrooms > 1 ) ? advmls_option('glc_bedrooms', 'Bedrooms') : advmls_option('glc_bedroom', 'Bedroom');
                                    $bd_output .= '<li class="h-beds">'.esc_attr($prop_bed_label).'</li>';
                                }

                            $bd_output .= '</ul>';

                            if(!empty($bd_output)) {
                                echo $bd_output;
                            }

                        } else if( $key == 'room' && $rooms != '' ) {

                            $rooms_output .= '<ul class="list-unstyled flex-fill">';
                                $rooms_output .= '<li class="property-overview-item">';
                                    
                                    if(advmls_option('icons_type') == 'font-awesome') {
                                        $room_icon .= '<i class="'.advmls_option('fa_room').' mr-1"></i>';

                                    } elseif (advmls_option('icons_type') == 'custom') {
                                        $cus_icon = advmls_option('room');
                                        if(!empty($cus_icon['url'])) {
                                            $room_icon .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $room_icon .= '<i class="advmls-icon icon-hotel-double-bed-1 mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $rooms_output .= $room_icon;
                                    }
                                    
                                    $rooms_output .= '<strong>'.esc_attr($rooms).'</strong>';
                                    
                                $rooms_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $prop_room_label = ($rooms > 1 ) ? advmls_option('glc_rooms', 'Rooms') : advmls_option('glc_room', 'Room');
                                    $rooms_output .= '<li class="h-beds">'.esc_attr($prop_room_label).'</li>';
                                }

                            $rooms_output .= '</ul>';

                            if(!empty($rooms_output)) {
                                echo $rooms_output;
                            }

                        } elseif( $key == 'bath' && $bathrooms != "" ) {

                            $b_output .= '<ul class="list-unstyled flex-fill">';
                                $b_output .= '<li class="property-overview-item">';
                                    
                                    if(advmls_option('icons_type') == 'font-awesome') {
                                        $icon_bt .= '<i class="'.advmls_option('fa_bath').' mr-1"></i>';

                                    } elseif (advmls_option('icons_type') == 'custom') {
                                        $cus_icon = advmls_option('bath');
                                        if(!empty($cus_icon['url'])) {
                                            $icon_bt .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $icon_bt .= '<i class="advmls-icon icon-bathroom-shower-1 mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $b_output .= $icon_bt;
                                    }
                                    
                                    $b_output .= '<strong>'.esc_attr($bathrooms).'</strong>';
                                    
                                $b_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $prop_bath_label = ($bathrooms > 1 ) ? advmls_option('glc_bathrooms', 'Bathrooms') : advmls_option('glc_bathroom', 'Bathroom');
                                    $b_output .= '<li class="h-baths">'.esc_attr($prop_bath_label).'</li>';
                                }

                            $b_output .= '</ul>';

                            if(!empty($b_output)) {
                                echo $b_output;
                            }

                        } elseif( $key == 'property-id' && $prop_id != "" ) {

                            $id_output .= '<ul class="list-unstyled flex-fill">';
                                $id_output .= '<li class="property-overview-item">';
                                    
                                    if(advmls_option('icons_type') == 'font-awesome') {
                                        $icon_prop_id .= '<i class="'.advmls_option('fa_property-id').' mr-1"></i>';

                                    } elseif (advmls_option('icons_type') == 'custom') {
                                        $cus_icon = advmls_option('property-id');
                                        if(!empty($cus_icon['url'])) {
                                            $icon_prop_id .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $icon_prop_id .= '<i class="advmls-icon icon-tags mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $id_output .= $icon_prop_id;
                                    }
                                    
                                    $id_output .= '<strong>'.esc_attr($prop_id).'</strong>';
                                    
                                $id_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $prop_id_label = advmls_option('glc_listing_id', 'Listing ID');
                                    $id_output .= '<li class="h-property-id">'.esc_attr($prop_id_label).'</li>';
                                }

                            $id_output .= '</ul>';

                            if(!empty($id_output)) {
                                echo $id_output;
                            }

                        } elseif( $key == 'garage' && $garage != "" ) {

                            $garage_output .= '<ul class="list-unstyled flex-fill">';
                                $garage_output .= '<li class="property-overview-item">';
                                    
                                    if(advmls_option('icons_type') == 'font-awesome') {
                                        $icon_garage .= '<i class="'.advmls_option('fa_garage').' mr-1"></i>';

                                    } elseif (advmls_option('icons_type') == 'custom') {
                                        $cus_icon = advmls_option('garage');
                                        if(!empty($cus_icon['url'])) {
                                            $icon_garage .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $icon_garage .= '<i class="advmls-icon icon-car-1 mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $garage_output .= $icon_garage;
                                    }
                                    
                                    $garage_output .= '<strong>'.esc_attr($garage).'</strong>';
                                    
                                $garage_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $prop_garage_label = ($garage > 1 ) ? advmls_option('glc_garages', 'Garages') : advmls_option('glc_garage', 'Garage');
                                    $garage_output .= '<li class="h-garage">'.esc_attr($prop_garage_label).'</li>';
                                }

                            $garage_output .= '</ul>';

                            if(!empty($garage_output)) {
                                echo $garage_output;
                            }

                        } elseif( $key == 'area-size' && $listing_area_size != "" ) {

                            $area_size_output .= '<ul class="list-unstyled flex-fill">';
                                $area_size_output .= '<li class="property-overview-item">';
                                    
                                    if(advmls_option('icons_type') == 'font-awesome') {
                                        $icon_areasize .= '<i class="'.advmls_option('fa_area-size').' mr-1"></i>';

                                    } elseif (advmls_option('icons_type') == 'custom') {
                                        $cus_icon = advmls_option('area-size');
                                        if(!empty($cus_icon['url'])) {
                                            $icon_areasize .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $icon_areasize .= '<i class="advmls-icon icon-ruler-triangle mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $area_size_output .= $icon_areasize;
                                    }
                                    
                                    $area_size_output .= '<strong>'.esc_attr($listing_area_size).'</strong>';
                                    
                                $area_size_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $area_size_output .= '<li class="h-area">'.$listing_size_unit.'</li>';
                                }

                            $area_size_output .= '</ul>';

                            if(!empty($area_size_output)) {
                                echo $area_size_output;
                            }

                        } elseif( $key == 'land-area' && $listing_land_size != "" ) {

                            $land_output .= '<ul class="list-unstyled flex-fill">';
                                $land_output .= '<li class="property-overview-item">';
                                    
                                    if(advmls_option('icons_type') == 'font-awesome') {
                                        $icon_land .= '<i class="'.advmls_option('fa_land-area').' mr-1"></i>';

                                    } elseif (advmls_option('icons_type') == 'custom') {
                                        $cus_icon = advmls_option('land-area');
                                        if(!empty($cus_icon['url'])) {
                                            $icon_land .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $icon_land .= '<i class="advmls-icon icon-real-estate-dimensions-map mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $land_output .= $icon_land;
                                    }
                                    
                                    $land_output .= '<strong>'.esc_attr($listing_land_size).'</strong>';
                                    
                                $land_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $land_output .= '<li class="h-land-area">'.$listing_land_unit.'</li>';
                                }

                            $land_output .= '</ul>';

                            if(!empty($listing_land_size)) {
                                echo $land_output;
                            }

                        }  elseif( $key == 'year-built' && $year_built != "" ) {

                            $year_output .= '<ul class="list-unstyled flex-fill">';
                                $year_output .= '<li class="property-overview-item">';
                                    
                                    if(advmls_option('icons_type') == 'font-awesome') {
                                        $icon_year .= '<i class="'.advmls_option('fa_year-built').' mr-1"></i>';

                                    } elseif (advmls_option('icons_type') == 'custom') {
                                        $cus_icon = advmls_option('year-built');
                                        if(!empty($cus_icon['url'])) {
                                            $icon_year .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $icon_year .= '<i class="advmls-icon icon-attachment mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $year_output .= $icon_year;
                                    }
                                    
                                    $year_output .= '<strong>'.esc_attr($year_built).'</strong>';
                                    
                                $year_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $year_output .= '<li class="h-year-built">'.advmls_option('glc_year_built', 'Year Built').'</li>';
                                }

                            $year_output .= '</ul>';

                            if(!empty($year_built)) {
                                echo $year_output;
                            }

                        } else {
                            
                            $cus_output = '';
                            $cus_data = advmls_get_listing_data_by_id($key, $listing_id);

                            $cus_output .= '<ul class="list-unstyled flex-fill">';
                            $cus_output .= '<li class="property-overview-item">';
                                
                                if(advmls_option('icons_type') == 'font-awesome') {
                                    $cus_icon .= '<i class="'.advmls_option('fa_'.$key).' mr-1"></i>';

                                } elseif (advmls_option('icons_type') == 'custom') {
                                    $cus_icon = advmls_option($key);
                                    if(!empty($cus_icon['url'])) {
                                        $cus_icon .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                    }
                                } 

                                if( $meta_type != 'text' ) {
                                    $cus_output .= $cus_icon;
                                }
                                
                                $cus_output .= '<strong>'.esc_attr($cus_data).'</strong>';
                                
                            $cus_output .= '</li>';

                            if( $meta_type != 'icons' ) {
                                $cus_output .= '<li class="h-year-built">'.esc_attr($value).'</li>';
                            }

                        $cus_output .= '</ul>';

                        if(!empty($cus_data)) {
                            echo $cus_output;
                        }

                        } // end else
                    if($i == 6)
                        break;
                    }
                }

                ?>
                
            </div>
            
            <a class="btn btn-primary btn-item" href="<?php echo esc_url(get_permalink($listing_id)); ?>">
                <?php echo advmls_option('glc_detail_btn', 'Details'); ?>
            </a><!-- btn-item -->

        </div><!-- lightbox-content-wrap -->
    </div><!-- modal-body -->
    <div class="modal-footer">
        
    </div><!-- modal-footer -->

    <?php
    wp_die();
    }
}

function getUrlMlsMember(){
    return get_option('advmls_mls_member', '');
}

function advmls_isAgent(){
    $userRegister = get_option('advmls_user_register', false);
    return isset($userRegister->isagent) ? $userRegister->isagent : false;
}

function advmls_isCompany(){
    $userRegister = get_option('advmls_user_register', false);
    return isset($userRegister->iscompany) ? $userRegister->iscompany : false;
}