<?php
$max_area = isset ( $_GET['sqft_max'] ) ? esc_attr($_GET['sqft_max']) : '';
$area_plac = get_option('srh_max_area', 'Max. Construction m²');

?>

<div class="form-group">
	<input name="sqft_max" type="text" class="form-control" value="<?php echo esc_attr($max_area); ?>" placeholder="<?php echo $area_plac; ?>">
</div><!-- form-group -->