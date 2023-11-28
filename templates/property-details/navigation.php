<?php

$prop_videos_url = json_decode($this->getDataDetails('pro_video'));
$prop_detail_nav = 'yes';

$layout = $layout['enabled'];

if( $prop_detail_nav != 'no' && ( $property_layout == "simple" || $property_layout == 'v2' ) ) {
?>
<div class="property-navigation-wrap">
	<div class="container-fluid">
		<ul class="property-navigation list-unstyled d-flex justify-content-between">
			<li class="property-navigation-item">
				<a class="back-top" href="#main-wrap">
					<i class="advmls-icon icon-arrow-button-circle-up"></i>
				</a>
			</li>
			<?php
            if ($layout): foreach ($layout as $key=>$value) {

                switch($key) {

                    case 'description':
                        
                        echo '<li class="property-navigation-item">
								<a class="target" href="#property-description-wrap"> Description </a>
							</li>';
                        break;


                    case 'address':
                        echo '<li class="property-navigation-item">
								<a class="target" href="#property-address-wrap"> Address </a>
							</li>';
                        break;

                    case 'details':
                        
                        echo '<li class="property-navigation-item">
								<a class="target" href="#property-detail-wrap"> Details </a>
							</li>';
                        break;

                    case 'features':
                        
                        echo '<li class="property-navigation-item">
								<a class="target" href="#property-features-wrap"> Features </a>
							</li>';
                        break;

                    case 'video':
                        if( !empty( $prop_videos_url[0] )) {
                        	echo '<li class="property-navigation-item">
								<a class="target" href="#property-video-wrap"> Video </a>
							</li>';
                        }
                        
                        break;

                }

            }

            endif;
            ?>
			
		</ul>
	</div><!-- container -->
</div><!-- property-navigation-wrap -->
<?php } ?>