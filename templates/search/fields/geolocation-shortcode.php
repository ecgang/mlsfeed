<?php 
$checked = true;
$search_location = isset ( $_GET['search_location'] ) ? $_GET['search_location'] : ''; ?>
<div class="form-group">
	<div class="location-search hz-map-field-js" data-address-field="search_location_shortcode">
		<input name="search_location" id="search_location_shortcode" type="text" class="search_location_js form-control" value="<?php echo esc_attr($search_location); ?>" placeholder="<?php echo advmls_option('srh_location', 'Location'); ?>">
		<a class="btn location-trigger" href="#">
			<i class="advmls-icon icon-location-target"></i>
		</a>
		<input type="hidden" name="lat" value="<?php echo isset ( $_GET['lat'] ) ? esc_attr($_GET['lat']) : ''; ?>" >
        <input type="hidden" name="lng" value="<?php echo isset ( $_GET['lng'] ) ? esc_attr($_GET['lng']) : ''; ?>">

        <?php if( !advmls_is_half_map()) { ?>
        <input type="checkbox" name="use_radius" class="hide_search_checkbox" <?php checked( true, $checked ); ?>>
    	<?php } ?>
	</div><!-- location-search -->
</div><!-- form-group -->
<?php advmls_enqueue_maps_api(); ?>