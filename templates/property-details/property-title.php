
<div class="page-title-wrap">
    <div class="container">
	<?php 
            $alertText = get_option('advmls_alert_details',''); 
            if ( !empty($alertText) ) {
        ?>
                <div class="alert-details small mb-2" style="text-align: center; font-weight: bold;background: #f5f5f5;"><?php echo $alertText; ?></div>
        <?php } ?>
        <div class="d-flex align-items-center">
            <?php #include_once($pathTemplate.'page/breadcrumb.php'); ?>
            <?php include_once($pathTemplate.'property-details/partials/tools.php'); ?> 
        </div><!-- d-flex -->
        <div class="d-flex align-items-center property-title-price-wrap">
            <?php include_once($pathTemplate.'property-details/partials/title.php'); ?>
            <?php include_once($pathTemplate.'property-details/partials/item-price.php'); ?>
        </div><!-- d-flex -->
        <div class="property-labels-wrap">
        <?php 
        if( $top_area != 'v2' ) {
           include_once($pathTemplate.'property-details/partials/item-labels.php'); 
        }
        ?>
        </div>
        <?php include_once($pathTemplate.'property-details/partials/item-address.php'); ?>
    </div><!-- container -->
</div><!-- page-title-wrap -->
