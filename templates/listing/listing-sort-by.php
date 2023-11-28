<?php
global $post;

$sortby = '';
if( isset( $_GET['sortby_list'] ) ) {
    $sortby = $_GET['sortby_list'];
}
$sort_id = 'sort_properties';

?>
<div class="sort-by">
	<div class="d-flex align-items-center">
		<div class="sort-by-title">
			<?php esc_html_e( 'Sort by:', 'advmls' ); ?>
		</div><!-- sort-by-title -->  
		<select id="<?php echo esc_attr($sort_id); ?>" class="selectpicker form-control bs-select-hidden" title="<?php esc_html_e( 'Default Order', 'advmls' ); ?>" data-live-search="false" data-dropdown-align-right="auto">
			<option value=""><?php esc_html_e( 'Default Order', 'advmls' ); ?></option>
			<option <?php selected($sortby, 'a_price'); ?> value="a_price"><?php esc_html_e('Price - Low to High', 'advmls'); ?></option>
            <option <?php selected($sortby, 'd_price'); ?> value="d_price"><?php esc_html_e('Price - High to Low', 'advmls'); ?></option>
             <option <?php selected($sortby, 'a_date'); ?> value="a_date"><?php esc_html_e('Date - Old to New', 'advmls' ); ?></option>
            <option <?php selected($sortby, 'd_date'); ?> value="d_date"><?php esc_html_e('Date - New to Old', 'advmls' ); ?></option>
		</select><!-- selectpicker -->
	</div><!-- d-flex -->
</div><!-- sort-by -->