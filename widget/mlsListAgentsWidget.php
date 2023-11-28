<?php
// Creating the widget 
class mlsListAgentsWidget extends WP_Widget {
  
	function __construct() {
		parent::__construct(
		// Base ID of your widget
		'mlsListAgentsWidget', 
		// Widget name will appear in UI
		__('MLS: List Agents', 'wpb_widget_domain'), 
		// Widget description
		array( 'description' => __( 'MLS: List Agents', 'wpb_widget_domain' ), ) 
		);
	}

	// Widget Backend 
	public function form( $instance ) {
		
		$title = isset($instance[ 'title' ]) ? $instance[ 'title' ] : '';
		$description = isset($instance[ 'description' ]) ? $instance[ 'description' ] : '';
		$view_type = !empty($instance['advmls_lagents_view_type']) ? $instance['advmls_lagents_view_type'] : 'grid';
		$view_columns = !empty($instance['advmls_lagents_view_colums']) ? $instance['advmls_lagents_view_colums'] : '3';

		// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'advmls_lagents_view_type' ); ?>"><?php _e( 'View Type:' ); ?></label> 
			<select class="widefat" id="<?php echo $this->get_field_id( 'advmls_lagents_view_type' ); ?>" name="<?php echo $this->get_field_name( 'advmls_lagents_view_type' ); ?>" type="text" value="<?php echo esc_attr( $view_type ); ?>">
				<option value="grid" <?php echo $view_type == 'grid' ? 'selected="selected"' : ''; ?>>Grid</option>
				<option value="carousel" <?php echo $view_type == 'carousel' ? 'selected="selected"' : ''; ?>>Carousel</option>
			</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'advmls_lagents_view_colums' ); ?>"><?php _e( 'View Colums:' ); ?></label> 
			<select class="widefat" id="<?php echo $this->get_field_id( 'advmls_lagents_view_colums' ); ?>" name="<?php echo $this->get_field_name( 'advmls_lagents_view_colums' ); ?>" type="text" value="<?php echo esc_attr( $view_columns ); ?>">
				<option value="1" <?php echo $view_columns == 1 ? 'selected="selected"' : ''; ?>>1</option>
				<option value="2" <?php echo $view_columns == 2 ? 'selected="selected"' : ''; ?>>2</option>
				<option value="3" <?php echo $view_columns == 3 ? 'selected="selected"' : ''; ?>>3</option>
				<option value="4" <?php echo $view_columns == 4 ? 'selected="selected"' : ''; ?>>4</option>
			</select>
		</p>
	<?php 
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['advmls_lagents_view_type'] = !empty($new_instance['advmls_lagents_view_type']) ? $new_instance['advmls_lagents_view_type'] : 'grid';
		$instance['advmls_lagents_view_colums'] = !empty($new_instance['advmls_lagents_view_colums']) ? $new_instance['advmls_lagents_view_colums'] : '3';

		return $instance;
	}

	// Creating widget front-end
  
	public function widget( $args, $instance ) {
		$title = isset($instance['title']) ? $instance['title'] : '';
		$description = isset($instance['description']) ? $instance['description'] : '';
		$view_type = isset($instance['advmls_lagents_view_type']) ? $instance['advmls_lagents_view_type'] : 'grid'; // grid, Carousel
	    $columns = isset($instance['advmls_lagents_view_colums']) ? $instance['advmls_lagents_view_colums'] : '3'; // 3, 4
		  
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		
		$pathTemplate = mlsConstants::ADVANTAGEMLSTPLPATH;

		$module_class = 'module-'.$columns.'cols';

		$queryUrlArr = array(
		    "token" => mlsUtility::getInstance()->getActivationToken(),
		    "source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl())
		);

		$queryUrl = http_build_query($queryUrlArr);
		$resultAgents = wp_remote_get(getUrlMlsMember().'api/getagentsfromcompany?'.$queryUrl,$args);
		
		if ( !is_wp_error($resultAgents) and isset($resultAgents['body']) ) {
			$agents = json_decode($resultAgents['body']);
		}else{
			return false;
		}
		
		if (!isset($agents->error)) {
		
		    global $agent;
		    ?>
				<div class="advmls_section_title_wrap section-title-module text-center">
					<?php if ( ! empty( $title ) ) { ?>
						<h2 class="advmls_section_title"><?php echo $title; ?></h2>
					<?php } ?>
					<?php if ( ! empty( $description ) ) { ?>
						<p class="advmls_section_subtitle"><?php echo $description; ?> </p>
					<?php } ?>
				</div>
		    <?php
		        if ($view_type == 'grid') { ?>
		            <div class="agent-module <?php echo esc_attr($module_class); ?> clearfix justify-content-start">
		                <?php 
		                if (!empty($agents) and count($agents) > 0): 
		                    foreach ($agents as $key => $agent) {
		                       include($pathTemplate.'agent/agent-item.php');
		                    }
		                endif;
		                ?>
		            </div><!-- agent-module -->
		        <?php 
		        } elseif ($view_type == 'carousel') { ?>
		            <?php $token = wp_generate_password(5, false, false); ?>
		            <script type="text/javascript">
		                jQuery(document).ready(function($){
		                    if($("#agents-carousel-<?php echo esc_attr( $token ); ?>").length > 0){
		                        var owlAgents = $('#agents-carousel-<?php echo esc_attr( $token ); ?>');
		                        
		                        owlAgents.slick({
		                        	autoplay: true,
		                            rtl: 'false',
		                            lazyLoad: 'ondemand',
		                            infinite: true,
		                            speed: 300,
		                            slidesToShow: <?php echo intval($columns); ?>,
		                            arrows: true,
		                            adaptiveHeight: true,
		                            dots: true,
		                            appendArrows: '.agents-module-slider',
		                            prevArrow: $('.agents-prev-js'),
		                            nextArrow: $('.agents-next-js'),
		                            responsive: [{
		                                    breakpoint: 992,
		                                    settings: {
		                                        slidesToShow: 2,
		                                        slidesToScroll: 2
		                                    }
		                                },
		                                {
		                                    breakpoint: 769,
		                                    settings: {
		                                        slidesToShow: 1,
		                                        slidesToScroll: 1
		                                    }
		                                }
		                            ]
		                        });

		                    }
		                });
		            </script>

		            <div class="agents-module agents-module-slider">
		                <div class="property-carousel-buttons-wrap">
		                    <button type="button" class="agents-prev-js slick-prev btn-primary-outlined"><?php esc_html_e('Prev', 'advmls'); ?></button>
		                    <button type="button" class="agents-next-js slick-next btn-primary-outlined"><?php esc_html_e('Next', 'advmls'); ?></button>
		                </div><!-- property-carousel-buttons-wrap -->
		            
		                <div id="agents-carousel-<?php echo esc_attr( $token ); ?>" class="agents-slider-wrap advmls-all-slider-wrap">
		                    <?php 
			                if (count($agents) > 0): 
			                    foreach ($agents as $key => $agent) {
			                       include($pathTemplate.'agent/agent-item.php');
			                    }
			                endif;
		                    ?>
		                </div>
		            </div>

		        <?php 
		        }

	    } else { ?>
	    	<div class="alert alert-warning">
				<p class="text-capitalize">
					<?php echo $agents->error_msg;?>
				</p>
			</div>
	    <?php 
    	}
	}
 
}

?>