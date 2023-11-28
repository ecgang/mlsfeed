<?php 

include('open_street_map_functions.php');

if( !function_exists('advmls_get_map_system') ) {
    function advmls_get_map_system() {
        $advmls_map_system = get_option('advmls_map_system');

        if($advmls_map_system == 'osm' || $advmls_map_system == 'mapbox') {
            $map_system = 'osm';
        } elseif($advmls_map_system == 'google' && get_option('googlemap_api_key') != "") {
            $map_system = 'google';
        } else {
            $map_system = 'osm';
        }
        return $map_system;
    }
}

if(!function_exists('advmls_enqueue_maps_api')) {
    function advmls_enqueue_maps_api() {
        if(advmls_get_map_system() == 'google') {

            advmls_enqueue_google_api(); 
            advmls_enqueue_geo_location_js();

        } else {
            advmls_enqueue_osm_api();
            advmls_enqueue_osm_location_js();
        }
    }
}