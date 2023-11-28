<?php

class mlsSearchResultsVirtualPageImpl extends mlsAbstractVirtualPage {
	
	public function getTitle() {
		return "Property Search Results";
	}
	
	public function getPermalink() {
		return "mls-search-results";
	}

	public function createQueryRequest($arrSource, $arrRequest){

		foreach ($arrRequest as $key => $value) {

			if (is_array($value) ){
				foreach ($value as $keyval => $val) {
					$arrSource[$key][$keyval] = $val;
				}
			}else{
				if ($value != "" or $value != 0) {
					$arrSource[$key] = $value;
				}

			}

		}

		return $arrSource;
	}
			
	public function getContent() {

		$this->remoteResponse = array();
		$this->proListResult = array();
		$this->proPagination = array("limit"=>0,"total"=>0);

		$sort_by = 'price';
		$order_by = 'asc';

		if (isset($_GET['s_sort_by']) and !empty($_GET['s_sort_by'])) {
		 	if ($_GET['s_sort_by'] == 'a_price') {
		 		$sort_by = 'price';
				$order_by = 'asc';
		 	}elseif ($_GET['s_sort_by'] == 'd_price') {
		 		$sort_by = 'price';
				$order_by = 'desc';
		 	}
		 }

		$queryUrlArr = array(
			"token" => mlsUtility::getInstance()->getActivationToken(),
			"source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl()),
			#"limit" => get_option('advmls_pro_per_page', 20),
			"page" => get_query_var( 'paged' ),
			"items_per_page" => 20,
			"sort_by" => $sort_by,
			"order_by" => $order_by
		);

		$queryUrlArr = $this->createQueryRequest($queryUrlArr, $_REQUEST);

		$queryUrl = http_build_query($queryUrlArr);
		$resultProDetails = wp_remote_get(getUrlMlsMember().'api/getpropertieslist?'.$queryUrl);

		if (is_wp_error($resultProDetails)) {
			return;
		}

		$proListResult = json_decode($resultProDetails['body']);

		$this->remoteResponse = isset($proListResult->properties) ? $proListResult->properties : array();
		$this->proListResult = isset($proListResult->properties) ? $proListResult->properties : array();
		$this->proPagination = isset($proListResult->pagination) ? $proListResult->pagination : array("limit"=>0,"total"=>0);
	}

	public function getBody() {

		$pathTemplate = mlsConstants::ADVANTAGEMLSTPLPATH;
		$type_search = get_option('advmls_search_result_page', 'normal') ;
		ob_start();
		if (count($this->proListResult) > 0) {
			if ($type_search == 'normal') {

				the_widget( 'mlsAdvanceSearchWidget' );
				include_once($pathTemplate.'normal-page-search-results.php');

			}elseif( $type_search == 'map' ){
				?>
				<style>
					.ct-container{
						max-width: 100% !important;
					}
				</style>
				<?php

				advmls_enqueue_maps_api();

				$property_array_temp = array();
				$properties_data = array();
				foreach ($this->proListResult as $key => $property) {

					$properties_images = $property->photos;
					$url_photo = $property->url_photo;

					$currentCurr =  !empty($property->currency_code) ? $property->currency_code : '';
					$price =  !empty($property->price) ? $property->price : 0;
					$priceFormat = mlsUtility::getInstance()->showNumberFormat($price);
					$pro_title = $property->pro_name.' - '.$property->ref;

					$urlProDetail = mlsUrlFactory::getInstance()->getListingDetailUrl(true);
					$category_name = !empty($property->category_name) ? $property->category_name : '';
            		$pro_url = mlsUtility::getInstance()->advmls_esc_url($urlProDetail.$category_name.'/'.$property->pro_alias);

					$property_array_temp[ 'title' ] = $pro_title;
					$property_array_temp[ 'url' ] = $pro_url;
					$property_array_temp['price'] = $currentCurr.' '.$priceFormat;
					$property_array_temp['property_id'] = $property->ref;
					$property_array_temp['pricePin'] = 'yes';
					$property_array_temp['address'] = $property->address;
					$property_array_temp['property_type'] = $property->type_name;
					$property_array_temp['lat'] = $property->lat_add;
					$property_array_temp['lng'] = $property->long_add;
					$property_array_temp[ 'term_id' ] = "33";
					$property_array_temp[ 'marker' ] = ADVMLS_IMG."/map/pin-single-family.png";
					$property_array_temp[ 'retinaMarker' ] = ADVMLS_IMG."/map/pin-single-family.png";
					$property_array_temp[ 'thumbnail' ] = $url_photo.'/'.$properties_images[0]->image;
					$properties_data[] = $property_array_temp;
				}
				wp_localize_script( 'advmls-osm-properties', 'advmls_map_properties', $properties_data );
				wp_enqueue_script( 'advmls-osm-properties' );

				include_once($pathTemplate.'half-map-search-results.php');
			}

		}else{
            echo '<div class="search-no-results-found">';
                esc_html_e('No results found', 'advmls');
            echo '</div>';
		}
		$searchResults = ob_get_contents();
		ob_end_clean();
		return $searchResults;

	}

	public function getFielProperty($name, $posProperty = 0){
		return $this->proListResult[$posProperty]->{$name};
	}

	public function getProTitle($posProperty = 0){
		return $this->getFielProperty('pro_name', $posProperty).' - '.$this->getFielProperty('ref', $posProperty);
	}
	
}