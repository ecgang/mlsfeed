<?php
if(!function_exists( 'advmls_enqueue_osm_marker_clusterer' )) {
    function advmls_enqueue_osm_marker_clusterer() {

        if(get_option('map_cluster_enable',1) != 0) {
            wp_enqueue_style('leafletMarkerCluster', ADVMLS_JS_DIR_URI . '/vendors/leafletCluster/MarkerCluster.css', array(), '1.4.0', 'all');
            wp_enqueue_style('leafletMarkerClusterDefault', ADVMLS_JS_DIR_URI . '/vendors/leafletCluster/MarkerCluster.Default.css', array(), '1.4.0', 'all');
            wp_enqueue_script('leafletMarkerCluster', ADVMLS_JS_DIR_URI . 'vendors/leafletCluster/leaflet.markercluster.js', array('leaflet'), '1.4.0', false);
            
        }
    }
}


if(!function_exists('advmls_enqueue_osm_api')) {
    function advmls_enqueue_osm_api() {

        if( !wp_script_is('leaflet') ) {
            // Enqueue leaflet CSS
            wp_enqueue_style( 'leaflet', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css', array(), '1.7.1' );

            // Enqueue leaflet JS
            wp_enqueue_script( 'leaflet', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', array(), '1.7.1', true );
            
        }
    }
}

if(!function_exists('advmls_enqueue_osm_location_js')) {
    function advmls_enqueue_osm_location_js() {

        if( !wp_script_is('advmls-osm-properties') ) {
            $map_options = array();
            wp_register_script( 'advmls-osm-properties', ADVMLS_JS_DIR_URI.'osm-properties.js', array( 'jquery', 'leaflet' ), ADVMLS_PLUGIN_VERSION, true );
            wp_localize_script( 'advmls-osm-properties', 'advmls_map_properties', $map_options );
            wp_enqueue_script( 'advmls-osm-properties' );
            
        }
    }
}

if(!function_exists('advmls_osm_maps_scripts')) {
	function advmls_osm_maps_scripts() {

       # if(houzez_map_needed()) {
        
            advmls_enqueue_osm_api();
            
            advmls_enqueue_osm_marker_clusterer();
            advmls_get_osm_properties();
            
            
       # } // End Houzez Map Needed
	}
}

if( !function_exists( 'advmls_get_osm_properties' ) ) {
    
    function advmls_get_osm_properties() {

        wp_register_script( 'advmls-osm-properties', ADVMLS_JS_DIR_URI.'osm-properties.js', array( 'jquery', 'leaflet' ), ADVMLS_PLUGIN_VERSION, true );
        
        $tax_query = array();
        $properties_limit = 1000;
        
        $properties_data = array();

        $property_array_temp = array();

        $properties_data[] = $property_array_temp;

       # wp_localize_script( 'advmls-osm-properties', 'advmls_map_properties', $properties_data );

        $map_cluster = get_option( 'map_cluster', false, 'url' );
        if($map_cluster != '') {
            $map_options['clusterIcon'] = $map_cluster;
        } else {
            $map_options['clusterIcon'] = 'map/cluster-icon.png';
        }
        $map_options['map_cluster_enable'] = get_option('map_cluster_enable');
        $map_options['clusterer_zoom'] = get_option('googlemap_zoom_cluster');
        $map_options['markerPricePins'] = get_option('markerPricePins');
        $map_options['marker_spiderfier'] = get_option('marker_spiderfier');
        $map_options['map_type'] = get_option('houzez_map_type');
        $map_options['googlemap_style'] = get_option('googlemap_stype');
        $map_options['closeIcon'] = 'map/close.png';
        $map_options['infoWindowPlac'] = "";
        wp_localize_script( 'advmls-osm-properties', 'advmls_map_options', $map_options );
        wp_enqueue_script( 'advmls-osm-properties' );

    }
}

/*-----------------------------------------------------------------------
* Single Property Map
*----------------------------------------------------------------------*/
if( !function_exists( 'houzez_get_single_property_osm_map' ) ) {
    
    function houzez_get_single_property_osm_map() {

        wp_register_script( 'houzez-single-property-map',  get_theme_file_uri('/js/single-property-osm-map' . houzez_minify_js() . '.js'), array( 'jquery', 'leaflet' ), HOUZEZ_THEME_VERSION, true );
        
        $map_options = array();
        $property_data = array();

        $address  = houzez_get_listing_data('property_map_address');
        $location = houzez_get_listing_data('property_location');
        $show_map = houzez_get_listing_data('property_map');

        if( !empty($location) && $show_map != 0 ) {

            $property_data[ 'title' ] = get_the_title();
            $property_data['price']   = houzez_listing_price_v5();
            $property_data['property_id'] = get_the_ID();
            $property_data['pricePin'] = houzez_listing_price_map_pins();
            $property_data['property_type'] = houzez_taxonomy_simple('property_type');
            $property_data['address'] = $address;

            $lat_lng = explode(',', $location);
            $property_data['lat'] = $lat_lng[0];
            $property_data['lng'] = $lat_lng[1];

            //Get marker 
            $property_type = get_the_terms( get_the_ID(), 'property_type' );
            if ( $property_type && ! is_wp_error( $property_type ) ) {
                foreach ( $property_type as $p_type ) {

                    $marker_id = get_term_meta( $p_type->term_id, 'fave_marker_icon', true );
                    $property_data[ 'term_id' ] = $p_type->term_id;

                    if ( ! empty ( $marker_id ) ) {
                        $marker_url = wp_get_attachment_url( $marker_id );

                        if ( $marker_url ) {
                            $property_data[ 'marker' ] = esc_url( $marker_url );

                            $retina_marker_id = get_term_meta( $p_type->term_id, 'fave_marker_retina_icon', true );
                            if ( ! empty ( $retina_marker_id ) ) {
                                $retina_marker_url = wp_get_attachment_url( $retina_marker_id );
                                if ( $retina_marker_url ) {
                                    $property_data[ 'retinaMarker' ] = esc_url( $retina_marker_url );
                                }
                            }
                            break;
                        }
                    }
                }
            }

            //Se default markers if property type has no marker uploaded
            if ( ! isset( $property_data[ 'marker' ] ) ) {
                $property_data[ 'marker' ]       = HOUZEZ_IMAGE . 'map/pin-single-family.png';           
                $property_data[ 'retinaMarker' ] = HOUZEZ_IMAGE . 'map/pin-single-family.png';  
            }

            //Featured image
            if ( has_post_thumbnail() ) {
                $thumbnail_id         = get_post_thumbnail_id();
                $thumbnail_array = wp_get_attachment_image_src( $thumbnail_id, 'houzez-map-info' );
                if ( ! empty( $thumbnail_array[ 0 ] ) ) {
                    $property_data[ 'thumbnail' ] = $thumbnail_array[ 0 ];
                }
            }
        }

        $map_options['markerPricePins'] = houzez_option('markerPricePins');
        $map_options['single_map_zoom'] = houzez_option('single_mapzoom', 15);
        $map_options['map_type'] = houzez_option('houzez_map_type');
        $map_options['map_pin_type'] = houzez_option('detail_map_pin_type', 'marker');
        $map_options['googlemap_stype'] = houzez_option('googlemap_stype');
        $map_options['closeIcon'] = HOUZEZ_IMAGE . 'map/close.png';
        $map_options['infoWindowPlac'] = houzez_get_image_placeholder_url( 'houzez-map-info' );

        wp_localize_script( 'houzez-single-property-map', 'houzez_single_property_map', $property_data );
        wp_localize_script( 'houzez-single-property-map', 'houzez_map_options', $map_options );
        wp_enqueue_script( 'houzez-single-property-map' );

    }
}