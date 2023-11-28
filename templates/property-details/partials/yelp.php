<?php
global $post;

$post_id = $post->ID;

$advmls_yelp_api_key = advmls_option('advmls_yelp_api_key');

$allowed_html_array = array(
    'i' => array(
        'class' => array()
    ),
    'span' => array(
        'class' => array()
    ),
    'a' => array(
        'href' => array(),
        'title' => array(),
        'target' => array()
    )
);

$yelp_categories = array (
    'active' => array( 'name' => esc_html__( 'Active Life', 'advmls' ), 'icon' => 'fa fa-bicycle' ),
    'arts' => array( 'name' => esc_html__( 'Arts & Entertainment', 'advmls' ), 'icon' => 'fas fa-image' ),
    'auto' => array( 'name' => esc_html__( 'Automotive', 'advmls' ), 'icon' => 'fa fa-car' ),
    'beautysvc' => array( 'name' => esc_html__( 'Beauty & Spas', 'advmls' ), 'icon' => 'fa fa-cutlery' ),
    'education' => array( 'name' => esc_html__( 'Education', 'advmls' ), 'icon' => 'fa fa-graduation-cap' ),
    'eventservices' => array( 'name' => esc_html__( 'Event Planning & Services', 'advmls' ), 'icon' => 'fa fa-birthday-cake' ),
    'financialservices' => array( 'name' => esc_html__( 'Financial Services', 'advmls' ), 'icon' => 'far fa-money-bill-alt' ),
    'food' => array( 'name' => esc_html__( 'Food', 'advmls' ), 'icon' => 'fa fa-shopping-basket' ),
    'health' => array( 'name' => esc_html__( 'Health & Medical', 'advmls' ), 'icon' => 'fa fa-medkit' ),
    'homeservices' => array( 'name' => esc_html__( 'Home Services ', 'advmls' ), 'icon' => 'fa fa-wrench' ),
    'hotelstravel' => array( 'name' => esc_html__( 'Hotels & Travel', 'advmls' ), 'icon' => 'fa fa-bed' ),
    'localflavor' => array( 'name' => esc_html__( 'Local Flavor', 'advmls' ), 'icon' => 'fa fa-coffee' ),
    'localservices' => array( 'name' => esc_html__( 'Local Services', 'advmls' ), 'icon' => 'fa fa-dot-circle-o' ),
    'massmedia' => array( 'name' => esc_html__( 'Mass Media', 'advmls' ), 'icon' => 'fa fa-television' ),
    'nightlife' => array( 'name' => esc_html__( 'Nightlife', 'advmls' ), 'icon' => 'fas fa-glass-martini-alt' ),
    'pets' => array( 'name' => esc_html__( 'Pets', 'advmls' ), 'icon' => 'fa fa-paw' ),
    'professional' => array( 'name' => esc_html__( 'Professional Services', 'advmls' ), 'icon' => 'fa fa-suitcase' ),
    'publicservicesgovt' => array( 'name' => esc_html__( 'Public Services & Government', 'advmls' ), 'icon' => 'fa fa-university' ),
    'realestate' => array( 'name' => esc_html__( 'Real Estate', 'advmls' ), 'icon' => 'fa fa-building' ),
    'religiousorgs' => array( 'name' => esc_html__( 'Religious Organizations', 'advmls' ), 'icon' => 'fa fa-universal-access' ),
    'restaurants' => array( 'name' => esc_html__( 'Restaurants', 'advmls' ), 'icon' => 'fas fa-utensils' ),
    'shopping' => array( 'name' => esc_html__( 'Shopping', 'advmls' ), 'icon' => 'fa fa-shopping-bag' ),
    'transport' =>  array( 'name' => esc_html__( 'Transportation', 'advmls' ), 'icon' => 'fa fa-bus' )
);

