<?php 

add_action( 'wp_ajax_nopriv_advmls_contact_realtor', 'advmls_contact_realtor' );
add_action( 'wp_ajax_advmls_contact_realtor', 'advmls_contact_realtor' );
if( !function_exists( 'advmls_contact_realtor' ) ) {
    function advmls_contact_realtor() {

        $captchaInput = isset($_POST['captchaInput']) ? $_POST['captchaInput'] : 0 ;
        $txtCaptcha = isset($_POST['txtCaptcha']) ? $_POST['txtCaptcha'] : '0+0';
        $numsCaptcha = explode('+', $txtCaptcha);
        $resultCaptcha = $numsCaptcha[0] + $numsCaptcha[1];

        if ( (int)$captchaInput != (int)$resultCaptcha or (int)$resultCaptcha <= 0 ) {
            echo json_encode(array(
                'success' => false,
                'msg' => esc_html__('Captcha Answer Invalid!', 'advmls')
            ));
            wp_die();
        }

        $sender_phone = isset($_POST['mobile']) ? sanitize_text_field( $_POST['mobile'] ) : '';
        $user_type = isset($_POST['user_type']) ? sanitize_text_field( $_POST['user_type'] ) : '';
        $agent_type = isset($_POST['agent_type']) ? sanitize_text_field( $_POST['agent_type'] ) : '';
        $user_type = advmls_get_form_user_type($user_type); 

        $target_email = sanitize_email($_POST['target_email']);
        $target_email = is_email($target_email);
        if (!$target_email) {
            echo json_encode(array(
                'success' => false,
                'msg' => sprintf( esc_html__('%s Target Email address is not properly configured!', 'advmls'), $target_email )
            ));
            wp_die();
        }


        $sender_name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        if ( empty($sender_name) ) {
            echo json_encode(array(
                'success' => false,
                'msg' => esc_html__('Name field is empty!', 'advmls')
            ));
            wp_die();
        }

        $sender_email = sanitize_email($_POST['email']);
        $sender_email = is_email($sender_email);
        if (!$sender_email) {
            echo json_encode(array(
                'success' => false,
                'msg' => esc_html__('Provided Email address is invalid!', 'advmls')
            ));
            wp_die();
        }

        $sender_msg = isset($_POST['message']) ? $_POST['message'] : '';
        if ( empty($sender_msg) ) {
            echo json_encode(array(
                'success' => false,
                'msg' => esc_html__('Your message empty!', 'advmls')
            ));
            wp_die();
        }

        
        if( get_option('advmls_privacy_policy_enable', 0) ) {
            $privacy_policy = $_POST['privacy_policy'];
            if ( empty($privacy_policy) ) {
                echo json_encode(array(
                    'success' => false,
                    'msg' => 'agent_forms_terms_validation'
                ));
                wp_die();
            }
        }
        
        $email_subject = sprintf( esc_html__('New message sent by %s using contact form at %s', 'advmls'), $sender_name, get_bloginfo('name') );

        $email_body = esc_html__("You have received a message from: ", 'advmls') . $sender_name . " <br/>";
        if (!empty($sender_phone)) {
            $email_body .= esc_html__("Phone Number : ", 'advmls') . $sender_phone . " <br/>";
        }
        if (!empty($user_type)) {
            $email_body .= esc_html__("User Type : ", 'advmls') . $user_type . " <br/>";
        }
        $email_body .= esc_html__("Additional message is as follows.", 'advmls') . " <br/>";
        $email_body .= wp_kses_post( wpautop( wptexturize( $sender_msg ) ) ) . " <br/>";
        $email_body .= sprintf( esc_html__( 'You can contact %s via email %s', 'advmls'), $sender_name, $sender_email );

        $headers = array();
        $headers[] = "From: $sender_name <$sender_email>";
        $headers[] = "Reply-To: $sender_name <$sender_email>";
        $headers[] = "Content-Type: text/html; charset=UTF-8";
        $headers = apply_filters( "advmls_realtors_mail_header", $headers );// Filter for modify the header in child theme

        if (wp_mail( $target_email, $email_subject, $email_body, $headers)) {
            echo json_encode( array(
                'success' => true,
                'msg' => esc_html__("Message Sent Successfully!", 'advmls')
            ));

        } else {
            echo json_encode(array(
                    'success' => false,
                    'msg' => esc_html__("Server Error: Make sure Email function working on your server!", 'advmls')
                )
            );
        }

        $activity_args = array(
            'type' => 'lead_agent',
            'name' => $sender_name,
            'email' => $sender_email,
            'phone' => $sender_phone,
            'user_type' => $user_type,
            'message' => $sender_msg,
        );
        #do_action('advmls_record_activities', $activity_args);

       	#do_action('advmls_after_agent_form_submission');
        
        wp_die();
    }
}


