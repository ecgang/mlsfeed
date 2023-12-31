<?php
if( advmls_is_half_map() ) {
	$field_name = "search_radius";
} else {
	$field_name = "radius";
}
?>
<div class="form-group">
	<select name="radius" data-size="8" class="selectpicker <?php advmls_ajax_search(); ?> form-control bs-select-hidden" title="<?php echo advmls_option('srh_radius', 'Radius');?>" data-none-results-text="<?php echo advmls_option('cl_no_results_matched', 'No results matched');?> {0}" data-live-search="true">
		<option value=""><?php echo advmls_option('srh_radius', 'Radius');?></option>
		<?php
		$radius_unit = advmls_option('radius_unit');
		$selected_radius = advmls_option('advmls_default_radius');
		if( isset( $_GET['radius'] ) ) {
		    $selected_radius = $_GET['radius'];
		}
	    $i = 0;
	    for( $i = 1; $i <= 100; $i++ ) {
	        echo '<option '.selected( $selected_radius, $i, false).' value="'.esc_attr($i).'">'.esc_attr($i).' '.esc_attr($radius_unit).'</option>';
	    }
	    ?>
	</select><!-- selectpicker -->
</div><!-- form-group -->