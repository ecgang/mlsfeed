<?php
	$parking_street = isset ( $_GET['parking_street'] ) ? esc_attr($_GET['parking_street']) : '';
?>

<div class="form-group">
	<select name="parking_street" data-size="5" class="selectpicker form-control bs-select-hidden" title="<?php echo  'Parking'; ?>" data-live-search="false">
		<option value="">Any</option>
		<option value="off_street" <?php echo $parking_street == 'off_street' ? 'selected="selected"' : '' ?>>Off Street</option>
		<option value="on_street" <?php echo $parking_street == 'on_street' ? 'selected="selected"' : '' ?>>On Street</option>
	</select><!-- selectpicker -->
</div>
