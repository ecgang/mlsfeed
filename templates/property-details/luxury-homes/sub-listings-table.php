<?php
$multi_units  = advmls_get_listing_data('multi_units');

if (!empty($multi_units)) {
?>
<div class="fw-property-sub-listings-wrap fw-property-section-wrap" id="property-sub-listings-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap">
			<h2><?php echo advmls_option('sps_sub_listings', 'Sub Listings'); ?></h2>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">
			<table class="sub-listings-table table-lined responsive-table">
				<thead>
					<tr>
						<th><?php esc_html_e('Title', 'advmls'); ?></th>
                        <th><?php esc_html_e('Property Type', 'advmls'); ?></th>
                        <th><?php esc_html_e('Price', 'advmls'); ?></th>
                        <th><?php esc_html_e('Beds', 'advmls'); ?></th>
                        <th><?php esc_html_e('Baths', 'advmls'); ?></th>
                        <th><?php esc_html_e('Property Size', 'advmls'); ?></th>
                        <th><?php esc_html_e('Availability Date', 'advmls'); ?></th>
					</tr>
				</thead>
				<tbody>

					<?php 
					$mu_price_postfix = '';
					foreach( $multi_units as $mu ):

                        if( !empty( $mu['fave_mu_price_postfix'] ) ) {
                            $mu_price_postfix = ' / '.$mu['fave_mu_price_postfix'];
                        }
                        ?>
						<tr>
							<td data-label="<?php esc_html_e('Title', 'advmls'); ?>">
								<strong><?php echo esc_attr( $mu['fave_mu_title'] ); ?></strong>
							</td>
							<td data-label="<?php esc_html_e('Property Type', 'advmls'); ?>"><?php echo esc_attr( $mu['fave_mu_type'] ); ?></td>
							<td data-label="<?php esc_html_e('Price', 'advmls'); ?>">
								<strong><?php echo advmls_get_property_price( $mu['fave_mu_price'] ).$mu_price_postfix; ?></strong>
							</td>
							<td data-label="<?php esc_html_e('Beds', 'advmls'); ?>"><?php echo esc_attr( $mu['fave_mu_beds'] ); ?> </td>
							<td data-label="<?php esc_html_e('Baths', 'advmls'); ?>"><?php echo esc_attr( $mu['fave_mu_baths'] ); ?> </td>
							<td data-label="<?php esc_html_e('Property Size', 'advmls'); ?>"><?php echo advmls_get_area_size($mu['fave_mu_size']).' '.advmls_get_size_unit( $mu['fave_mu_size_postfix'] ); ?></td>
							<td data-label="<?php esc_html_e('Availability Date', 'advmls'); ?>"><?php echo esc_attr( $mu['fave_mu_availability_date'] ); ?></td>
						</tr>
					<?php endforeach; ?>
					
				</tbody>
			</table>
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-address-wrap -->
<?php } ?>