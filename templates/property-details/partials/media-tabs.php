<?php

$photos = $this->getDataDetails('photos');
$url_photo = $this->getDataDetails('url_photo');

$featured_image_url = $url_photo.'/'.$photos[0]->image;

$gallery_active = $map_active = $street_active = "";
$active_tab = 'show active';
if( $active_tab == 'map_view' ) {
	$map_active = 'show active';

} elseif( $active_tab == 'street_view' ) {
	$street_active = 'show active'; 
} else {
	$gallery_active = 'show active';
}


if($top_area == 'v2') { ?>
	<div class="tab-pane <?php echo esc_attr($gallery_active); ?>" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab" style="background-image: url(<?php echo esc_url($featured_image_url); ?>);">
		<?php include_once($pathTemplate.'property-details/partials/image-count.php'); ?>	
		<div class="d-flex page-title-wrap page-label-wrap">
			<div class="container">
			<?php include_once($pathTemplate.'property-details/partials/item-labels.php'); ?>
			</div>
		</div>
		<?php include_once($pathTemplate.'property-details/property-title.php'); ?> 
		<a class="property-banner-trigger" data-toggle="modal" data-target="#property-lightbox" href="#"></a>
	</div>

<?php } elseif($top_area == 'v3' || $top_area == 'v4') { ?>

	<div class="tab-pane <?php echo esc_attr($gallery_active); ?>" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab">
		<?php include_once($pathTemplate.'property-details/partials/gallery.php'); ?>
	</div>

<?php } elseif($top_area == 'v5') { ?>

	<div class="tab-pane <?php echo esc_attr($gallery_active); ?>" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab">
		<?php include_once($pathTemplate.'property-details/partials/image-count.php'); ?>
		<?php include_once($pathTemplate.'property-details/partials/gallery-variable-width.php'); ?>
	</div>

<?php } else { ?>

	<div class="tab-pane <?php echo esc_attr($gallery_active); ?>" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab" style="background-image: url(<?php echo esc_url($featured_image_url); ?>);">
		<?php include_once($pathTemplate.'property-details/partials/image-count.php'); ?>
		<?php 
		
			include_once($pathTemplate.'property-details/agent-form.php'); 
		?>

		<a class="property-banner-trigger" data-toggle="modal" data-target="#property-lightbox" href="#"></a>
	</div>

<?php } ?>
