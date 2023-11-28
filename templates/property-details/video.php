<?php
$prop_video_img = '';
$prop_video_url = json_decode($this->getDataDetails('pro_video'));
$pro_own = json_decode($this->getDataDetails('pro_own'));

$prop_video_url = $prop_video_url[0];

if( !empty( $prop_video_url ) and (int)$pro_own > 0) {

?>
<div class="property-video-wrap property-section-wrap" id="property-video-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap d-flex justify-content-between align-items-center">
			<h2><?php echo 'Video'; ?></h2>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">
			<div class="block-video-wrap">
				<?php $embed_code = wp_oembed_get($prop_video_url); echo $embed_code; ?>
			</div>
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-video-wrap -->
<?php } ?>