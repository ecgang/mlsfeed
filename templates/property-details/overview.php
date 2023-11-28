<?php
$prop_id = $this->getDataDetails('id');
?>
<div class="property-overview-wrap property-section-wrap" id="property-overview-wrap">
	<div class="block-wrap">
		
		<div class="block-title-wrap d-flex justify-content-between align-items-center">
			<h2><?php echo 'Overview'; ?></h2>

			<?php if( !empty( $prop_id ) ) { ?>
			<div><strong><?php echo  'Property ID'; ?>:
			</strong> <?php echo $this->getDataDetails('ref'); ?></div>
			<?php } ?>
		</div><!-- block-title-wrap -->

		<div class="d-flex property-overview-data">
			<?php include_once($pathTemplate.'property-details/partials/overview-data.php'); ?>
		</div><!-- d-flex -->
	</div><!-- block-wrap -->
</div><!-- property-overview-wrap -->