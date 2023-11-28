<?php

class mlsDefaultVirtualPageImpl extends mlsAbstractVirtualPage {
	
	public function getPageTemplate() {
		return get_option(mlsConstants::OPTION_VIRTUAL_PAGE_TEMPLATE_DEFAULT, null);
	}
	
}