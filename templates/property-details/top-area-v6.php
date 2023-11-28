<?php
$listing_photos = $this->getDataDetails('photos');
$url_photo = $this->getDataDetails('url_photo');
$i = 0;
$total_photos = count($listing_photos);
?>
<div class="property-top-wrap">
    <div class="property-banner">
		<div class="visible-on-mobile">
			<div class="tab-content" id="pills-tabContent">
				<?php include_once($pathTemplate.'property-details/partials/media-tabs.php'); ?>
			</div><!-- tab-content -->
		</div><!-- visible-on-mobile -->

		<div class="container hidden-on-mobile">
			<div class="row">
				
				<?php
				if(!empty($listing_photos)) {
					foreach( $listing_photos as $photo ) { $i++; 
					
						if($i == 1) {
						?>
						<div class="col-md-8">
							<a href="#" data-slider-no="<?php echo esc_attr($i); ?>" class="advmls-trigger-popup-slider-js img-wrap-1" data-toggle="modal" data-target="#property-lightbox">
								<img class="img-fluid" src="<?php echo esc_url($url_photo.'/'.$photo->image); ?>" alt="">
							</a>
						</div><!-- col-md-8 -->
						<?php } elseif($i == 2 || $i == 3) { ?>

						<?php if($i == 2) { ?>
						<div class="col-md-4">
						<?php } ?>
							<a href="#" data-slider-no="<?php echo esc_attr($i); ?>" data-toggle="modal" data-target="#property-lightbox" class="advmls-trigger-popup-slider-js swipebox img-wrap-<?php echo esc_attr($i); ?>">
								<?php if($total_photos > 3 && $i == 3) { ?>
								<div class="img-wrap-3-text"><?php echo $total_photos-3; ?> <?php echo esc_html__('More', 'advmls'); ?></div>
								<?php } ?>

								<img class="img-fluid" src="<?php echo esc_url($url_photo.'/'.$photo->image); ?>" alt="">
							</a>
						<?php if( ($i == 3 && $total_photos == 3) || ( $i == 2 && $total_photos == 2 ) || ( $i == 1 && $total_photos == 1 ) || $i == 3 ) { ?>
						</div><!-- col-md-4 -->
						<?php } ?>
						<?php } else { ?>
							<a href="#" class="advmls-trigger-popup-slider-js img-wrap-1 gallery-hidden">
								<img class="img-fluid" src="<?php echo esc_url($url_photo.'/'.$photo->image); ?>" alt="">
							</a>
						<?php
						}
					}
				}?>
			
				<div class="col-md-12">
					<div class="block-wrap">
						<div class="d-flex property-overview-data">
							<?php include_once($pathTemplate.'property-details/partials/overview-data.php'); ?>
						</div><!-- d-flex -->
					</div><!-- block-wrap -->
				</div><!-- col-md-12 -->
			</div><!-- row -->
		</div><!-- hidden-on-mobile -->
	</div><!-- property-banner -->
</div><!-- property-top-wrap -->