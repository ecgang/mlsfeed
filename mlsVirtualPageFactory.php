<?php

class mlsVirtualPageFactory {

	private static $instance;

	private function __construct() {
	}

	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	//Types used to determine the VirtualPage type in mlsVirtualPageFactory.
	const DEFAULT_PAGE = "idx-default";
	const LISTING_SEARCH_RESULTS = "idx-results";
	const LISTING_DETAIL = "idx-detail";
	const MLS_AGENT_DETAIL = "idx-agent-detail";
	const MLS_PORTAFOLIO_DETAIL = "idx-portafolio-detail";
	
	
	/**
	 * 
	 * @param string $type
	 * @return mlsVirtualPageInterface
	 */
	public function getVirtualPage($virtualPageType) {
		$virtualPage = null;
	
		switch($virtualPageType) {
			case self::DEFAULT_PAGE:
				$virtualPage = new mlsDefaultVirtualPageImpl();
				break;
			case self::LISTING_SEARCH_RESULTS:
				$virtualPage = new mlsSearchResultsVirtualPageImpl();
				break;
			case self::LISTING_DETAIL:
				$virtualPage = new mlsListingDetailVirtualPageImpl();
				break;
			case self::MLS_AGENT_DETAIL:
				$virtualPage = new mlsAgentDetailVirtualPageImpl();
				break;
			case self::MLS_PORTAFOLIO_DETAIL:
				$virtualPage = new mlsPortafolioDetailVirtualPageImpl();
			break;
			
		}
		return $virtualPage;
	}
	
	/**
	 * @param string $name
	 * @return boolean
	 */
	public static function isOrganizerPage($name) {
		$pages = array(
			self::ORGANIZER_LOGIN,
			self::ORGANIZER_LOGOUT,
			self::ORGANIZER_EDIT_SAVED_SEARCH,
			self::ORGANIZER_EDIT_SAVED_SEARCH_SUBMIT,
			self::ORGANIZER_EMAIL_UPDATES_CONFIRMATION,
			self::ORGANIZER_DELETE_SAVED_SEARCH,
			self::ORGANIZER_DELETE_SAVED_SEARCH_SUBMIT,
			self::ORGANIZER_VIEW_SAVED_SEARCH,
			self::ORGANIZER_VIEW_SAVED_SEARCH_LIST,
			self::ORGANIZER_VIEW_SAVED_LISTING_LIST,
			self::ORGANIZER_DELETE_SAVED_LISTING_SUBMIT,
			self::ORGANIZER_RESEND_CONFIRMATION_EMAIL,
			self::ORGANIZER_ACTIVATE_SUBSCRIBER,
			self::ORGANIZER_SEND_SUBSCRIBER_PASSWORD,
			self::ORGANIZER_HELP,
			self::ORGANIZER_EDIT_SUBSCRIBER,
		);
		return array_search($name, $pages) !== false;
	}
	
	public static function isHotSheetPage($name) {
		$pages = array(
			self::HOT_SHEET_LIST,
			self::HOT_SHEET_LISTING_REPORT,
			self::HOT_SHEET_OPEN_HOME_REPORT,
			self::HOT_SHEET_MARKET_REPORT,
		);
		return array_search($name, $pages) !== false;
	}
	
	public static function isEmailAlertsPage($name) {
		$pages = array (
			self::ORGANIZER_EDIT_SAVED_SEARCH,
			self::ORGANIZER_EMAIL_UPDATES_CONFIRMATION,
		);
		return array_search($name, $pages) !== false;
	}
}