<?php

class mlsPortafolioDetailVirtualPageImpl extends mlsAbstractVirtualPage {

	protected $remoteResponse;
	
	public function getTitle() {
		return $this->getText(mlsConstants::OPTION_VIRTUAL_PAGE_TITLE_PORTAFOLIO, "Portafolio");
	}
	
	public function getPermalink() {
		return $this->getText(mlsConstants::OPTION_VIRTUAL_PAGE_PERMALINK_TEXT_PORTAFOLIO, "mls-portafolio");
	}
	
	public function getPageTemplate() {
		return get_option(mlsConstants::OPTION_VIRTUAL_PAGE_PORTAFOLIO, null);
	}
	
	public function getMetaTags() {
		$default = "";
		return $this->getText(mlsConstants::OPTION_VIRTUAL_PAGE_META_TAGS_PORTAFOLIO, $default);
	}
	
	public function getAvailableVariables() {
		$variableUtility = mlsVariableUtility::getInstance();
		return array(
			$variableUtility->getPortafolioName()
		);
	}
	
	public function getContent() {
		$resPortafolioDetails;
		$alias = mlsUtility::getInstance()->getQueryVar("portafolio-alias");
		
		$queryUrlArr = array(
			"token" => mlsUtility::getInstance()->getActivationToken(),
			"source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl()),
			"alias" => $alias
		);
		$queryUrl = http_build_query($queryUrlArr);
		
		$resPortafolioDetails = wp_remote_get(getUrlMlsMember().'api/getportafoliodetail?'.$queryUrl);

		if (is_wp_error($resPortafolioDetails) and !isset($resPortafolioDetails['body'])) {
			return false;
		}

		$portafolioDetails = json_decode($resPortafolioDetails['body']);

		$this->remoteResponse = $portafolioDetails;

	}
	
