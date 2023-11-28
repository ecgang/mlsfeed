<?php 
$compared = isset($_COOKIE['advmls_compare_listings']) ? $_COOKIE['advmls_compare_listings'] : '';
$ids = explode(',', $compared);
?>
<div id="compare-property-panel" class="compare-property-panel compare-property-panel-vertical compare-property-panel-right">
	
	<button class="compare-property-label" style="display: none;">
		<span class="compare-count compare-label"></span>
		<i class="advmls-icon icon-move-left-right"></i>
	</button>

	<p><strong><?php echo esc_html__('Compare listings', 'advmls'); ?></strong></p>
	
	<div class="compare-wrap">
		<?php 
		if(!empty($ids[0])) {
		foreach($ids as $id ) { ?>
			<div class="compare-item remove-<?php echo intval($id); ?>">
				<a href="" class="remove-compare remove-icon" data-listing_id="<?php echo intval($id); ?>"><i class="advmls-icon icon-remove-circle"></i></a>

				<?php if(!empty(get_the_post_thumbnail_url($id, 'advmls-item-image-1'))) { ?>
				<img class="img-fluid" src="<?php echo get_the_post_thumbnail_url($id, 'advmls-item-image-1'); ?>" width="200" height="150" alt="<?php esc_attr_e('Thumb', 'advmls'); ?>">
				<?php } else { ?>
				<div class="empty-compare-item"></div>
				<?php } ?>
			</div>
		<?php } 
		}?>
	</div>


	<a href="" class="compare-btn btn btn-primary btn-full-width mb-2"><?php echo esc_html__('Compare', 'advmls'); ?></a>
	<button class="btn btn-grey-outlined btn-full-width close-compare-panel"><?php echo esc_html__('Close', 'advmls'); ?></button>
</div>