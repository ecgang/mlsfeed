<?php 
$keyword_field = get_option('keyword_field', 'prop_address');
if( $keyword_field == 'prop_title' ) {
    $keyword_placeholder = get_option('advmls_keyword', 'Enter Keyword...');

} else if( $keyword_field == 'prop_city_state_county' ) {
    $keyword_placeholder = get_option('advmls_csa', 'Search City, State or Area');

} else if( $keyword_field == 'prop_address' ) {
    $keyword_placeholder = get_option('advmls_address', 'Enter an address, town, street, zip or property ID');

} else {
    $keyword_placeholder = get_option('advmls_keyword', 'Enter Keyword...');
}

$keyword = isset ( $_GET['keyword'] ) ? $_GET['keyword'] : ''; ?>
<div class="form-group">
	<div class="search-icon">
		<input name="keyword" type="text" data-type="banner" class="advmls-keyword-autocomplete form-control" value="<?php echo esc_attr($keyword); ?>" placeholder="<?php echo esc_attr($keyword_placeholder); ?>">
	</div><!-- search-icon -->
</div><!-- form-group -->