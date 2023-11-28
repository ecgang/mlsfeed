<?php
$advmls_walkscore = advmls_option('advmls_walkscore');
$advmls_walkscore_api = advmls_option('advmls_walkscore_api');

if( $advmls_walkscore != 0 && $advmls_walkscore_api != '' ) {
?>
<div class="property-walkscore-wrap property-section-wrap" id="property-walkscore-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap d-flex justify-content-between align-items-center">
			<h2><?php echo advmls_option('sps_walkscore', 'WalkScore'); ?></h2>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">

			<?php advmls_walkscore($post->ID); ?>

		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-walkscore-wrap -->
<?php } ?>