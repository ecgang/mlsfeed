<?php
/* ----------------------------------------------------------------------------
 * Enqueue styles.
 *----------------------------------------------------------------------------*/
if( !function_exists('advmls_enqueue_styles') ) {
    function advmls_enqueue_styles() {


            $minify_css = get_option('minify_css');
            $css_minify_prefix = '';
            if ($minify_css != 0) {
                $css_minify_prefix = '.min';
            }

            /* Register Styles
             * ----------------------*/
            if( get_option('css_all_in_one', 0) ) {
                
                wp_enqueue_style('advmls-all-css', ADVMLS_CSS_DIR_URI . 'all-css.css', array(), ADVMLS_PLUGIN_VERSION);
                wp_enqueue_style('font-awesome-5-all', ADVMLS_CSS_DIR_URI . 'font-awesome/css/all.min.css', array(), '5.14.0', 'all');

            } else {
                wp_enqueue_style('bootstrap', ADVMLS_CSS_DIR_URI . 'bootstrap.min.css', array(), '4.5.0');
                wp_enqueue_style('bootstrap-select', ADVMLS_CSS_DIR_URI . 'bootstrap-select.min.css', array(), '1.13.18');
                wp_enqueue_style('font-awesome-5-all', ADVMLS_CSS_DIR_URI . 'font-awesome/css/all.min.css', array(), '5.14.0', 'all');
                wp_enqueue_style('advmls-icons', ADVMLS_CSS_DIR_URI . 'icons'.$css_minify_prefix.'.css', array(), ADVMLS_PLUGIN_VERSION);

                if ( is_singular('property') ) {
                    wp_enqueue_style('lightslider', ADVMLS_CSS_DIR_URI . 'lightslider.css', array(), '1.1.3');
                }

                wp_enqueue_style('slick-min', ADVMLS_CSS_DIR_URI . 'slick-min.css', array(), ADVMLS_PLUGIN_VERSION);
                wp_enqueue_style('slick-theme-min', ADVMLS_CSS_DIR_URI . 'slick-theme-min.css', array(), ADVMLS_PLUGIN_VERSION);

                wp_enqueue_style('jquery-ui', ADVMLS_CSS_DIR_URI . 'jquery-ui.min.css', array(), '1.12.1');
                wp_enqueue_style('radio-checkbox', ADVMLS_CSS_DIR_URI . 'radio-checkbox-min.css', array(), ADVMLS_PLUGIN_VERSION);

                wp_enqueue_style('bootstrap-datepicker', ADVMLS_CSS_DIR_URI . 'bootstrap-datepicker.min.css', array(), '1.8.0');

                wp_enqueue_style('advmls-main', ADVMLS_CSS_DIR_URI . 'main'.$css_minify_prefix.'.css', array(), ADVMLS_PLUGIN_VERSION);
                wp_enqueue_style('advmls-styling-options', ADVMLS_CSS_DIR_URI . 'styling-options'.$css_minify_prefix.'.css', array(), ADVMLS_PLUGIN_VERSION);
            }

            if( advmls_get_map_system() == 'osm' ) {
                wp_enqueue_script( 'jquery-ui-autocomplete' );  // Use in osm-properties.js
            }

            if (is_rtl()) {
                wp_enqueue_style('bootstrap-rtl', get_template_directory_uri() . '/css/bootstrap-rtl.min.css', array(), '4.4.1', 'all');
                wp_enqueue_style('advmls-rtl', get_template_directory_uri() . '/css/rtl' . $css_minify_prefix . '.css', array(), ADVMLS_PLUGIN_VERSION, 'all');
            }

            wp_enqueue_style('advmls-style', get_stylesheet_uri(), array(), ADVMLS_PLUGIN_VERSION, 'all');

    }
    add_action( 'wp_enqueue_scripts', 'advmls_enqueue_styles' );
}

/* ----------------------------------------------------------------------------
 * Enqueue scripts
 *----------------------------------------------------------------------------*/
