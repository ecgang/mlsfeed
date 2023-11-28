<?php

class mlsUrlFactory {
	
	private static $instance;
	private $virtualPageFactory;

	private function __construct() {
		$this->virtualPageFactory = mlsVirtualPageFactory::getInstance();
	}

	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Gets the base URL for this blog
	 */
	public function getBaseUrl() {
		return home_url();
	}

	/**
	 * This is a Wordpress standard for AJAX handling.
	 */
	public function getAjaxBaseUrl() {
		return admin_url("admin-ajax.php");
	}
	
	private function prependBaseUrl($permalink, $includeBaseUrl) {
		$result = $permalink;
		if($includeBaseUrl) {
			$result = $this->getBaseUrl() . "/" . $result . "/";
		}
		return $result;
	}
	
	public function getListingDetailUrl($includeBaseUrl = true) {
		$virtualPage = $this->virtualPageFactory->getVirtualPage(mlsVirtualPageFactory::LISTING_DETAIL);
		$permalink = $virtualPage->getPermalink();
		$result = $this->prependBaseUrl($permalink, $includeBaseUrl);
		return $result;
	}
	
	public function getListingsSearchResultsUrl($includeBaseUrl = true) {
		$virtualPage = $this->virtualPageFactory->getVirtualPage(mlsVirtualPageFactory::LISTING_SEARCH_RESULTS);
		$permalink = $virtualPage->getPermalink();
		$result = $this->prependBaseUrl($permalink, $includeBaseUrl);
		return $result;
	}

	public function getAgentDetailUrl($includeBaseUrl = true) {
		$virtualPage = $this->virtualPageFactory->getVirtualPage(mlsVirtualPageFactory::MLS_AGENT_DETAIL);
		$permalink = $virtualPage->getPermalink();
		$result = $this->prependBaseUrl($permalink, $includeBaseUrl);
		return $result;
	}

	public function getPortafolioDetailUrl($includeBaseUrl = true) {
		$virtualPage = $this->virtualPageFactory->getVirtualPage(mlsVirtualPageFactory::MLS_PORTAFOLIO_DETAIL);
		$permalink = $virtualPage->getPermalink();
		$result = $this->prependBaseUrl($permalink, $includeBaseUrl);
		return $result;
	}
	
}