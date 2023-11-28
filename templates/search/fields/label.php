<div class="form-group">
	<select name="label[]" data-size="5" class="selectpicker form-control bs-select-hidden" title="<?php echo  get_option('srh_label','Label'); ?>" data-selected-text-format="count > 1" data-live-search="false" data-actions-box="true" data-select-all-text="<?php echo get_option('cl_select_all', 'Select All'); ?>" data-deselect-all-text="<?php echo get_option('cl_deselect_all', 'Deselect All'); ?>" data-none-results-text="<?php echo get_option('cl_no_results_matched', 'No results matched');?> {0}" data-count-selected-text="{0} <?php echo get_option('srh_labels', 'Labels'); ?>" data-container="body">
		<?php

			echo '<option value="">'.get_option('srh_label','Label').'</option>';

		?>
	</select><!-- selectpicker -->
</div><!-- form-group -->