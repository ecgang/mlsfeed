<div class="form-group">
	<select name="nbed" data-size="5" class="selectpicker form-control bs-select-hidden" title="<?php echo get_option('srh_bedrooms', 'Bedrooms'); ?>" data-live-search="false">
		<option value=""><?php echo get_option('srh_bedrooms', 'Bedrooms'); ?></option>
        <?php advmls_number_list('bedrooms'); ?>
	</select><!-- selectpicker -->
</div>