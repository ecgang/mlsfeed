<?php

class mlsGoogleMapsWidget extends WP_Widget {

	public $addressDefault = '';

	function __construct() {

	 $widget_options = array (
	  'classname' => 'mlsGoogleMapsWidget',
	  'description' => 'MLS: Google Maps Show Office Address.'
	 );

	 parent::__construct( 'mlsGoogleMapsWidget', 'MLS: Google Maps Show Office Address.', $widget_options );

	 $default = "";
	 $company = advmls_getCompanyDetails();
	 if (isset($company->company_name)) {
	 	$default = $company->company_name.', '.$company->city_name.', '.$company->state_name.', '.$company->country_name;
	 }
	 $this->addressDefault = $default;
	}
	
	function form( $instance ) {

		/* Default widget settings. */
		$defaults = array(
			'adv_map_title' => '',
			'adv_map_address' => $this->addressDefault,
			'adv_map_zoom' => '12',
			'adv_map_height' => '300'

		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'adv_map_title'); ?>">Title:</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'adv_map_title' ); ?>" name="<?php echo $this->get_field_name( 'adv_map_title' ); ?>" value="<?php echo esc_attr( $instance['adv_map_title'] ); ?>" />
		</p>

		<p>
			<label for="addressmap">Address</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'adv_map_address' ); ?>" name="<?php echo $this->get_field_name( 'adv_map_address' ); ?>" value="<?php echo esc_attr( $instance['adv_map_address'] ); ?>" placeholder="<?php echo $this->addressDefault ?>"/>
		</p>

		<p>
			<label for="sliderzoom"> Zoom</label>
			<div class="slidecontainer">
  				<input type="range" min="1" max="20" value="<?php echo absint($instance['adv_map_zoom']) ?>" class="slider" id="sliderzoom" name="<?php echo $this->get_field_name( 'adv_map_zoom' ); ?>">
			</div>
		</p>	
		<p>
			<label for="Heightmap">Height</label>
			<input class="widefat" type="range" min="1" max="1000" id="<?php echo $this->get_field_id( 'adv_map_height' ); ?>" name="<?php echo $this->get_field_name( 'adv_map_height' ); ?>" value="<?php echo esc_attr( $instance['adv_map_height'] ); ?>" />
		</p>
		<?php

	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['adv_map_title'] = isset($new_instance['adv_map_title']) ? strip_tags($new_instance['adv_map_title']) : '';
		$instance['adv_map_address'] = isset($new_instance['adv_map_address']) ? strip_tags($new_instance['adv_map_address']) : $this->addressDefault;
		$instance['adv_map_zoom'] = isset($new_instance['adv_map_zoom']) ? strip_tags($new_instance['adv_map_zoom']) : 12;
		$instance['adv_map_height'] = isset($new_instance['adv_map_height']) ? strip_tags($new_instance['adv_map_height']) : 300;
		return $instance;

	}

	function widget( $args, $instance ) {

	$title = isset($instance['adv_map_title']) ? strip_tags($instance['adv_map_title']) : '';
	$address = !empty($instance['adv_map_address']) ? strip_tags($instance['adv_map_address']) : $this->addressDefault;
	$zoom = isset($instance['adv_map_zoom']) ? strip_tags($instance['adv_map_zoom']) : 12;
	$height = isset($instance['adv_map_height']) ? strip_tags($instance['adv_map_height']) : 300;

		$params = [
			rawurlencode( $address ),
			absint( $zoom ),
		];

		$api_key = esc_html( get_option( 'elementor_google_maps_api_key' ) );

		if ( $api_key ) {
			$params[] = $api_key;

			$url = 'https://www.google.com/maps/embed/v1/place?key=%3$s&q=%1$s&amp;zoom=%2$d';
		} else {
			$url = 'https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;output=embed&amp;iwloc=near';
		}
		#echo esc_url( vsprintf( $url, $params ) );
		?>
		<style>
			.advmls-elementor-custom-embed iframe {
				height: <?php echo $height.'px'; ?> !important;
			}						
		</style>

		<div class="advmls-elementor-custom-embed">
			<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
					src="<?php echo esc_url( vsprintf( $url, $params ) ); ?>"
					title="<?php echo esc_attr( $address ); ?>"
					aria-label="<?php echo esc_attr( $address ); ?>"
			></iframe>
		</div>

		<?php

	}
}
