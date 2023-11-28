<?php

$search_builder =array("enabled" => array(
	"keyword" => "Keyword",
	"type" => "Type",
	"status" => "Status",
	"city" => "City",
	"min-price" => "Min. Price", 
	"max-price" => "Max. Price", 
));

$enabledFields = (array)get_option('advmls_quicksearch', array());

if ( isset($enabledFields['enabled']) and count($enabledFields['enabled']) > 0 ) {
	$search_builder = $enabledFields;
}

$layout = $search_builder['enabled'];
$urlSearchResult = mlsUrlFactory::getInstance()->getListingsSearchResultsUrl(true);
?>
<section id="desktop-header-search" class="advanced-search mls-advanced-search-nav " >
	<div class="container-fluid">
		<form class="advmls-search-form-js" method="get" autocomplete="off" action="<?php echo $urlSearchResult; ?>">
			<div class="advanced-search-filters">
				<div class="d-flex justify-content-between">
				<?php if ($layout['keyword']) { ?>
					<div class="col-md-4 p-0">
						<?php	
						$common_class = "flex-search";
						$class_flex_grow = 'flex-grow-1';
						
							include_once($pathTemplate.'search/fields/keyword.php');

						unset($layout['keyword']);
						?>
					</div>
				<?php } ?>

					<?php
					$i = 0;
					if ($layout) {
						foreach ($layout as $key=>$value) { $i ++;
							$class_flex_grow = '';
							$common_class = "col-md-1 p-0";
							
							if(in_array($key, advmls_search_builtIn_fields()) and $key != "") {
								
								echo '<div class="'.$common_class.' '.$class_flex_grow.'">';
									include_once($pathTemplate.'search/fields/'.$key.'.php');
								echo '</div>';
							}
						}
					}
					?>
				<div class="col-md-2 p-0">
					<?php include_once($pathTemplate.'search/fields/submit-button.php'); ?>
				</div>
				</div><!-- d-flex -->
			</div><!-- advanced-search-v1 -->

		</form>
	</div><!-- container -->
</section><!-- advanced-search -->