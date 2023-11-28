<?php
$min_area = isset ( $_GET['sqft_min'] ) ? esc_attr($_GET['sqft_min']) : '';
$area_plac = get_option('srh_min_area', 'Min. Construction m²');

?>
<div class="form-group">
	<input name="sqft_min" type="text" class="form-control" value="<?php echo esc_attr($min_area); ?>" placeholder="<?php echo $area_plac; ?>">
</div><!-- form-group -->