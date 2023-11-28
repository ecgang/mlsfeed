<?php

class mlsAdminSettingsDetails {
	
	private static $instance;
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function registerSettings() {

		register_setting('advmls-settings-details', 'advmls-top-area');
		register_setting('advmls-settings-details', 'advmls_default_active_tab');
		register_setting('advmls-settings-details', 'advmls-content-layout');
		register_setting('advmls-settings-details', 'advmls_is_full_width');
		register_setting('advmls-settings-details', 'advmls_agent_form');

	}
	
	public function getContent() {
		
		$top_area = get_option('advmls-top-area','v3');
		$default_active_tab = get_option('advmls_default_active_tab','image_gallery');
		$content_layout = get_option('advmls-content-layout','default');
		$is_full_width = get_option('advmls_is_full_width',0);
		$agent_form = get_option('advmls_agent_form',0);

		$section = mlsUtility::getInstance()->getRequestVar("section");
		//if the activationToken is passed in the url, we manually update the option
		$activationToken = mlsUtility::getInstance()->getRequestVar("reg");
		?>
		<form method="post" action="options.php">
			<?php settings_fields('advmls-settings-details'); ?>

			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row">
							<div class="redux_field_th">Property Banner
								<span class="description">Select the banner version you want to display in the property detail page</span>
							</div>
						</th>
						<td>
							<fieldset id="advmls_options-advmls-top-area" class="redux-field-container redux-field redux-container-image_select" data-id="advmls-top-area" data-type="image_select">
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
							<div class="redux_field_th">Agent Form
							</div>
						</th>
						<td>
							<fieldset id="advmls_default_active_tab" class="redux-field-container redux-field redux-container-select" data-id="advmls_default_active_tab" data-type="select">
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
								<div class="redux_field_th">Property Content Layout
									<span class="description"></span>
								</div>
							</th>
							<td>
								<fieldset id="advmls-content-layout" class="redux-field-container redux-field redux-container-select" data-id="advmls-content-layout" data-type="select">
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
								<div class="redux_field_th">Full Width Property Content Layout
									<span class="description">If you select yes the property page will be full-width without the sidebar</span>
								</div>
							</th>
							<td>
								<fieldset id="advmls_options-is_full_width" class="redux-field-container redux-field redux-container-switch" data-id="is_full_width" data-type="switch">
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
						
					</tbody>
				</table>

			<p class="submit">
				<button type="submit" class="button-primary">Save Changes</button>
			</p>
		</form>
		<?php
	}
	
}