<?php
$properties_images = $this->getDataDetails('photos');

$url_photo = $this->getDataDetails('url_photo');
$no_photo = $this->getDataDetails('no_photo');
$gallery_caption = advmls_option('gallery_caption', 0); 

if( !empty($properties_images) && count($properties_images)) {
?>
<div class="top-gallery-section top-gallery-variable-width-section">
	<div class="listing-slider-variable-width advmls-all-slider-wrap">
		<?php
		$i = 0;
        foreach( $properties_images as $image_id => $prop_image ) { $i++;
  			$thumb = $prop_image;
			echo '<div>
					<a rel="gallery-1" href="#" data-slider-no="'.esc_attr($i).'" class="advmls-trigger-popup-slider-js swipebox" data-toggle="modal" data-target="#property-lightbox">
						<img class="img-responsive" data-lazy="'.esc_attr( $url_photo.'/'.$thumb->image ).'" src="'.esc_attr( $url_photo.'/'.$thumb->image ).'" alt="" title="">
					</a>';

					
		               echo '<span class="hz-image-caption">'.esc_attr('caption').'</span>';
		            

				echo '</div>';

				if($i == 5) {
					$i = 0;
				}
        }
        ?>
	
	</div>
</div><!-- top-gallery-section -->
<?php } ?>