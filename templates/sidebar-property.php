<?php

$agent_form = 1;

?>

<aside id="sidebar" class="sidebar-wrap">
    <?php
        if( $agent_form != 0 ) {
            include($pathTemplate.'property-details/agent-form.php' );
        }

        #dynamic_sidebar( 'property-listing' );

        /*
    if( is_singular('property') ) { 


        if( is_active_sidebar( 'single-property' ) ) {
            dynamic_sidebar( 'single-property' );
        }
    } else {
        if( $sidebar_meta['specific_sidebar'] == 'yes' ) {
            if( is_active_sidebar( $sidebar_meta['selected_sidebar'] ) ) {
                dynamic_sidebar( $sidebar_meta['selected_sidebar'] );
            }
        } else {
            if( is_active_sidebar( 'property-listing' ) ) {
                dynamic_sidebar( 'property-listing' );
            }
        }
    }*/

    ?>
</aside>