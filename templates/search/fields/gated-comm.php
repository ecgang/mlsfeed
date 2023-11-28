<?php
	$gated_comm = isset ( $_GET['gated_comm'] ) ? esc_attr($_GET['gated_comm']) : '';
	#yes, no, multiple casita or haciendas
?>
<div class="form-group">
	<select name="gated_comm" data-size="5" id="gated_comm" class="selectpicker form-control bs-select-hidden gated_comm" title="<?php echo 'Gated Comm'; ?>" data-live-search="false">
		<option value=""><?php echo 'Gated Comm'; ?></option>
        <option value="yes" <?php echo $gated_comm == 'yes' ? 'selected="selected"' : '' ?>>Yes</option>
       	<option value="no" <?php echo $gated_comm == 'no' ? 'selected="selected"' : '' ?>>No</option>
        
	</select><!-- selectpicker -->
</div>
