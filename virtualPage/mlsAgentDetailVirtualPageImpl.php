<?php 

/**
 * 
 */
class mlsAgentDetailVirtualPageImpl extends mlsAbstractVirtualPage
{
	
	public function getTitle() {
		return $this->getText(mlsConstants::OPTION_VIRTUAL_PAGE_TITLE_AGENT_DETAIL, "{name}");
	}
	
	public function getPermalink() {
		return $this->getText(mlsConstants::OPTION_VIRTUAL_PAGE_PERMALINK_TEXT_AGENT_DETAIL, "mls-agent");
	}
	
	public function getPageTemplate() {
		return get_option(mlsConstants::OPTION_VIRTUAL_PAGE_TEMPLATE_AGENT_DETAIL, null);
	}

	public function getMetaTags() {
		$default = "<meta name=\"description\" content=\"Photos and Property Details for {pro_alias}. Get complete property information, maps, street view, schools, walk score and more. Request additional information, schedule a showing, save to your property organizer.\" />\n
		<meta name=\"keywords\" content=\"{pro_alias}, Real Estate, Property for Sale\" />";
		return $this->getText(mlsConstants::OPTION_VIRTUAL_PAGE_META_TAGS_AGENT_DETAIL, $default);
	}
	
	public function getAvailableVariables() {
		$variableUtility = mlsVariableUtility::getInstance();
		return array(
			$variableUtility->getAgentName()
		);
	}
	
	public function getContent() {
		global $agent;
		
		$this->remoteResponse = array();
		$this->agentDetail = array();
		
		$agentalias = mlsUtility::getInstance()->getQueryVar("alias");
		
		$queryUrlArr = array(
			"token" => mlsUtility::getInstance()->getActivationToken(),
			"source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl()),
			"agent_alias" => $agentalias,
			"page" => get_query_var( 'paged' ),
		);

		$queryUrl = http_build_query($queryUrlArr);
		$resultAgent = wp_remote_get(getUrlMlsMember().'api/getagentdetail?'.$queryUrl);
		if (is_wp_error($resultAgent)) {
			return;
		}
		$agent = json_decode($resultAgent['body']);
		
		$this->remoteResponse = $agent;
		$this->agentDetail = $agent;

	}

