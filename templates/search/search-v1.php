<?php

$search_builder =array("enabled" => array( "placebo"=> "placebo",
"keyword" => "Keyword",
"type" => "Type",
"status" => "Status",
"state" => "States", 
"city" => "Cities", 
"areas" => "Areas", 

));

$layout = $search_builder['enabled'];
$urlSearchResult = mlsUrlFactory::getInstance()->getListingsSearchResultsUrl(true);
?>
<style type="text/css">
	#desktop-header-search{
		background-color: #fff;
	}
</style>
<section id="desktop-header-search" class="advanced-search mls-advanced-search-nav " >
	<div class="container-fluid">
		<form class="advmls-search-form-js" method="get" autocomplete="off" action="<?php echo $urlSearchResult; ?>">

			<?php do_action('advmls_search_hidden_fields'); ?>
			
			<div class="advanced-search-filters">

				<?php if ($layout['keyword']) { ?>
					<div class="d-flex mb-2">
						<?php	
						$common_class = "flex-search";
						$class_flex_grow = 'flex-grow-1';

						echo '<div class="p-0 '.$common_class.' '.$class_flex_grow.'">';
							include_once($pathTemplate.'search/fields/keyword.php');
						echo '</div>';
						unset($layout['keyword']);
						?>
					</div>
				<?php } ?>

				<div class="d-flex mb-2">
					<?php
					$i = 0;
					if ($layout) {
						foreach ($layout as $key=>$value) { $i ++;
							$class_flex_grow = '';
							$common_class = "col-md-2 p-0 mr-2";
							
							if(in_array($key, advmls_search_builtIn_fields()) and $key != "") {
								
								echo '<div class="'.$common_class.' '.$class_flex_grow.'">';
									include_once($pathTemplate.'search/fields/'.$key.'.php');
								echo '</div>';
							}
						}
					}
					?>
					
				</div><!-- d-flex -->
			</div><!-- advanced-search-v1 -->

			<div id="advanced-search-filters" class="collapse show">
				<?php include_once($pathTemplate.'search/filters.php'); ?>
			</div><!-- advanced-search-filters -->
			<div class="flex-search btn-no-right-padding">
				<?php include_once($pathTemplate.'search/fields/submit-button.php'); ?>
			</div>

		</form>
	</div><!-- container -->
</section><!-- advanced-search -->
