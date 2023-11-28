<?php
$images = $this->getDataDetails('photos');

if( !empty($images) ) { ?>
<div class="property-top-wrap">
	<div class="property-banner">
		<div class="container hidden-on-mobile">
			<?php #include_once($pathTemplate.'property-details/partials/banner-nav.php'); ?>
		</div><!-- container -->
		<div class="tab-content" id="pills-tabContent">
			<?php include_once($pathTemplate.'property-details/partials/media-tabs.php'); ?>
		</div><!-- tab-content -->
	</div><!-- property-banner -->
</div><!-- property-top-wrap -->
<?php } ?>