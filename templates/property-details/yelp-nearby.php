<?php
global $post;
$hide_yelp = advmls_option('advmls_yelp');

if( $hide_yelp ) { ?>

<div class="property-nearby-wrap property-section-wrap" id="property-nearby-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap d-flex justify-content-between align-items-center">
			<h2><?php echo advmls_option('sps_nearby', "What's Nearby?"); ?></h2>
			<div class="small-text grey nearby-logo"><?php echo esc_html__("Powered by", "advmls"); ?> <i class="advmls-icon icon-social-media-yelp"></i> <strong><?php echo esc_html__("Yelp", "advmls"); ?></strong></div>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">

			<?php get_template_part('property-details/partials/yelp'); ?>

		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-walkscore-wrap -->
<?php } ?>