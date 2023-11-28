<?php
$max_land_area = isset ( $_GET['lotsize_max'] ) ? esc_attr($_GET['lotsize_max']) : '';
$land_area_plac = get_option('srh_max_land_area', 'Max. Lot m²');

?>
<div class="form-group">
	<input name="lotsize_max" type="text" class="form-control" value="<?php echo esc_attr($max_land_area); ?>" placeholder="<?php echo $land_area_plac; ?>">
</div><!-- form-group -->