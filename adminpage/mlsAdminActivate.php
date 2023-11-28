<?php

class mlsAdminActivate {
	
	const ADVMLS_NOTIFICATION = "";
	
	private static $instance;
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function registerSettings() {

		register_setting(mlsConstants::OPTION_GROUP_ACTIVATE, mlsConstants::ACTIVATION_TOKEN_OPTION);
		register_setting(mlsConstants::OPTION_GROUP_ACTIVATE, 'advmls_mls_member');

	}
	
	public function getContent() {

		wp_enqueue_style('bootstrap', ADVMLS_CSS_DIR_URI . 'bootstrap.min.css', array(), '4.5.0');
		wp_enqueue_script('bootstrap', ADVMLS_JS_DIR_URI. 'vendors/bootstrap.bundle.min.js', array('jquery'), '4.5.0', true);

		$this->registerSettings();
		$mlsUtility = mlsUtility::getInstance();
		$mlsList = $mlsUtility->advmls_mls_list();

		// $dataDummy = new stdClass;
		// $dataDummy->name = "joomsy";
		// $dataDummy->url = "http://joomsy/";
		// array_push($mlsList->list, $dataDummy);

		$registerUsername = "";

		if ( count($_POST) > 0 and $_GET['register'] == 'mlsusername' ) {
			$registerUsername = $mlsUtility->advmls_register_mlsusername();
		}

		if ($mlsUtility->isActivated() ) { ?>
			<h2>Thanks For Signing Up</h2>
			<div class="updated">
				<p>Your Token plugin has been registered.</p>
			</div>
			
		<?php }else{ ?>

			<?php $activationToken = get_option(mlsConstants::ACTIVATION_TOKEN_OPTION, null); ?>
			<style type="text/css">			
				.advmls-container .redux-header {
				    border-bottom-width: 3px;
				    border-bottom-style: solid;
				}
				.advmls-container .redux-header, .advmls-container #redux-footer {
				    text-align: left;
				    padding: 5px 15px;
				}
				.redux-header {
				    position: relative;
				    margin-bottom: 15px;
				}
				.redux-header {
				    border-color: #00a0d2 !important;
				    background: #23282d !important;
				}

				.redux-header .display_header h2 {
				    color: #eee;
				}
				label.title-decoretion {
					border-left: solid 3px #14a2d8;
				    padding-left: 5px;
				}
			</style>
			<div class="advmls-container">
				<div class="redux-header">
					<div class="display_header">
						<h2>Add Registration Key</h2>
					</div>
				</div>
				<?php if(empty($activationToken)) { ?>
					<div class="updated">
						<p>Add your Registration Key and click "Save Changes" to get started.</p>
					</div>
				<?php } elseif($mlsUtility->isActivated() ) { ?>
					<div class="updated">
						<p>Your Token plugin has been registered.</p>
					</div>
				<?php } else { ?>
					<div class="error">
						<p>Incorrect Registration Key.</p>
					</div>
				<?php } ?>

				<form method="post" action="options.php">
					<?php settings_fields(mlsConstants::OPTION_GROUP_ACTIVATE); ?>
					<table class="form-table">
						<tr>
							<th>
								<label for="<?php echo mlsConstants::ACTIVATION_TOKEN_OPTION; ?>">MLS Member</label>
							</th>
							<td>
								<select name="advmls_mls_member" id="<?php echo mlsConstants::ACTIVATION_TOKEN_OPTION; ?>" required="required">
									<option value="">Any</option>
									<?php foreach ($mlsList->list as $mls) { ?>
										<option <?php echo selected(get_option('advmls_mls_member', null), $mls->url) ?> value="<?=$mls->url?>"><?=$mls->name?></option>
									<?php } ?>
								</select>
								
							</td>
						</tr>
						<tr>
							<th>
								<label for="<?php echo mlsConstants::ACTIVATION_TOKEN_OPTION; ?>">Registration Key</label>
							</th>
							<td>
								<input id="<?php echo mlsConstants::ACTIVATION_TOKEN_OPTION; ?>" class="regular-text" type="text" name="<?php echo mlsConstants::ACTIVATION_TOKEN_OPTION; ?>" value="<?php echo get_option(mlsConstants::ACTIVATION_TOKEN_OPTION, null); ?>" required="required" />
							</td>
						</tr>
					</table>	
					<p>
						<?php echo self::ADVMLS_NOTIFICATION; ?>
					</p>
					<p class="submit">
						<button type="submit" class="button-primary">Save Changes</button>
					</p>
				</form>

				<div class="redux-header">
					<div class="display_header">
						<h2>Add Registration by MLS Username</h2>
					</div>
				</div>

				<?php 
				if(isset($registerUsername->error) and $registerUsername->error ){ ?>
					<div class="alert alert-danger">
						<?=$registerUsername->error_msg ?>
					</div>
				<?php } ?>

				<form method="post" action="admin.php?register=mlsusername&page=advantage-mls-activated">
					<?php settings_fields(mlsConstants::OPTION_GROUP_ACTIVATE); ?>
					<table class="form-table">
						<tr>
							<th>MLS Member:</th>
							<td>
								<select name="advmls_mls_member" id="mlslistusername" required="required">
									<option value="">Any</option>
									<?php foreach ($mlsList->list as $mls) { ?>
										<option <?php echo selected( get_option('advmls_mls_member', null), $mls->url) ?> value="<?=$mls->url?>"><?=$mls->name?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<th>MLS Username</th>
							<td>
								<input id="<?php echo mlsConstants::ACTIVATION_TOKEN_OPTION; ?>" class="regular-text" type="text" name="advmls_username" value="<?php echo get_option('advmls_username', null); ?>" required="required" />
							</td>
						</tr>
						<tr>
							<th>MLS Password:</th>
							<td>
								<input id="<?php echo mlsConstants::ACTIVATION_TOKEN_OPTION; ?>" class="regular-text" type="password" name="advmls_password" value="<?php echo get_option('advmls_password', null); ?>" required="required" />
							</td>
						</tr>
					</table>
					<p class="submit">
						<button type="submit" class="button-primary">Save Changes</button>
					</p>
				</form>
			</div>
		<?php 
		}

	}
	
}