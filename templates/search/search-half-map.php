<?php
global $post;
$search_style = get_option('halfmap_search_layout', 'v1');

$search_builder = array( 
	"enabled" => array(
		#"placebo" => "placebo",
		#"geolocation" => "Geolocation",
		"keyword" => "Keyword",
		"type" => "Type",
		"status" => "Status",
		"state" => "States",
		"city" => "Cities",
		"areas" => "Areas",
		"bedrooms" => "Bedrooms",
		"bathrooms" => "Bathrooms",
		"rooms" => "Rooms",
		"parking" => "Parking",
		"with-yard" => "With Yard",
		"with-pool" => "With Pool",
		"furnished" => "Furnished", // yes, no, partial, Optional Pkg
		"with-casita" => "With Casita", // yes, no, multiple casita or haciendas
		"gated-comm" => "Gated Comm", // yes, no
		"with-view" => "View", // montain, lake, lake and montain, Ocean, Partial
		"min-sqft" => "Min. Construction", 
		"max-sqft" => "Max. Construction",
		"min-land-area" => "Min. Lot",
		"max-land-area" => "Max. Lot",
		"min-price" => "Min. Price usd",
		"max-price" => "Max. Price usd",
		"sort-by" => "Sort by"
		),
	"disabled" => array(
		"placebo" => "placebo",
		"state" => "States",
		"country" => "Countries",
		"keyword" => "Keyword",
		"price" => "Price (Only Search v.3)",
		"rooms" => "Rooms",
		"min-land-area" => "Min. Land Area",
		"max-land-area" => "Max. Land Area",
		"garage" => "Garage",
		"year-built" => "Year Built"
		)
	);



$layout = $search_builder['enabled'];

if(empty($layout)) {
	$layout = array();
}
unset($layout['placebo']);

// if(advmls_is_radius_search() != 1) {
// 	unset($layout['geolocation']);
// }

// if(!taxonomy_exists('property_country')) {
//     unset($layout['country']);
// }

// if(!taxonomy_exists('property_state')) {
//     unset($layout['state']);
// }

// if(!taxonomy_exists('property_city')) {
//     unset($layout['city']);
// }

// if(!taxonomy_exists('property_area')) {
//     unset($layout['areas']);
// }

// if(get_option('price_range_halfmap')) {
// 	unset($layout['min-price'], $layout['max-price']);
// }

// if($search_style != 'v3') {
// 	unset($layout['price']);
// }
// $advanced_fields = array_slice($layout, advmls_search_builder_first_row());
$urlSearchResult = mlsUrlFactory::getInstance()->getListingsSearchResultsUrl(true);
?>
<section class="advanced-search advanced-search-half-map">
	<div class="container">
		<form class="advmls-search-form-js advmls-search-filters-js" method="get" autocomplete="off" action="<?php echo esc_url( $urlSearchResult ); ?>">

		<?php do_action('advmls_search_hidden_fields'); ?>

		<div class="d-flex">
			<?php
			if ($layout) {
				$i = 0;
				foreach ($layout as $key=>$value) { $i++;
					$class_flex_grow = '';
					$common_class = "flex-search";
					if($key == 'keyword' && $i == 1 ) {
						$class_flex_grow = 'full-width';

					} elseif($key == 'geolocation' && $i == 1 ) {
						$class_flex_grow = 'geolocation-width';
					} else if($key == 'geolocation') {
						$class_flex_grow = 'flex-grow-1';
					}

						echo '<div class="'.$common_class.' '.$class_flex_grow.'">';
							include_once($pathTemplate.'search/fields/'.$key.'.php');
						echo '</div>';
				
				}
			}
			if(get_option('price_range_halfmap')) { 
				include_once($pathTemplate.'search/fields/currency.php');
			}
			?>
		</div>

		<?php if(get_option('price_range_halfmap')) { ?>
		<div class="d-flex">
			<div class="flex-search-half">
				<?php include_once($pathTemplate.'search/fields/price-range.php'); ?>
			</div>
		</div>
		<?php } ?>

		<div class="half-map-features-list-wrap">
			<?php 
			if(get_option('search_other_features_halfmap')) {
				include_once($pathTemplate.'search/other-features.php');
			}
			?>
		</div><!-- half-map-features-list-wrap -->
		
		<div class="d-flex half-map-buttons-wrap">
			<button type="submit" class="btn btn-search half-map-search-js-btn btn-secondary btn-full-width"><?php echo get_option('srh_btn_search', 'Search'); ?></button>
			<?php #include_once($pathTemplate.'search/save-search-btn.php'); ?>
		</div>
	</form>
	</div><!-- container -->
</section><!-- advanced-search -->