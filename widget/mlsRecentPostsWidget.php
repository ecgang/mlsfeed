<?php
class mlsRecentPostsWidget extends WP_Widget {

	/**
	 * Sets up a new Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'mlsRecentPostsWidget',
			'description'                 => __( 'MLS: Post list with image.' ),
			'customize_selective_refresh' => true,
			'show_instance_in_rest'       => true,
		);
		parent::__construct( 'mls-recent-posts', __( 'MLS: Post list with image.' ), $widget_ops );
		$this->alt_option_name = 'mlsRecentPostsWidget';
	}

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$category_ids 	  = ( ! empty( $instance[ 'category_ids' ] ) ) ? array_map( 'absint', $instance[ 'category_ids' ] ) : array( 0 );

		$default_title = __( 'Recent Posts' );
		$title         = ( ! empty( $instance['title'] ) ) ? $instance['title'] : $default_title;

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title 			= apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number 		= ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		$show_date 		= isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		$orderby        = ( ! empty( $instance[ 'orderby' ] ) ) ? $instance[ 'orderby' ] : 'date';
		$viewtype       = ( ! empty( $instance[ 'viewtype' ] ) ) ? $instance[ 'viewtype' ] : 'grid';


		$query_args = array(
			'posts_per_page' => $number,
			'no_found_rows'  => true,
			'post_status'    => 'publish',
            'orderby'        => $orderby
        );

		// if 'all categories' was selected ignore other selections of categories
		if ( in_array( 0, $category_ids ) ) {
			$category_ids = array(0);
		}
        // add categories param only if 'all categories' was not selected
		if ( ! in_array( 0, $category_ids ) ) {
			$query_args[ 'category__in' ] = $category_ids;
		}
		$r = new WP_Query(
			apply_filters( 'query_widget_posts_args', $query_args )
		);

		if ( ! $r->have_posts() ) {
			return;
		}
		?>

		<?php echo $args['before_widget']; ?>

		<?php

		$format = current_theme_supports( 'html5', 'navigation-widgets' ) ? 'html5' : 'xhtml';

		/** This filter is documented in wp-includes/widgets/class-wp-nav-menu-widget.php */
		$format = apply_filters( 'navigation_widgets_format', $format );
		$aria_label = '';
		if ( 'html5' === $format ) {
			// The title may be filtered: Strip out HTML and make sure the aria-label is never empty.
			$title      = trim( strip_tags( $title ) );
			$aria_label = $title ? $title : $default_title;
		}

		if ($viewtype == 'grid') { ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}?>
		<?php echo '<nav role="navigation" aria-label="' . esc_attr( $aria_label ) . '">'; ?>
		<div class="row">
			<?php foreach ( $r->posts as $recent_post ) : ?>
				<?php
				#var_dump($recent_post);
				$post_title   = get_the_title( $recent_post->ID );
				$title        = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
				$aria_current = '';

				if ( get_queried_object_id() === $recent_post->ID ) {
					$aria_current = ' aria-current="page"';
				}

				$metaPost = get_post_meta( $recent_post->ID );
				$img = "";
				if (is_array($metaPost)) {
					if (isset($metaPost['_thumbnail_id'][0]) and $metaPost['_thumbnail_id'][0] > 0) {
						$img_url = wp_get_attachment_image_src( $metaPost['_thumbnail_id'][0], 'full', true );
						$img = '<img src="'. $img_url[0]. '" alt="'.$post_title .'">';
					}
				}

				?>
				<div class="col-md-3 mb-2 d-flex align-items-stretch">
					<div class="card" style="width: 18rem;">
						<?php echo $img; ?>
					  <div class="card-body">
					    <h5 class="card-title"><?php echo $title; ?></h5>
					    <p class="card-text"><?php 
					    $excerpt = strip_shortcodes( get_the_content( '', false , $recent_post->ID  ) );
						$excerpt = apply_filters( 'the_post', $excerpt );
						$excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
						echo $excerpt = wp_trim_words( $excerpt, 5, '...' );

					     ?></p>
						<?php if ( $show_date ) : ?>
							<p class="card-text"><?php echo get_the_date( '', $recent_post->ID ); ?></p>
						<?php endif; ?>
						<a href="<?php the_permalink( $recent_post->ID ); ?>"<?php echo $aria_current; ?> class="submit" target="_blank">Read More!</a>
					  </div>
					</div>
				</div>

