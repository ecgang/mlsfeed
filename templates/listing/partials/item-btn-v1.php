<?php 
$button_class = '';
if( !get_option('disable_date', 1) && !get_option('disable_agent', 1)) {
	$button_class = 'item-no-footer';
}

$pro_alias = $this->getFielProperty('pro_alias', $currentKey);
$category_name = $this->getFielProperty('category_name', $currentKey);
$urlProDetail = mlsUrlFactory::getInstance()->getListingDetailUrl(true);


if(get_option('disable_detail_btn', 1)) { ?>
<a class="btn btn-primary btn-item <?php echo esc_attr($button_class); ?>" href="<?php echo esc_url($urlProDetail.$category_name.'/'.$pro_alias); ?>">
	<?php echo get_option('glc_detail_btn', 'Details'); ?>
</a><!-- btn-item -->
<?php } ?>