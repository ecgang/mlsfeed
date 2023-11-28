<?php

class mlsAdminSettings {
	
	private static $instance;
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function registerSettings() {

		register_setting('advmls-settings-global', 'advmls_key_converter_curr');
		register_setting('advmls-settings-global', 'advmls_alert_details');

		// settings details
		register_setting('advmls-settings-global', 'advmls-top-area');
		register_setting('advmls-settings-global', 'advmls_default_active_tab');
		register_setting('advmls-settings-global', 'advmls-content-layout');
		register_setting('advmls-settings-global', 'advmls_is_full_width');
		register_setting('advmls-settings-global', 'advmls_agent_form');
		register_setting('advmls-settings-global', 'advmls_bgcolor_detail');
		register_setting('advmls-settings-global', 'advmls_color_detail');

		register_setting('advmls-settings-global', 'advmls_privacy_policy_url');
		register_setting('advmls-settings-global', 'advmls_privacy_policy_title');
		register_setting('advmls-settings-global', 'advmls_privacy_policy_enable');

		register_setting('advmls-settings-global', 'advmls_status_pro_type');
		register_setting('advmls-settings-global', 'advmls_status_show');
		register_setting('advmls-settings-global', 'advmls_default_state');
		register_setting('advmls-settings-global', 'advmls_default_city');

		register_setting('advmls-settings-global', 'advmls_not_translate_selectors');
		register_setting('advmls-settings-global', 'advmls_lang_settings');

		register_setting('advmls-settings-global', 'advmls_search_result_page');
		register_setting('advmls-settings-global', 'advmls_quicksearch');
		
	}
	
