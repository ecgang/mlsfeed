<?php
$contactInfo = advmls_getContactInfo();

$property_id = 0;
$proTitle = "that you contact me";
$image_url = "";
$agent_name = "";

if (!$wioListing) {
	#$terms_page_id = get_option('terms_condition');
	$property_id = $this->getDataDetails('ref');
	$proTitle = $this->getProTitle();
	$image_url = !empty($this->getDataDetails('agent_photo')) ? $this->getDataDetails('agent_photo') : '' ;
	$name = !empty($this->getDataDetails('agent_name')) ? $this->getDataDetails('agent_name') : '' ;
}

$agent_number = isset($contactInfo->phone) ? $contactInfo->phone : '';
$agent_whatsapp_call = isset($contactInfo->phone) ? $contactInfo->phone : '';
$agent_mobile_call = isset($contactInfo->phone) ? $contactInfo->phone : '';
$user_name = '';
$user_email = '';
$send_btn_class = 'btn-full-width';

$action_class = "advmls-send-message";

$agent_email = is_email(isset($contactInfo->email) ? $contactInfo->email : '');

$agent_mobile_num = 1;
$agent_whatsapp_num = 1;

$whatsappBtnClass = "btn-full-width mt-10";
$messageBtnClass = "btn-full-width mt-10";

$agent_display = "block";
$section_header = 1;


if($agent_display != 'none') {
?>
<div class="property-contact-agent-wrap property-section-wrap" id="property-contact-agent-wrap">
	<div class="block-wrap">

		<div class="block-content-wrap">
			<form method="post" action="#">
				<?php if(!empty($image_url)) { ?>
				<div class="agent-details">
	                <div class="d-flex align-items-center">
	                    <div class="agent-image">
	                        <img class="rounded" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($name); ?>" style="max-width: 100px; max-height: 100px;">
	                    </div>
	                    <ul class="agent-information list-unstyled">
	                        <li class="agent-name">
	                            <i class="advmls-icon icon-single-neutral mr-1"></i> 
	                            <?php echo esc_attr($name); ?>
	                        </li>
	                    </ul>

	                </div><!-- d-flex -->
	            </div><!-- agent-details -->
            	<?php } ?>
				<div class="block-title-wrap">
					<h3><?php echo get_option('sps_propperty_enqry', 'Inquire About This Property'); ?></h3>
				</div>
			
				<div class="form_messages"></div>
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label><?php echo get_option('spl_con_name', 'Name'); ?></label>
							<input class="form-control" name="name" placeholder="<?php echo get_option('spl_con_name_plac', 'Enter your name'); ?>" type="text">
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label><?php echo get_option('spl_con_phone', 'Phone'); ?></label>
							<input class="form-control" name="mobile" placeholder="<?php echo get_option('spl_con_phone_plac', 'Enter your phone number'); ?>" type="text">
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label><?php echo get_option('spl_con_email', 'Email'); ?></label>
							<input class="form-control" name="email" placeholder="<?php echo get_option('spl_con_email_plac', 'Enter your email address'); ?>" type="email">
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label><?php echo get_option('spl_con_usertype', "I'm a"); ?></label>
							<select name="user_type" class="selectpicker form-control bs-select-hidden" title="<?php echo get_option('spl_con_select', 'Select'); ?>">
								<option value="buyer"><?php echo get_option('spl_con_buyer', "I'm a buyer"); ?></option>
								<option value="other"><?php echo get_option('spl_con_other', 'Other'); ?></option>
							</select><!-- selectpicker -->
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<div class="col-sm-12 col-xs-12">
						<div class="form-group form-group-textarea">
							<label><?php echo get_option('spl_con_message', 'Message'); ?></label>
							<textarea class="form-control hz-form-message" name="message" rows="5" placeholder="<?php echo get_option('spl_con_message_plac', 'Message'); ?>"><?php echo get_option('spl_con_interested', "Hello, I am interested in"); ?> [<?php echo $proTitle; ?>]</textarea>
						</div>
					</div><!-- col-sm-12 col-xs-12 -->
					<?php if( get_option('advmls_privacy_policy_enable', 0) ) { ?>
					<div class="col-sm-12 col-xs-12">
						<div class="form-group">
							<label class="control control--checkbox m-0 hz-terms-of-use">
								<input type="checkbox" name="privacy_policy">
								<?php echo get_option('advmls_message_agree', 'By submitting this form I agree to'); ?>
								<a href="<?php echo esc_url(get_option('advmls_privacy_policy_url', '')); ?>" target="_blank">
									<?php echo get_option('advmls_privacy_policy_title', 'Privacy Policy'); ?>
								</a>

								<span class="control__indicator"></span>
							</label>
						</div><!-- form-group -->
					</div>
					<?php } ?>

					<?php echo advmls_formCaptcha(); ?>

					<div class="col-sm-12 col-xs-12">
				         <input type="hidden" name="target_email" value="<?php echo antispambot($agent_email); ?>">
				        <input type="hidden" name="property_agent_contact_security" value="<?php echo wp_create_nonce('property_agent_contact_nonce'); ?>"/>
				        <input type="hidden" name="property_permalink" value=""/>
				        <input type="hidden" name="property_title" value="<?php echo esc_attr($proTitle); ?>"/>
				        <input type="hidden" name="property_id" value="<?php echo esc_attr($property_id); ?>"/>
				        <input type="hidden" name="action" value="advmls_property_agent_contact">
				        <input type="hidden" class="is_bottom" value="bottom">
				        <input type="hidden" name="listing_id" value="<?php echo intval($property_id)?>">
				        <input type="hidden" name="is_listing_form" value="yes">

						<button class="advmls_agent_property_form btn submit btn-sm-full-width">
							<span class="btn-loader advmls-loader-js"></span>
							<?php echo get_option('spl_btn_request_info', 'Request Information'); ?>		
						</button>
						
					</div><!-- col-sm-12 col-xs-12 -->
				</div><!-- row -->
			</form>
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-schedule-tour-wrap -->
<?php } ?>