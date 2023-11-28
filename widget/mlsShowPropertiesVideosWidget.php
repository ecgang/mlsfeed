<?php
// Creating the widget 
class mlsShowPropertiesVideosWidget extends WP_Widget {
  
	function __construct() {
		parent::__construct(
		// Base ID of your widget
		'mlsShowPropertiesVideosWidget', 
		// Widget name will appear in UI
		__('MLS: Property Videos', 'wpb_widget_domain'), 
		// Widget description
		array( 'description' => __( 'Property Videos', 'wpb_widget_domain' ),
		'icon' => 'eicon-image-box' ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance ) {
		$title = isset($instance['title']) ? apply_filters( 'widget_title', $instance['title'] ) : '';

		$pathTemplate = mlsConstants::ADVANTAGEMLSTPLPATH;
		$sort_by = 'created';
		$order_by = 'desc';

		if (isset($_GET['sortby_list']) and !empty($_GET['sortby_list'])) {
		 	if ($_GET['sortby_list'] == 'a_price') {
		 		$sort_by = 'price';
				$order_by = 'asc';
		 	}elseif ($_GET['sortby_list'] == 'd_price') {
		 		$sort_by = 'price';
				$order_by = 'desc';
		 	}elseif ($_GET['sortby_list'] == 'a_date') {
				$sort_by = 'created';
				$order_by = 'asc';
			}elseif ($_GET['sortby_list'] == 'd_date') {
				$sort_by = 'created';
				$order_by = 'desc';
			}
		}

		$queryUrlArr = array(
		    "token" => mlsUtility::getInstance()->getActivationToken(),
		    "source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl()),
		    "sort_by" => $sort_by,
			"order_by" => $order_by,
		);

		$queryUrl = http_build_query($queryUrlArr);
		$proResult = wp_remote_get(getUrlMlsMember().'api/getpropertiesvideo?'.$queryUrl);
		if (is_wp_error($proResult)) {
			return;
		}
		
		if (isset($proResult['body'])) {
			$proVideos = json_decode($proResult['body']);
			$this->proResult = $proVideos;
			if (count($proVideos) > 0) { ?>

				<div class="listing-tools-wrap">
                    <div class="d-flex justify-content-end mb-1">
                        <?php include_once($pathTemplate.'listing/listing-sort-by.php'); ?>
                    </div><!-- d-flex -->
                </div><!-- listing-tools-wrap -->
				<div class="row">
					<?php foreach ($proVideos as $key => $property) { ?>
						<?php 
						$videos = json_decode($property->pro_video);
						$currentKey = $key;
						foreach ($videos as $key => $video) { 
							$embed_code = wp_oembed_get($video, array("height"=>300));
							$price = mlsUtility::getInstance()->showNumberFormat($property->price);
							$urlProDetail = mlsUrlFactory::getInstance()->getListingDetailUrl(true);
							$category_name = $property->category_name;
							$pro_alias = $property->pro_alias;
							if ($embed_code) { ?>
							<div class="col-md-4 mb-2 item-wrap-v2">
							  <div class="card text-center">
							    <?php echo $embed_code; ?>
							    <div class="card-body">
							      <h5 class="card-title ">
							      	<a href="<?php echo mlsUtility::getInstance()->advmls_esc_url($urlProDetail.$category_name.'/'.$pro_alias); ?>"><?php echo $property->pro_name.' - '. $property->ref ?></a>
							      </h5>
							      <p class="card-text h5"><?php echo $property->currency_code. ' ' . $price ?></p>
							      <div class="item-body flex-grow-1 pb-1 pt-1 pl-0 pr-0 text-center">
							      	<?php include($pathTemplate.'listing/partials/item-features-v1.php'); ?>
							      </div>
							    </div>
							  </div>
							</div>
							<?php }	?>
						<?php }	?>
					<?php } ?> 
				</div>
			<?php } ?> 
		<?php
		}else{
			return false;
		}
	}
	          
	// Widget Backend 
	public function form( $instance ) {
		$title =  isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php

	}
	      
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		return $instance;
	}

	public function getFielProperty($name, $posProperty = 0){
		if (isset($this->proResult[$posProperty]->{$name})) {
			return $this->proResult[$posProperty]->{$name};
		}
		return "";
	}

}

?>