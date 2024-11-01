<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

final class WPSubscriptionautoresponderController {

    function get_setting() {
        global $wpdb, $wp_version;
        $data = array();   
        $mailchimp_lists=array();
         $cu = wp_get_current_user();
        if ($cu->has_cap('manage_options')) {
            //Form Setting
            $inputData = json_decode(file_get_contents("php://input"), true);
            if(isset($inputData['mailchimp_apikey'])){
                 update_option('mailchimp_apikey', sanitize_text_field($inputData['mailchimp_apikey']));

                 if(isset($inputData['wp_subscription_enable_auto_opt_mailchimp'])){
                     update_option('wp_subscription_enable_auto_opt_mailchimp',sanitize_text_field($inputData['wp_subscription_enable_auto_opt_mailchimp']));
                }

                 if(isset($inputData['wp_subscription_enable_ignore_email_mailchimp'])){
                     update_option('wp_subscription_enable_ignore_email_mailchimp',sanitize_text_field($inputData['wp_subscription_enable_ignore_email_mailchimp']));
                }
            }

            

            

            $data['mailchimp_apikey'] = get_option('mailchimp_apikey');
            $data['wp_subscription_enable_auto_opt_mailchimp'] = get_option('wp_subscription_enable_auto_opt_mailchimp');
            $data['wp_subscription_enable_ignore_email_mailchimp'] = get_option('wp_subscription_enable_ignore_email_mailchimp');

            $data['mailchimp_apikey_list_message']="After you have entered a valid API key you will be able to select different MailChimp options on form.";
            $data['mailchimp_apikey_test'] ="NOT CONNECTED";
            $data['mailchimp_lists'] =$mailchimp_lists;

            $mailchimp_apikey = get_site_option('mailchimp_apikey');

             if ( ! empty( $mailchimp_apikey ) ) {
                $api = $this->mailchimp_load_API();
                $api->ping();
                $mailchimp_lists = $api->lists();
                $mailchimp_lists = $mailchimp_lists['data'];
            

            if ( empty( $api->errorMessage ) ) {
                 $data['mailchimp_apikey_test'] ="CONNECTED";
                  if ( !is_array( $mailchimp_lists ) || !count( $mailchimp_lists ) ) {
                  $data['mailchimp_apikey_list_message']="You must have at least one MailChimp mailing list in order to use this plugin. Please create a mailing list via the MailChimp admin panel.";
                  }else{
                    $data['mailchimp_lists'] = $mailchimp_lists;
                    $data['mailchimp_apikey_list_message']="Select a mailing list you want to have new users added to.(form setting). Following lists were found in your MailChimp account.";
                  }
             }else{
                $data['mailchimp_apikey_test'] ="Failed - Please check your key and try again.";
             }
            }
                 
                    print_r(json_encode($data));
                    die();
        //return json_encode($data);  
                }
    }

    function mailchimp_load_API() {
  $mailchimp_apikey = get_site_option('mailchimp_apikey');
  $api = new MCAPI($mailchimp_apikey);
  return $api;
}

       

}
