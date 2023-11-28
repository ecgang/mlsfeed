<?php
	$furnished = isset ( $_GET['furnished'] ) ? esc_attr($_GET['furnished']) : '';
?>
<div class="form-group">
	<select name="furnished" data-size="5" class="selectpicker form-control bs-select-hidden" title="<?php echo 'Furnished'; ?>" data-live-search="false">
		<option value=""><?php echo 'Furnished'; ?></option>
        <option value="yes" <?php echo $furnished == 'yes' ? 'selected="selected"' : '' ?>>Yes</option>
       	<option value="no" <?php echo $furnished == 'no' ? 'selected="selected"' : '' ?>>No</option>
        <option value="partially" <?php echo $furnished == 'partially' ? 'selected="selected"' : '' ?>>Partially</option>
        <option value="Optional Pkg" <?php echo $furnished == 'Optional Pkg' ? 'selected="selected"' : '' ?>>Optional Pkg</option>
	</select><!-- selectpicker -->
</div>
