<?php 
$images = $this->getDataDetails('photos');
$url_image = $this->getDataDetails('url_image');

$fave_property_images = $url_image.'/'.$images[0]->image;
?>

<div class="visible-on-mobile">
    <div class="mobile-top-wrap">
        <div class="mobile-property-tools clearfix">
            <?php 
            if( !empty($fave_property_images) ) {
                #include_once($pathTemplate.'property-details/partials/banner-nav.php'); 
            }?>
            <?php include_once($pathTemplate.'property-details/partials/tools.php'); ?> 
        </div><!-- mobile-property-tools -->
        <div class="mobile-property-title clearfix">
            <?php include_once($pathTemplate.'listing/partials/item-featured-label.php'); ?>
            <?php include_once($pathTemplate.'property-details/partials/item-labels-mobile.php'); ?>
            <?php include_once($pathTemplate.'property-details/partials/title.php'); ?> 
            <?php include_once($pathTemplate.'property-details/partials/item-address.php'); ?>
            <?php include_once($pathTemplate.'property-details/partials/item-price.php'); ?>
            
        </div><!-- mobile-property-title -->
    </div><!-- mobile-top-wrap -->
    <?php 
    if($top_area == 'v6') {
        include_once($pathTemplate.'property-details/overview.php');  
    }
    ?>
</div><!-- visible-on-mobile -->