	public function getContent() {

		wp_enqueue_style('bootstrap', ADVMLS_CSS_DIR_URI . 'bootstrap.min.css', array(), '4.5.0');
		wp_enqueue_script('bootstrap', ADVMLS_JS_DIR_URI. 'vendors/bootstrap.bundle.min.js', array('jquery'), '4.5.0', true);

		$top_area = get_option('advmls-top-area','v3');
		$default_active_tab = get_option('advmls_default_active_tab','image_gallery');
		$content_layout = get_option('advmls-content-layout','default');
		$is_full_width = get_option('advmls_is_full_width',0);
		$agent_form = get_option('advmls_agent_form',0);

		$bgcolor_detail = get_option('advmls_bgcolor_detail','#ffffff');
		$color_detail = get_option('advmls_color_detail','#6e6d76');

		$section = mlsUtility::getInstance()->getRequestVar("section");
		//if the activationToken is passed in the url, we manually update the option
		$activationToken = mlsUtility::getInstance()->getRequestVar("reg");
		?>
		<style type="text/css">
			
			.advmls-container #redux-header {
			    border-bottom-width: 3px;
			    border-bottom-style: solid;
			}
			.advmls-container #redux-header, .advmls-container #redux-footer {
			    text-align: left;
			    padding: 20px 15px;
			}
			#redux-header {
			    position: relative;
			    margin-bottom: 15px;
			}
			#redux-header {
			    border-color: #00a0d2 !important;
			    background: #23282d !important;
			}

			#redux-header .display_header h2 {
			    color: #eee;
			}
			label.title-decoretion {
				border-left: solid 3px #14a2d8;
			    padding-left: 5px;
			}
		</style>
		<div class="advmls-container">
			
		<div id="redux-header">
			<div class="display_header">
				<h2>Advantage MLS Settings</h2>
			</div>
			<div class="clear"></div>
		</div>
		<form method="post" action="options.php">
			<nav>
			  <div class="nav nav-tabs" id="nav-tab" role="tablist">
			    <a class="nav-item nav-link active" id="nav-global-tab" data-toggle="tab" href="#nav-global" role="tab" aria-controls="nav-global" aria-selected="true">Global</a>
			    <a class="nav-item nav-link" id="nav-details-tab" data-toggle="tab" href="#nav-details" role="tab" aria-controls="nav-details" aria-selected="false">Property Details</a>
			    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>
			    <a class="nav-item nav-link" id="nav-search-tab" data-toggle="tab" href="#nav-search" role="tab" aria-controls="nav-search" aria-selected="false">Search</a>
			    <a class="nav-item nav-link" id="nav-translate-tab" data-toggle="tab" href="#nav-translate" role="tab" aria-controls="nav-translate" aria-selected="false">Translate</a>
			  </div>
			</nav>
			<div class="tab-content" id="nav-tabContent">
			  <div class="tab-pane fade show active" id="nav-global" role="tabpanel" aria-labelledby="nav-global-tab">
			  	<hr>
			  	<label for="currencyconverterapi" class="title-decoretion">Currency Converter</label>
			  	<table class="form-table">
			  		<tbody>
			  			<tr>
			  				<th scope="row">
			  					<div class="redux_field_th pl-3">
			  						Key Converter Currency:
			  					</div>
			  				</th>
			  				<td>
			  					<input type="text" name="advmls_key_converter_curr" size="50" value="<?php echo get_option('advmls_key_converter_curr',''); ?>">
			  					<div class="description field-desc">Get your token from the currency converter here: <a href="https://free.currencyconverterapi.com" target="_blank">free.currencyconverterapi</a></div>
			  				</td>
						</tr>
			  		</tbody>
			  	</table>
			  	<hr>
			  </div>
			  <div class="tab-pane fade" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab">
				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<th scope="row">
								<div class="redux_field_th pl-3">Property Banner
									<span class="description">Select the banner version you want to display in the property detail page</span>
								</div>
							</th>
							<td>
								<fieldset id="advmls_options-advmls-top-area" class="redux-field-container redux-field advmls-container-image_select" data-id="advmls-top-area" data-type="image_select">
									<div class="redux-table-container">
										<ul class="redux-image-select">
											<li class="redux-image-select" style="float: left;">
												<label class=" redux-image-select-selected redux-image-select advmls-top-area_3" for="advmls-top-area_3">
													<input type="radio" class=" no-update " id="advmls-top-area_3" name="advmls-top-area" value="v3" <?php echo ($top_area =='v3' ? 'checked="checked"' : '')?>>
													<img src="/wp-content/plugins/advantagemls/img/property/property-banner-style-3.jpg" title="" alt="" class="" style=" width: 100%; ">
												</label>
											</li>
											<li class="redux-image-select" style="float: left;">
												<label class=" redux-image-select advmls-top-area_6" for="advmls-top-area_6">
													<input type="radio" class=" no-update " id="advmls-top-area_6" name="advmls-top-area" value="v6" <?php echo ($top_area =='v6' ? 'checked="checked"' : '')?>>
													<img src="/wp-content/plugins/advantagemls/img/property/property-banner-style-6.jpg" title="" alt="" class="" style=" width: 100%; ">
												</label>
											</li>
										</ul>
									</div>
									<div class="description field-desc">Select the banner version</div>
								</fieldset>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<div class="redux_field_th pl-3">Agent Form
								</div>
							</th>
							<td>
								<fieldset id="advmls_default_active_tab" class="redux-field-container redux-field advmls-container-select" data-id="advmls_default_active_tab" data-type="select">
									<select id="advmls_default_active_tab-select" data-placeholder="" name="advmls_agent_form" class="redux-select-item select2-hidden-accessible" style="width:40%">
										<option value="0" <?php echo ($agent_form =='0' ? 'selected="selected"' : '')?>>Any</option>
										<option value="0" <?php echo ($agent_form =='0' ? 'selected="selected"' : '')?>>No</option>
										<option value="1" <?php echo ($agent_form =='1' ? 'selected="selected"' : '')?>>Yes</option>
									</select>
										<div class="description field-desc"></div>
									</fieldset>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<div class="redux_field_th pl-3">Property Content Layout
										<span class="description"></span>
									</div>
								</th>
								<td>
									<fieldset id="advmls-content-layout" class="redux-field-container redux-field advmls-container-select" data-id="advmls-content-layout" data-type="select">
										<select id="advmls-content-layout-select" data-placeholder="" name="advmls-content-layout" class="redux-select-item select2-hidden-accessible" style="width:40%" rows="6" data-width="resolve" data-allow-clear="true" data-theme="default" tabindex="-1" aria-hidden="true">
											<option value="simple" <?php echo ($content_layout =='simple' ? 'selected="selected"' : '')?>>  Any</option>
											<option value="simple" <?php echo ($content_layout =='simple' ? 'selected="selected"' : '')?>>Default</option>
											<option value="tabs" <?php echo ($content_layout =='tabs' ? 'selected="selected"' : '')?>>Tabs</option>
											<option value="tabs-vertical" <?php echo ($content_layout =='tabs-vertical' ? 'selected="selected"' : '')?>>Tabs Vertical</option>
										</select>
										<div class="description field-desc">Select the contet layout</div>
									</fieldset>
								</td>
							</tr>
							<tr class="fold">
								<th scope="row">
									<div class="redux_field_th pl-3">Full Width Property Content Layout
										<span class="description">If you select yes the property page will be full-width without the sidebar</span>
									</div>
								</th>
								<td>
									<fieldset id="advmls_options-is_full_width" class="redux-field-container redux-field advmls-container-switch" data-id="is_full_width" data-type="switch">
										<div class="switch-options">
											<select id="advmls_is_full_width" data-placeholder="" name="advmls_is_full_width" class="redux-select-item select2-hidden-accessible" style="width:40%">
												<option value="0" <?php echo ($is_full_width =='0' ? 'selected="selected"' : '')?>>Any</option>
												<option value="1" <?php echo ($is_full_width =='1' ? 'selected="selected"' : '')?>>Yes</option>
												<option value="0" <?php echo ($is_full_width =='0' ? 'selected="selected"' : '')?>>No</option>
											</select>
										</div>
										<div class="description field-desc">Do you want to make the property page full width?</div>
									</fieldset>
								</td>
							</tr>
							<tr class="fold">
								<th scope="row">
									<div class="redux_field_th pl-3">Background Color of detail content</div>
								</th>
								<td>
									<script type="text/javascript">
										jQuery(document).ready(function($){
											$('#advmls_bgcolor_detail_select').on('change',function(){
												$("#advmls_bgcolor_detail").val($(this).val())
											});
											$("#advmls_bgcolor_detail").focusout(function(){
												$('#advmls_bgcolor_detail_select').val($(this).val())
											});
										})
									</script>
									<input type="color" name="advmls_bgcolor_detail_select" id="advmls_bgcolor_detail_select" style="width: 60px;height: 60px;" value="<?php echo $bgcolor_detail; ?>">
									<input type="text" id="advmls_bgcolor_detail" name="advmls_bgcolor_detail" value="<?php echo $bgcolor_detail; ?>">
								</td>
							</tr>
							<tr class="fold">
								<th scope="row">
									<div class="redux_field_th pl-3">Color of the text in details</div>
								</th>
								<td>
									<script type="text/javascript">
										jQuery(document).ready(function($){
											$('#advmls_color_detail_select').on('change',function(){
												$("#advmls_color_detail").val($(this).val())
											});
											$("#advmls_color_detail").focusout(function(){
												$('#advmls_color_detail_select').val($(this).val())
											});
										})
									</script>
									<input type="color" name="advmls_color_detail_select" id="advmls_color_detail_select" style="width: 60px;height: 60px;" value="<?php echo $color_detail; ?>">
									<input type="text" id="advmls_color_detail" name="advmls_color_detail" value="<?php echo $color_detail; ?>">
								</td>
							</tr>
							<tr>
				  				<th scope="row">
				  					<div class="redux_field_th pl-3">
				  						Alert in Details:
				  					</div>
				  				</th>
				  				<td>
				  					<input type="text" name="advmls_alert_details" size="50" value="<?php echo get_option('advmls_alert_details',''); ?>">
				  				</td>
			  				</tr>
						</tbody>
					</table>
			  </div>
			  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

			  	<hr>
			  	<label for="privacypolicy" class="title-decoretion">
			  		Privacy Policy for the contact form</label>
			  	<table class="form-table">
			  		<tbody>
			  			<tr>
			  				<th scope="row">
			  					<div class="redux_field_th pl-3">
			  						Privacy Policy Enable:
			  					</div>
			  				</th>
			  				<td>
			  					<input type="checkbox" name="advmls_privacy_policy_enable" size="50" value="1" <?php echo checked(1, get_option('advmls_privacy_policy_enable','')); ?>>
			  					<label for="privacy_policy_enable">Enable verification privacy policy</label>
			  					
			  				</td>
			  			</tr>
			  			<tr>
			  				<th scope="row">
			  					<div class="redux_field_th pl-3">
			  						Privacy Policy url:
			  					</div>
			  				</th>
			  				<td>
			  					<input type="text" name="advmls_privacy_policy_url" size="50" value="<?php echo get_option('advmls_privacy_policy_url',''); ?>">
			  					
			  				</td>
			  			</tr>
			  			<tr>
			  				<th scope="row">
			  					<div class="redux_field_th pl-3">
			  						Privacy Policy Title:
			  					</div>
			  				</th>
			  				<td>
			  					<input type="text" name="advmls_privacy_policy_title" size="50" value="<?php echo get_option('advmls_privacy_policy_title',''); ?>">
			  					
			  				</td>
			  			</tr>
			  		</tbody>
			  	</table>
			  	<hr>
			  
			  </div>
			  <div class="tab-pane fade" id="nav-search" role="tabpanel" aria-labelledby="nav-search-tab">
					<hr>
						<label for="resultspage" class="title-decoretion">
							Search Results Page</label>
						<table class="form-table">
							<tbody>
								<tr>
									<th scope="row">
										<div class="redux_field_th pl-3">
											Search Result Page:
										</div>
									</th>
									<td>
									<?php $pageSelected = get_option('advmls_search_result_page', 'normal'); ?>
									<select name="advmls_search_result_page" title="Result Page">
										<option value="normal" <?php echo selected($pageSelected, 'normal') ?>>Normal Page</option>
										<option value="map" <?php echo selected($pageSelected, 'map') ?>>Half Map</option>
									</select><!-- selectpicker -->
									
									</td>
								</tr>
							</tbody>
						</table>
					<hr>
					<hr>
						<label for="statusshow" class="title-decoretion">
							Default Pro Type to show in the search engine</label>
						<table class="form-table">
							<tbody>
								<tr>
									<th scope="row">
										<div class="redux_field_th pl-3">
											Default Status Type:
										</div>
									</th>
									<td>
										<select name="advmls_status_pro_type" title="Type">
											<option value="">All</option>
										<?php
											$pro_type = !empty(get_option("advmls_status_pro_type",0)) ? get_option("advmls_status_pro_type",0) : 0 ;
											echo advmls_get_type_list($pro_type);
										?>
									</select><!-- selectpicker -->
									
									</td>
								</tr>
							</tbody>
						</table>
						<hr>
						<label for="statusshow" class="title-decoretion">
							Status to show in the search engine</label>
						<table class="form-table">
							<tbody>
								<tr>
									<th scope="row">
										<div class="redux_field_th pl-3">
											Status Show:
										</div>
									</th>
									<td>
										<?php $proStatus = advmls_get_status_list(false, 'checkbox', 'advmls_status_show[]'); ?>
										<div class="form-check">
										<?php echo $proStatus ?>
										</div>
									
									</td>
								</tr>
							</tbody>
						</table>
						<hr>
						<hr>
						<label for="defaultstate" class="title-decoretion">
							Default State in the search engine</label>
						<table class="form-table">
							<tbody>
								<tr>
									<th scope="row">
										<div class="redux_field_th pl-3">
											Default State:
										</div>
									</th>
									<td>
										<select name="advmls_default_state"  class="form-control" title="<?php echo get_option('advmls_states', 'All States'); ?>">
										<option value="">All</option>
										<?php
										$defState = !empty(get_option("advmls_default_state",0)) ? get_option("advmls_default_state",0) : 0;
										echo advmls_getListStates($defState);
										?>
									</select>
									
									</td>
								</tr>
							</tbody>
						</table>
						<hr>
						<label for="defaultcity" class="title-decoretion">
							Default City in the search engine</label>
						<table class="form-table">
							<tbody>
								<tr>
									<th scope="row">
										<div class="redux_field_th pl-3">
											Default City:
										</div>
									</th>
									<td>
										<select name="advmls_default_city"  class="form-control" title="<?php echo get_option('advmls_states', 'All States'); ?>">
										<option value="">All</option>
										<?php
										$citySelect = get_option("advmls_default_city",0);
										echo advmls_get_cities_list($citySelect ? $citySelect : 0 );
										?>
									</select>
									
									</td>
								</tr>
							</tbody>
						</table>
						<hr>
						<div class="alert alert-info">
							QuickSearch
						</div>
						<hr>
						<?php 
						$available_fields = array(
								"keyword" => "Keyword",
								"type" => "Type",
								"status" => "Status",
								"state" => "State",
								"city" => "City",
								"areas" => "Areas",
								"min-price" => "Min. Price", 
								"max-price" => "Max. Price"
						);

						$enabledFields = (array)get_option('advmls_quicksearch', array('enabled'=>array()));
						?>
						<label for="defaultcity" class="title-decoretion">
							Fields Quicksearch</label>
						<table class="form-table">
							<tbody>
								<tr>
									<th scope="row">
										<div class="redux_field_th pl-3">
											Fields:
										</div>
									</th>
									<td>
										<script>
											jQuery( function() {
												jQuery( "#quicksearch_enable, #quicksearch_disabled" ).sortable({
												  connectWith: ".connectedSortable",
												  group: 'connectedSortable',
												  delay: 500,
												 // pullPlaceholder: false,
												    update: function(e){
														jQuery('#quicksearch_enable li').each(function(){
														    var currentName = jQuery(this.children[0]).attr('name')
														    jQuery(this.children[0]).attr('name', currentName.replace('disabled', 'enabled') ) 
														});

														jQuery('#quicksearch_disabled li').each(function(){
														    var currentName = jQuery(this.children[0]).attr('name')
														    jQuery(this.children[0]).attr('name', currentName.replace('enabled','disabled') ) 
														});
													}
												});
											} );
										</script>

										<style>
											#quicksearch_enable, #quicksearch_disabled {
												border: 1px solid #eee;
												width: 142px;
												min-height: 20px;
												list-style-type: none;
												margin: 0;
												padding: 5px 0 0 0;
												float: left;
												margin-right: 10px;
												background: #2271b185;
											}
											#quicksearch_enable li, #quicksearch_disabled li {
												margin: 0 5px 5px 5px;
												padding: 5px;
												font-size: 1.2em;
												width: 120px;
												border: solid 1px #e7e7e7;
												background: #fff;
											}
										</style>
										<table>
											<tr>
												<th><h3>enabled</h3></th>
												<th><h3>disabled</h3></th>
											</tr>
											<tr>
												<td>
													<ul id="quicksearch_enable" class="connectedSortable serialize">
														<?php 
														if (isset($enabledFields['enabled'])) {
															
															foreach ($enabledFields['enabled'] as $key => $field) { ?>
																<li class="ui-state-highlight"><?=$field?>
																	<input class="position " type="hidden" name="advmls_quicksearch[enabled][<?=$key?>]" value="<?=$field?>">
																</li>
															
															<?php 
																}
														} ?>
													</ul>
												</td>
												<td>
													<ul id="quicksearch_disabled" class="connectedSortable serialize">
													<?php
														if (isset($enabledFields['enabled'])) {
														   foreach ($available_fields as $key => $field) { 
															if(!in_array( $field, $enabledFields['enabled']) ){
															?>
															<li class="ui-state-highlight"><?=$field?>
																<input class="position " type="hidden" name="advmls_quicksearch[disabled][<?=$key?>]" value="<?=$field?>">
															</li>
														<?php 
															}
														   }
														} ?>
													</ul>	
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
			  </div>
			  <div class="tab-pane fade" id="nav-translate" role="tabpanel" aria-labelledby="nav-translate-tab">
			  	<hr>
				<label for="translatetitle" class="title-decoretion"> Translate</label>
					<div class="description field-desc pl-3">
						The translation works in conjunction with the gtranslate plugin, make sure you have it installed and active.
					</div>
					<?php if (is_plugin_active( 'gtranslate/gtranslate.php' )) { ?>
						<table class="form-table">
					  		<tbody>
					  			<tr>
					  				<th scope="row">
					  					<div class="redux_field_th pl-3">
					  						CSS Selectors to Ignore:
					  					</div>
					  				</th>
					  				<td>
					  					<div class="description field-desc" style="font-size: 12px;">
					  						These selectors will be ignored for translation by the gtranslate plugin
					  					</div>
										<?php
											$selectors = get_option('advmls_not_translate_selectors',array());
											$html = "";
											for ($i=0; $i < count($selectors); $i++) { 

												if (!empty($selectors[$i])) {
													$html .= "<tr class='trp-list-entry'>";
														$html .= "<td><textarea class='trp_narrow_input' name='advmls_not_translate_selectors[]'>" . htmlspecialchars($selectors[$i], ENT_QUOTES) . "</textarea></td>";
														$html .= "<td><span class='trp-adst-remove-element' data-confirm-message='Are you sure you want to remove this item?'>Remove</span></td>";
													$html .= "</tr>";
												}
											}
										?>
					  					<table class="trp-adst-list-option">
											<tbody>

												<?php echo $html; ?>
												<tr class="trp-add-list-entry trp-list-entry">
													<td>
														<textarea id="" data-name="advmls_not_translate_selectors[]" data-setting-name="advmls_not_translate_selectors[]" data-column-name="selectors" name="advmls_not_translate_selectors[]"></textarea>
													</td>
													<td>
														<input type="button" class="button-secondary trp-adst-button-add-new-item" value="Add">
														<span class="trp-adst-remove-element" style="display: none;" data-confirm-message="Are you sure you want to remove this item?">Remove</span>
													</td>
												</tr>
											</tbody>
										</table>
					  				</td>
					  			</tr>
					  		</tbody>
					  	</table>
					  	<hr>
						<label for="translatetitle" class="title-decoretion">Words to Translate</label>
					  	<table class="form-table">
					  		<tbody>
					  			<tr>
					  				<th scope="row">
					  					<div class="redux_field_th pl-3">
					  						List of words to translate:
					  					</div>
					  				</th>
					  				<td>
					  					<div class="description field-desc" style="font-size: 12px;">
					  						These selectors will be ignored for translation by the gtranslate plugin
					  					</div>
										
					  					<table class="trp-adst-list-option">
											<thead>
												<tr>
													<th class="trp_lang_code">
														<strong>Language code<span title="Required"> *</span> </strong>
													</th>
													<th>
														<strong>Selector</strong>
													</th>
													<th>
														<strong>Key</strong>
													</th>
													<th>
														<strong>Text Original</strong>
													</th>
													<th>
														<strong>Text Translate</strong>
													</th>
													<th>
														
													</th>
												</tr>
											</thead>
											<tbody>
											<?php

											$langStr = get_option('advmls_lang_settings', '');
											?>
											<script>
												jQuery(document).ready(function(){
													jQuery("#advmls_lang_settings").val(JSON.stringify(<?php echo $langStr ?>))
												});
											</script>
											<?php
											$langs = $langStr != '' ? json_decode($langStr) : array();

											$html = "";
												for ($i=0; $i < count($langs); $i++) {

													if (!empty($langs[$i]) and !empty($langs[$i]->iso)) {
													$html .= "<tr class='trp-list-entry'>";
														$html .= "<td class=\"cuslangcode\">
																<select name=\"langiso\" class=\"trp_narrow_input selectlangiso\" id=\"\" required>
																	<option value=\"\">any</option>
								<option value=\"en_es\"".($langs[$i]->iso == 'en_es' ? ' selected ': '') .">en_ES</option>
								<option value=\"en_en\"".($langs[$i]->iso == 'en_en' ? ' selected ': '') .">en_EN</option>
																</select>
														</td>";
														$html .= "<td class=\"cuslangselector\">
															<input type=\"text\" class=\"trp_narrow_input inputlangselector\" name=\"langselector\" value=\"".$langs[$i]->selector."\" required>
														</td>";
														$html .= "<td <td class=\"cuslangkey\">
														<input type=\"text\" class=\"trp_narrow_input inputlangkey\" name=\"langkey\" value=\"".$langs[$i]->key."\" required></td>";
														$html .= "<td class=\"cuslangoriginal\">
														<input type=\"text\" class=\"trp_narrow_input inputlangtextoriginal\" name=\"langoriginal\" value=\"".$langs[$i]->original."\" required>
														</td>";
														$html .= "<td class=\"cuslangtranslate\">
														<input type=\"text\" class=\"trp_narrow_input inputlangtexttranslate\" name=\"langtranslate\" value=\"".$langs[$i]->translate."\" required>
														</td>";
														$html .= "<td><span class='trp-adst-remove-element' data-confirm-message='Are you sure you want to remove this item?'>Remove</span></td>";
													$html .= "</tr>";
													}
												}
												echo $html;
											?>
												<tr class="trp-add-list-entry trp-list-entry">
													<td class="cuslangcode">
														<select name="langiso" class="trp_narrow_input selectlangiso" id="">
															<option value="">any</option>
															<option value="en_es">en_ES</option>
															<option value="en_en">en_EN</option>
														</select>
													</td>
													<td class="cuslangselector">
														<input type="text" class="trp_narrow_input inputlangselector" id="" name="langselector">
													</td>
													<td class="cuslangkey">
														<input type="text" class="trp_narrow_input inputlangkey" id="" name="langkey">
													</td>
													<td class="cuslangoriginal">
														<input type="text" class="trp_narrow_input inputlangtextoriginal" id="" name="langoriginal">
													</td>
													<td class="cuslangtranslate">
														<input type="text" class="trp_narrow_input inputlangtexttranslate" id="" name="langtranslate">
													</td>
													<td>
														<input type="button" id="button_add_custom_language" class="button-secondary trp-adst-button-add-new-item" value="New">
														<span class="trp-adst-remove-element" style="display: none;" data-confirm-message="Are you sure you want to remove this item?">Remove</span>
													</td>
												</tr>
											</tbody>
										</table>
										<p class="description">
				                        <strong>Language code:</strong> Select a <br>
				                        <strong>Selector:</strong> <br>
				                        <strong>Text Original:</strong> <br>
				                        <strong>Text Translate:</strong> <br>
				                    </p>
										<input type="hidden" name="advmls_lang_settings" id="advmls_lang_settings" value="">
					  				</td>
					  			</tr>
					  		</tbody>
					  	</table>
					<?php } ?>
			  </div>
			</div>
			<p class="submit">
				<button type="submit" class="button-primary">Save Changes</button>
			</p>
			<?php settings_fields('advmls-settings-global'); ?>
		</form>
		</div>
		<script type="text/javascript">
			
		jQuery( function() {

			/*
			* Manage adding and removing items from an option of tpe list from Advanced Settings page
			*/
		    function TRP_Advanced_Settings_List( table ){

		        var _this = this

		        this.addEventHandlers = function( table ){
		            var add_list_entry = table.querySelector( '.trp-add-list-entry' );

		            // add event listener on ADD button
		            add_list_entry.querySelector('.trp-adst-button-add-new-item').addEventListener("click", _this.add_item );

		            var removeButtons = table.querySelectorAll( '.trp-adst-remove-element' );
		            for( var i = 0 ; i < removeButtons.length ; i++ ) {
		                removeButtons[i].addEventListener("click", _this.remove_item)
		            }

		            // change name inputs
		            var selectlangiso = table.querySelectorAll( '.selectlangiso' );
		            for( var i = 0 ; i < selectlangiso.length ; i++ ) {
		            		selectlangiso[i].addEventListener("change", _this.change_names);
		        	}

		        	var inputlangselector = table.querySelectorAll( '.inputlangselector' );
		            for( var i = 0 ; i < inputlangselector.length ; i++ ) {
		            		inputlangselector[i].addEventListener("focusout", _this.change_names);
		        	}

		        	var inputlangkey = table.querySelectorAll( '.inputlangkey' );
		            for( var i = 0 ; i < inputlangkey.length ; i++ ) {
		            		inputlangkey[i].addEventListener("focusout", _this.change_names);
		        	}

		        	var inputlangtextoriginal = table.querySelectorAll( '.inputlangtextoriginal' );
		            for( var i = 0 ; i < inputlangtextoriginal.length ; i++ ) {
		            		inputlangtextoriginal[i].addEventListener("focusout", _this.change_names);
		        	}

		        	var inputlangtexttranslate = table.querySelectorAll( '.inputlangtexttranslate' );
		            for( var i = 0 ; i < inputlangtexttranslate.length ; i++ ) {
		            		inputlangtexttranslate[i].addEventListener("focusout", _this.change_names);
		        	}

		        }

		        this.change_names = function( event ){

		        	var add_list_entry = table.querySelector( '.trp-add-list-entry' );
		        	
		        	var list_entry = table.querySelectorAll( '.trp-list-entry' );
		        	var langs = [];

		        	for( var i = 0 ; i < list_entry.length ; i++ ) {
						var lang = {}; 

						var valiso = list_entry[i].querySelector('.selectlangiso').value;
						var valselector = list_entry[i].querySelector('.inputlangselector').value;
						var valkey = list_entry[i].querySelector('.inputlangkey').value;
						var original = list_entry[i].querySelector('.inputlangtextoriginal').value;
						var translate = list_entry[i].querySelector('.inputlangtexttranslate').value;

						lang.iso = valiso ? valiso : '';

						if(valselector != '')
						lang.selector = valselector ? valselector : '';

						if (valkey != '')
						lang.key = valkey ? valkey : '';
					
						if (original != '') 
							lang.original = original ? original : '';
					
						if (translate != '') 
							lang.translate = translate ? translate : '';

		        		langs.push(lang);
		        		
		        		if (lang.iso != "" || valselector != '' || valkey != '' || original != '' || translate != '') {
			        		list_entry[i].querySelector('.selectlangiso').setAttribute("required", true);
			        		list_entry[i].querySelector('.inputlangselector').setAttribute("required", true);
			        		list_entry[i].querySelector('.inputlangkey').setAttribute("required", true);
			        		list_entry[i].querySelector('.inputlangtextoriginal').setAttribute("required", true);
			        		list_entry[i].querySelector('.inputlangtexttranslate').setAttribute("required", true);
		        		}
		        	}
		        	document.querySelector("#advmls_lang_settings").value = JSON.stringify(langs);

		        }

		        this.remove_item = function( event ){
		            if ( confirm( event.target.getAttribute( 'data-confirm-message' ) ) ){
		                jQuery( event.target ).closest( '.trp-list-entry' ).remove()
		                _this.change_names();
		            }
		        }

		        this.add_item = function () {
		            var add_list_entry = table.querySelector( '.trp-add-list-entry' );
		            var clone = add_list_entry.cloneNode(true)

		            // Remove the trp-add-list-entry class from the second element after it was cloned
		            add_list_entry.classList.remove('trp-add-list-entry');

		            // Show Add button, hide Remove button
		            add_list_entry.querySelector( '.trp-adst-button-add-new-item' ).style.display = 'none'
		            add_list_entry.querySelector( '.trp-adst-remove-element' ).style.display = 'block'

		            // Design change to add the cloned element at the bottom of list
		            // Done becasue the select box element cannot be cloned with its selected state
		            var itemInserted =  add_list_entry.parentNode.insertBefore(clone, add_list_entry.nextSibling);

		            // Set name attributes
		            var dataNames = add_list_entry.querySelectorAll( '[data-name]' )
		            for( var i = 0 ; i < dataNames.length ; i++ ) {
		                dataNames[i].setAttribute( 'name', dataNames[i].getAttribute('data-name') );
		            }

		            var removeButtons = table.querySelectorAll( '.trp-adst-remove-element' );
		            for( var i = 0 ; i < removeButtons.length ; i++ ) {
		                removeButtons[i].addEventListener("click", _this.remove_item)
		            }
		            
		            //------ list custom words to translate
		            // Add action change Select Lang 
		            var selectlangiso = table.querySelectorAll( '.selectlangiso' );
		            for( var i = 0 ; i < selectlangiso.length ; i++ ) {
		            		selectlangiso[i].addEventListener("change", _this.change_names);
		        	}

		        	var inputlangselector = table.querySelectorAll( '.inputlangselector' );
		            for( var i = 0 ; i < inputlangselector.length ; i++ ) {
		            		inputlangselector[i].addEventListener("focusout", _this.change_names);
		        	}

		        	var inputlangkey = table.querySelectorAll( '.inputlangkey' );
		            for( var i = 0 ; i < inputlangkey.length ; i++ ) {
		            		inputlangkey[i].addEventListener("focusout", _this.change_names);
		        	}

		        	var inputlangtextoriginal = table.querySelectorAll( '.inputlangtextoriginal' );
		            for( var i = 0 ; i < inputlangtextoriginal.length ; i++ ) {
		            		inputlangtextoriginal[i].addEventListener("focusout", _this.change_names);
		        	}

		        	var inputlangtexttranslate = table.querySelectorAll( '.inputlangtexttranslate' );
		            for( var i = 0 ; i < inputlangtexttranslate.length ; i++ ) {
		            		inputlangtexttranslate[i].addEventListener("focusout", _this.change_names);
		        	}
		        	//------ list custom words to translate

		            // Reset values of textareas with new items
		            var dataValues = clone.querySelectorAll( '[data-name]' )
		            for( var i = 0 ; i < dataValues.length ; i++ ) {
		                dataValues[i].value = ''
		            }

		            //Restore checkbox(es) values after cloning and clearing; alternative than excluding from reset
		            var restoreCheckboxes = clone.querySelectorAll ( 'input[type=checkbox]' )
		            for( var i = 0 ; i < restoreCheckboxes.length ; i++ ) {
		                restoreCheckboxes[i].value = 'yes'
		            }

		            // Add click listener on new row's Add button
		            var addButton = itemInserted.querySelector('.trp-adst-button-add-new-item');
		            addButton.addEventListener("click", _this.add_item );
		        }

		        _this.addEventHandlers( table )
		    }

		    // Options of type List adding, from Advanced Settings page
		    var trpListOptions = document.querySelectorAll( '.trp-adst-list-option' );
		    for ( var i = 0 ; i < trpListOptions.length ; i++ ){
		        new TRP_Advanced_Settings_List( trpListOptions[i] );
		    }

		})
		</script>
		<?php
	}
	
}
