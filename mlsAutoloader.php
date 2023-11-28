<?php

/**
 * autoloads mls classes
 */
class mlsAutoloader {
	
	private static $instance;
	
	/*
	 * we store an array indexed by class name of class paths instead of using a PSR-4 autoloader
	 * because we want to support versions of PHP that don't support namespacing
	 */
	private $classes = array(
		//core files
		"mlsUtility" => "mlsUtility.php",
		"mlsConstants" => "mlsConstants.php",
		"mlsRewriteRules" => "mlsRewriteRules.php",
		"mlsVirtualPageDispatcher" => "mlsVirtualPageDispatcher.php",
		"mlsVirtualPageFactory" => "mlsVirtualPageFactory.php",
		"mlsRequestor" => "mlsRequestor.php",
		"mlsUrlFactory" => "mlsUrlFactory.php",
		"mlsVariableUtility" => "mlsVariableUtility.php",
		"mlsVariable" => "mlsVariable.php",

		//widgets
		"mlsListAgentsWidget" => "widget/mlsListAgentsWidget.php",
		"mlsAdvanceSearchWidget" => "widget/mlsAdvanceSearchWidget.php",
		"mlsSlideShowWidget" => "widget/mlsSlideShowWidget.php",
		"mlsShowListPropertiesWidget" => "widget/mlsShowListPropertiesWidget.php",
		"mlsShowFeaturesPropertiesWidget" => "widget/mlsShowFeaturesPropertiesWidget.php",
		"mlsContactFormWidget" => "widget/mlsContactFormWidget.php",
		"mlsCompanyInfoWidget" => "widget/mlsCompanyInfoWidget.php",
		"mlsGoogleMapsWidget" => "widget/mls-google-maps.php",
		"mlsRecentPostsWidget" => "widget/mlsRecentPostsWidget.php",
		"mlsShowPropertiesVideosWidget" => "widget/mlsShowPropertiesVideosWidget.php",
		
		//virtual pages
		"mlsListingDetailVirtualPageImpl" => "virtualPage/mlsListingDetailVirtualPageImpl.php" ,
		"mlsAbstractVirtualPage" => "virtualPage/mlsAbstractVirtualPage.php",
		"mlsVirtualPageInterface" => "virtualPage/mlsVirtualPageInterface.php",
		"mlsDefaultVirtualPageImpl" => "virtualPage/mlsDefaultVirtualPageImpl.php",
		"mlsSearchResultsVirtualPageImpl" => "virtualPage/mlsSearchResultsVirtualPageImpl.php",
		"mlsAgentDetailVirtualPageImpl" => "virtualPage/mlsAgentDetailVirtualPageImpl.php",
		"mlsPortafolioDetailVirtualPageImpl" => "virtualPage/mlsPortafolioVirtualPageImpl.php",
		
		//mls portal pages
		
		//admin pages
		"mlsAdminActivate" => "adminpage/mlsAdminActivate.php",
		"mlsAdminSettings" => "adminpage/mlsAdminSettings.php",
		"mlsAdminSettingsDetails" => "adminpage/mlsAdminSettingsDetails.php",

	);
	
	private function __construct() {
		spl_autoload_register(array($this, "load"));
	}
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function load($className) {
		if(array_key_exists($className, $this->classes)) {
			include $this->classes[$className];
		}
	}
	
}