			<?php endforeach; ?>
		</div>
		<?php  } elseif ($viewtype == 'slider') { ?>
			<?php $token = wp_generate_password(5, false, false); ?>
            <script type="text/javascript">
                jQuery(document).ready(function($){
                    if($("#post-carousel-<?php echo esc_attr( $token ); ?>").length > 0){
                        var owlPosts = $('#post-carousel-<?php echo esc_attr( $token ); ?>');
                        
                        owlPosts.slick({
                        	autoplay: true,
                            rtl: 'false',
                            lazyLoad: 'ondemand',
                            infinite: true,
                            speed: 300,
                            slidesToShow: 1,
                            arrows: true,
                            adaptiveHeight: true,
                            dots: true,
                            appendArrows: '.posts-module-slider',
                            prevArrow: $('.posts-prev-js'),
                            nextArrow: $('.posts-next-js'),
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
            <div class="posts-module posts-module-slider">
            	<div class="property-carousel-buttons-wrap" style="height: 30px;">
		                    <button type="button" class="posts-prev-js slick-prev btn-primary-outlined"><?php esc_html_e('Prev', 'advmls'); ?></button>
		                    <button type="button" class="posts-next-js slick-next btn-primary-outlined"><?php esc_html_e('Next', 'advmls'); ?></button>
		                </div><!-- property-carousel-buttons-wrap -->
                <div id="post-carousel-<?php echo esc_attr( $token ); ?>" class="Posts-slider-wrap advmls-all-slider-wrap">
                   <?php foreach ( $r->posts as $recent_post ) : ?>
						<?php
						#var_dump($recent_post);
						$post_title   = get_the_title( $recent_post->ID );
						$title        = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
						$aria_current = '';

						if ( get_queried_object_id() === $recent_post->ID ) {
							$aria_current = ' aria-current="page"';
						}

						$metaPost = get_post_meta( $recent_post->ID );
						$img = "";
						if (is_array($metaPost)) {
							if (isset($metaPost['_thumbnail_id'][0]) and $metaPost['_thumbnail_id'][0] > 0) {
								$img_url = wp_get_attachment_image_src( $metaPost['_thumbnail_id'][0], 'full', true );
								$img = '<img src="'. $img_url[0]. '" alt="'.$post_title .'">';
							}
						}

						?>
						<div class="post-item card">

						  <div class="card-body">
						    <h5 class="card-title"><a href="<?php the_permalink( $recent_post->ID ); ?>" ><?php echo $post_title; ?></a></h5>
						    <p class="card-text"><?php 
							    $excerpt = strip_shortcodes( get_the_content( '', false , $recent_post->ID  ) );
								$excerpt = apply_filters( 'the_post', $excerpt );
								$excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
								echo $excerpt = wp_trim_words( $excerpt, 60, '...' ); ?>
							</p>
						  </div>
						</div>

					<?php endforeach; ?>

                </div>
            </div>
		<?php } ?>

		<?php
		if ( 'html5' === $format ) {
			echo '</nav>';
		}

		echo $args['after_widget'];
	}

	/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['number']    = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$instance[ 'category_ids' ]   	= ( isset( $new_instance[ 'category_ids' ] ) ) ? array_map( 'absint', $new_instance[ 'category_ids' ] ) : array( 0 );
		$instance[ 'orderby' ] = ( isset( $new_instance[ 'orderby' ] ) ) ? $new_instance[ 'orderby' ] : 'date';
		$instance[ 'viewtype' ] = ( isset( $new_instance[ 'viewtype' ] ) ) ? $new_instance[ 'viewtype' ] : 'grid';

		return $instance;
	}

	/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since 2.8.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		$category_ids			= ( isset( $instance[ 'category_ids' ] ) )			? $instance[ 'category_ids' ]		: array();
		$viewtype = isset( $instance['viewtype'] ) ? (bool) $instance['viewtype'] : false;

		 // order settings
        $orderby = ( isset( $instance[ 'orderby' ] ) ) ? $instance[ 'orderby' ] : 'date';
		
		// get categories
		$categories = get_categories( array( 'hide_empty' => 0, 'hierarchical' => 1 ) );
		$number_of_cats = count( $categories );
		
		// get size (number of rows to display) of selection box: not more than 10
		$number_of_rows = ( 10 > $number_of_cats ) ? $number_of_cats + 2 : 10;

		// start selection box
		$selection_element = sprintf(
			'<select name="%s[]" id="%s" class="rpwwt-cat-select" multiple size="%d">',
			$this->get_field_name( 'category_ids' ),
			$field_ids[ 'category_ids' ],
			$number_of_rows
		);
		$selection_element .= "\n";

		// make selection box entries
		$cat_list = array();
		if ( 0 < $number_of_cats ) {

			// make a hierarchical list of categories
			while ( $categories ) {
				// go on with the first element in the categories list:
				// if there is no parent
				if ( '0' == $categories[ 0 ]->parent ) {
					// get and remove it from the categories list
					$current_entry = array_shift( $categories );
					// append the current entry to the new list
					$cat_list[] = array(
						'id'	=> absint( $current_entry->term_id ),
						'name'	=> esc_html( $current_entry->name ),
						'depth'	=> 0
					);
					// go on looping
					continue;
				}
				// if there is a parent:
				// try to find parent in new list and get its array index
				$parent_index = $this->get_cat_parent_index( $cat_list, $categories[ 0 ]->parent );
				// if parent is not yet in the new list: try to find the parent later in the loop
				if ( false === $parent_index ) {
					// get and remove current entry from the categories list
					$current_entry = array_shift( $categories );
					// append it at the end of the categories list
					$categories[] = $current_entry;
					// go on looping
					continue;
				}
				// if there is a parent and parent is in new list:
				// set depth of current item: +1 of parent's depth
				$depth = $cat_list[ $parent_index ][ 'depth' ] + 1;
				// set new index as next to parent index
				$new_index = $parent_index + 1;
				// find the correct index where to insert the current item
				foreach( $cat_list as $entry ) {
					// if there are items with same or higher depth than current item
					if ( $depth <= $entry[ 'depth' ] ) {
						// increase new index
						$new_index = $new_index + 1;
						// go on looping in foreach()
						continue;
					}
					// if the correct index is found:
					// get current entry and remove it from the categories list
					$current_entry = array_shift( $categories );
					// insert current item into the new list at correct index
					$end_array = array_splice( $cat_list, $new_index ); // $cat_list is changed, too
					$cat_list[] = array(
						'id'	=> absint( $current_entry->term_id ),
						'name'	=> esc_html( $current_entry->name ),
						'depth'	=> $depth
					);
					$cat_list = array_merge( $cat_list, $end_array );
					// quit foreach(), go on while-looping
					break;
				} // foreach( cat_list )
			} // while( categories )

			// make HTML of selection box
			$selected = ( in_array( 0, $category_ids ) ) ? ' selected="selected"' : '';
			$selection_element .= "\t";
			$selection_element .= '<option value="0"' . $selected . '>' . $label_all_cats . '</option>';
			$selection_element .= "\n";

			foreach ( $cat_list as $category ) {
				$cat_name = apply_filters( 'rpwwt_list_cats', $category[ 'name' ], $category );
				$pad = ( 0 < $category[ 'depth' ] ) ? str_repeat('&ndash;&nbsp;', $category[ 'depth' ] ) : '';
				$selection_element .= "\t";
				$selection_element .= '<option value="' . $category[ 'id' ] . '"';
				$selection_element .= ( in_array( $category[ 'id' ], $category_ids ) ) ? ' selected="selected"' : '';
				$selection_element .= '>' . $pad . $cat_name . '</option>';
				$selection_element .= "\n";
			}
			
		}

		// close selection box
		$selection_element .= "</select>\n";
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="categorypost">Category</label>
			<?php  echo $selection_element; ?> 
		</p>

		<p><label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php esc_html_e( 'Order by', 'recent-posts-widget-with-thumbnails' ); ?>:</label>
		    <select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
		        <option value="date" <?php selected( 'none', $orderby ); ?>><?php esc_html_e( 'Date (default)', 'recent-posts-widget-with-thumbnails' ); ?></option>
		        <option value="title" <?php selected( 'title', $orderby ); ?>><?php esc_html_e( 'Title', 'recent-posts-widget-with-thumbnails' ); ?></option>
		        <option value="modified" <?php selected( 'modified', $orderby ); ?>><?php esc_html_e( 'Last modified date', 'recent-posts-widget-with-thumbnails' ); ?></option>
		        <option value="menu_order" <?php selected( 'menu_order', $orderby ); ?>><?php esc_html_e( 'Page order', 'recent-posts-widget-with-thumbnails' ); ?></option>
		        <option value="rand" <?php selected( 'rand', $orderby ); ?>><?php esc_html_e( 'Random', 'recent-posts-widget-with-thumbnails' ); ?></option>
		    </select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'viewtype' ); ?>">View Type</label>
			<select name="<?php echo $this->get_field_name('viewtype'); ?>" id="<?php echo $this->get_field_id( 'viewtype' ); ?>">
				<option value="grid" <?php selected( 'grid', $viewtype ); ?>>Grid</option>
				<option value="slider" <?php selected( 'slider', $viewtype ); ?>>Slider</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
			<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label>
		</p>
		<?php
	}
}
