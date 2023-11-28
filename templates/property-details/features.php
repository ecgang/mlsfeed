<?php
global $features;
$features = $this->getDataDetails('features');

if (!empty($features)):
?>
<div class="property-features-wrap property-section-wrap" id="property-features-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap d-flex justify-content-between align-items-center">
			<h2><?php echo get_option('sps_features', 'Features'); ?></h2>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">
			<?php include_once($pathTemplate.'property-details/partials/features.php'); ?> 
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-features-wrap -->
<?php endif; ?>