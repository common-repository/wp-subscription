<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_action( 'wp_footer', array('WPSPActionModule', 'wp_subscription_footer_popup'));
add_action('wp_subscription_add_subscriber',array('WPSPActionModule',  'wp_subscription_action_register_function'));
 add_filter('wp_subscription_filter_email', array('WPSPActionModule', 'wp_subscription_filter_email_function'), 10, 6);
add_action('wp_subscription_add_subscriber',array('WPSPActionModule',  'wp_subscription_action_mailchimp_function'));


class WPSPActionModule {    

    public static function wp_subscription_footer_popup() {
            $wp_subscription_popup_pages_list=array();
            $wp_subscription_popup_pages_list =explode(',',get_option('pageids'));
            $wpsp_form_popup = get_option('wpsp_form_popup');
            $current_page=get_the_ID();        
            if(in_array($current_page,$wp_subscription_popup_pages_list)){
               echo do_shortcode("[wp_subscription id='".$wpsp_form_popup."' type='popup']");
           }
    }


      public static function wp_subscription_action_register_function(&$args) {
        //error_log("WP USER :Inside wp_subscription_action_register action");
        $to = $args[1];
        $wp_subscription_email_name = get_option('wp_subscription_email_name');
        $wp_subscription_email_id = get_option('wp_subscription_email_id');
        $sender = !empty($wp_subscription_email_name) ? $wp_subscription_email_name : get_option('blogname');
        $email = !empty($wp_subscription_email_id) ? $wp_subscription_email_id : get_option('admin_email');
        $subject = get_option('wp_subscription_email_admin_register_subject');
        $site_url = site_url();
        $headers[] = 'MIME-Version: 1.0' . "\r\n";
        $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers[] = "X-Mailer: PHP \r\n";
        $headers[] = 'From: ' . $sender . ' < ' . $email . '>' . "\r\n";

        if (get_option('wp_subscription_email_admin_register_enable')) {
            //error_log("WP USER :Inside wp_subscription_email_admin_register_enable");
            $email_header_text = get_option('wp_subscription_email_admin_register_subject');
            $email_body_text = apply_filters('wp_subscription_filter_email', get_option('wp_subscription_email_admin_register_content'), $args[0],$to, $args[2],$args[3]);
            $email_footer_text = 'You\'re receiving this email because you have enablr subscribe notification on ' . $site_url;
            include(WPSP_PLUGIN_DIR . 'includes/module/templateEmail/template_email_defualt.php');
            $mail = wp_mail($email, $subject, $message, $headers);
           // error_log($message);
           // error_log("WP Subscription :New user subscription: Mail send to Admin");
        }

        if (get_option('wp_subscription_email_user_register_enable')) {
            //error_log("WP USER :Inside wp_subscription_email_user_register_enable");
            $email_header_text = get_option('wp_subscription_email_user_register_subject');
            $email_body_text = apply_filters('wp_subscription_filter_email', get_option('wp_subscription_email_user_register_content'),  $args[0],$to, $args[2],$args[3]);
            $email_footer_text = 'You\'re receiving this email because you have subscribe on ' . $site_url;
            include(WPSP_PLUGIN_DIR . 'includes/module/templateEmail/template_email_defualt.php');
            $mail = wp_mail($to, $subject, $message, $headers);
           // error_log($message);
           // error_log("WP Subscription :New user subscription: Mail send to $to");
        }
    }

