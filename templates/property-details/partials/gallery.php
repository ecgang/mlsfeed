<?php
$size = 'advmls-gallery';
$properties_images = $this->getDataDetails('photos');

$url_photo = $this->getDataDetails('url_photo');
$no_photo = $this->getDataDetails('no_photo');
$gallery_caption = 0; 

if( !empty($properties_images) && count($properties_images)) {
?>
<div class="top-gallery-section">
    <div id="property-gallery-js" class="listing-slider cS-hidden">
        <?php
        $i = 0;
        foreach( $properties_images as $image_id => $prop_image ) { $i++;
            $output = '';
            $thumb = $prop_image;

            $output .= '<div data-thumb="'.esc_url( $url_photo.'/thumb/'.$thumb->image ).'">';
                    $output .= '<a rel="gallery-1" data-slider-no="'.esc_attr($i).'" href="#" class="advmls-trigger-popup-slider-js swipebox" data-toggle="modal" data-target="#property-lightbox">
                        <img class="img-fluid" src="'.esc_url( $url_photo.'/'.$thumb->image ).'" alt="" title="">
                    </a>';

            if( !empty($prop_image_meta['caption']) && $gallery_caption != 0 ) {
               $output .= '<span class="hz-image-caption">'.esc_attr($prop_image_meta['caption']).'</span>';
            }

            $output .= '</div>';

            echo $output;   
        }
        ?>

    </div>
</div><!-- top-gallery-section -->
<?php } else { ?>
<div class="top-gallery-section">
    <img src="<?php echo $no_photo; ?>" alt="No photo">
</div>
<?php } ?>