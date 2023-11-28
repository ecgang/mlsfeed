<?php
	$with_yard = isset ( $_GET['with_yard'] ) ? esc_attr($_GET['with_yard']) : '';
?>
	<div class="form-group">
		<select name="with_yard" data-size="5" class="selectpicker form-control bs-select-hidden" title="<?php echo get_option('srh_rooms', 'Yard'); ?>" data-live-search="false">
			<option value=""><?php echo get_option('srh_rooms', 'Yard'); ?></option>
	        <option value="no" <?php echo $with_yard == 'no' ? 'selected="selected"' : '' ?>>No</option>
	        <option value="yes" <?php echo $with_yard == 'yes' ? 'selected="selected"' : '' ?>>Yes</option>
		</select><!-- selectpicker -->
	</div>
