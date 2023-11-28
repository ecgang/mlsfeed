<div class="form-group">
	<select name="country[]" data-target="advmlsSecondList" data-size="5" class="advmlsSelectFilter advmlsCountryFilter advmlsFirstList selectpicker <?php advmls_ajax_search(); ?> advmls-country-js form-control bs-select-hidden" title="<?php echo advmls_option('srh_countries', 'All Countries')?>" data-none-results-text="<?php echo advmls_option('cl_no_results_matched', 'No results matched');?> {0}" data-live-search="false" data-container="body">
		<?php
        $country = isset($_GET['country']) ? $_GET['country'] : array();
        
        echo '<option value="">'.advmls_option('srh_countries', 'All Countries').'</option>';

        advmls_get_search_taxonomies('property_country', $country );

		?>
	</select><!-- selectpicker -->
</div><!-- form-group -->