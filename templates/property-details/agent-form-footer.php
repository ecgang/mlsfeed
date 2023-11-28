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

$agent_number = !empty($contactInfo->phone) ? $contactInfo->phone : '';
$agent_whatsapp_call = !empty($contactInfo->phone) ? $contactInfo->phone : '';
$agent_mobile_call = !empty($contactInfo->phone) ? $contactInfo->phone : '';
$user_name = '';
$user_email = '';
$send_btn_class = 'btn-full-width';

$action_class = "advmls-send-message";

$agent_email = !empty($contactInfo->email) ? is_email($contactInfo->email) : '';

$agent_mobile_num = 1;
$agent_whatsapp_num = 1;

$whatsappBtnClass = "btn-full-width mt-10";
$messageBtnClass = "btn-full-width mt-10";

$agent_display = "block";


if ($agent_email && $agent_display != 'none') {
?>
<div class="property-form-wrap">
	<div class="property-form clearfix">
		<form method="post" action="#"  onsubmit="return checkform(this);">
			<?php if(!empty($image_url)) { ?>
				<div class="agent-details">
	                <div class="d-flex align-items-center">
	                    <div class="agent-image">
	                        <img class="rounded" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($name); ?>" style="max-width: 80px; max-height: 80px;">
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
			<div class="form-group mb-1">
				<input class="form-control" name="name" value="<?php echo esc_attr($user_name); ?>" type="text" placeholder="<?php echo 'Name'; ?>">
			</div><!-- form-group -->

			<div class="form-group mb-1">
				<input class="form-control" name="email" value="<?php echo esc_attr($user_email); ?>" type="email" placeholder="<?php echo 'Email'; ?>">
			</div><!-- form-group -->

			<div class="form-group form-group-textarea">
				<textarea class="form-control hz-form-message" name="message" rows="3" placeholder="<?php echo 'Message'; ?>"></textarea>
			</div><!-- form-group -->	

			<?php echo advmls_formCaptcha(); ?>

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
	        <input type="hidden" name="target_email" value="<?php echo antispambot($agent_email); ?>">
	        <input type="hidden" name="property_agent_contact_security" value="<?php echo wp_create_nonce('property_agent_contact_nonce'); ?>"/>
	        <input type="hidden" name="property_permalink" value=""/>
	        <input type="hidden" name="property_title" value="<?php echo esc_attr($proTitle); ?>"/>
	        <input type="hidden" name="property_id" value="<?php echo esc_attr($property_id); ?>"/>
	        <input type="hidden" name="action" value="advmls_property_agent_contact">
	        <input type="hidden" name="listing_id" value="<?php echo intval($property_id)?>">
	        <input type="hidden" name="is_listing_form" value="yes">

	        <div class="form_messages"></div>
			<button type="button" class="advmls_agent_property_form btn submit <?php echo esc_attr($send_btn_class); ?>">
				<?php echo 'Send Email'; ?>
			</button>
		</form>
	</div><!-- property-form -->
</div><!-- property-form-wrap -->
<?php } ?>