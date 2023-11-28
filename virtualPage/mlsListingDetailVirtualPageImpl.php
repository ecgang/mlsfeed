<?php

class mlsListingDetailVirtualPageImpl extends mlsAbstractVirtualPage {
	
	public function getTitle() {
		return $this->getText(mlsConstants::OPTION_VIRTUAL_PAGE_TITLE_DETAIL, "{pro_name} {ref}");
	}
	
	public function getPermalink() {
		return $this->getText(mlsConstants::OPTION_VIRTUAL_PAGE_PERMALINK_TEXT_DETAIL, "listing-details");
	}
	
	public function getPageTemplate() {
		return get_option(mlsConstants::OPTION_VIRTUAL_PAGE_TEMPLATE_DETAIL, null);
	}
	
	public function getMetaTags() {
		$default = "<meta property=\"og:image\" content=\"{listingPhotoUrl}\" />\n<meta property=\"og:image:width\" content=\"{listingPhotoWidth}\" />\n<meta property=\"og:image:height\" content=\"{listingPhotoHeight}\" />\n<meta name=\"description\" content=\"Property Details for {pro_name}. Get complete property information, maps. Request additional information, schedule a showing, save to your property organizer.\" />\n<meta name=\"keywords\" content=\"{pro_name}, Real Estate, Property for Sale\" />";
		return $this->getText(mlsConstants::OPTION_VIRTUAL_PAGE_META_TAGS_DETAIL, $default);
	}
	
	public function getAvailableVariables() {
		$variableUtility = mlsVariableUtility::getInstance();
		return array(
			$variableUtility->getProAlias(),
			$variableUtility->getProRef()
		);
	}
	
	public function getContent() {

		$this->remoteResponse = array();
		$this->proDetails = array();

		$category_name = mlsUtility::getInstance()->getQueryVar("category_name");
		$pro_alias = mlsUtility::getInstance()->getQueryVar("pro_alias");
		
		$queryUrlArr = array(
			"token" => mlsUtility::getInstance()->getActivationToken(),
			"source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl()),
			"pro_alias" => $pro_alias
		);
		$queryUrl = http_build_query($queryUrlArr);
		#echo getUrlMlsMember().'api/getpropertydetails?'.$queryUrl;
		$resultProDetails = wp_remote_get(getUrlMlsMember().'api/getpropertydetails?'.$queryUrl);

		if (is_wp_error($resultProDetails)) {
			return;
		}
		$proDetails = json_decode($resultProDetails['body']);

		$this->remoteResponse = $proDetails;
		$this->proDetails = $proDetails;
		
	}
	
