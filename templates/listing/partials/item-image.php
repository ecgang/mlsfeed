<?php 
global $property;
$properties_images = !empty($property->photos) ? $property->photos : array();

$url_photo = !empty($property->url_photo) ? $property->url_photo : '';
$no_photo = !empty($property->no_photo) ? $property->no_photo : '';

$pro_alias = !empty($property->pro_alias) ? $property->pro_alias : '';
$category_name = !empty($property->category_name) ? $property->category_name : '';

$urlProDetail = mlsUrlFactory::getInstance()->getListingDetailUrl(true);

?>
<div class="listing-image-wrap">
	<div class="listing-thumb text-center">
		<a href="<?php echo mlsUtility::getInstance()->advmls_esc_url($urlProDetail.$category_name.'/'.$pro_alias); ?>" target="_blank" class="listing-featured-thumb hover-effect">
			<img  src="<?php echo $no_photo; ?>" alt="" style="max-width: 100%; max-height: 240px;" loading="lazy" srcset="<?php echo $url_photo.'/'.$properties_images[0]->image ?>">
		</a><!-- hover-effect -->
	</div>
</div>
