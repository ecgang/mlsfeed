<?php
	$pool = isset ( $_GET['pool'] ) ? esc_attr($_GET['pool']) : '';
?>
<div class="form-group">
	<select name="pool" data-size="5" class="selectpicker form-control bs-select-hidden" title="<?php echo 'Pool'; ?>" data-live-search="false">
		<option value=""><?php echo 'Pool'; ?></option>
       	<option value="no" <?php echo $pool == 'no' ? 'selected="selected"' : '' ?>>No</option>
        <option value="yes" <?php echo $pool == 'yes' ? 'selected="selected"' : '' ?>>Yes</option>
	</select><!-- selectpicker -->
</div>