add_action( 'wp_ajax_nopriv_advmls_property_agent_contact', 'advmls_property_agent_contact' );
add_action( 'wp_ajax_advmls_property_agent_contact', 'advmls_property_agent_contact' );
if( !function_exists('advmls_property_agent_contact') ) {
    function advmls_property_agent_contact() {

        $agent_forms_terms = get_option('agent_forms_terms');
        $hide_form_fields = get_option('hide_prop_contact_form_fields');

        $captchaInput = isset($_POST['captchaInput']) ? $_POST['captchaInput'] : 0 ;
        $txtCaptcha = isset($_POST['txtCaptcha']) ? $_POST['txtCaptcha'] : '0+0';
        $numsCaptcha = explode('+', $txtCaptcha);
        $resultCaptcha = $numsCaptcha[0] + $numsCaptcha[1];

        if ( (int)$captchaInput != (int)$resultCaptcha or (int)$resultCaptcha <= 0 ) {
            echo json_encode(array(
                'success' => false,
                'msg' => esc_html__('Captcha Answer Invalid!', 'advmls')
            ));
            wp_die();
        }

        $property_id = isset($_POST['property_id']) ? sanitize_text_field( $_POST['property_id'] ) : '';
        $sender_phone = isset($_POST['mobile']) ? sanitize_text_field( $_POST['mobile'] ) : '';
        $property_link = esc_url( $_POST['property_permalink'] );
        $property_title = sanitize_text_field( $_POST['property_title'] );

        $user_type = isset($_POST['user_type']) ? sanitize_text_field( $_POST['user_type'] ) : '';
        $user_type = advmls_get_form_user_type($user_type);

        $target_email = $_POST['target_email'];
        if ( !is_array( $target_email ) ) {
            $target_email = is_email($target_email);
        }
        if (!$target_email) {
            echo json_encode(array(
                'success' => false,
                'msg' => sprintf( ('%s Email address is not configured!'), $target_email )
            ));
            wp_die();
        }

        $sender_name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        if ( empty($sender_name) && $hide_form_fields['name'] != 1 ) {
            echo json_encode(array(
                'success' => false,
                'msg' => ('Name field is empty!')
            ));
            wp_die();
        }

        
        if ( empty($sender_phone) && $hide_form_fields['phone'] != 1 ) {
            echo json_encode(array(
                'success' => false,
                'msg' => ('Phone field is empty!')
            ));
            wp_die();
        }

        $sender_email = sanitize_email($_POST['email']);
        $sender_email = is_email($sender_email);
        if (!$sender_email) {
            echo json_encode(array(
                'success' => false,
                'msg' => ('Invalid email address!')
            ));
            wp_die();
        }

        $sender_msg = stripslashes( $_POST['message'] );
        if ( empty($sender_msg) && $hide_form_fields['message'] != 1 ) {
            echo json_encode(array(
                'success' => false,
                'msg' => ('Your message is empty!')
            ));
            wp_die();
        }

        
        if( get_option('advmls_privacy_policy_enable', 0) ) {
            $privacy_policy = $_POST['privacy_policy'];
            if ( empty($privacy_policy) ) {
                echo json_encode(array(
                    'success' => false,
                    'msg' => ('agent_forms_terms_validation')
                ));
                wp_die();
            }
        }

        $cc_email = '';
        $bcc_email = '';
        $send_message_copy = get_option('send_agent_message_copy');
        if( $send_message_copy == '1' ){
            $cc_email = get_option( 'send_agent_message_email' );
        }

        $args = array(
            'sender_name' => $sender_name, 
            'sender_email' => $sender_email, 
            'sender_phone' => $sender_phone, 
            'property_title' => $property_title, 
            'property_link' => $property_link, 
            'property_id' => $property_id, 
            'user_type' => $user_type, 
            'sender_message' => $sender_msg, 
        );

        $email_sent = advmls_email_with_reply( $target_email, 'property_agent_contact', $args, $sender_name, $sender_email, $cc_email, $bcc_email);


        if ( $email_sent ) {

            echo json_encode( array(
                'success' => true,
                'msg' => esc_html__("Email Sent Successfully!", 'advmls')
            ));
        } else {
            echo json_encode(array(
                    'success' => false,
                    'msg' => esc_html__("Server Error: Make sure Email function working on your server!", 'advmls')
                )
            );
        }

        $activity_args = array(
            'type' => 'lead',
            'name' => $sender_name,
            'email' => $sender_email,
            'phone' => $sender_phone,
            'user_type' => $user_type,
            'message' => $sender_msg,
        );
        #do_action('advmls_record_activities', $activity_args);

       # do_action('advmls_after_agent_form_submission');
        

        wp_die();

    }
}


