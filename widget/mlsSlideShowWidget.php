<?php 
class mlsSlideShowWidget extends WP_Widget {
	//widget constructor function

	function __construct() {

	 $widget_options = array (
	  'classname' => 'mlsSlideShowWidget',
	  'description' => 'MLS: Slide Show.'
	 );

	 parent::__construct( 'mlsSlideShowWidget', 'MLS: Slide Show.', $widget_options );

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
			'see_company_listing' => 0,
			'listHeight' => null,
			'add_quick_search' => 0,
			'mls_detail_box' => 'default'
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
		if (!is_wp_error($resultProType)) {
			$proType = json_decode($resultProType['body']);
		}else{
			$proType = json_encode(array());
		}

		$resultProStatus = wp_remote_get(getUrlMlsMember().'api/getpropertystatus?'.$queryUrl);
		if (!is_wp_error($resultProStatus)) {
			$proStatus = json_decode($resultProStatus['body']);
		}else{
			$proStatus = json_encode(array());
		}

		$resultStates = wp_remote_get(getUrlMlsMember().'api/getliststates?'.$queryUrl);
		if (!is_wp_error($resultStates)) {
			$listStates = json_decode($resultStates['body']);
		}else{
			$listStates = json_encode(array());
		}

		$resultCities = wp_remote_get(getUrlMlsMember().'api/getlistcities?'.$queryUrl);
		if (!is_wp_error($resultCities)) {
			$listCities = json_decode($resultCities['body']);
		}else{
			$listCities = json_encode(array());
		}
		$listCitiesJson = json_encode($listCities);

		$resultAgents = wp_remote_get(getUrlMlsMember().'api/getagentsfromcompany?'.$queryUrl);
		if (!is_wp_error($resultAgents)) {
			$listAgents = json_decode($resultAgents['body']);
		}else{
			$listAgents = json_encode(array());
		}
		
	?>

	<style type="text/css">
		select[multiple]{
			height: auto !important;
		}

	</style>

	<p>
	 <label for="<?php echo $this->get_field_id( 'title'); ?>">Title:</label>
	 <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>

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
	
	<h2 class="p-2"><strong>Design:</strong></h2>
	<hr>

	<p class="listHeight">
		<label for="listHeight">
			Container Height
			<input type="number" name="<?php echo $this->get_field_name("listHeight");?>" class="widefat" placeholder="Container Height" value="<?php echo $instance['listHeight']; ?>" min="300" max="600">
		</label>
	</p>

	<p class="addquicksearch">
		<label for="addquicksearch">
			<input type="checkbox" value="1" name="<?php echo $this->get_field_name("add_quick_search"); ?>" <?php echo ($instance['add_quick_search']) ? 'checked' : ''; ?> />
			Add Quick Search
		</label>
	</p>
	<p class="detailbox">
		<label for="detailbox">
			Detail Box
			<select name="<?php echo $this->get_field_name("mls_detail_box"); ?>" id="<?php echo $this->get_field_id( 'mls_detail_box' ); ?>" class="widefat">
				<option value="" <?php echo ($instance['mls_detail_box'] == '' ? 'selected' : ''); ?>>Default</option>
				<option value="slider-tiny" <?php echo ($instance['mls_detail_box'] == 'slider-tiny' ? 'selected' : '' ); ?>>Tiny Transparent</option>
			</select>
		</label>
	</p>
	<?php }

	
	//function to define the data saved by the widget

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = isset($new_instance['title']) ? strip_tags( $new_instance['title'] ) : '';
		$listCategoryIds = isset($new_instance['category_ids']) ? implode(',', $new_instance['category_ids']) : '';
		$instance['category_ids'] = strip_tags($listCategoryIds );
		$listPropertyType = isset($new_instance['property_types']) ? implode(',', $new_instance['property_types']) : '';
		$instance['property_types'] = strip_tags($listPropertyType );

		$instance['state'] = isset($new_instance['state']) ? strip_tags( implode(',', $new_instance['state'] )) : '';
		$instance['city'] = isset($new_instance['city']) ? strip_tags( implode(',', $new_instance['city'] )) : '';
		$instance['region'] = isset($new_instance['region']) ? strip_tags( implode(',', $new_instance['region'] ) ) : '';

		$instance['agent'] = isset($new_instance['agent']) ? strip_tags($new_instance['agent'] ) : '';
		$instance['sort_by'] = isset($new_instance['sort_by']) ? strip_tags($new_instance['sort_by'] ) : 'price';
		$instance['order_by'] = isset($new_instance['order_by']) ? strip_tags($new_instance['order_by'] ) : 'asc';
		$instance['propertiesShown'] = isset($new_instance["propertiesShown"]) ? strip_tags($new_instance["propertiesShown"])  : '3';
		$instance['properties_own'] = isset($new_instance["properties_own"]) ? strip_tags($new_instance["properties_own"]) : 0 ;
		$instance['min_price'] = isset($new_instance["min_price"]) ? strip_tags($new_instance["min_price"]) : '';
		$instance['max_price'] = isset($new_instance["max_price"]) ? strip_tags($new_instance["max_price"]) : '';
		$instance['see_company_listing'] = isset($new_instance["see_company_listing"]) ? strip_tags($new_instance["see_company_listing"]) : 0 ;
		$instance['listHeight'] = isset($new_instance["listHeight"]) ? strip_tags($new_instance["listHeight"]) : null ;
		$instance['add_quick_search'] = isset($new_instance["add_quick_search"]) ? strip_tags($new_instance["add_quick_search"]) : 0 ;
		$instance['mls_detail_box'] = isset($new_instance["mls_detail_box"]) ? strip_tags($new_instance["mls_detail_box"]) : 'default' ;