if( !function_exists('advmls_enqueue_scripts') ) {
    function advmls_enqueue_scripts() {
        
           
            $protocol = is_ssl() ? 'https' : 'http';

            $advmls_logged_in = 'yes';
            if (!is_user_logged_in()) {
                $advmls_logged_in = 'no';
            }

            if (is_rtl()) {
                $advmls_rtl = "yes";
            } else {
                $advmls_rtl = "no";
            }

            $userID = null;
            $after_login_redirect = null;
            $login_redirect = null;
            $agent_form_redirect = null;

            wp_enqueue_script( 'jquery' );

            if( get_option('js_all_in_one', 0) ) {

                wp_enqueue_script('advmls-all-in-one', ADVMLS_JS_DIR_URI. 'vendors/all-scripts.js', array('jquery'), ADVMLS_PLUGIN_VERSION, true);

                wp_enqueue_script( 'jquery-ui-slider' );

            } else {

                wp_enqueue_script('bootstrap', ADVMLS_JS_DIR_URI. 'vendors/bootstrap.bundle.min.js', array('jquery'), '4.5.0', true);

                wp_enqueue_script('bootstrap-select', ADVMLS_JS_DIR_URI. 'vendors/bootstrap-select.min.js', array('jquery'), '1.13.18', true);
                wp_enqueue_script('modernizr', ADVMLS_JS_DIR_URI. 'vendors/modernizr.custom.js', array('jquery'), '3.2.0', true);
            
                wp_enqueue_script('slideout', ADVMLS_JS_DIR_URI. 'vendors/slideout.min.js', array('jquery'), ADVMLS_PLUGIN_VERSION, true);
                wp_enqueue_script('lightbox', ADVMLS_JS_DIR_URI. 'vendors/lightbox.min.js', array('jquery'), ADVMLS_PLUGIN_VERSION, true);
                wp_enqueue_script('theia-sticky-sidebar', ADVMLS_JS_DIR_URI. 'vendors/theia-sticky-sidebar.min.js', array('jquery'), ADVMLS_PLUGIN_VERSION, true);

                wp_enqueue_script('slick', ADVMLS_JS_DIR_URI. 'vendors/slick.min.js', array('jquery'), ADVMLS_PLUGIN_VERSION, true);

                wp_enqueue_script( 'jquery-ui-slider' );
                
            }

            $search_min_price = get_option('advanced_search_widget_min_price', 0);
            $search_min_price_range_for_rent = get_option('advanced_search_min_price_range_for_rent', 0);

            $search_max_price = get_option('advanced_search_widget_max_price', 2500000);
            $search_max_price_range_for_rent = get_option('advanced_search_max_price_range_for_rent', 12000);

            wp_enqueue_script('advmls-custom', ADVMLS_JS_DIR_URI. 'custom.js' , array('jquery'), ADVMLS_PLUGIN_VERSION, true);

            wp_localize_script('advmls-custom', 'advmls_vars',
            array(
                'admin_url' => get_admin_url(),
                'advmls_rtl' => $advmls_rtl,
                'user_id' => $userID,
                'redirect_type' => $after_login_redirect,
                'login_redirect' => $login_redirect,
                'wp_is_mobile' => wp_is_mobile(),
                'default_lat' => get_option('map_default_lat', 25.686540),
                'default_long' => get_option('map_default_long', -80.431345),
                'prop_detail_nav' => get_option('prop-detail-nav', 'no'),
                'is_singular_property' => is_singular('property'),
                'login_loading' => esc_html__('Sending user info, please wait...', 'advmls'),
                'not_found' => esc_html__("We didn't find any results", 'advmls'),                
                'search_min_price_range' => 0,
                'search_max_price_range' => 10000000,
                'search_min_price_range_for_rent' => 0,
                'search_max_price_range_for_rent' => 10000000,
                'get_min_price' => isset($_GET['min_price']) ? $_GET['min_price'] : 0,
                'get_max_price' => isset($_GET['max_price']) ? $_GET['max_price'] : 0,
                'currency_position' => get_option('currency_position', 'before'),
                'currency_symbol' => get_option('currency_symbol', '$'),
                'decimals' => get_option('decimals', '2'),
                'decimal_point_separator' => get_option('decimal_point_separator', '.'),
                'thousands_separator' => get_option('decimal_point_separator', ','),
                'advmls_date_language' => get_option('advmls_date_language', ''),
                'advmls_default_radius' => get_option('advmls_default_radius', '50'),
                'processing_text' => esc_html__('Processing, Please wait...', 'advmls'),
                'prev_text' => esc_html__('Prev', 'advmls'),
                'next_text' => esc_html__('Next', 'advmls'),
                'keyword_search_field' => get_option('keyword_field'),
                'keyword_autocomplete' => get_option('keyword_autocomplete', 0),
                'autosearch_text' => esc_html__('Searching...', 'advmls'),
                'paypal_connecting' => esc_html__('Connecting to paypal, Please wait... ', 'advmls'),
                'is_top_header' => get_option('top_bar', 0),
                'simple_logo' => get_custom_logo(),
                'retina_logo' => get_option('retina_logo', '', 'url'),
                'mobile_logo' => get_option('mobile_logo', '', 'url'),
                'retina_logo_mobile' => get_option('mobile_retina_logo', '', 'url'),
                'retina_logo_mobile_splash' => get_option('retina_logo_mobile_splash', '', 'url'),
                'custom_logo_splash' => get_option('custom_logo_splash', '', 'url'),
                'retina_logo_splash' => get_option('retina_logo_splash', '', 'url'),
                'monthly_payment' => esc_html__('Monthly Payment', 'advmls'),
                'weekly_payment' => esc_html__('Weekly Payment', 'advmls'),
                'bi_weekly_payment' => esc_html__('Bi-Weekly Payment', 'advmls'),
                'compare_page_not_found' => esc_html__('Please create page using compare properties template', 'advmls'),
                'compare_limit' => esc_html__('Maximum item compare are 4', 'advmls'),
                'compare_add_icon' => '',
                'compare_remove_icon' => '',
                'add_compare_text' => get_option('cl_add_compare', 'Add to Compare'),
                'remove_compare_text' => get_option('cl_remove_compare', 'Remove from Compare'),
                'is_mapbox' => get_option('advmls_map_system'),
                'api_mapbox' => get_option('mapbox_api_key'),
                'is_marker_cluster' => get_option('map_cluster_enable'),
                'g_recaptha_version' => get_option( 'recaptha_type', 'v2' ),
                's_country' => isset($_GET['country']) ? $_GET['country'] : '',
                's_state' => isset($_GET['states']) ? $_GET['states'] : '',
                's_city' => isset($_GET['location']) ? $_GET['location'] : '',
                's_areas' => isset($_GET['areas']) ? $_GET['areas'] : '',
                'agent_redirection' => $agent_form_redirect,
                'default_state' => isset($_GET['states'][0]) && (int)$_GET['states'][0] > 0 ? $_GET['states'][0] : get_option('advmls_default_state',null),
                'default_city' => isset($_GET['cities'][0]) && (int)$_GET['cities'][0] > 0 ? $_GET['cities'][0] : get_option('advmls_default_city',null),
                'css_dir_uri' => ADVMLS_CSS_DIR_URI,
                'list_selectors_ignore' => get_option('advmls_not_translate_selectors'),
                'advmls_lang_settings' => get_option('advmls_lang_settings')
            )
        ); // end ajax calls

        //enqueue maps scripts
        if(advmls_get_map_system() == 'google') {
            #advmls_google_maps_scripts();
        } else {
            advmls_osm_maps_scripts();
        }
    }

    add_action( 'wp_enqueue_scripts', 'advmls_enqueue_scripts' );
}

