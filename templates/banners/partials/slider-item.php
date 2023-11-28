<?php

if ( count($args->photos) > 0) {
	#var_dump($args);
	$img_url = $args->url_photo."/".$args->photos[0]->image;
}
?>
<div class="property-slider-item-wrap" style="background-image: url(<?php echo esc_url($img_url); ?>);"	>
	<a href="#" class="property-slider-link"></a>
	<div class="property-slider-item">
		<?php get_template_part('template-parts/listing/partials/item-featured-label','item-featured-label',$args); ?>
		<?php get_template_part('template-parts/listing/partials/item-title','item-title',$args); ?>
		<?php get_template_part('template-parts/listing/partials/item-address','item-address',$args); ?>
		<?php get_template_part('template-parts/listing/partials/item-price','item-price',$args); ?>
		<?php get_template_part('template-parts/listing/partials/item-features-v1','item-features-v1',$args); ?>
		<?php get_template_part('template-parts/listing/partials/item-author','item-author',$args); ?>
		<?php get_template_part('template-parts/listing/partials/item-date','item-date',$args); ?>
		<?php get_template_part('template-parts/listing/partials/item-btn','item-btn',$args); ?>
	</div><!-- property-slider-item -->
</div><!-- property-slider-item-wrap -->