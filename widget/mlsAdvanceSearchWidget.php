<?php
// Creating the widget 
class mlsAdvanceSearchWidget extends WP_Widget {
  
function __construct() {
	parent::__construct(
	// Base ID of your widget
	'mlsAdvanceSearchWidget', 
	// Widget name will appear in UI
	__('MLS: Advance Search', 'wpb_widget_domain'), 
	// Widget description
	array( 'description' => __( 'MLS: Advance Search', 'wpb_widget_domain' ), ) 
	);
}
  
// Creating widget front-end
  
public function widget( $args, $instance ) {
	global $advmls_type_search;

	$title = isset($instance['title']) ? apply_filters( 'widget_title', $instance['title'] ) : '';
	$advmls_type_search = isset($instance['advmls_type_search']) ? $instance['advmls_type_search'] : 'v1';
	  
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) )
	echo $args['before_title'] . $title . $args['after_title'];
	
	$pathTemplate = mlsConstants::ADVANTAGEMLSTPLPATH;
	include_once($pathTemplate.'search/main.php');

}
          
// Widget Backend 
public function form( $instance ) {
	
	$title =  isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
	$type_search = isset( $instance['advmls_type_search']) ? $instance['advmls_type_search'] : 'v1';

	// Widget admin form
	?>
	<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<p>
		<label for="TypeSearch">Type Search</label>
		<select name="<?php echo $this->get_field_name( 'advmls_type_search' ); ?>" id="advmls_type_search">
			<option value="v1" <?php echo ($type_search == 'v1' ? 'selected="selected"': ''); ?>>Advance Search</option>
			<option value="v2" <?php echo ($type_search == 'v2' ? 'selected="selected"': ''); ?>>Quick Search</option>
			<option value="v3" <?php echo ($type_search == 'v3' ? 'selected="selected"': ''); ?>>Quick Search Vertical</option>
		</select>
	</p>
<?php 
}
      
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	$instance['advmls_type_search'] = ( ! empty( $new_instance['advmls_type_search'] ) ) ? strip_tags( $new_instance['advmls_type_search'] ) : 'v1';
	return $instance;
}
 
}

?>