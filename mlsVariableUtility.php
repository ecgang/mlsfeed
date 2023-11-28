<?php

class mlsVariableUtility {
	
	private static $instance;
	
	private function __construct() {
	}
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * @param string $input
	 * @param array<mlsVariable> $variables
	 * @return string
	 */
	public function replaceVariable($input, array $variables) {
		$result = $input;

		if(is_array($variables)) {
			foreach($variables as $variable) {
				if(is_a($variable, "mlsVariable")) {
					$result = str_replace($variable->getNameWithAffix(), $variable->getValue(), $result);
				}
			}
		}
		return $result;
	}
	
	/**
	 * @param array<mlsVariable> $variables
	 * @return array
	 */
	public function getAffixedArray($variables) {
		$result = array();
		foreach($variables as $variable) {
			$result[] = array(
				"name" => $variable->getNameWithAffix(),
				"value" => $variable->getValue(),
				"description" => $variable->getDescription(),
			);
		}
		return $result;
	}

	public function getProAlias(){
		return new mlsVariable("pro_name", null, "Property Alias");
	}
	
	public function getProRef(){
		return new mlsVariable("ref", null, "Property Ref");
	}
	
	public function getAgentName() {
		return new mlsVariable("name", null, "Agent Name");
	}

	public function getListingAddress() {
		return new mlsVariable("listingAddress", null, "Listing Address");
	}
	
	public function getListingCity() {
		return new mlsVariable("listingCity", null, "Listing City");
	}
	
	public function getListingPostalCode() {
		return new mlsVariable("listingPostalCode", null, "Listing Postal Code");
	}
	
	public function getListingPhotoUrl() {
		return new mlsVariable("listingPhotoUrl", null, "Listing Photo URL");
	}
	
	public function getListingPhotoWidth() {
		return new mlsVariable("listingPhotoWidth", null, "Listing Photo Width");
	}
	
	public function getListingPhotoHeight() {
		return new mlsVariable("listingPhotoHeight", null, "Listing Photo Height");
	}
	
	public function getListingPrice() {
		return new mlsVariable("listingPrice", null, "Listing Price");
	}
	
	public function getListingSoldPrice() {
		return new mlsVariable("listingSoldPrice", null, "Listing Sold Price");
	}
	
	public function getListingSquareFeet() {
		return new mlsVariable("listingSquareFeet", null, "Listing Square Feet");
	}
	
	public function getListingBedrooms() {
		return new mlsVariable("listingBedrooms", null, "Listing # of Bedrooms");
	}
	
	public function getListingBathrooms() {
		return new mlsVariable("listingBathrooms", null, "Listing # of Bathrooms");
	}
	
	public function getListingNumber() {
		return new mlsVariable("listingNumber", null, "Listing Number");
	}
	
	public function getListingDescription() {
		return new mlsVariable("listingDescription", null, "Listing Description");
	}
	
	public function getSavedSearchId() {
		return new mlsVariable("savedSearchId", null, "Market ID");
	}
	
	public function getSavedSearchName() {
		return new mlsVariable("savedSearchName", null, "Market Name" );
	}
	
	public function getSavedSearchDescription() {
		return new mlsVariable("savedSearchDescription", null, "Market Description");
	}
	
	public function getAgentId() {
		return new mlsVariable("agentId", null, "Agent ID");
	}
	
	public function getAgentDesignation() {
		return new mlsVariable("agentDesignation", null, "Agent Designation");
	}
	
	public function getOfficeId() {
		return new mlsVariable("officeId", null, "Office ID");
	}
	
	public function getOfficeName() {
		return new mlsVariable("officeName", null, "Office Name");
	}
	
	public function getPortafolioName() {
		return new mlsVariable("name", null, "Portafolio Name");
	}
}