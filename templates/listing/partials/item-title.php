<?php 
global $property;
$pro_alias = $property->pro_alias ? $property->pro_alias : '';
$category_name = $property->category_name ? $property->category_name : '';
$pro_title = $property->pro_name.' - '.$property->ref;

$urlProDetail = mlsUrlFactory::getInstance()->getListingDetailUrl(true);
?>
<h2 class="item-title m-1 p-1">
	<a href="<?php echo mlsUtility::getInstance()->advmls_esc_url($urlProDetail.$category_name.'/'.$pro_alias); ?>" target="_blank"><?php echo $pro_title; ?></a>
</h2><!-- item-title -->