if (!function_exists('advmls_email_with_reply')) {
    function advmls_email_with_reply( $email, $email_type, $args, $sender_name, $sender_email, $cc_email, $bcc_email ) {

        $defaul_subject = "New message sent by %sender_name using agent contact form at %website_name";
        $defaul_message = "You have received new message from: %sender_name
Property Title : %property_title
Property URL : %property_link
Property ID : %property_id
Phone Number : %sender_phone
User Type : %user_type
Additional message is
%sender_message
You can contact %sender_name via email %sender_email or via phone %sender_phone";

        $value_message = get_option('advmls_property_agent_contact', $defaul_message);
        $value_subject = get_option('advmls_subject_property_agent_contact', $defaul_subject);

        do_action( 'wpml_register_single_string', 'advmls', 'advmls_email_' . $value_message, $value_message );
        do_action( 'wpml_register_single_string', 'advmls', 'advmls_email_subject_' . $value_subject, $value_subject );

        $value_message = apply_filters('wpml_translate_single_string', $value_message, 'advmls', 'advmls_email_' . $value_message );
        $value_subject = apply_filters('wpml_translate_single_string', $value_subject, 'advmls', 'advmls_email_subject_' . $value_subject );

        return advmls_emails_maker( $email, $value_message, $value_subject, $args, $sender_name, $sender_email, $cc_email, $bcc_email);
    }
}


if( !function_exists('advmls_emails_maker')):
    function  advmls_emails_maker( $email, $message, $subject, $args, $sender_name, $sender_email, $cc_email, $bcc_email ) {
        $args ['website_url'] = get_option('siteurl');
        $args ['website_name'] = get_option('blogname');
        $args ['user_email'] = $email;
        $user = get_user_by( 'email',$email );
        $args ['username'] = $user->user_login;

        foreach( $args as $key => $val){
            $subject = str_replace( '%'.$key, $val, $subject );
            $message = str_replace( '%'.$key, $val, $message );
        }

        return advmls_send_emails_with_reply( $email, $subject, $message, $sender_name, $sender_email, $cc_email, $bcc_email );
        
    }
endif;

