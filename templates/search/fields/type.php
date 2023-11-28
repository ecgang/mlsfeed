<div class="form-group">
	<select name="category_ids[]" data-size="5" class="selectpicker form-control bs-select-hidden" title="<?php echo get_option('srh_type', 'Type'); ?>" data-live-search="true" data-selected-text-format="count > 1" data-actions-box="true" data-select-all-text="<?php echo get_option('cl_select_all', 'Select All'); ?>" data-deselect-all-text="<?php echo get_option('cl_deselect_all', 'Deselect All'); ?>" data-count-selected-text="{0} <?php echo get_option('srh_types', 'Types'); ?>" data-none-results-text="<?php echo get_option('cl_no_results_matched', 'No results matched');?> {0}" data-container="body">

		<?php
			$selected = isset($_GET['category_ids'][0]) ? $_GET['category_ids'][0] : 0;
			if ($selected <= 0 ){

				$selected = get_option('advmls_status_pro_type',0);
	        }
			echo advmls_get_type_list((int)$selected);
		?>
	</select><!-- selectpicker -->
</div><!-- form-group -->