$yelp_data = advmls_option( 'advmls_yelp_term' );
$yelp_dist_unit = advmls_option( 'advmls_yelp_dist_unit' );
$prop_location = get_post_meta( get_the_ID(), 'fave_property_location', true );
$prop_location = explode( ',', $prop_location );
$prop_location = $prop_location[0].','.$prop_location[1];


$dist_unit = 1.1515;
$unit_text = 'mi';
if ( $yelp_dist_unit == 'kilometers' ) {
    $dist_unit = 1.609344;
    $unit_text = 'km';
}
?>
<div class="what-nearby">
	<?php
    $link = site_url('wp-admin/admin.php?page=advmls_options&tab=30');
    if( empty( $advmls_yelp_api_key ) ) {
        echo '<div class="yelp-cat-block">';
        echo esc_html__('Please supply your API key', 'advmls').' ';
        echo '<a target="_blank" href="'.$link.'">'.esc_html__('Click Here', 'advmls').'</a>';
        echo '</div>';
    } else {

        foreach ( $yelp_data as $value ) :

            $term_id = $value;
            $term_name = $yelp_categories[ $term_id ]['name'];
            $term_icon = $yelp_categories[ $term_id ]['icon'];
            
            $response = advmls_yelp_query_api( $term_id, $prop_location );

            // Check for yelp api error
            if ( isset( $response->error ) ) {
                $output = '';
                $error = '';
                if ( ! empty( $response->error->code ) ) {
                    $error .= $response->error->code . ': ';
                }
                if ( ! empty( $response->error->description ) ) {
                    $error .= $response->error->description;
                }
                $output .= '<div class="yelp-api-error">' . esc_html( $error ) . '</div>';

            } else {

                if ( isset( $response->businesses ) ) {
                    $businesses = $response->businesses;
                } else {
                    $businesses = array( $response );
                }

                if ( ! count( $businesses ) ) {
                    continue;
                }

                $distance = false;
                $current_lat = '';
                $current_lng = '';

                if ( isset( $response->region->center ) ) {

                    $current_lat = $response->region->center->latitude;
                    $current_lng = $response->region->center->longitude;
                    $distance = true;

                }

                if ( sizeof( $businesses ) != 0 ) {
    			?>

    			<dl>
    				<dt><i class="<?php echo esc_attr($term_icon); ?>"></i> <?php echo esc_attr($term_name); ?></dt>

    				<?php
                    foreach ( $businesses as $data ) :

                    $location_distance = '';

                    if ( $distance && isset( $data->coordinates ) ) {

                        $location_lat = $data->coordinates->latitude;
                        $location_lng = $data->coordinates->longitude;
                        $theta = $current_lng - $location_lng;
                        $dist = sin( deg2rad( $current_lat ) ) * sin( deg2rad( $location_lat ) ) +  cos( deg2rad( $current_lat ) ) * cos( deg2rad( $location_lat ) ) * cos( deg2rad( $theta ) );
                        $dist = acos( $dist );
                        $dist = rad2deg( $dist );
                        $miles = $dist * 60 * $dist_unit;

                        $location_distance = '<span class="time-review"> (' . round( $miles, 2 ) . ' ' . $unit_text . ') </span>';

                    }
                    ?>
    				<dd>
    					<div class="what-nearby-left">
    						<?php echo esc_attr($data->name); ?> <?php echo $location_distance; ?>
    					</div>
    					<div class="what-nearby-right">
    						<div class="rating-wrap">
    							<div class="rating-container">
    								<div class="rating">                                            
    									<?php echo advmls_get_stars($data->rating); ?>

    									<span class="time-review"><?php echo $data->review_count; ?> <?php esc_html_e('reviews', 'advmls');?></span>
    								</div>
    							</div>
    						</div>
    					</div>
    				</dd>
    				<?php endforeach; ?>
    				
    			</dl>

    			<?php
                } //sizeof( $businesses )
            } // end error else

        endforeach;
    } //advmls_yelp_api_key
    ?>
</div>