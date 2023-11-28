<div class="form-group">
	<select name="rooms" data-size="5" class="selectpicker form-control bs-select-hidden" title="<?php echo get_option('srh_rooms', 'Floors'); ?>" data-live-search="false">
		<option value=""><?php echo get_option('srh_rooms', 'Floors'); ?></option>
        <?php advmls_number_list('rooms'); ?>
	</select><!-- selectpicker -->
</div>