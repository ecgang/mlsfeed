<?php 

$sortby = isset ( $_GET['s_sort_by'] ) ? esc_attr($_GET['s_sort_by']) : '';
?>
<div class="sort-by">
	<div class="form-group">
		<select id="search_sort_by" class="selectpicker form-control bs-select-hidden" title="<?php esc_html_e( 'Default Order', 'advmls' ); ?>" data-live-search="false" data-dropdown-align-right="auto" name="s_sort_by">
			<option value=""><?php esc_html_e( 'Order by Any', 'advmls' ); ?></option>
			<option <?php selected($sortby, 'a_price'); ?> value="a_price"><?php esc_html_e('Price - Low to High', 'advmls'); ?></option>
            <option <?php selected($sortby, 'd_price'); ?> value="d_price"><?php esc_html_e('Price - High to Low', 'advmls'); ?></option>
		</select><!-- selectpicker -->
	</div><!-- d-flex -->
</div><!-- sort-by -->