if( !function_exists('advmls_send_emails_with_reply') ):
    function advmls_send_emails_with_reply( $user_email, $subject, $message, $sender_name, $sender_email, $cc_email, $bcc_email ){
        $headers = array();
        
        $enable_html_emails = get_option('enable_html_emails');
        $enable_email_header = get_option('enable_email_header');
        $enable_email_footer = get_option('enable_email_footer');

        $cc_header = '';
        if ( ! empty( $cc_email ) ) {
            $cc_email = sanitize_email( $cc_email );
            $cc_email = is_email( $cc_email );
            $cc_header = 'Cc: ' . $cc_email . "\r\n";
        }

        $headers[] = "From: $sender_name <$sender_email>";
        $headers[] = "Reply-To: $sender_name <$sender_email>";
        if( $enable_html_emails != 0 ) {
            $headers[] = "Content-Type: text/html; charset=UTF-8";
        }
        $headers = apply_filters( "advmls_send_mails_header", $headers );// Filter for modify the header in child theme

        $enable_html_emails = get_option('enable_html_emails');
        $email_head_logo = get_option('email_head_logo', false, 'url');
        $email_head_bg_color = get_option('email_head_bg_color');
        $email_foot_bg_color = get_option('email_foot_bg_color');
        $email_footer_content = get_option('email_footer_content');

        $social_1_icon = get_option('social_1_icon', false, 'url');
        $social_1_link = get_option('social_1_link');
        $social_2_icon = get_option('social_2_icon', false, 'url');
        $social_2_link = get_option('social_2_link');
        $social_3_icon = get_option('social_3_icon', false, 'url');
        $social_3_link = get_option('social_3_link');
        $social_4_icon = get_option('social_4_icon', false, 'url');
        $social_4_link = get_option('social_4_link');

        $message = ( ( wptexturize( $message ) ) );

        $socials = '';
        if( !empty($social_1_icon) || !empty($social_2_icon) || !empty($social_3_icon) || !empty($social_4_icon) ) {
            $socials = '<div style="font-size: 0; text-align: center; padding-top: 20px;">';
            $socials .= '<p style="margin:0;margin-bottom: 10px; text-align: center; font-size: 14px; color:#777777;">'.esc_html__('Follow us on', 'advmls').'</p>';

            if( !empty($social_1_icon) ) {
                $socials .= '<a href="'.esc_url($social_1_link).'" style="margin-right: 5px"><img src="'.esc_url($social_1_icon).'" width="" height="" alt=""> </a>';
            }
            if( !empty($social_2_icon) ) {
                $socials .= '<a href="'.esc_url($social_2_link).'" style="margin-right: 5px"><img src="'.esc_url($social_2_icon).'" width="" height="" alt=""> </a>';
            }
            if( !empty($social_3_icon) ) {
                $socials .= '<a href="'.esc_url($social_3_link).'" style="margin-right: 5px"><img src="'.esc_url($social_3_icon).'" width="" height="" alt=""> </a>';
            }
            if( !empty($social_4_icon) ) {
                $socials .= '<a href="'.esc_url($social_4_link).'" style="margin-right: 5px"><img src="'.esc_url($social_4_icon).'" width="" height="" alt=""> </a>';
            }

            $socials .= '</div>';
        }

        if( $enable_email_header != 0 ) {
            $email_content = '<div style="text-align: center; background-color: ' . esc_attr($email_head_bg_color) . '; padding: 16px 0;">
                            <img src="' . esc_url($email_head_logo) . '" alt="logo">
                        </div>';
        }

        $email_content .= '<div style="background-color: #F6F6F6; padding: 30px;">
                            <div style="margin: 0 auto; width: 620px; background-color: #fff;border:1px solid #eee; padding:30px;">
                                <div style="font-family:\'Helvetica Neue\',\'Helvetica\',Helvetica,Arial,sans-serif;font-size:100%;line-height:1.6em;display:block;max-width:600px;margin:0 auto;padding:0">
                                '.$message.'
                                </div>
                            </div>
                        </div>';

        if( $enable_email_footer != 0 ) {
            $email_content .= '<div style="padding-top: 30px; text-align:center; padding-bottom: 30px; font-family:\'Helvetica Neue\',\'Helvetica\',Helvetica,Arial,sans-serif;">

                            <div style="width: 640px; background-color: ' . $email_foot_bg_color . '; margin: 0 auto;">
                                ' . $email_footer_content . '
                            </div>
                            ' . $socials . '
                        </div>';
        }

        if( $enable_html_emails != 0 ) {
            $email_messages = $email_content;
        } else {
            $email_messages = $message;
        }


        if ( ! empty( $bcc_email ) ) {
            $bcc_emails = explode( ',', $bcc_email );
            foreach ( $bcc_emails as $bcc_email ) {
                wp_mail( trim( $bcc_email ), $subject, $email_messages, $headers );
            }
        }

        $headers[] = $cc_header;

        $email_sent = @wp_mail(
            $user_email,
            $subject,
            $email_messages,
            $headers
        );

        return $email_sent;

    };
endif;


function advmls_formCaptcha(){

    $inputCaptcha  = '<div class="input-group mb-3">';
        $inputCaptcha  .= '<div class="input-group-prepend">';
        $inputCaptcha  .=   '<span class="input-group-text captchaDiv">5 + 5</span>';
        $inputCaptcha  .= '</div>';
        $inputCaptcha  .= '<input type="number" aria-label="Default" aria-describedby="inputGroup-sizing-default" class="form-control" name="captchaInput" id="captchaInput" size="15" placeholder="Type the answer:">';
        $inputCaptcha  .= '<input type="hidden" class="txtCaptcha" value="" name="txtCaptcha">';
        $inputCaptcha  .= '</div>';

    return $inputCaptcha;
}

?>