<?php
$max_price = isset ( $_GET['max_price'] ) ? esc_attr($_GET['max_price']) : '';
?>

<div class="form-group">
	<input name="max_price" type="text" class="form-control" value="<?php echo esc_attr($max_price); ?>" placeholder="<?php echo 'Max. Price usd'; ?>">
</div><!-- form-group -->