     public static function wp_subscription_action_mailchimp_function(&$args) {
                    $mailchimp_apikey = get_site_option('mailchimp_apikey');
                    if ( ! empty( $mailchimp_apikey ) && !empty($args[4])) {
                      $api = mailchimp_load_API();
                      $api->ping();

                         if ( empty( $api->errorMessage ) ) {
                              error_log("mailchimp enabled");
                              if ( is_integer( $args ) ) {
                                        $user = get_userdata( $args );
                                    }
                                    elseif ( is_array($args ) ) {
                                        $user = new stdClass;
                                        $user->spam = false;
                                        $user->deleted = false;
                                        $user->user_email =  $args[1];
                                        $user->user_firstname = $args[2];
                                        $user->user_lastname = $args[3];
                                    }
                                    else {
                                        return false;
                                    }

                                    //check for spam
                                    if ( $user->spam || $user->deleted )
                                    return false;

                                    //remove + sign emails
                                    if ( get_site_option('wp_subscription_enable_auto_opt_mailchimp') == '1' && strstr($user->user_email, '+') ) {
                                       return false;
                                    }

                                    $mailchimp_mailing_list =$args[4];// get_site_option('mailchimp_mailing_list');
                                    
           
                                 if(!empty(get_option('wp_subscription_enable_auto_opt_mailchimp'))){
                                    $mailchimp_auto_opt_in = 'yes';
                                 }else{
                                    $mailchimp_auto_opt_in = 'no';
                                 }
                                    //get_site_option('mailchimp_auto_opt_in');
                                    $api = mailchimp_load_API();

                                    $unsubscribed_list = mailchimp_get_unsubscribed_users( $api, $mailchimp_mailing_list );

                                    if ( in_array( $user->user_email, $unsubscribed_list ) )
                                        return false;

                                    if ( $mailchimp_auto_opt_in == 'yes' ) {
                                        $merge_vars = array( 'OPTINIP' => $_SERVER['REMOTE_ADDR'], 'FNAME' => $user->user_firstname, 'LNAME' => $user->user_lastname );
                                        $double_optin = false;
                                    } else {
                                        $merge_vars = array( 'FNAME' => $user->user_firstname, 'LNAME' => $user->user_lastname );
                                        $double_optin = true;
                                    }
                                    $merge_vars = apply_filters('mailchimp_merge_vars', $merge_vars, $user);

                                    $mailchimp_subscribe = $api->listSubscribe( $mailchimp_mailing_list, $user->user_email, $merge_vars, '', $double_optin );

                                    if ( ! $mailchimp_subscribe )
                                        mailchimp_log_errors( mailchimp_extract_api_errors( $api, $user->user_email ) );

                                    if (($api->errorCode) && ($api->errorCode != 214)) {
                                        $error = "MailChimp listSubscribe() Error: " . $api->errorCode . " - " . $api->errorMessage;
                                        trigger_error($error, E_USER_WARNING);
                                    }
                              }
                              else
                              {
                                    error_log("mailchimp desabled");
                                }
                     }

     }


     public static function wp_subscription_filter_email_function($value,$list_id= null, $userEmail = null, $userFirstName = null, $userLastName = null,$args=array()) {
        $wp_subscription_email_name = get_option('wp_subscription_email_name');
        $wp_subscription_email_id = get_option('wp_subscription_email_id');
        if(!empty($list_id)){
            $get_subscriber_list_name_by_id=WPSubscriptionModule::get_subscriber_list_name_by_id($list_id);
        }else{
            $get_subscriber_list_name_by_id='';
        }

         $campaign_type_id=(isset($args[5])) ? $args[5] : ''; 
         $campaign_type=(isset($args[4])) ? $args[4] : '';  
         $post_content="";     
         $post_title="";

         $post_permalink    =(!empty($campaign_type_id)) ? get_post_permalink($campaign_type_id) : '';

         $campaign_type_id=(isset($args[5])) ? $args[5] : '';

         if($campaign_type_id){
          $post_content=get_post_field('post_content', $campaign_type_id);
          $post_title=get_post_field('post_title',$campaign_type_id);  
        }        

        $replace = array(
            '{WPSP_ADMIN_EMAIL}' => !empty($wp_subscription_email_id) ? $wp_subscription_email_id : get_option('admin_email'),
            '{WPSP_BLOGNAME}' => get_option('blogname'),
            '{WPSP_LISTNAME}' =>$get_subscriber_list_name_by_id ,           
            '{WPSP_BLOG_ADMIN}' => !empty($wp_subscription_email_name) ? $wp_subscription_email_name : get_option('blogname'),
            '{WPSP_BLOG_URL}' => get_option('siteurl'),
            '{WPSP_FIRST_NAME}' => $userFirstName,
            '{WPSP_LAST_NAME}' => $userLastName,
            '{WPSP_EMAIL}' => $userEmail,
            '{WPSP_POST_PERMALINK}' => $post_permalink,
            '{WPSP_PRODUCT_NAME}' => $post_title,
            '{WPSP_PRODUCT_DESC}' => $post_content          
        );
        $value = str_replace(array_keys($replace), $replace, $value);       
        return $value;
    }   
}