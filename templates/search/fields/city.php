<div class="form-group">
	<select name="cities[]" data-target="advmlsFourthList" data-size="5" class="advmlsCityFilter advmlsThirdList selectpicker advmls-city-js form-control bs-select-hidden" title="<?php echo get_option('srh_cities', 'All Cities'); ?>" data-selected-text-format="count > 1" data-live-search="true" data-actions-box="true" data-none-results-text="<?php echo get_option('cl_no_results_matched', 'No results matched');?> {0}" data-container="body">
		
		<?php
	        $selected = isset($_GET['cities'][0]) ? $_GET['cities'][0] : 0;
			if ($selected <= 0 ){

				$selected = get_option('advmls_default_city',0);
	        }
			echo advmls_get_cities_list((int)$selected);
		?>
	</select><!-- selectpicker -->
</div><!-- form-group -->
