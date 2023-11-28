<?php
$google_map_address = $this->getDataDetails('lat_add').','.$this->getDataDetails('long_add');
$google_map_address_url = "http://maps.google.com/?q=".$google_map_address;
?>
<div class="property-address-wrap property-section-wrap" id="property-address-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap d-flex justify-content-between align-items-center">
			<h2><?php echo  'Address'; ?></h2>

			<?php if( !empty($google_map_address) ) { ?>
			<a class="btn btn-primary btn-slim" href="<?php echo esc_url($google_map_address_url); ?>" target="_blank"><i class="advmls-icon icon-maps mr-1"></i> <?php echo  'Open on Google Maps' ; ?></a>
			<?php } ?>

		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">
			<ul class="list-2-cols list-unstyled">
				<?php include_once($pathTemplate.'property-details/partials/address-data.php'); ?>
			</ul>	
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-address-wrap -->