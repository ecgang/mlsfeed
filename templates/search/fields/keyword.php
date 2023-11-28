<?php 
$keyword_field = get_option('keyword_field','prop_address');
if( $keyword_field == 'prop_title' ) {
    $keyword_placeholder = get_option('srh_keyword', 'Enter Keyword...');

} else if( $keyword_field == 'prop_city_state_county' ) {
    $keyword_placeholder = get_option('srh_csa', 'Search City, State or Area');

} else if( $keyword_field == 'prop_address' ) {
    $keyword_placeholder = get_option('srh_address', 'Enter an address, town, street, zip or property ID');

} else {
    $keyword_placeholder = get_option('srh_keyword', 'Enter Keyword...');
}

$keyword_autocomplete = get_option('keyword_autocomplete',0);

$keyword = isset ( $_GET['keyword'] ) ? $_GET['keyword'] : ''; ?>

<?php 

?>

<div class="form-group">
		
	<div class="search-icon">
		<?php if( $keyword_autocomplete == 1 ) { ?>
		<input name="keyword" type="text" class="<?php advmls_ajax_search(); ?> advmls-keyword-autocomplete form-control" value="<?php echo esc_attr($keyword); ?>" placeholder="<?php echo esc_attr($keyword_placeholder); ?>">
		<div id="auto_complete_ajax" class="auto-complete"></div>
		<?php } else { ?>

			<input name="keyword" type="text" class="advmls-keyword form-control" value="<?php echo esc_attr($keyword); ?>" placeholder="<?php echo esc_attr($keyword_placeholder); ?>">

		<?php } ?>
	</div><!-- search-icon -->
</div><!-- form-group -->