	public function getBody() {

		if (isset($this->agentDetail->error)) {
			ob_start();
			?>
				<div class="alert alert-warning">
					<p class="text-capitalize"><?php echo $this->agentDetail->error_msg ?></p>
				</div>
			<?php
			$agentDetail = ob_get_contents();
			ob_end_clean();
			return $agentDetail;
		}

		if(!isset($this->agentDetail->name) or empty($this->agentDetail->name) ){
			ob_start();
			?>
				<div class="alert alert-warning">
					<span>Agent not Available</span>
				</div>
			<?php
			$detail = ob_get_contents();
			ob_end_clean();
			return $detail;
		}

		$pathTemplate = mlsConstants::ADVANTAGEMLSTPLPATH;
		
		$advmls_agent_sidebar = get_option( 'advmls_agent_sidebar', 0 );

		$properties = isset($this->agentDetail->listings->properties) ? $this->agentDetail->listings->properties : array();
		$pagination = isset($this->agentDetail->listings->pagination) ? $this->agentDetail->listings->pagination : array();
		$agent_listing = get_option( 'advmls_agent_listings', 1 );

		$content_classes = 'col-lg-8 col-md-12 bt-content-wrap';

		if( $advmls_agent_sidebar == 0 ) { 
		    $content_classes = 'col-lg-12 col-md-12';
		}

		$wrap_class = 'listing-v1';
	    $item_layout = 'v1';
	    $view_class = 'list-view';
	    $active_listings_tab = 'active';
	    $active_listings_content = 'show active';

		ob_start();
		?>
		<section class="content-wrap">
		    <div class="container">

		        <div class="agent-profile-wrap">
		            <div class="row">
		                <div class="col-lg-4 col-md-4 col-sm-12">
		                    <div class="agent-image" style="max-width: 350px; max-height: 350px;">
		                        <?php #include($pathTemplate.'agent/image.php'); ?>
		                        <img  src="<?php echo $this->agentDetail->url_photo.$this->agentDetail->photo ?>" class="img-fluid wp-post-image" alt="" loading="lazy" style="max-width: 100%;">
		                    </div><!-- agent-image -->
		                </div><!-- col-lg-4 col-md-4 col-sm-12 -->

		                <div class="col-lg-8 col-md-8 col-sm-12">
		                    <div class="agent-profile-top-wrap">
		                        <div class="agent-profile-header">
		                            <h1><?php echo $this->agentDetail->name; ?></h1>

		                        </div><!-- agent-profile-content -->
		                        <?php include($pathTemplate.'agent/position.php'); ?>
		                    </div><!-- agent-profile-header -->

		                    <div class="agent-profile-content">
		                        <?php include($pathTemplate.'agent/contact-info.php'); ?>
		                        <ul class="list-unstyled">
		                            <?php include($pathTemplate.'agent/social.php'); ?>
		                        </ul>
		                    </div><!-- agent-profile-content -->

		                    <div class="agent-profile-buttons">
		                        
		                        <?php if( get_option('agent_form_agent_page', 1) ) { ?>
		                        <button type="button" class="btn submit" data-toggle="modal" data-target="#realtor-form">
		                            <?php echo esc_html__('Send Email', 'advmls'); ?>  
		                        </button>
		                        <?php } ?>
		                        
		                        <?php if(!empty($agent_number)) { ?>
		                        <a href="tel:<?php echo esc_attr($agent_number_call); ?>">
		                            <button type="button" class="btn btn-call">
		                                <span class="hide-on-click"><?php echo esc_html__('Call', 'advmls'); ?></span>
		                                <span class="show-on-click"><?php echo esc_attr($agent_number); ?></span>
		                            </button>
		                        </a>
		                        <?php } ?>


		                    </div><!-- agent-profile-buttons -->
		                </div><!-- col-lg-8 col-md-8 col-sm-12 -->
		            </div><!-- row -->
		        </div><!-- agent-profile-wrap -->

		        <div class="row">
		            <div class="<?php echo esc_attr($content_classes); ?>">

		                <?php if( !empty($this->agentDetail->bio) ) { ?>
		                <div class="agent-bio-wrap">

		                    <?php echo $this->agentDetail->bio; ?>

		                </div><!-- agent-bio-wrap --> 
		                <?php } ?>
		                
		                <?php if( $agent_listing != 0 and count($properties) > 0 ) { ?>
		                <div id="review-scroll" class="agent-nav-wrap">
		                    <ul class="nav nav-pills nav-justified">
		                        
		                        <?php if( $agent_listing != 0 and count($properties) > 0 ) { ?>
		                        <li class="nav-item">
		                            <a class="nav-link <?php echo esc_attr($active_listings_tab); ?>" href="#tab-properties" data-toggle="pill" role="tab">
		                                <?php esc_html_e('Listings', 'advmls'); ?> (<?php echo esc_attr(count($properties)); ?>)
		                            </a>
		                        </li>
		                        <?php } ?>
		                    </ul>
		                </div><!-- agent-nav-wrap -->
		                
		                <div class="tab-content" id="tab-content">
		                    
		                    <?php if( $agent_listing != 0 and count($properties) > 0 ) { ?>
		                    <div class="tab-pane fade <?php echo esc_attr($active_listings_content); ?>" id="tab-properties">
		                        <div class="listing-tools-wrap">
		                            <div class="d-flex align-items-center">
		                                <div class="listing-tabs flex-grow-1">
		                                    <?php# include($pathTemplate.'agent/listing-tabs.php'); ?> 
		                                </div>
		                            </div><!-- d-flex -->
		                        </div><!-- listing-tools-wrap -->

		                        <section class="listing-wrap <?php echo esc_attr($wrap_class); ?>">
		                            <div class="listing-view <?php echo esc_attr($view_class); ?> card-deck">
		                                <?php
		                                global $property;
						                    if ( count($properties) > 0 ) :

						                        foreach ($properties as $key => $property) {
						                            $currentKey = $key;
						                            include($pathTemplate.'listing/item-'.$item_layout.'.php');
						                        }
						                        ?>
						                        <?php
						                    else:
						                        echo '<div class="search-no-results-found">';
						                            esc_html_e('No results found', 'advmls');
						                        echo '</div>';
						                        
						                    endif;
		                                ?> 
		                            </div><!-- listing-view -->
		                            <?php advmls_pagination( ceil( $pagination->total / $pagination->limit ) ); ?>
		                        </section>
		                    </div><!-- tab-pane -->
		                    <?php } ?>

		                </div><!-- tab-content -->
		                <?php } ?>

		            </div><!-- bt-content-wrap -->

		            <?php if( $advmls_agent_sidebar != 0 ) { ?>
		            <div class="col-lg-4 col-md-12 bt-sidebar-wrap <?php echo esc_attr($is_sticky); ?>">
		                <aside class="sidebar-wrap">
		                    <?php include($pathTemplate.'agent/contact-info.php') ;?> 
		                    <?php 
		                    if (is_active_sidebar('agent-sidebar')) {
		                        dynamic_sidebar('agent-sidebar');
		                    }
		                    ?>
		                </aside>
		            </div><!-- bt-sidebar-wrap -->
		            <?php } ?>
		        </div><!-- row -->
		        <?php include($pathTemplate.'agent/contact-form.php') ;?> 
		    </div><!-- container -->
		</section><!-- listing-wrap -->
		<?php
		$agentDetail = ob_get_contents();
		ob_end_clean();

		return $agentDetail;

	}

	public function getFielProperty($name, $posProperty = 0){
		return $this->agentDetail->listings->properties[$posProperty]->{$name};
	}

	public function getProTitle($posProperty = 0){
		return $this->getFielProperty('pro_name', $posProperty).' - '.$this->getFielProperty('ref', $posProperty);
	}
}

?>