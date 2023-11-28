<?php 
class mlsShowFeaturesPropertiesWidget extends WP_Widget {
	//widget constructor function
	function __construct() {

	 $widget_options = array (
	  'classname' => 'mlsShowFeaturesPropertiesWidget',
	  'description' => 'MLS: Featured Properties Carusel'
	 );

	 parent::__construct( 'mlsShowFeaturesPropertiesWidget', 'MLS: Featured Properties Carusel', $widget_options );
	}

	//function to output the widget form

	function form( $instance ) {

		/* Default widget settings. */
		$defaults = array(
			'title' => '',
			'name' => '',
			'category_ids' => array(),
			'property_types' => array(),
			'state' => array(),
			'city' => array(),
			'region' => '',
			'agent' => '',
			'sort_by' => 'price',
			'order_by' => 'asc',
			'propertiesShown' => '3',
			'properties_own' => '0',
			'min_price' => '',
			'max_price' => '',
			'slides_to_show' => '3',
			'see_company_listing' => 0
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		$property_type_arr = ($instance['category_ids']) ? esc_attr($instance['category_ids']) : "";
		$property_type = explode(',', ($property_type_arr));

		$property_status_arr = ($instance['property_types']) ? esc_attr($instance['property_types']) : "";
		$property_status = explode(',', ($property_status_arr));

		$lists_state_arr = ($instance['state']) ? esc_attr($instance['state']) : "";
		$lists_state = explode(',', ($lists_state_arr));

		$lists_cities_arr = ($instance['city']) ? esc_attr($instance['city']) : "";
		$lists_cities = array_map('intval',explode(',', ($lists_cities_arr)));
		
		//property type
		$queryUrlArr = array(
			"token" => mlsUtility::getInstance()->getActivationToken(),
			"source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl())
		);

		$queryUrl = http_build_query($queryUrlArr);
		$resultProType = wp_remote_get(getUrlMlsMember().'api/getpropertytype?'.$queryUrl);
		if (is_wp_error($resultProType)) {
			$proType = array();
		}else{
			$proType = json_decode($resultProType['body']);
		}

		$resultProStatus = wp_remote_get(getUrlMlsMember().'api/getpropertystatus?'.$queryUrl);
		if (is_wp_error($resultProStatus)) {
			$proStatus = array();
		}else{
			$proStatus = json_decode($resultProStatus['body']);
		}

		$resultStates = wp_remote_get(getUrlMlsMember().'api/getliststates?'.$queryUrl);
		if (is_wp_error($resultStates)) {
			$listStates = array();
		}else{
			$listStates = json_decode($resultStates['body']);
		}

		$resultCities = wp_remote_get(getUrlMlsMember().'api/getlistcities?'.$queryUrl);
		if (is_wp_error($resultCities)) {
			$listCities = array();
		}else{
			$listCities = json_decode($resultCities['body']);
		}
		$listCitiesJson = json_encode($listCities);

		$resultAgents = wp_remote_get(getUrlMlsMember().'api/getagentsfromcompany?'.$queryUrl);
		if (is_wp_error($resultAgents)) {
			$listAgents = array();
		}else{
			$listAgents = json_decode($resultAgents['body']);
		}
		
	?>

	<style type="text/css">
		select[multiple]{
			height: auto !important;
		}

	</style>

	<p>
	 <label for="<?php echo $this->get_field_id( 'title'); ?>">Title:</label>
	 <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" /></p>

	<p class="category_ids">
		<label for="category_ids">
			Property Type
			<select name="<?php echo $this->get_field_name("category_ids[]"); ?>" id="<?php echo $this->get_field_id( 'category_ids' ); ?>" class="widefat" multiple>
				<option value="">Any</option>
				<?php foreach ($proType as $key => $type) { ?>
					<option value="<?php echo $type->id; ?>" <?php echo (is_array($property_type) and in_array($type->id, $property_type) ) ? 'selected="selected"' : '' ?>><?php echo $type->category_name; ?></option>
				<?php } ?>
			</select>
		</label>
	</p>
	<p class="property_status">
		<label for="property_status">
			Property Status
			<select name="<?php echo $this->get_field_name("property_types[]"); ?>" id="<?php echo $this->get_field_id( 'property_types' ); ?>" class="widefat" multiple>
				<option value="">Any</option>
				<?php foreach ($proStatus as $key => $status) { ?>
					<option value="<?php echo $status->id; ?>" <?php echo (is_array($property_status) and in_array($status->id, $property_status) ) ? 'selected="selected"' : '' ?>><?php echo $status->type_name; ?></option>
				<?php } ?>
			</select>
		</label>
	</p>
	<p class="state">
		<label for="state">
			State
			<select name="<?php echo $this->get_field_name("state[]"); ?>" id="<?php echo $this->get_field_id( 'state' ); ?>" class="widefat" multiple>
				<option value="">All</option>
				<?php foreach ($listStates as $key => $state) { ?>
					<option value="<?php echo $state->id; ?>" <?php echo (is_array($lists_state) and in_array($state->id, $lists_state) ) ? 'selected="selected"' : '' ?>><?php echo $state->state_name; ?></option>
				<?php } ?>
			</select>
		</label>
	</p>
	<p class="city">
		<script type="text/javascript">
			 jQuery(document).ready(function () {
		        jQuery('#<?php echo $this->get_field_id( 'state' ); ?>').on('change',function(){
		        	loadCities()
		        });
		        loadCities()
		    });

			 function loadCities(){
			 	var listCitiesSelected = <?php echo json_encode($lists_cities); ?>;
			 	var listCities = <?php echo $listCitiesJson ?>;
		        var citySelect = jQuery('#<?php echo $this->get_field_id( 'city' ); ?>');
			 	var listStates = jQuery('#<?php echo $this->get_field_id( 'state' ); ?>').val();
		        	
		        	citySelect.empty().append('<option value="">All</option>');

		        	for (var i = listCities.length - 1; i >= 0; i--) {
		        		if(jQuery.inArray(listCities[i].state_id, listStates) !== -1){

					        newOpt = jQuery('<option></option>');
					        newOpt.val(listCities[i].id).html(listCities[i].city);

					        if (jQuery.inArray(parseInt( listCities[i].id), listCitiesSelected) !== -1) {
					        	newOpt.prop('selected','selected');
					        }

		        			citySelect.append(newOpt);
		        		}
		        	}
			 }
		</script>
		<label for="city">
			City
			<select name="<?php echo $this->get_field_name("city[]"); ?>" id="<?php echo $this->get_field_id( 'city' ); ?>" class="widefat" multiple>
				<option value="">All</option>
			</select>
		</label>
	</p>
	<p class="region">
		<label for="region">
			Region
			<select name="<?php echo $this->get_field_name("region[]"); ?>" id="<?php echo $this->get_field_id( 'region' ); ?>" class="widefat">
				<option value="">All</option>
				<?php echo advmls_getListRegions($instance['region']) ?>
			</select>
		</label>
	</p>
	<p class="agent">
		<label for="agent">
			Agent
			<select name="<?php echo $this->get_field_name("agent"); ?>" id="<?php echo $this->get_field_id( 'agent' ); ?>" class="widefat">
				<option value="">All</option>
				<?php foreach ($listAgents as $key => $agent) { ?>
					<option value="<?php echo $agent->id; ?>" <?php echo ($instance['agent'] == $agent->id ) ? 'selected="selected"' : '' ?>><?php echo $agent->name; ?></option>
				<?php } ?>
			</select>
		</label>
	</p>
	<p class="min_price">
		<label for="min_price">
			Min. Price
			<input type="text" name="<?php echo $this->get_field_name("min_price");?>" class="widefat" placeholder="Min. Price" value="<?php echo $instance['min_price']; ?>">
		</label>
		
	</p>
	<p class="max_price">
		<label for="max_price">
			Max. Price
			<input type="text" name="<?php echo $this->get_field_name("max_price");?>" class="widefat" placeholder="Max. Price" value="<?php echo $instance['max_price']; ?>">
		</label>
		
	</p>
	<p class="sort_by">
		<label for="sort_by">
			Sort By
			<select name="<?php echo $this->get_field_name("sort_by"); ?>" id="<?php echo $this->get_field_id( 'sort_by' ); ?>" class="widefat">
				<option value="">Any</option>
				<option value="created" <?php echo ($instance['sort_by'] == 'created' ? 'selected' : ''); ?> >Created</option>
				<option value="price" <?php echo ($instance['sort_by'] == 'price' ? 'selected' : '' ); ?> >Price</option>
				<option value="rand" <?php echo ($instance['sort_by'] == 'rand' ? 'selected' : '' ); ?> >Rand</option>
			</select>
		</label>
	</p>
	<p class="order_by">
		<label for="order_by">
			Order By
			<select name="<?php echo $this->get_field_name("order_by"); ?>" id="<?php echo $this->get_field_id( 'order_by' ); ?>" class="widefat">
				<option value="">Any</option>
				<option value="desc" <?php echo ($instance['order_by'] == 'desc' ? 'selected' : ''); ?>>Descending</option>
				<option value="asc" <?php echo ($instance['order_by'] == 'asc' ? 'selected' : '' ); ?>>Ascending</option>
			</select>
		</label>
	</p>

	<p class="propertiesShown">
		<label>
			Number of Properties Shown:
			<select class="widefat" name="<?php echo $this->get_field_name("propertiesShown"); ?>">
				<?php for($index = 1; $index < 11; $index += 1) { ?>
					<option value="<?php echo $index; ?>"
						<?php if($instance['propertiesShown'] == $index) { ?>
							selected="selected"
						<?php } ?>
					>
						<?php echo $index; ?>
					</option>
				<?php } ?>
			</select>
		</label>
	</p>

	<p class="slides_to_show">
		<label>
			Slides to Shown:
			<select class="widefat" name="<?php echo $this->get_field_name("slides_to_show"); ?>">
				<?php for($index = 1; $index < 6; $index += 1) { ?>
					<option value="<?php echo $index; ?>"
						<?php if($instance['slides_to_show'] == $index) { ?>
							selected="selected"
						<?php } ?>
					>
						<?php echo $index; ?>
					</option>
				<?php } ?>
			</select>
		</label>
	</p>

	<p class="properties_own">
		<label for="properties_own">
			<input type="checkbox" value="1" name="<?php echo $this->get_field_name("properties_own"); ?>" <?php echo ($instance['properties_own']) ? 'checked' : ''; ?> />
			See Only My Listings
		</label>
	</p>
	<?php if (advmls_isAgent()) { ?>
		<p class="see_company_listing">
			<label for="see_company_listing">
				<input type="checkbox" value="1" name="<?php echo $this->get_field_name("see_company_listing"); ?>" <?php echo ($instance['see_company_listing']) ? 'checked' : ''; ?> />
				See Only My Company Listings
			</label>
		</p>
	<?php } ?>
	<?php }

	
	//function to define the data saved by the widget

	function update( $new_instance, $old_instance ) {
	 	$instance = $old_instance;
		$instance['title'] = isset($new_instance['title']) ? strip_tags( $new_instance['title'] ) : '';
		$listCategoryIds = isset($new_instance['category_ids']) ? implode(',', $new_instance['category_ids']) : '';
		$instance['category_ids'] = strip_tags($listCategoryIds );
		$listPropertyType = isset($new_instance['property_types']) ? implode(',', $new_instance['property_types']) : '';
		$instance['property_types'] = strip_tags($listPropertyType );

		$instance['state'] = isset($new_instance['state']) ? strip_tags( implode(',', $new_instance['state'])) : '';
		$instance['city'] = isset($new_instance['city']) ? strip_tags( implode(',', $new_instance['city'])) : '';
		$instance['region'] = isset($new_instance['region']) ? strip_tags( implode(',', $new_instance['region'])) : '';

		$instance['agent'] = isset($new_instance['agent']) ? strip_tags($new_instance['agent'] ) : '';
		$instance['sort_by'] = isset($new_instance['sort_by']) ? strip_tags($new_instance['sort_by'] ) : 'price';
		$instance['order_by'] = isset($new_instance['order_by']) ? strip_tags($new_instance['order_by'] ) : 'asc';
		$instance['propertiesShown'] = isset($new_instance["propertiesShown"]) ? strip_tags($new_instance["propertiesShown"]) : 3;
		$instance['properties_own'] = isset($new_instance["properties_own"]) ? strip_tags($new_instance["properties_own"]) : 0 ;
		$instance['min_price'] = isset($new_instance["min_price"]) ? strip_tags($new_instance["min_price"]) : 0;
		$instance['max_price'] = isset($new_instance["max_price"]) ? strip_tags($new_instance["max_price"]) : 0;
		$instance['slides_to_show'] = isset($new_instance["slides_to_show"]) ? strip_tags($new_instance["slides_to_show"]) : 3;
		$instance['see_company_listing'] = isset($new_instance["see_company_listing"]) ? strip_tags($new_instance["see_company_listing"]) : 0 ;

		return $instance;

	}

	//function to display the widget in the site

	function widget( $args, $instance ) {
		 //define variables
		 $title = isset($instance['title']) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		 $property_type_arr = isset($instance['category_ids']) ? $instance['category_ids'] : '';
		 $property_type = explode(',', ($property_type_arr));
		 $property_status_arr = isset($instance['property_types']) ? $instance['property_types'] : '';
		 $property_status = explode(',', ($property_status_arr));
		 $statesArr = isset($instance['state']) ? $instance['state'] : '';
		 $states = explode(',', ($statesArr));
		 $citiesArr = isset($instance['city']) ? $instance['city'] : '';
		 $cities = explode(',', ($citiesArr));
		 $regionsArr = isset($instance['region']) ? $instance['region'] : '';
	 	 $regions = explode(',', ($regionsArr));
		 $agent = isset($instance['agent']) ? $instance['agent'] : '';
		 $sort_by = isset($instance['sort_by']) ? $instance['sort_by'] : 'price';
		 $order_by = isset($instance['order_by']) ? $instance['order_by'] : 'asc';

		 $propertiesShown = isset($instance["propertiesShown"]) ? $instance["propertiesShown"] : 3;
		 $properties_own = isset($instance["properties_own"]) ? $instance["properties_own"] : 0;
		 $min_price = isset($instance["min_price"]) ? $instance["min_price"] : 0;
		 $max_price = isset($instance["max_price"]) ? $instance["max_price"] : 0;
		 $slides_to_show = isset($instance["slides_to_show"]) ? $instance["slides_to_show"] : 3;
		 $see_company_listing = isset($instance["see_company_listing"]) ? $instance["see_company_listing"] : 0;
		 
		$queryUrlArr = array(
			"token" => mlsUtility::getInstance()->getActivationToken(),
			"source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl()),
			"properties_own" => $properties_own,
			"see_company_listing" => $see_company_listing,
			"limit" => $propertiesShown,
			"min_price" => $min_price,
			"max_price" => $max_price,
			"agent" => $agent,
			"sort_by" => $sort_by,
			"order_by" => $order_by
		);

		foreach ($property_type as $key => $type) {
			$queryUrlArr["category_ids[$key]"] = $type;
		}

		foreach ($property_status as $key => $status) {
			$queryUrlArr["pro_types[$key]"] = $status;
		}

		foreach ($states as $key => $state) {
			$queryUrlArr["states[$key]"] = $state;
		}

		foreach ($cities as $key => $city) {
			$queryUrlArr["cities[$key]"] = $city;
		}

		foreach ($regions as $key => $region) {
			$queryUrlArr["egion[$key]"] = $region;
		}

		$queryUrl = http_build_query($queryUrlArr);
		$resultProperties = wp_remote_get(getUrlMlsMember().'api/getpropertieslist?'.$queryUrl);
		
		if (is_wp_error($resultProperties)) {
			return;
		}

		$jsonResult = json_decode($resultProperties['body']);
		$properties = isset($jsonResult->properties) ? $jsonResult->properties : array();
		$this->proListResult = $properties;
		$this->proPagination = isset($jsonResult->pagination) ? $jsonResult->pagination : null ;
		
		if (!isset($jsonResult->error)) {
			?>
			<h3><?php echo $title ; ?></h3>
			<?php

			$urlProDetail = mlsUrlFactory::getInstance()->getListingDetailUrl(true);
			$pathTemplate = mlsConstants::ADVANTAGEMLSTPLPATH;

			$token = wp_generate_password(5, false, false);

			?>
				<style>
					.advmls-properties-carousel-js .slick-prev.slick-arrow{
						left: 33px !important;
					}

					.advmls-properties-carousel-js .slick-next.slick-arrow{
						right: 33px !important;
					}
				</style>

				<script type="text/javascript">
				 	jQuery(document).ready(function(){

				 	    /* ------------------------------------------------------------------------ */
					    /*  property slider
					    /* ------------------------------------------------------------------------ */
					    var properties_carousel = jQuery('#advmls-properties-carousel-<?php echo esc_attr($token); ?>');
					    if( properties_carousel.length > 0 ) {

					        properties_carousel.slick({
					            //rtl: advmls_rtl,
					            autoplay: true,
					            autoplaySpeed: 5000,
					            lazyLoad: 'ondemand',
					            infinite: true,
					            speed: 300,
					            slidesToShow: <?php echo $slides_to_show ?>,
					            arrows: true,
					            adaptiveHeight: true,
					            slides_to_scroll: 1,
					            
								responsive: [
										{
		                                    breakpoint: 1200,
		                                    settings: {
		                                        slidesToShow: 3,
		                                        slidesToScroll: 3
		                                    }
		                                },
										{
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


			<style type="text/css">
				.listing-thumb{
					width: 100%;
					height: 250px;
				}
			</style>
			<div class="property-carousel-module advmls-carousel-arrows-<?php echo esc_attr($token); ?> advmls-carousel-cols-<?php echo esc_attr(2); ?> property-carousel-module-v3">


				<div class="listing-view grid-view">
					<div id="advmls-properties-carousel-<?php echo esc_attr($token); ?>" data-token="<?php echo esc_attr($token); ?>" class="advmls-properties-carousel-js advmls-all-slider-wrap card-deck">
						<?php
						global $property;
							foreach ($properties as $key => $property) {
								$currentKey = $key;
								include($pathTemplate.'listing/item-v2.php');
							}
						?>
					</div><!-- testimonials-slider -->
				</div><!-- listing-view grid-view -->
			</div><!-- testimonials-module -->	

		<?php
		}elseif ($jsonResult->error) { ?>
			<div class="alert alert-warning">
				<p class="text-capitalize">
					<?php echo $jsonResult->error_msg;?>
				</p>
			</div>
		<?php }

	}


	public function getFielProperty($name, $posProperty = 0){
		return $this->proListResult[$posProperty]->{$name};
	}

	public function getProTitle($posProperty = 0){
		return $this->getFielProperty('pro_name', $posProperty).' - '.$this->getFielProperty('ref', $posProperty);
	}
}