if (is_admin() ){
    function advmls_admin_scripts(){
        global $pagenow, $typenow;

        wp_enqueue_style( 'advmls-admin.css', ADVMLS_CSS_DIR_URI. 'admin/admin.css', array(), ADVMLS_PLUGIN_VERSION, 'all' );

        wp_enqueue_script('advmls-admin-ajax', ADVMLS_JS_DIR_URI .'admin/advmls-admin-ajax.js', array('jquery'));
        wp_localize_script('advmls-admin-ajax', 'advmls_admin_vars',
            array( 
                'nonce'        => wp_create_nonce( 'advmls-admin-nonce' ),
                'ajaxurl'      => admin_url( 'admin-ajax.php' ),
                'paid_status'  => esc_html__( 'Paid','advmls' ),
                'activate_now' => esc_html__( 'Activate Now', 'advmls' ),
                'activating'   => esc_html__( 'Activating...', 'advmls' ),
                'activated'    => esc_html__( 'Activated!', 'advmls' ),
                'install_now'  => esc_html__( 'Install Now', 'advmls' ),
                'installing'   => esc_html__( 'Installing...', 'advmls' ),
                'installed'    => esc_html__( 'Installed!', 'advmls' ),
                'active'       => esc_html__( 'Active', 'advmls' ),
                'failed'       => esc_html__( 'Failed!', 'advmls' ),
            )
        );

    }
    add_action('admin_enqueue_scripts', 'advmls_admin_scripts');
}

// Header custom JS
function advmls_header_scripts(){

    $custom_js_header = get_option('custom_js_header');

    if ( $custom_js_header != '' ){
        echo ( $custom_js_header );
    }
}
if(!is_admin()){
    add_action('wp_head', 'advmls_header_scripts');
}

// Footer custom JS
function advmls_footer_scripts(){
    $custom_js_footer = get_option('custom_js_footer');

    if ( $custom_js_footer != '' ){
        echo ( $custom_js_footer );
    }
}
if(!is_admin()){
    add_action( 'wp_footer', 'advmls_footer_scripts', 100 );
}