<?php
$min_price = isset ( $_GET['min_price'] ) ? esc_attr($_GET['min_price']) : '';
?>
<div class="form-group">
	<input name="min_price" type="text" class="form-control" value="<?php echo esc_attr($min_price); ?>" placeholder="<?php echo 'Min. Price usd'; ?>">
</div><!-- form-group -->
