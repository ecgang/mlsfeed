<?php 

function apply_package() {

    $newerVersion = mlsUtility::getInstance()->advmls_check_version();
    $_current_version = ADVMLS_PLUGIN_VERSION;
    $_plugin = ADVMLS_BASENAME_ID;

    if ($newerVersion and isset($newerVersion->newer_version)) {

        $update_plugins = new \stdClass();
        $new_version = $newerVersion->newer_version;
        $plugin_slug = 'advmls-upd';
        $package_url = $newerVersion->package;

        $plugin_info = new \stdClass();

        $plugin_info->new_version = $new_version;
        $plugin_info->slug = $plugin_slug;
        $plugin_info->package = $package_url;
        $plugin_info->url = 'https://advantagemls.com/';
        $plugin_info->plugin = $_plugin;
        $plugin_info->requires_php = $newerVersion->requires_php;

        $update_plugins = $plugin_info;

        if(version_compare($new_version, $_current_version, '>')){
            return $update_plugins ;

        }
    }
    return false;
}

function advmls_site_transient_update_plugins( $transient ) {

    $update = apply_package();
    $_current_version = ADVMLS_PLUGIN_VERSION;
    $_plugin = ADVMLS_BASENAME_ID;
    $transient = new \stdClass();
    
    if ( $update ) {
        // Update is available.
        // $update should be an array containing all of the fields in $item below.
        $transient->response[$_plugin] = $update;
    } else {
        // No update is available.
        
        $item = (object) array(
            'id'            => $_plugin,
            'slug'          => 'advantagemls',
            'plugin'        => $_plugin,
            'new_version'   => $_current_version,
            'url'           => '',
            'package'       => '',
            'icons'         => array(),
            'banners'       => array(),
            'banners_rtl'   => array(),
            'tested'        => '',
            'requires_php'  => '',
            'compatibility' => new stdClass(),
        );
        // Adding the "mock" item to the `no_update` property is required
        // for the enable/disable auto-updates links to correctly appear in UI.
        $transient = false;
    }

    return $transient;
}

remove_filter( 'site_transient_update_plugins', 'advmls_site_transient_update_plugins', 10, 1 );  
add_filter( 'site_transient_update_plugins', 'advmls_site_transient_update_plugins', 10, 1 );