		return $instance;

	}

	//function to display the widget in the site

	function widget( $args, $instance ) {
	 //define variables
		$title = isset($instance['title']) ? apply_filters( 'widget_title', $instance['title'] ): '';
		$property_type_arr = isset($instance['category_ids']) ? $instance['category_ids'] : '';
		$property_type = explode(',', ($property_type_arr));
		$property_status_arr =  isset($instance['property_types']) ? $instance['property_types'] : '';
		$property_status = explode(',', ($property_status_arr));
		$statesArr = isset( $instance['state']) ?  $instance['state'] : '';
		$states = explode(',', ($statesArr));
		$citiesArr = isset( $instance['city']) ?  $instance['city'] : '';
		$cities = explode(',', ($citiesArr));
		$regionsArr = isset( $instance['region']) ?  $instance['region'] : '';
		$regions = explode(',', ($regionsArr));
		$agent = isset($instance['agent'] ) ? $instance['agent'] : '';
		$sort_by = isset($instance['sort_by'] ) ? $instance['sort_by'] : 'price';
		$order_by = isset($instance['order_by'] ) ? $instance['order_by'] : 'asc';
		$propertiesShown = isset($instance["propertiesShown"]) ? $instance["propertiesShown"] : 3;
		$properties_own = isset($instance["properties_own"]) ? $instance["properties_own"]: '0';
		$min_price = isset($instance["min_price"]) ? $instance["min_price"]: 0;
		$max_price = isset($instance["max_price"]) ? $instance["max_price"]: 0;
		$see_company_listing = isset($instance["see_company_listing"]) ? $instance["see_company_listing"] : 0;
		$listHeight = isset($instance["listHeight"]) ? $instance["listHeight"] : null;
		$addQuickSearch = isset($instance["add_quick_search"]) ? $instance["add_quick_search"] : null;
		$detailBox = isset($instance["mls_detail_box"]) ? $instance["mls_detail_box"] : 'default';

		$removable_query_args = wp_removable_query_args();

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

		#var_dump($regions);
		$queryUrl = http_build_query(array_filter($queryUrlArr));
		$resultProperties = wp_remote_get(getUrlMlsMember().'api/getpropertieslist?'.$queryUrl);

		if (is_wp_error($resultProperties)) {
			return;
		}

		$jsonResult = json_decode($resultProperties['body']);
		echo $args['before_widget']; 

			if ( !isset($jsonResult->error)) {

				$properties = isset($jsonResult->properties) ? $jsonResult->properties : array() ;

				if( count($properties) > 0 and !isset($properties->error)){
					$urlProDetail = mlsUrlFactory::getInstance()->getListingDetailUrl(true);
					echo $args['before_widget']; 
				 ?>
				 <script type="text/javascript">
				 	jQuery(document).ready(function(){

				 	    /* ------------------------------------------------------------------------ */
					    /*  property slider
					    /* ------------------------------------------------------------------------ */
					    var property_banner_slider = jQuery('.property-slider');
					    if( property_banner_slider.length > 0 ) {
					        
					        var autoplay = property_banner_slider.data('autoplay');
					        var slider_loop = property_banner_slider.data('loop');
					        var slider_speed = property_banner_slider.data('speed');

					        var s_loop = false;
					        if(slider_loop == 1) {
					            s_loop = true;
					        }

					        property_banner_slider.slick({
					            //rtl: advmls_rtl,
					            autoplay: autoplay,
					            autoplaySpeed: slider_speed,
					            lazyLoad: 'ondemand',
					            infinite: s_loop,
					            speed: 300,
					            slidesToShow: 1,
					            arrows: true,
					            adaptiveHeight: true
					            <?php echo (int)$listHeight > 0 ? ",listHeight:".$listHeight : '' ?>
					        });
					    }
				 	});
				 </script>
				 <?php if($title != ""){ ?>
				 	<h3 class="text-center"><?php echo $title ; ?></h3>
				 <?php } ?>

					<section class="top-banner-wrap property-slider-wrap horizontal-search-wrap">

						<?php 
							$pathTemplate = mlsConstants::ADVANTAGEMLSTPLPATH;
							if ($addQuickSearch == 1) {
							
							global $advmls_type_search;
							$advmls_type_search = 'v2';
							if (!empty($advmls_type_search)) {
							?>
								<style>
									.property-slider-wrap .quick-search-v2 {
									    position: absolute;
									    left: 50%;
									    top: 50px;
									    text-align: center;
									    -webkit-transform: translate(-50%, -35%);
									    -ms-transform: translate(-50%, -35%);
									    transform: translate(-50%, -35%);
									    z-index: 9999;
									    width: 50%;
									}
									.quick-search-v2 input {
										background: #ffffff;
									}

									.quick-search-v2 .banner-caption{
										top: 10% !important;
									}
									.quick-search-v2 .form-group, .quick-search-v2 .nav-item{
										margin-bottom: 0px !important;
									}
								</style>
								<div class="quick-search-<?=$advmls_type_search?>" style="display: none;">
									<?php
										include_once($pathTemplate.'search/main.php');
									?>
						 		</div>
					 		<?php 
			 				}
			 				?>

			 				<div class="align-self-center flex-fill quick-search-<?=$advmls_type_search?>">
								<div class="banner-caption">

									<?php include_once($pathTemplate.'search/search-for-banners.php'); ?>

								</div><!-- banner-caption -->
							</div><!-- align-self-center -->
			 			<?php 
			 			}
				 		?>
						<div class="property-slider advmls-all-slider-wrap" data-autoplay="1" data-loop="1" data-speed="5000">
							<?php 
							foreach( $properties as $key => $property ){
								if ( count($property->photos) > 0) {
									$img_url = $property->url_photo."/".$property->photos[0]->image;
								}
								?>
								<div class="property-slider-item-wrap" style="background-image: url(<?php echo esc_url($img_url); ?>);"	>
									<a href="#" class="property-slider-link"></a>
									<div class="property-slider-item <?php echo $detailBox; ?>">
										<h2 class="item-title h-type">
											<a href="<?php echo esc_url($urlProDetail.$property->category_name.'/'.$property->pro_alias); ?>"><?php echo $property->ref.' - '.$property->pro_name; ?></a>
										</h2><!-- item-title -->
										<address class="item-address"><?php echo $property->address.', ' ?> <?php echo $property->city_name.', ' ?> <?php echo $property->state_name.', ' ?><?php echo $property->region.', ' ?><?php echo $property->postcode ?></address>
										<ul class="item-price-wrap hide-on-list">
											<li class="item-price"><?php echo $property->currency_code.' '. mlsUtility::getInstance()->showNumberFormat($property->price,6); ?></li>
										</ul>
										<ul class="item-amenities item-amenities-with-icons">
											<?php if($property->bed_room > 0){ ?>
												<li class="h-beds">
													<i class="advmls-icon icon-hotel-double-bed-1 mr-1"></i>
													<span class="item-amenities-text">Beds:</span>
													<span class="hz-figure"><?php echo mlsUtility::getInstance()->showNumberFormat($property->bed_room) ?></span>
												</li>
											<?php }  ?>
											<?php if($property->bath_room > 0){ ?>
												<li class="h-baths">
													<i class="advmls-icon icon-bathroom-shower-1 mr-1"></i>
													<span class="item-amenities-text">Baths:</span>
													<span class="hz-figure"><?php echo mlsUtility::getInstance()->showNumberFormat($property->bath_room) ?></span>
												</li>
											<?php }  ?>
											<?php if($property->square_feet > 0){ ?>
												<li class="h-area">
													<i class="fa fa-building os-1x"></i>
													<span class="hz-figure"><?php echo mlsUtility::getInstance()->showNumberFormat($property->square_feet) ?></span>
													<span class="area_postfix">m²</span>
												</li>
											<?php }  ?>
											<?php if($property->lot_size > 0){ ?>
												<li class="h-area">
													<i class="advmls-icon icon-ruler-triangle mr-1"></i>
													<span class="hz-figure"><?php echo mlsUtility::getInstance()->showNumberFormat($property->lot_size) ?></span>
													<span class="area_postfix">m²</span>
												</li>
											<?php }  ?>
											<li class="h-type"><span class="h-region"><?php echo $property->region.' - ' ?></span><span><?php echo $property->type_name; ?></span></li>
										</ul>
										
										<a class="btn btn-primary btn-item submit" href="<?php echo esc_url($urlProDetail.$property->category_name.'/'.$property->pro_alias); ?>">
											Details
										</a><!-- btn-item -->
									</div><!-- property-slider-item -->
								</div><!-- property-slider-item-wrap -->
							<?php
							}
							?>
						</div><!-- property-slider -->
					</section><!-- property-slider-wrap -->
				 <?php
				 echo $args['after_widget']; 
				}else{
				?>
				<div class="alert alert-warning">
					<p class="text-capitalize">
						<?php echo $jsonResult->error_msg; ?>
					</p>
				</div>
				<?php 
				}
			}else{ ?>
				<div class="alert alert-warning">
					<p class="text-capitalize">
						<?php echo $jsonResult->error_msg; ?>
					</p>
				</div>
			<?php
			}
		
		echo $args['after_widget'];

	}
}