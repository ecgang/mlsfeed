<div class="form-group">
	<select name="nbath" data-size="5" class="selectpicker form-control bs-select-hidden" title="<?php echo get_option('srh_bathrooms', 'Bathrooms'); ?>" data-live-search="false">
		<option value=""><?php echo get_option('srh_bathrooms', 'Bathrooms'); ?></option>
        <?php advmls_number_list('bathrooms'); ?>
	</select><!-- selectpicker -->
</div>