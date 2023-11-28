<?php

class mlsUtility {

	private static $instance;

	private function __construct() {
	}

	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function getQueryVar($name) {
		return get_query_var($name, null);
	}

	public function getRequestVar($name) {
		$result = $this->getVarFromArray($name, $_REQUEST);
		return $result;
	}

	public function hasRequestVar($name) {
		$result = false;
		$value = $this->getVarFromArray($name, $_REQUEST);
		if(!empty($value)) {
			$result = true;
		}
		return $result;
	}

	public function getVarFromArray($key, $array) {
		$result = null;
		$key = strtolower($key);
		$array = $this->arrayKeysToLowerCase($array);
		if(array_key_exists($key, $array)) {
			$result = $array[$key];
		}
		return $result;
	}
	
	private function arrayKeysToLowerCase($array) {
		$lowerCaseKeysArray = array();
		if(is_array($array)) {
			foreach($array as $key => $value) {
				$key = strtolower($key);
				$lowerCaseKeysArray[$key] = $value;
			}
		}
		return $lowerCaseKeysArray;
	}
	
	public function appendQueryString($url, $key, $value) {
		if(isset($value, $key)) {
			if(is_bool($value)) {
				$value = ($value) ? "true" : "false";
			}
			if($value !== null) {
				if(substr($url, -1) !== "?" && substr($url, -1) !== "&") {
					$url .= "&";
				}
				$url .= $key . "=" . urlencode(trim($value));
			}
		}
		return $url;
	}
	
	public function buildUrl($url, array $parameters = null) {
		if(strpos($url, "?") === false) {
			$url .= "?";
		}
		if($parameters !== null && is_array($parameters)) {
			foreach($parameters as $key => $values) {
				$paramValue = null;
				if(is_array($values)) {
					foreach($values as $value) {
						if($paramValue !== null) {
							$paramValue .= ",";
						}
						$paramValue .= $value;
					}
				} else {
					$paramValue = $values;
				}
				$url = $this->appendQueryString($url, $key, $paramValue);
			}
		}
		return $url;
	}
	
	public function isDatabaseCached() {
		$result = false;
		$value1 = uniqid();
		update_option(iHomefinderConstants::DATABASE_CACHE_TEST, $value1);
		$value2 = get_option(iHomefinderConstants::DATABASE_CACHE_TEST, null);
		if($value1 !== $value2) {
			$result = true;
		}
		return $result;
	}
	
	public function isTruthy($value) {
		return $value === true || $value === 1 || $value === "true";
	}
	
	public function isFalsy($value) {
		return $value === false || $value === 0 || $value === "false";
	}

	public function getActivationToken(){

		return get_option(mlsConstants::ACTIVATION_TOKEN_OPTION, null);
	}

	public function isActivated() {
		$result = false;

		$authenticationToken = self::getActivationToken();
		$queryUrlArr = array(
		    "token" => $authenticationToken,
		    "source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl())
		);

		$queryUrl = http_build_query($queryUrlArr);
		$response = wp_remote_get(getUrlMlsMember().'api/validateregister?'.$queryUrl);
		if (!is_wp_error($response)) {
			
			$resJson = json_decode($response['body']);

			if(isset($resJson->success) and $resJson->success == 'true'){
				add_option("advmls_user_register", $resJson->data);
				return true;
			}

			if(isset($resJson->error) and $resJson->error == 'true'){
				return false;
			}

		}else{
			return false;
		}
		
		return $result;
	}

	public static function showNumberFormat($price, $money_format = 6){
		
		switch ($money_format){
			case "1":
				return number_format($price,2,',','.');
				break;
			case "2":
				return number_format($price,2,',',' ');
				break;
			case "3":
				return number_format($price,2,'.',',');
				break;
			case "4":
				return number_format($price,0,',','.');
				break;
			case "5":
				return number_format($price,0,',',' ');
				break;
			case "6":
				return number_format($price,0,'.',',');
				break;
			case "7":
				return number_format($price,0,'','');
				break;
		}
	}

	public function getCurrentUrl(){
		$removable_query_args = wp_removable_query_args();
		$current_url = set_url_scheme( '//' . $_SERVER['HTTP_HOST']  );
		$current_url = remove_query_arg( $removable_query_args, $current_url );
		$current_url = $current_url.(substr($current_url, -1) == '/' ? '' : '/' );
		return $current_url;
	}


	public function advmls_esc_url($url){

		$url = esc_url($url);

		$url = str_replace('%20', '-', $url);
		$url = strtolower($url);
		return $url;
	}

	public function advmls_check_version(){	

		$newerVersion = json_decode(get_option('advmls_check_version'));

		if ( $newerVersion == null or !isset($newerVersion->newer_version)) {
			
			$queryUrlArr = array(
			    "token" => mlsUtility::getInstance()->getActivationToken(),
			    "source" => base64_encode(mlsUtility::getInstance()->getCurrentUrl())
			);

			$queryUrl = http_build_query($queryUrlArr);
			
			$resVersionPlugin = wp_remote_get('https://cdn.advantagemls.com/wordpressidx/config/conf_version.json');
			if (is_wp_error($resVersionPlugin)) {
			    $newerVersion = json_encode(array());
			}else{
				$newerVersion = json_decode($resVersionPlugin['body']);
			}
			
			update_option('advmls_check_version', json_encode($newerVersion), 'no');
		}
		
		return $newerVersion;
	}

	public function advmls_mls_list(){
		$mlslist = json_decode(get_option('advmls_mls_list'));

		if ( $mlslist == null or !isset($mlslist->list) ) {
			
			$result = wp_remote_get('https://cdn.advantagemls.com/wordpressidx/config/mls-list.json');
			if (is_wp_error($result)) {
			    $mlslist = json_encode(array());
			}else{
				$mlslist = json_decode($result['body']);
			}
			
			update_option('advmls_mls_list', json_encode($mlslist), 'no');
		}
		
		return $mlslist;
	}
	
	public function advmls_register_mlsusername(){

		if ( count($_POST) > 0 and $_GET['register'] == 'mlsusername' ) {
			$getToken = false;
			$data = array();
			if (isset($_POST['advmls_username']) and !empty($_POST['advmls_username']) ) {
				$data['username'] = $_POST['advmls_username'];
				$getToken = true;
			}else{
				$getToken = false;
			}

			if (isset($_POST['advmls_password']) and !empty($_POST['advmls_password']) ) {
				$data['password'] = $_POST['advmls_password'];
				$getToken = true;
			}else{
				$getToken = false;
			}

			if (isset($_POST['advmls_mls_member']) and !empty($_POST['advmls_mls_member']) ) {
				$mlsMember = $_POST['advmls_mls_member'];
				$data['source'] = base64_encode(mlsUtility::getInstance()->getCurrentUrl());
				$getToken = true;
			}else{
				$getToken = false;
			}

			if ($getToken) {
				$url = $mlsMember.'api/mlslogin';
				$response = wp_remote_post( $url, array( "body" => $data) );
				if (!is_wp_error($response)) {
					$resJson = json_decode($response['body']);
					
					if (isset($resJson->token_activated) and !empty($resJson->token_activated)) {
						update_option('advmls_mls_member', $mlsMember);
						update_option('mls_activation_token', $resJson->token_activated);
					}

					return $resJson;
				}
			}
			return false;
		}

		return false;

	}
}