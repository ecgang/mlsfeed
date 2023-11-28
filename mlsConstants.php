<?php

define( 'ADVMLS_DIR_URI', __DIR__ );
define( 'ADVMLS_JS_DIR_URI', plugin_dir_url(__FILE__) . 'js/' );
define( 'ADVMLS_CSS_DIR_URI', plugin_dir_url(__FILE__) . 'css/' );
define( 'ADVMLS_IMG', plugin_dir_url(__FILE__) . 'img' );
define( 'ADVMLS_PLUGIN_VERSION', '1.2.9.1' );
define( 'ADVMLS_BASENAME_ID', plugin_basename(plugin_dir_path( __FILE__ ) . 'advantagemls.php' ));
/**
 * Option names should lowercase snake_case
 */
interface mlsConstants {

	const VERSION = "1.2.9.1";
	const VERSION_NAME = "Advantage MLS";
	const EXTERNAL_URL = "advantagemls.com";
	const KESTREL_URL = "https://advantagemls.com";
	const KESTREL_DEVELOPMENT = false;
	const ADVANTAGEMLSWGPATH = __DIR__;
	const ADVANTAGEMLSTPLPATH = __DIR__.'/templates/';
	const EXTERNAL_URL_API = 'http://joomsy/';
	
	/*
	 * menu slugs
	 */
	const PAGE_INFORMATION = "advantage-mls-information";
	const PAGE_ACTIVATE = "advantage-mls-activated";

	/*
	 * activation options
	 */
	const OPTION_GROUP_ACTIVATE = "advantage-mls-activated";
	const ACTIVATION_TOKEN_OPTION = "mls_activation_token"; //key used to register and generate authentication token
	const AUTHENTICATION_TOKEN_OPTION = "mls_authentication_token"; //token sent with every request

	const MLS_TYPE_URL_VAR = "mls-type";

	//Listing Detail Virtual Page Options
	const OPTION_VIRTUAL_PAGE_TITLE_DETAIL = "mls-virtual-page-title-detail";
	const OPTION_VIRTUAL_PAGE_TEMPLATE_DETAIL = "mls-virtual-page-template-detail";
	const OPTION_VIRTUAL_PAGE_PERMALINK_TEXT_DETAIL = "mls-virtual-page-permalink-text-detail";
	const OPTION_VIRTUAL_PAGE_META_TAGS_DETAIL = "mls-virtual-page-meta-tags-detail";
		
	const OPTION_VIRTUAL_PAGE_TITLE_AGENT_DETAIL = "mls-virtual-page-title-agent-detail";
	const OPTION_VIRTUAL_PAGE_TEMPLATE_AGENT_DETAIL = "mls-virtual-page-template-agent-detail";
	const OPTION_VIRTUAL_PAGE_PERMALINK_TEXT_AGENT_DETAIL = "mls-virtual-page-permalink-text-agent-detail";
	const OPTION_VIRTUAL_PAGE_META_TAGS_AGENT_DETAIL = "mls-virtual-page-meta-tags-agent-detail";
	
	const OPTION_VIRTUAL_PAGE_TITLE_PORTAFOLIO = "mls-virtual-page-title-portafolio-detail";
	const OPTION_VIRTUAL_PAGE_PERMALINK_TEXT_PORTAFOLIO = "mls-virtual-page-template-portafolio-detail";
	const OPTION_VIRTUAL_PAGE_PORTAFOLIO = "mls-virtual-page-permalink-text-portafolio-detail";
	const OPTION_VIRTUAL_PAGE_META_TAGS_PORTAFOLIO = "mls-virtual-page-meta-tags-portafolio-detail";

	//Default Virtual Page options
	const OPTION_VIRTUAL_PAGE_TEMPLATE_DEFAULT = "mls-virtual-page-template-default";
}
