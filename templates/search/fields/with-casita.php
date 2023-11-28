<?php
	$with_casita = isset ( $_GET['with_casita'] ) ? esc_attr($_GET['with_casita']) : '';
	#yes, no, multiple casita or haciendas
?>
<div class="form-group">
	<select name="with_casita" data-size="5" class="selectpicker form-control bs-select-hidden" title="<?php echo 'Casita'; ?>" data-live-search="false">
		<option value=""><?php echo 'Casita'; ?></option>
        <option value="yes" <?php echo $with_casita == 'yes' ? 'selected="selected"' : '' ?>>Yes</option>
       	<option value="no" <?php echo $with_casita == 'no' ? 'selected="selected"' : '' ?>>No</option>
        <option value="multiple casitas_or_haciendas" <?php echo $with_casita == 'multiple casitas_or_haciendas' ? 'selected="selected"' : '' ?>>Multiple Casitas or Haciendas</option>
	</select><!-- selectpicker -->
</div>
