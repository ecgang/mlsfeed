<?php

/**
 *
 * Singleton implementation of mlsRewriteRules
 *
 * All mls requests are directed to the $rootPageName, which tries to load a wordpress page that
 * does not exist. We do not want to load a real page. We get the content from the mls services
 * and display it as a virtual Wordpress post.
 *
 * The rewrite rules below set a variable mlsConstants::IHF_TYPE_URL_VAR that is used to determine
 * which VirtualPage retrieves the content from mls
 *
 * @author mls
 *
 */
class mlsRewriteRules {

	private static $instance;
	private $urlFactory;
	private $rootPageName;

	private function __construct() {
		$this->rootPageName = "index.php?pagename=non_existent_page";
	}

	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function initialize() {

		$this->addQueryVar(mlsConstants::MLS_TYPE_URL_VAR);
		$this->initRewriteRules();
		$this->flushRules();
	}

	public function flushRules() {
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}
	
	/**
	 * Function to initialize rewrite rules for the IHF plugin.
	 *
	 * During development we initialize and flush the rules often, but
	 * this should only be performed when the plugin is registered.
	 *
	 * We need to map certain URL patters ot an internal ihf page
	 * Once requests are routed to that page, we can handle different
	 * behavior in functions that listen for updates on that page.
	 */
	private function initRewriteRules() {
		$this->setRewriteRules("");
		//set the rules again, to support almost pretty permalinks
		$this->setRewriteRules("index.php/");
	}
	
	/**
	 * @param string $type
	 * @param string $pattern
	 */
	private function addRule($type, $pattern) {
		$matches = array();
		preg_match_all("/\{(.*?)\}/", $pattern, $matches);
		$matches = $matches[1];
		$regex = $pattern;
		$redirect = $this->rootPageName . "&" . mlsConstants::MLS_TYPE_URL_VAR . "=" . $type;
		
		foreach($matches as $key => $value) {
			$key += 1;
			if(!empty($value)) {
				$regex = str_replace("{" . $value . "}", "([^/]+)", $regex);
				$redirect .= "&" . $value . "=\$matches[" . $key . "]";
				$this->addQueryVar($value);
			}
		}
		//anchor regex to prevent matching permalink contained in another permalink (ex. home-for-sale and home-for-sale-)
		$regex = "^" . $regex . "$";
		//$this->logger->debug("just added rewrite rule: " . $regex . $redirect);
		add_rewrite_rule($regex, $redirect, "top");
	}

	/**
	 * WordPress reserves some names (name, term, page) in /wp-includes/class-wp.php
	 * ($public_query_vars, $private_query_vars) that should not be used
	 * 
	 * @param string $name
	 */
	private function addQueryVar($name) {
		global $wp;
		$wp->add_query_var($name);
		//$this->logger->debug("just added query var: " . $name);
	}
	
	/**
	 * Note: The order of these search rules is important. The match will pick
	 * the first page it finds that matches any of the first few selected characters.
	
	 * For example:
	 * listing-search
	 * listing-search-results
	
	 * When "listing-search-results" is selected, the "listing-search" may be
	 * returned instead. If you encounter this problem, a simple fix is to change
	 * the first few characters of the problem page to something unique.
	 * 
	 * @param string $matchRulePrefix
	 * @return void
	 */
	private function setRewriteRules($matchRulePrefix) {
		$urlFactory = mlsUrlFactory::getInstance();
		
		$this->addRule(
			mlsVirtualPageFactory::LISTING_DETAIL,
			$matchRulePrefix . $urlFactory->getListingDetailUrl(false)."/{category_name}/{pro_alias}"
		);
		// Search Result
		$this->addRule(
			mlsVirtualPageFactory::LISTING_SEARCH_RESULTS,
			$matchRulePrefix . $urlFactory->getListingsSearchResultsUrl(false)
		);
		// Pagination search result
		$this->addRule(
			mlsVirtualPageFactory::LISTING_SEARCH_RESULTS,
			$matchRulePrefix . $urlFactory->getListingsSearchResultsUrl(false)."/page/{paged}"
		);
		// Agent Detail
		$this->addRule(
			mlsVirtualPageFactory::MLS_AGENT_DETAIL,
			$matchRulePrefix . $urlFactory->getAgentDetailUrl(false)."/{alias}"
		);
		// Agent Detail Pagination
		$this->addRule(
			mlsVirtualPageFactory::MLS_AGENT_DETAIL,
			$matchRulePrefix . $urlFactory->getAgentDetailUrl(false)."/{alias}/page/{paged}"
		);
		// Portafolio Details
		$this->addRule(
			mlsVirtualPageFactory::MLS_PORTAFOLIO_DETAIL,
			$matchRulePrefix . $urlFactory->getPortafolioDetailUrl(false)."/{portafolio-alias}"
		);
	}
	
}