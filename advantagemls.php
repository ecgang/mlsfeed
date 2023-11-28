<?php
/**
 * Advantage MLS
 *
 * @package     AdvantageMLS
 * @author      Advantage MLS
 * @copyright   2021 Advantage MLS
 * @license     GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: Advantage MLS
 * Plugin URI:  https://advantagemls.com
 * Description: This Plugin lets you show all the listings from the MLS in a multitude  of ways, without the company nor listing agents info. additionally all information requests will go to you
 * Version:     1.2.9.1
 * Author:      Advantage MLS
 * Author URI:  https://advantagemls.com
 * Text Domain: advantage-mls
 * License:     GPL v2 or later
 * License URI: https://advantagemls.com
 */

    include "mlsAutoloader.php";
    include "mlsFunctions.php";
    $autoloader = mlsAutoloader::getInstance();
    $rewriteRules = mlsRewriteRules::getInstance();
    $virtualPageDispatcher = mlsVirtualPageDispatcher::getInstance();

    if(is_admin()){
        include 'adminpage/mlsAdminCheckVersion.php';

        add_action('admin_menu', 'mls_admin_menu');
    }

    add_action("init", array($rewriteRules, "initialize"), 1);

    function display_mls_page() {
    ?>
    	<h2>Information</h2>
    	<p>Thank You for using the Advantage MLS IDX plugin for Wordpress</p>
        <p>for help or assistance you can contact us at advantagemls@hotmail.com</p>
    	<?php
    }

    // In get option
    add_filter("page_template", array($virtualPageDispatcher, "getPageTemplate"));
    add_filter("the_content", array($virtualPageDispatcher, "getContent"), 20);
    add_filter("the_excerpt", array($virtualPageDispatcher, "getExcerpt"), 20);

    add_filter("the_posts", array($virtualPageDispatcher, "postCleanUp"), 10, 2);
    add_filter("comments_array", array($virtualPageDispatcher, "clearComments"));

    function mls_admin_menu() {
        add_menu_page(
            'Advantage MLS',// page title
            'Advantage MLS',// menu title
            'manage_options',// capability
            'advantage-mls',// menu slug
            'display_mls_page' // callback function
        );
        add_submenu_page('advantage-mls', 
            "Register",
            "Register",
            "manage_options",
            'advantage-mls-activated',
            array(mlsAdminActivate::getInstance(), "getContent"));
            mlsAdminActivate::getInstance()->registerSettings();

        add_submenu_page('advantage-mls', 
            "Settings",
            "Settings",
            "manage_options",
            'advantage-mls-settings',
            array(mlsAdminSettings::getInstance(), "getContent"));
            mlsAdminSettings::getInstance()->registerSettings();
    }

    // Register and load the widget
    function mls_load_widget() {

        register_widget( 'mlsAdvanceSearchWidget' );
        register_widget( 'mlsSlideShowWidget' );
        register_widget( 'mlsShowListPropertiesWidget' );
        register_widget( 'mlsShowFeaturesPropertiesWidget' );
        register_widget( 'mlsListAgentsWidget' ); // for companies
        register_widget( 'mlsContactFormWidget' );
        register_widget( 'mlsCompanyInfoWidget' ); // for companies
        register_widget( 'mlsGoogleMapsWidget' ); // for companies
        register_widget( 'mlsRecentPostsWidget' );
        register_widget( 'mlsShowPropertiesVideosWidget' );
        
    }
    if (mlsUtility::getInstance()->isActivated()) {
        // Widgets
        add_action( 'widgets_init', 'mls_load_widget' );

        // Shortcodes
        add_shortcode('getCompanyInfo', "getCompanyInfoShortCode");
    }