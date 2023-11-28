<?php global $property; ?>
<div class="item-listing-wrap hz-item-gallery-js card">
	<div class="item-wrap item-wrap-v2 item-wrap-no-frame h-100">
		<div class="d-flex align-items-center h-100">
			<div class="item-header">
				<?php include($pathTemplate.'listing/partials/item-featured-label.php'); ?>
				<?php include($pathTemplate.'listing/partials/item-labels.php'); ?>
				<?php include($pathTemplate.'listing/partials/item-price.php'); ?>
				<?php include($pathTemplate.'listing/partials/item-tools.php'); ?>
				<?php include($pathTemplate.'listing/partials/item-image.php'); ?>
				<div class="preview_loader"></div>
			</div><!-- item-header -->	
			<div class="item-body flex-grow-1">
				<?php include($pathTemplate.'listing/partials/item-labels.php'); ?>
				<?php include($pathTemplate.'listing/partials/item-title.php'); ?>
				<?php include($pathTemplate.'listing/partials/item-price.php'); ?>
				<?php include($pathTemplate.'listing/partials/item-address.php'); ?>
				<?php include($pathTemplate.'listing/partials/item-features-v1.php'); ?>
			</div><!-- item-body -->

		</div><!-- d-flex -->
		
	</div><!-- item-wrap -->
</div><!-- item-listing-wrap -->