<?php
$contactInfo = advmls_getContactInfo();

$property_id = 0;
$proTitle = "that you contact me";

$image_url = "";
$agent_name = "";
$permalink =  get_home_url();

if (!$wioListing) {
	#$terms_page_id = get_option('terms_condition');
	$property_id = $this->getDataDetails('ref');
	$proTitle = $this->getProTitle();
	$image_url = !empty($this->getDataDetails('agent_photo')) ? $this->getDataDetails('agent_photo') : '' ;
	$agent_name = !empty($this->getDataDetails('agent_name')) ? $this->getDataDetails('agent_name') : '' ;

	$permalink = esc_url($urlProDetail.$this->getDataDetails('category_name').'/'.$this->getDataDetails('pro_alias'));
}

$agent_number = isset($contactInfo->mobile) ? $contactInfo->mobile :  $contactInfo->phone;
$agent_whatsapp_call = isset($contactInfo->mobile) ? $contactInfo->mobile :  $contactInfo->phone;
$agent_mobile_call = isset($contactInfo->mobile) ? $contactInfo->mobile :  $contactInfo->phone;
$user_name = '';
$user_email = '';
$send_btn_class = 'btn-full-width';

$action_class = "advmls-send-message";

$agent_email = is_email($contactInfo->email);

$agent_mobile_num = 1;
$agent_whatsapp_num = 1;

$whatsappBtnClass = "btn-full-width mt-10";
$messageBtnClass = "btn-full-width mt-10";

$agent_display = "block";


if ($agent_email && $agent_display != 'none') {

$urlProDetail = mlsUrlFactory::getInstance()->getListingDetailUrl(true);

?>
<div class="property-form-wrap">
	<div class="property-form clearfix">
		<form method="post" action="#">
            <?php if(!empty($image_url)) { ?>
				<div class="agent-details">
	                <div class="d-flex align-items-center">
	                    <div class="agent-image">
	                        <img class="rounded" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($agent_name); ?>" style="max-width: 80px; max-height: 80px;">
	                    </div>
	                    <ul class="agent-information list-unstyled">
	                        <li class="agent-name">
	                            <i class="advmls-icon icon-single-neutral mr-1"></i> 
	                            <?php echo esc_attr($agent_name); ?>
	                        </li>
	                    </ul>

	                </div><!-- d-flex -->
	            </div><!-- agent-details -->
            <?php } ?>
			<div class="form-group">
				<input class="form-control" name="name" value="<?php echo esc_attr($user_name); ?>" type="text" placeholder="<?php echo 'Name'; ?>">
			</div><!-- form-group -->

			<div class="form-group">
				<input class="form-control" name="mobile" value="" type="text" placeholder="<?php echo 'Phone'; ?>">
			</div><!-- form-group -->

			<div class="form-group">
				<input class="form-control" name="email" value="<?php echo esc_attr($user_email); ?>" type="email" placeholder="<?php echo 'Email'; ?>">
			</div><!-- form-group -->

			<div class="form-group form-group-textarea">
				<textarea class="form-control hz-form-message" name="message" rows="4" placeholder="<?php echo 'Message'; ?>"><?php echo "Hello, I am interested in"; ?> [<?php echo $proTitle; ?>]</textarea>
			</div><!-- form-group -->	

			<div class="form-group">
				<select name="user_type" class="selectpicker form-control bs-select-hidden" title="<?php echo 'Select'; ?>">
					<option value="buyer"><?php echo "I'm a buyer"; ?></option>
					<option value="other"><?php echo 'Other'; ?></option>
				</select><!-- selectpicker -->
			</div><!-- form-group -->	
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
	        <input type="hidden" name="target_email" value="<?php echo antispambot($agent_email); ?>">
	        <input type="hidden" name="property_agent_contact_security" value="<?php echo wp_create_nonce('property_agent_contact_nonce'); ?>"/>
	        <input type="hidden" name="property_permalink" value="<?php echo $permalink ?>"/>
	        <input type="hidden" name="property_title" value="<?php echo esc_attr($proTitle); ?>"/>
	        <input type="hidden" name="property_id" value="<?php echo esc_attr($property_id); ?>"/>
	        <input type="hidden" name="action" value="advmls_property_agent_contact">
	        <input type="hidden" name="listing_id" value="<?php echo intval($property_id)?>">
	        <input type="hidden" name="is_listing_form" value="yes">

	        <div class="form_messages"></div>
			<button type="button" class="advmls_agent_property_form btn submit <?php echo esc_attr($send_btn_class); ?>">
				<?php echo 'Send Email'; ?>
			</button>
			<?php if ( !empty($agent_number) && $agent_mobile_num && !wp_is_mobile() ) : ?>
			<a href="tel:<?php echo esc_attr($agent_mobile_call); ?>" class="btn btn-secondary-outlined border-initial-color btn-full-width">
				<!-- <button type="button" class="btn"> -->
					<span class="hide-on-click"><?php echo 'Call'; ?></span>
					<span class="show-on-click"><?php echo esc_attr($agent_number); ?></span>
				<!-- </button> -->
			</a>

			<a class="btn btn-success btn-full-width mt-2" href="https://api.whatsapp.com/send?phone=<?php echo esc_attr($agent_number) ?>&amp;text=<?php echo $permalink ?>" target="_blank" title="Share property via Whatsapp">
				<span class="text-icon" style="display: block;">Whatsapp</span>
			</a>

			<?php endif; ?>

		</form>
	</div><!-- property-form -->
</div><!-- property-form-wrap -->
<?php } ?>