	/**
	 * same code in sold detail
	 */
	public function getBody() {
		if (isset($this->proDetails->error)) {
			ob_start();
			?>
				<div class="alert alert-warning">
					<p class="text-capitalize"><?php echo $this->proDetails->error_msg ?></p>
				</div>
			<?php
			$proDetails = ob_get_contents();
			ob_end_clean();
			return $proDetails;
		}

		if(!isset($this->proDetails->ref) or empty($this->proDetails->ref) ){
			ob_start();
			?>
				<div class="alert alert-warning">
					<span>Property not Available</span>
				</div>
			<?php
			$detail = ob_get_contents();
			ob_end_clean();
			return $detail;
		}
		$wioListing = false;
		#v3, v6
		$top_area = get_option('advmls-top-area','v3');
		#1,0
		$is_full_width = get_option('advmls_is_full_width',0);
		#simple, tabs, tabs-vertical
		$property_layout = get_option('advmls-content-layout','simple');

		$agent_form = get_option('advmls_agent_form',0);

		$prop_detail_nav = "";
		if($is_full_width == 1) {
    		$content_classes = 'col-lg-12 col-md-12 bt-full-width-content-wrap';
		} else {
		    $content_classes = 'col-lg-8 col-md-12 bt-content-wrap';
		}

		$is_sticky = "advmls_sticky";
		$pathTemplate = mlsConstants::ADVANTAGEMLSTPLPATH;

		$bgcolor_detail = get_option('advmls_bgcolor_detail','#ffffff');
		$color_detail = get_option('advmls_color_detail','#6e6d76');

		$layout = array("enabled"=>array("overview" => "Overview", "description"=>"Description", "open_house" => "Open House", "address" => "Address", "details" => "Details", "features" => "Features", "video" => "Video" ));

		wp_register_script('lightslider', ADVMLS_JS_DIR_URI. 'vendors/lightslider.min.js', array('jquery'), '1.1.3', true);
		wp_enqueue_style('lightslider', ADVMLS_CSS_DIR_URI . 'lightslider.css', array(), '1.1.3');
		wp_enqueue_script('lightslider');
		wp_enqueue_script('lightbox', ADVMLS_JS_DIR_URI. 'vendors/lightbox.min.js', array('jquery'), '2.3.7', true);

		#get_header();
		ob_start();
		?>
		<style>
			.page-title-wrap, .property-banner, .property-overview-data, .block-wrap{
				background-color: <?php echo $bgcolor_detail; ?> !important;
			}
			.page-title-wrap, .page-title-wrap h1, .property-banner, .property-overview-data, .block-wrap, .item-price-wrap .item-price, .item-address, .block-wrap h2{
				color: <?php echo $color_detail; ?> !important;
			}

			.page-title-wrap .item-tool span{
				color: <?php echo $color_detail; ?> !important;
    			border: 1px solid <?php echo $color_detail; ?> !important;
			}
		</style>
		<section class="content-wrap property-wrap property-detail-<?php echo esc_attr($top_area); ?> alignfull">
		    <?php 
		    include_once($pathTemplate.'property-details/navigation.php'); 

		    if($top_area != 'v5' && $top_area != 'v2') {
		        include($pathTemplate.'property-details/property-title.php'); 
		    }

			if( ($top_area == 'v3' || $top_area == 'v4') && $property_layout == 'v2' ) {
		        echo '<div class="container">';
		        
		        include_once($pathTemplate.'property-details/top-area-v3-4.php');
		        echo '</div>';

		    } elseif($top_area == 'v6') {
		        include_once($pathTemplate.'property-details/top-area-v6.php');
		    }

		        
		    if( $property_layout == 'v2' ) { ?>
		        
		        <div class="property-view full-width-property-view">
		            <?php include_once($pathTemplate.'property-details/mobile-view.php'); ?>
		            <?php include_once($pathTemplate.'property-details/single-property-luxury-homes.php'); ?>
		        </div>

		        <?php if( !empty($global_disclaimer) && $enable_disclaimer ) { ?>
		        <div class="property-disclaimer">
		            <?php echo $global_disclaimer; ?>
		        </div>
		        <?php } ?>

		    <?php } else { ?>

		    <div class="container">
		        <?php
		        if($top_area == 'v4') {
		            include_once($pathTemplate.'property-details/top-area-v3-4.php');
		        } 
		        ?>
		        <div class="row">
		            <div class="<?php echo esc_attr($content_classes); ?>">
		                <?php
		                if($top_area == 'v3') {
		                    include_once($pathTemplate.'property-details/top-area-v3-4.php');
		                } 
		                ?>                   
		                <div class="property-view">

		                    <?php include_once($pathTemplate.'property-details/mobile-view.php'); ?>

		                    <?php
		                    if( $property_layout == 'tabs' ) {
		                        include_once($pathTemplate.'property-details/single-property-tabs.php');
		                    } else if( $property_layout == 'tabs-vertical' ) {
		                        include_once($pathTemplate.'property-details/single-property-tabs-vertical.php');
		                    } else {
		                        include_once($pathTemplate.'property-details/single-property-simple.php');
		                    }
		                    ?>
		                    
		                </div><!-- property-view -->
		            </div><!-- bt-content-wrap -->

		            <?php if($is_full_width != 1) { ?>
		            <div class="col-lg-4 col-md-12 bt-sidebar-wrap <?php echo esc_attr($is_sticky); ?>">
		                <?php include_once($pathTemplate.'sidebar-property.php'); ?>

		            </div><!-- bt-sidebar-wrap -->
		            <?php } ?>
		            <?php 
		            if( $agent_form == 1 and $is_full_width == 1) {
				        include($pathTemplate.'property-details/agent-form-bottom.php' );
				    }
				    ?>

		        </div><!-- row -->

		        <?php if( !empty($global_disclaimer) && $enable_disclaimer ) { ?>
		        <div class="property-disclaimer">
		            <?php echo $global_disclaimer; ?>
		        </div>
		        <?php } ?>

		    </div><!-- container -->

			<?php } ?>
		</section><!-- listing-wrap -->    
		<?php include_once($pathTemplate.'property-details/lightbox.php'); ?>

		<?php
		$detail = ob_get_contents();
		ob_end_clean();
		
		// $wArray = array("pool","artistry","Cons.","Phone");
		// $words = "pool|artistry|Cons.|Phone";

		// $detail = preg_replace_callback('#(.*?'.$words.'.*?.*)#', function($matches) use ($wArray){

		// 	$wordsOriginArray = mlsListingDetailVirtualPageImpl::wrap_implode($wArray, '/', '/');
		// 	$wordsDestinArray = mlsListingDetailVirtualPageImpl::wrap_implode($wArray, '<span class="notranslate"> ', ' </span>');

		// 	$strNotAllowed = array("href=",">","</","src=");

		// 	if( !strpos($matches[0], "href=") and !strpos($matches[0], "src=") and !strpos($matches[0], "\">") and !strpos($matches[0], "</") ){
		// 		$t = preg_replace($wordsOriginArray, $wordsDestinArray, $matches[0]);
		//   		return $t;
		// 	}else{
		// 		return $matches[0];
		// 	}
			
		// }, $detail);
		return $detail;
	}

	public function wrap_implode( $array, $before = '', $after = '', $separator = '' ){
		if( ! $array )  return '';
		$result = array();
		for ($i=0; $i < count($array); $i++) { 
			$result[] = $before . $array[$i] . $after;
		}
		return $result;
	}

	public function getDataDetails($name){
		return isset($this->proDetails->{$name}) ? $this->proDetails->{$name} : null;
	}

	public function getProTitle(){
		return 'MLS ID: '.$this->getDataDetails('ref').' - '.$this->getDataDetails('pro_name');
	}
	
}
