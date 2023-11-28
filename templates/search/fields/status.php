<div class="form-group">
	<select name="pro_types[]" data-size="5" class="selectpicker status-js form-control bs-select-hidden" title="<?php echo get_option('srh_status', 'Status'); ?>" data-live-search="false" data-selected-text-format="count > 1" data-actions-box="true" data-select-all-text="<?php echo get_option('cl_select_all', 'Select All'); ?>" data-deselect-all-text="<?php echo get_option('cl_deselect_all', 'Deselect All'); ?>" data-none-results-text="<?php echo get_option('cl_no_results_matched', 'No results matched');?> {0}" data-count-selected-text="{0} <?php echo get_option('srh_statuses', 'Statues'); ?>" data-container="body">
		<?php

        echo advmls_get_status_list();

		?>
	</select><!-- selectpicker -->
</div><!-- form-group -->