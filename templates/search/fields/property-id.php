<?php $property_id = isset ( $_GET['property_id'] ) ? $_GET['property_id'] : ''; ?>
<div class="form-group">
	<input name="property_id" type="text" class=" form-control" value="<?php echo esc_attr($property_id); ?>" placeholder="<?php echo get_option('srh_prop_id', 'Property ID'); ?>">
</div>