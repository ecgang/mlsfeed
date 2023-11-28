<?php
$advmls_walkscore = advmls_option('advmls_walkscore');
$advmls_walkscore_api = advmls_option('advmls_walkscore_api');

if( $advmls_walkscore != 0 && $advmls_walkscore_api != '' ) {
?>
<div class="fw-property-walkscore-wrap fw-property-section-wrap" id="property-walkscore-wrap">
	<div class="block-wrap">
		<div class="block-content-wrap">

			<?php advmls_walkscore($post->ID); ?>

		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- fw-property-walkscore-wrap -->
<?php } ?>