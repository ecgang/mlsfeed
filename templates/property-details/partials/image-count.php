<?php 
global $post;
$images_count = $this->getDataDetails('photos');
$total_images = count($images_count);
 ?>
<div class="property-image-count visible-on-mobile"><i class="advmls-icon icon-picture-sun"></i> <?php echo esc_attr($total_images); ?></div>