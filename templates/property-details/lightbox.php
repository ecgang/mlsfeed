<?php
global $post;
$size = 'full';

$properties_images = $this->getDataDetails('photos');
$url_photo = $this->getDataDetails('url_photo');

$userID      =   get_current_user_id();
$fav_option = 'advmls_favorites-'.$userID;
$fav_option = get_option( $fav_option );

$lightbox_agent_cotnact = true;


$lightbox_class = "";
if(!$lightbox_agent_cotnact) {
	$lightbox_class = "lightbox-gallery-full-wrap";
}

$icon = $key = '';
if( !empty($fav_option) ) {
    $key = array_search($post->ID, $fav_option);
}
if( $key != false || $key != '' ) {
    $icon = 'text-danger';
}
?>
<div class="property-lightbox">
	<div class="modal fade" id="property-lightbox" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="d-flex align-items-center">
						<div class="lightbox-title flex-grow-1">
						</div><!-- lightbox-title  -->
						<div class="lightbox-tools">
							<ul class="list-inline">
								<li class="list-inline-item btn-share">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fas fa-share-alt mr-2"></i> <span><?php esc_html_e('Share', 'advmls'); ?></span></a>
									<div class="dropdown-menu dropdown-menu-right item-tool-dropdown-menu">
										<?php include($pathTemplate.'property-details/partials/share.php'); ?>
									</div>
								</li>
								<li class="list-inline-item btn-email">
									<a href="#"><i class="advmls-icon icon-envelope"></i></a>
								</li>
							</ul>
						</div><!-- lightbox-tools -->
					</div><!-- d-flex -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div><!-- modal-header -->

				<div class="modal-body clearfix">
					<div class="lightbox-gallery-wrap <?php echo esc_attr($lightbox_class); ?>">
						
						<?php 
						if($lightbox_agent_cotnact) { ?>
						<a class="btn-expand">
							<i class="advmls-icon icon-expand-3"></i>
						</a>
						<?php } ?>
						
						<?php  if( !empty($properties_images) && count($properties_images)) { ?>
						<div class="lightbox-gallery">
						    <div id="lightbox-slider-js" class="lightbox-slider">
						        
						        <?php
						        foreach( $properties_images as $prop_image_id => $prop_image_meta ) {
						       		$output = '';
						            $output .= '<div>';
								        $output .= '<img class="img-fluid" src="'.esc_url($url_photo.'/'. $prop_image_meta->image ).'" alt="" title="">';

								        if( !empty($prop_image_meta->image_desc) ) {
									        $output .= '<span class="hz-image-caption">'.esc_attr($prop_image_meta->image_desc).'</span>';
									    }

								    $output .= '</div>';

								    echo $output;
						        }
						        ?>
						        
						    </div>
						</div><!-- lightbox-gallery -->
						<?php } ?>

					</div><!-- lightbox-gallery-wrap -->

					<?php 
					if($lightbox_agent_cotnact) { ?>
					<div class="lightbox-form-wrap">
						<?php include($pathTemplate.'property-details/agent-form.php'); ?>
					</div><!-- lightbox-form-wrap -->
					<?php } ?>
				</div><!-- modal-body -->
				<div class="modal-footer">
					
				</div><!-- modal-footer -->
			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div><!-- modal -->
</div><!-- property-lightbox -->

