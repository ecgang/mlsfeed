<?php
global $post, $current_user;
$return_array = advmls20_property_contact_form(false, true);
if(empty($return_array)) {
	return;
}
$terms_page_id = advmls_option('terms_condition');
$agent_display = advmls_get_listing_data('agent_display_option');
$property_id = advmls_get_listing_data('property_id');

$user_name = $user_email = '';
if(!advmls_is_admin()) {
	$user_name =  $current_user->display_name;
	$user_email =  $current_user->user_email;
}
$agent_email = is_email( $return_array['agent_email'] );
$hide_form_fields = advmls_option('hide_prop_contact_form_fields');

$action_class = "advmls-send-message";
$login_class = '';
$dataModel = '';
if( !is_user_logged_in() ) {
	$action_class = '';
	$login_class = 'msg-login-required';
	$dataModel = 'data-toggle="modal" data-target="#login-register-form"';
}

if($agent_display != 'none') {
?>
<div class="fw-property-contact-agent-wrap fw-property-section-wrap" id="property-contact-agent-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap">
			<h2><?php echo advmls_option('sps_contact_info', 'Contact Information'); ?></h2>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">
			
			<?php 
			if(advmls_form_type()) {

				echo $return_array['agent_data']; ?>

				<div class="block-title-wrap">
					<h3><?php echo advmls_option('sps_propperty_enqry', 'Enquire About This Property'); ?></h3>
				</div>

				<?php

				if(!empty(advmls_option('contact_form_agent_bottom'))) {
					echo do_shortcode(advmls_option('contact_form_agent_bottom'));
				}
			} else { ?>
			<form method="post" action="#">
				<?php echo $return_array['agent_data']; ?>

				<div class="block-title-wrap">
					<h3><?php echo advmls_option('sps_propperty_enqry', 'Enquire About This Property'); ?></h3>
				</div><!-- block-title-wrap -->

				<div class="form_messages"></div>
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label><?php echo advmls_option('spl_con_name', 'Name'); ?></label>
							<input class="form-control" name="name" placeholder="<?php echo advmls_option('spl_con_name_plac', 'Enter your name'); ?>" type="text">
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label><?php echo advmls_option('spl_con_phone', 'Phone'); ?></label>
							<input class="form-control" name="mobile" placeholder="<?php echo advmls_option('spl_con_phone_plac', 'Enter your Phone'); ?>" type="text">
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label><?php echo advmls_option('spl_con_email', 'Email'); ?></label>
							<input class="form-control" name="email" placeholder="<?php echo advmls_option('spl_con_email_plac', 'Enter your email address'); ?>" type="email">
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					
					<?php if( $hide_form_fields['usertype'] != 1 ) { ?>
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<label><?php esc_html_e("I'm a", 'advmls'); ?></label>
							<select name="user_type" class="selectpicker form-control bs-select-hidden" title="<?php echo advmls_option('spl_con_select', 'Select'); ?>">
								<option value="buyer"><?php echo advmls_option('spl_con_buyer', "I'm a buyer"); ?></option>
								<option value="tennant"><?php echo advmls_option('spl_con_tennant', "I'm a tennant"); ?></option>
								<option value="agent"><?php echo advmls_option('spl_con_agent', "I'm an agent"); ?></option>
								<option value="other"><?php echo advmls_option('spl_con_other', 'Other'); ?></option>
							</select><!-- selectpicker -->
						</div>
					</div><!-- col-md-6 col-sm-12 -->
					<?php } ?>

					<div class="col-sm-12 col-xs-12">
						<div class="form-group form-group-textarea">
							<label><?php echo advmls_option('spl_con_message', 'Message'); ?></label>
							<textarea class="form-control hz-form-message" name="message" rows="5" placeholder="<?php echo advmls_option('spl_con_message_plac', 'Message'); ?>"><?php echo advmls_option('spl_con_interested', "Hello, I am interested in"); ?> [<?php echo get_the_title(); ?>]</textarea>
						</div>
					</div><!-- col-sm-12 col-xs-12 -->

					<?php if( advmls_option('advmls_privacy_policy_enable', 0) ) { ?>
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

					<div class="col-sm-12 col-xs-12">
						<?php if ( $return_array['is_single_agent'] == true ) : ?>
				            <input type="hidden" name="target_email" value="<?php echo antispambot($agent_email); ?>">
				        <?php endif; ?>
				        <input type="hidden" name="property_agent_contact_security" value="<?php echo wp_create_nonce('property_agent_contact_nonce'); ?>"/>
				        <input type="hidden" name="property_permalink" value="<?php echo esc_url(get_permalink($post->ID)); ?>"/>
				        <input type="hidden" name="property_title" value="<?php echo esc_attr(get_the_title($post->ID)); ?>"/>
				        <input type="hidden" name="property_id" value="<?php echo esc_attr($property_id); ?>"/>
				        <input type="hidden" name="action" value="advmls_property_agent_contact">
				        <input type="hidden" class="is_bottom" value="bottom">
				        <input type="hidden" name="listing_id" value="<?php echo intval($post->ID)?>">
				        <input type="hidden" name="is_listing_form" value="yes">
				        <input type="hidden" name="agent_id" value="<?php echo intval($return_array['agent_id'])?>">
				        <input type="hidden" name="agent_type" value="<?php echo esc_attr($return_array['agent_type'])?>">

				        <?php get_template_part('template-parts/google', 'reCaptcha'); ?>

						<button class="advmls_agent_property_form btn btn-secondary btn-sm-full-width">
							<?php get_template_part('template-parts/loader'); ?>
							<?php echo advmls_option('spl_btn_request_info', 'Request Information'); ?>
						</button>

						<?php if( $return_array['is_single_agent'] == true && advmls_option('agent_direct_messages', 0) ) { ?>
						<button type="button" <?php echo $dataModel; ?> class="<?php echo esc_attr($action_class).' '.esc_attr($login_class); ?> btn btn-secondary-outlined btn-sm-full-width">
							<?php get_template_part('template-parts/loader'); ?>
							<?php echo advmls_option('spl_btn_message', 'Send Message'); ?>		
						</button>
						<?php } ?>
						
					</div><!-- col-sm-12 col-xs-12 -->
				</div><!-- row -->
			</form>
			<?php } ?>
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- fw-property-schedule-tour-wrap -->
<?php } ?>