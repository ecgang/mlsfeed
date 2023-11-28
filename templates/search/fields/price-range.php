<?php 
$min_price = isset($_GET['min_price']) && $_GET['min_price'] != '';
$max_price = isset($_GET['max_price']) && $_GET['max_price'] != '';
?>
<div class="range-text">
	<input type="hidden" name="min_price" class="min-price-range-hidden range-input" value="<?php echo esc_attr($min_price); ?>">
    <input type="hidden" name="max_price" class="max-price-range-hidden range-input" value="<?php echo esc_attr($max_price); ?>">
	<span class="range-title"><?php echo get_option('srh_price_range', 'Price Range:'); ?></span> <?php echo get_option('srh_from', 'from'); ?> <span class="min-price-range"></span> <?php echo get_option('srh_to', 'to'); ?> <span class="max-price-range"></span>
</div><!-- range-text -->
<div class="price-range-wrap">
	<div class="price-range"></div><!-- price-range -->
</div><!-- price-range-wrap -->