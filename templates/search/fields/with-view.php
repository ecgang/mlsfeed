<?php
	$with_view = isset ( $_GET['with_view'] ) ? esc_attr($_GET['with_view']) : '';
	#montain, lake, lake and montain, Ocean, Partial
?>
<div class="form-group">
	<select name="with_view" data-size="5" class="selectpicker form-control" title="<?php echo 'View'; ?>" data-live-search="false">
		<option value=""><?php echo 'View'; ?></option>
        <option value="Lake" <?php echo $with_view == 'Lake' ? 'selected="selected"' : '' ?>>Lake</option>
       	<option value="Mountain" <?php echo $with_view == 'Mountain' ? 'selected="selected"' : '' ?>>Mountain</option>
       	<option value="Lake and Mountain" <?php echo $with_view == 'Lake and Mountain' ? 'selected="selected"' : '' ?>>Lake and Mountain</option>
       	<option value="Ocean" <?php echo $with_view == 'Ocean' ? 'selected="selected"' : '' ?>>Ocean</option>
       	<option value="Partial" <?php echo $with_view == 'Partial' ? 'selected="selected"' : '' ?>>Partial</option>
        
	</select><!-- selectpicker -->
</div>
