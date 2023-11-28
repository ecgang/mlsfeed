
<?php $state = isset($_GET['states']) ? $_GET['states'] : ''; ?>
<div class="form-group">
	<select name="states[]" data-target="advmlsThirdList" data-size="5" class="advmlsSelectFilter advmlsStateFilter advmlsSecondList selectpicker advmls-state-js form-control bs-select-hidden" title="<?php echo get_option('srh_states', 'All States'); ?>" data-none-results-text="<?php echo get_option('cl_no_results_matched', 'No results matched');?> {0}" data-live-search="true" data-container="body">
		<option value="">All</option>
		<?php
		echo advmls_getListStates($state);

		?>
	</select><!-- selectpicker -->
</div><!-- form-group -->