<?php
$search_style = get_option('search_style', 'style_1');
$halfmap_search_style = get_option('halfmap_search_layout', 'v1');

$advanced_fields = array(
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
);

$advanced_fields_size = array(
"lotsize_min" => "Min. Lot",
"lotsize_max" => "Max. Lot",
"min-sqft" => "Min. Construction", 
"max-sqft" => "Max. Construction",
"min-land-area" => "Min. Lot",
"max-land-area" => "Max. Lot",
);
?>

<div class="advanced-search-filters search-v1-v2">
	<div class="d-flex">
		<?php
		if ($advanced_fields) {
			foreach ($advanced_fields as $key=>$value) {
				if(in_array($key, advmls_search_builtIn_fields())) {
					echo '<div class="col-md-2 p-0 mr-2">';
						include_once($pathTemplate.'search/fields/'.$key.'.php');
					echo '</div>';
				}
			}
		}
		?>
	</div>

	<div class="d-flex size-input">
		<?php
		if ($advanced_fields_size) {
			foreach ($advanced_fields_size as $key => $value) {
				if(in_array($key, advmls_search_builtIn_fields())) {
					echo '<div class="col-md-3 pl-0">';
						include_once($pathTemplate.'search/fields/'.$key.'.php');
					echo '</div>';
				}
			}
		}
		?>
	</div>

	<?php if( get_option('price_range_search', 1) ) { ?>
	<div class="d-flex size-input">
		<!--<div class="flex-search-full">-->
			<?php #include_once($pathTemplate.'search/fields/price-range.php'); ?>
			<div class="col-md-3 pl-0">
				<?php include_once($pathTemplate.'search/fields/min-price.php'); ?>
			</div>
			<div class="col-md-3 pl-0">
				<?php include_once($pathTemplate.'search/fields/max-price.php'); ?>
			</div>
			<div class="col-md-3 pl-0">
				<?php include_once($pathTemplate.'search/fields/sort-by.php'); ?>
			</div>
		<!--</div>-->
	</div>
	<?php } ?>
</div>

