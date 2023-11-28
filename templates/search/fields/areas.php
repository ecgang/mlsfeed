<?php $region = isset($_GET['egion']) ? $_GET['egion'] : ''; ?>

<div class="form-group">
	<select name="egion[]" data-size="5" class="advmlsSelectFilter advmlsFourthList selectpicker form-control bs-select-hidden" title="<?php echo get_option('srh_areas', 'All Areas'); ?>" data-selected-text-format="count > 1" data-live-search="true" data-actions-box="false" data-select-all-text="<?php echo get_option('cl_select_all', 'Select All'); ?>" data-deselect-all-text="<?php echo get_option('cl_deselect_all', 'Deselect All'); ?>" data-none-results-text="<?php echo get_option('cl_no_results_matched', 'No results matched');?> {0}" data-count-selected-text="{0} <?php echo get_option('srh_areass', 'Areas'); ?>">
		<option value="">All</option>
		<?php
			echo advmls_getListRegions($region);
		?>

	</select><!-- selectpicker -->
</div><!-- form-group -->