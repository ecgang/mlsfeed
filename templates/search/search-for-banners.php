<?php
$splash_v1_dropdown = 'city';
$banner_search = true;
$checked = true;

$search_tabs = get_option('banner_search_tabs', 0);
$field_name = 'city';

$urlSearchResult = mlsUrlFactory::getInstance()->getListingsSearchResultsUrl(true);
if($banner_search) { ?>
<form class="advmls-search-form-js" method="get" autocomplete="off" action="<?=$urlSearchResult?>">
	

	<div class="search-banner-wrap">
		
		<div class="d-flex flex-sm-max-column">
			
			<div class="flex-search">
				<?php include($pathTemplate.'search/fields/type.php'); ?>
			</div>
			
			<div class="flex-search">
				<?php include($pathTemplate.'search/fields/'.$field_name.'.php'); ?>
			</div>
			
			<div class="flex-grow-1 flex-search">
				<?php include_once($pathTemplate.'search/fields/keyword-banner.php'); ?>
			</div>
			
			<div class="flex-search">
				<?php include($pathTemplate.'search/fields/submit-button.php'); ?>
			</div>
		</div>
		
	</div>
	<?php 
	if( $search_tabs != 0 ) {
		include_once($pathTemplate.'search/fields/status-tabs.php');
	}
	?>
</form>
<?php } ?>