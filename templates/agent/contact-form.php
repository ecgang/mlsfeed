<?php
global $agent;
$name = $agent->name;
$target_email = $agent->email;
$source_link = mlsUtility::getInstance()->advmls_esc_url(mlsUrlFactory::getInstance()->getAgentDetailUrl(true).$agent->alias);
$agent_id = $agent->id;
$agent_type = "agentmls";
?>
<div class="modal fade mobile-property-form" id="realtor-form">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <div class="property-form-wrap">
                    <div class="agent-details">
                        <div class="d-flex align-items-center">
                            
                            <ul class="agent-information list-unstyled">
                                <li class="agent-name">
                                    <i class="advmls-icon icon-single-neutral mr-1"></i> <?php echo esc_attr($name); ?>
                                </li>
                            </ul>

                        </div><!-- d-flex -->
                    </div><!-- agent-details -->

                    <div class="property-form clearfix">
                        <div class="form_messages"></div>

                        <form method="post">
                            <input type="hidden" id="target_email" name="target_email" value="<?php echo antispambot($target_email); ?>">
                            <input type="hidden" name="contact_realtor_ajax" id="contact_realtor_ajax" value="<?php echo wp_create_nonce('contact_realtor_nonce'); ?>"/>
                            <input type="hidden" name="action" value="advmls_contact_realtor" />
                            <input type="hidden" name="source_link" value="<?php echo esc_url($source_link)?>">
                            <input type="hidden" name="agent_id" value="<?php echo intval($agent_id)?>">
                            <input type="hidden" name="agent_type" value="<?php echo esc_attr($agent_type)?>">
                            <input type="hidden" name="realtor_page" value="yes">

                            <div class="form-group">
                                <input class="form-control" name="name" value="" type="text" placeholder="<?php esc_html_e('Your Name', 'advmls'); ?>">
                            </div><!-- form-group --> 

                            <div class="form-group">
                                <input class="form-control" name="mobile" value="" type="text" placeholder="<?php esc_html_e('Phone', 'advmls'); ?>">
                            </div><!-- form-group -->   

                            <div class="form-group">
                                <input class="form-control" name="email" value="" type="email" placeholder="<?php esc_html_e('Email', 'advmls'); ?>">
                            </div><!-- form-group --> 

                            <div class="form-group form-group-textarea">
                                <textarea class="form-control" name="message" rows="4" placeholder="<?php esc_html_e('Message', 'advmls'); ?>"><?php echo sprintf(esc_html__('Hi %s, I saw your profile on %s and wanted to see if i can get some help', 'advmls'), $name, get_option('blogname')); ?></textarea>
                            </div><!-- form-group -->

                            <div class="form-group">
                                <select name="user_type" class="selectpicker form-control bs-select-hidden" title="<?php echo get_option('spl_con_select', 'Select'); ?>">
                                    <option value="buyer"><?php echo get_option('spl_con_buyer', "I'm a buyer"); ?></option>
                                    <option value="other"><?php echo get_option('spl_con_other', 'Other'); ?></option>
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
                           
                            <button id="contact_realtor_btn" type="button" class="btn submit btn-full-width">
                                <?php esc_html_e('Submit', 'advmls'); ?>
                            </button>
                        </form>
                    </div><!-- property-form -->
                </div><!-- property-form-wrap -->
            </div>
        </div>
    </div>
</div>