	/**
	 * same code in sold detail
	 */
	public function getBody() {

		wp_enqueue_style('advmls-bookblock', ADVMLS_CSS_DIR_URI . 'vendors/catalogo/bookblock.css', array(), ADVMLS_PLUGIN_VERSION);
		wp_enqueue_style('advmls-catalogo-default', ADVMLS_CSS_DIR_URI . 'vendors/catalogo/default.css', array(), ADVMLS_PLUGIN_VERSION);
		wp_enqueue_style('advmls-catalogo-demo4', ADVMLS_CSS_DIR_URI . 'vendors/catalogo/demo4.css', array(), ADVMLS_PLUGIN_VERSION);

		wp_enqueue_script('advmls-modernizr', ADVMLS_JS_DIR_URI. 'vendors/catalogo/modernizr.custom.js', array('jquery'), ADVMLS_PLUGIN_VERSION, true);
		wp_enqueue_script('advmls-bookblock', ADVMLS_JS_DIR_URI. 'vendors/catalogo/jquery.bookblock.js', array('modernizr'), ADVMLS_PLUGIN_VERSION, true);
		wp_enqueue_script('advmls-jquerypp', ADVMLS_JS_DIR_URI. 'vendors/catalogo/jquerypp.custom.js', array('jquery'), ADVMLS_PLUGIN_VERSION, true);

		$pathTemplate = mlsConstants::ADVANTAGEMLSTPLPATH;
		$pre_title = "Listing Chosen for";

		$item_layout = 'v1'; // config catalago
		$listing_view = 'grid-view-v1'; // config catalago
		ob_start();

		$howsee = isset($this->remoteResponse->data->howsee) ? $this->remoteResponse->data->howsee : 'catalogo';
		
			if($howsee == 'catalogo'){
				?>	
				<script>
				jQuery(document).ready(function($){
					var Page = (function() {
						var config = {
								$bookBlock : $( '#bb-bookblock' ),
								$navNext : $( '#bb-nav-next' ),
								$navPrev : $( '#bb-nav-prev' ),
								$navFirst : $( '#bb-nav-first' ),
								$navLast : $( '#bb-nav-last' )
							},
							init = function() {
								config.$bookBlock.bookblock( {
									speed : 1000,
									shadowSides : 0.8,
									shadowFlip : 0.1	,
									orientation : 'vertical'
								} );
								initEvents();
							},
							initEvents = function() {
								
								var $slides = config.$bookBlock.children();

								// add navigation events
								config.$navNext.on( 'click touchstart', function() {
									config.$bookBlock.bookblock( 'next' );
									return false;
								} );

								config.$navPrev.on( 'click touchstart', function() {
									config.$bookBlock.bookblock( 'prev' );
									return false;
								} );

								config.$navFirst.on( 'click touchstart', function() {
									config.$bookBlock.bookblock( 'first' );
									return false;
								} );

								config.$navLast.on( 'click touchstart', function() {
									config.$bookBlock.bookblock( 'last' );
									return false;
								} );
								
								// add swipe events
								$slides.on( {
									'swipeleft' : function( event ) {
										config.$bookBlock.bookblock( 'next' );
										return false;
									},
									'swiperight' : function( event ) {
										config.$bookBlock.bookblock( 'prev' );
										return false;
									}
								} );

								// add keyboard events
								$( document ).keydown( function(e) {
									var keyCode = e.keyCode || e.which,
										arrow = {
											left : 37,
											up : 38,
											right : 39,
											down : 40
										};

									switch (keyCode) {
										case arrow.left:
											config.$bookBlock.bookblock( 'prev' );
											break;
										case arrow.right:
											config.$bookBlock.bookblock( 'next' );
											break;
									}
								} );
							};
							return { init : init };
					})();
					Page.init();
				});
				</script>
				<style>
					.bb-custom-side .item-price-wrap{
						bottom: 0px !important;
						left: 0px !important;
						font-weight: 500;
					}
					.card-portafolio p.small-desc.text-capitalize {
						display: none;
					}

					.card-portafolio .item-listing-wrap.hz-item-gallery-js.card {
						width: 90% !important;
						flex-basis: 90% !important;
					}
				</style>
				<div class="page-title-wrap">
					<div class="d-flex align-items-center">
						<div class="page-title flex-grow-1 text-center">
							<h1 class="portafolio-title h1 text-capitalize"><?php echo $pre_title ?> <?php echo isset($this->remoteResponse->data->name) ? $this->remoteResponse->data->name : '' ?></h1>
						</div><!-- page-title -->
					</div><!-- d-flex --> 
				</div><!-- page-title-wrap -->
					<div class="alignfull">
						<div class="bb-custom-wrapper bb-wrapper-<?php echo wp_is_mobile() ? 'mobile' : '' ?>">
							<div id="bb-bookblock" class="bb-bookblock">
								<?php 
								global $property;
								$properties = isset($this->remoteResponse->properties) ? $this->remoteResponse->properties : array() ;
								
								for ($po=0; $po < count($properties); $po++) { 
									$currentKey = $po;
									?>
									<?php if(wp_is_mobile()){ ?>
										<div class="bb-item">
											<div class="listing-view grid-view card-portafolio">
												<?php include($pathTemplate.'listing/item-v1.php'); ?>
											</div>
										</div>
									<?php }else{ ?>
										<?php 
											$property = $properties[$po]; 
											$po = $po + 1;
										?>
										<div class="bb-item">
											<div class="bb-custom-side">
												<div class="listing-view grid-view card-portafolio">
													<?php include($pathTemplate.'listing/item-v1.php'); ?>
												</div>		
											</div>
											<div class="bb-custom-side">
												<?php 
													$currentKey = $po;
													$property = $properties[$po];
												?>
												<div class="listing-view grid-view card-portafolio">
													<?php include($pathTemplate.'listing/item-v1.php'); ?>
												</div>
											</div>

										</div>
									<?php } ?>

								<?php } ?>

							</div>

							<nav>
								<a id="bb-nav-first" href="#" class=""><i class="fas fa-angle-double-left"></i> </a>
								<a id="bb-nav-prev" href="#" class=""><i class="fas fa-angle-left"></i></a>
								<a id="bb-nav-next" href="#" class=""><i class="fas fa-angle-right"></i></a>
								<a id="bb-nav-last" href="#" class=""><i class="fas fa-angle-double-right"></i></a>
							</nav>

						</div>
					</div><!-- /container -->
			<?php
			}

			if($howsee == 'list'){
				$item_layout = 'v1'; // config catalago
				$listing_view = 'list-view-v1'; // config catalago
				$content_classes = 'col-lg-12 col-md-12';
				$wrap_class = 'listing-v1';
				$view_class = 'list-view';
				$cols_in_row = 'grid-view-3-cols';

				$properties = isset($this->remoteResponse->properties) ? $this->remoteResponse->properties : array() ;
				?>
				<section class="listing-wrap <?php echo esc_attr($wrap_class); ?>">
	    			<div class="container">
				        <div class="page-title-wrap">

				            <div class="d-flex align-items-center">
				                <div class="page-title flex-grow-1 text-center">
				                    <h1 class="portafolio-title h1 text-capitalize"><?php echo $pre_title ?> <?php echo isset($this->remoteResponse->data->name) ? $this->remoteResponse->data->name : '' ?></h1>
				                </div><!-- page-title -->
				            </div><!-- d-flex -->  

				        </div><!-- page-title-wrap -->
	    				<div class="row">
	            			<div class="<?php echo esc_attr($content_classes); ?>">
	            				<div class="listing-view <?php echo esc_attr($view_class).' '.esc_attr($cols_in_row); ?> card-deck">
									<?php
									for ($po=0; $po < count($properties); $po++) { 
										$portafolio = $properties[$po];
										$currentKey = $po;

										include($pathTemplate.'listing/item-'.$item_layout.'.php');
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</section>
				<?php
			}

		$body = ob_get_contents();
		ob_end_clean();
		return $body;

	}

	public function getFielProperty($name, $posProperty = 0){
		return isset($this->remoteResponse->properties[$posProperty]->{$name}) ? $this->remoteResponse->properties[$posProperty]->{$name} : '';
	}

	public function getProTitle($posProperty = 0){
		return $this->getFielProperty('pro_name', $posProperty).' - '.$this->getFielProperty('ref', $posProperty);
	}
	
}