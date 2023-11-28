<?php

abstract class mlsAbstractVirtualPage implements mlsVirtualPageInterface {
	
	protected $remoteResponse;
	protected $remoteRequest;
	protected $displayRules;
	private $stateManager;
	
	public function __construct() {
		$this->remoteRequest = new mlsRequestor();
		#$this->displayRules = mlsDisplayRules::getInstance();
		#$this->stateManager = mlsStateManager::getInstance();
	}
	
	public function getPageTemplate() {
		return null;
	}
	
	public function getPermalink() {
		return null;
	}
	
	public function getHead() {
		$result = null;
		if(is_object($this->remoteResponse)) {
			$result = $this->remoteResponse->getHead();
		}
		return $result;
	}
	
	public function getFooterContent() {
		$result = null;
		if(is_object($this->remoteResponse)) {
			if($this->remoteResponse->hasFooterContent()) {
				$result = $this->remoteResponse->getFooterContent();
			}
		}
		return $result ;
	}
	
	public function getTitle() {
		return null;
	}
	
	public function getMetaTags() {
		return null;
	}
	
	public function getAvailableVariables() {
		return null;
	}
	
	public function getVariables() {
		$result = array();

		//if only one node exists, this is returning one object instead an array of objects
		if(is_object($this->remoteResponse)) {
			$variables = $this->getAvailableVariables();

			if(is_array($variables)) {
				foreach($variables as $variable) {
					if ($variable->getName() and isset($this->remoteResponse->{$variable->getName()})) {
						$result[] = new mlsVariable($variable->getName(), $this->remoteResponse->{$variable->getName()}, null);
					}
					
				}
			}
		}
		return $result;
	}
	
	public function getContent() {
		return null;
	}
	
	public function getBody() {
		$result = null;
		if(is_object($this->remoteResponse)) {
			$result = $this->remoteResponse->getBody();
		}
		return $result;
	}
	
	public function addParameter($name, $value) {
		$this->remoteRequest->addParameter($name, $value);
	}
	
	/**
	 * 
	 * @param string $optionName the name of the option
	 * @param string $default the default value if the option value cannot be found or is empty 
	 * @return string variables replaced
	 */
	protected function getText($optionName, $default = null) {

		$result = get_option($optionName, null);
		if(empty($result)) {
			$result = $default;
		}
		$result = mlsVariableUtility::getInstance()->replaceVariable($result, $this->getVariables());

		return $result;
	}
	
	/**
	 * Used in active and sold detail pages 
	 * @return string
	 */
	protected function getPreviousSearchLink() {
		$previousUrl = $this->stateManager->getLastSearchUrl();
		$text = null;
		if(empty($previousUrl)) {
			$previousUrl = mlsUrlFactory::getInstance()->getListingsSearchFormUrl(true);
			$text = "New Search";
		} elseif(strpos($previousUrl, "map-search") !== false) {
			$text = "Return To Map Search";
		} else {
			$text = "Return To Results";
		}
		$result = null;
		if(!empty($text) and !empty($previousUrl)) {
			$result = "<a href=\"" . $previousUrl . "\">&lt;&nbsp;" . $text . "</a>";
		}
		return $result;
	}

	protected function getKestrelBody($path) {
		$authenticationToken = $authenticationToken = mlsAdmin::getInstance()->getAuthenticationToken();
		$sessionId = $this->stateManager->getSessionId();
		$leadCaptureUserId = $this->stateManager->getLeadCaptureUserId();
		return "";
	}
	
}