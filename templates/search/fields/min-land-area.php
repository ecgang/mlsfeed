<?php
$min_land_area = isset ( $_GET['lotsize_min'] ) ? esc_attr($_GET['lotsize_min']) : '';
$land_area_plac = get_option('srh_min_land_area', 'Min. Lot m²');

?>
<div class="form-group">
	<input name="lotsize_min" type="text" class="form-control" value="<?php echo esc_attr($min_land_area); ?>" placeholder="<?php echo $land_area_plac; ?>">
</div><!-- form-group -->