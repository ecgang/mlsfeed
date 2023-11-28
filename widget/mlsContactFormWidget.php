<?php
// Creating the widget 
class mlsContactFormWidget extends WP_Widget {
  
function __construct() {
	parent::__construct(
	// Base ID of your widget
	'mlsContactFormWidget', 
	// Widget name will appear in UI
	__('MLS: Contact Form', 'wpb_widget_domain'), 
	// Widget description
	array( 'description' => __( 'MLS: Contact Form', 'wpb_widget_domain' ), ) 
	);
}

// Widget Backend 
public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
	}
	else {
		$title = __( '', 'wpb_widget_domain' );
	}

	$view_type = !empty($instance['advmls_form_view_type']) ? $instance['advmls_form_view_type'] : 'rigth';

	// Widget admin form
	?>
	<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'advmls_form_view_type' ); ?>"><?php _e( 'View Type:' ); ?></label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'advmls_form_view_type' ); ?>" name="<?php echo $this->get_field_name( 'advmls_form_view_type' ); ?>" type="text" value="<?php echo esc_attr( $view_type ); ?>">
			<option value="rigth">Rigth</option>
			<option value="bottom">Bottom</option>
			<option value="footer">Footer</option>
		</select>
	</p>
<?php 
}

// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	$instance['advmls_form_view_type'] = !empty($new_instance['advmls_form_view_type']) ? $new_instance['advmls_form_view_type'] : 'rigth';

	return $instance;
}

// Creating widget front-end
  
public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	$view_type = $instance['advmls_form_view_type']; // rigth, bottom
	  
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	
	$pathTemplate = mlsConstants::ADVANTAGEMLSTPLPATH;
	$wioListing = true;

	/*$queryUrlArr = array(
	    "token" => mlsUtility::getInstance()->getActivationToken(),
	    "source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl())
	);

	$queryUrl = http_build_query($queryUrlArr);
	$resultAgents = wp_remote_get(getUrlMlsMember().'api/getagentsfromcompany?'.$queryUrl,$args);
	$agents = json_decode($resultAgents['body']);*/


    global $agent;
    ?>
		<div class="advmls_section_title_wrap section-title-module text-center">
			<?php if ( ! empty( $title ) ) { ?>
				<h3 class="advmls_section_title"><?php echo $args['before_title'] . $title . $args['after_title']; ?></h3>
			<?php } ?>
		</div>
    <?php

        if ($view_type == 'bottom') {
			include($pathTemplate.'property-details/agent-form-bottom.php' ); 
 
        } elseif ($view_type == 'rigth') { 
			 include($pathTemplate.'property-details/agent-form.php' );

        } elseif ($view_type == 'footer') {
			 include($pathTemplate.'property-details/agent-form-footer.php' );

        }

	}
 
}

?>