<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

final class WPSubscriptionSettingController {

    function get_setting() {
        global $wpdb;
        $data = array();      
        

            //Form Setting
            $data['wp_subscription_title'] = get_option('wp_subscription_title');
            $data['wp_subscription_sub_title'] = get_option('wp_subscription_sub_title');
            $data['wp_subscription_enable_first_name'] = (get_option('wp_subscription_enable_first_name'));   
            $data['wp_subscription_first_name'] = get_option('wp_subscription_first_name');             
            $data['wp_subscription_enable_last_name'] = get_option('wp_subscription_enable_last_name');
            $data['wp_subscription_last_name'] = get_option('wp_subscription_last_name'); 
            $data['wp_subscription_email_label'] = get_option('wp_subscription_email_label');  
            $data['wp_subscription_button_label'] = get_option('wp_subscription_button_label');  

            //Form Setting - Error Messages
            $data['wp_subscription_error_msg_required'] = get_option('wp_subscription_error_msg_required');
            $data['wp_subscription_error_msg_invalid_email'] = get_option('wp_subscription_error_msg_invalid_email');
            $data['wp_subscription_error_msg_email_exist'] = (get_option('wp_subscription_error_msg_email_exist'));   
            $data['wp_subscription_success_msg'] = get_option('wp_subscription_success_msg');             
           
            //Form Setting -Appearance           
            $data['wp_subscription_appearance_skin'] = get_option('wp_subscription_appearance_skin');
            $data['wp_subscription_appearance_icon'] = get_option('wp_subscription_appearance_icon'); 
            $data['wp_subscription_appearance_custom_css'] = get_option('wp_subscription_appearance_custom_css');  
            $data['wp_subscription_language'] = get_option('wp_subscription_language');  
            $data['selectedpageids'] =explode(',',get_option('pageids'));
            $data['wpsp_form_popup'] = get_option('wpsp_form_popup');
            $data['wpsp_form_popup_count'] = get_option('wpsp_form_popup_count');
            $data['wpsp_form_popup_time'] = get_option('wpsp_form_popup_time');


            //Admin Notification
            $data['wp_subscription_email_name'] = get_option('wp_subscription_email_name');
            $data['wp_subscription_email_id'] = get_option('wp_subscription_email_id');  
            //admin
            $data['wp_subscription_email_admin_register_enable'] = get_option('wp_subscription_email_admin_register_enable');
            $data['wp_subscription_email_admin_register_subject'] = get_option('wp_subscription_email_admin_register_subject');
            $data['wp_subscription_email_admin_register_content'] = get_option('wp_subscription_email_admin_register_content');  
            //user
            $data['wp_subscription_email_user_register_enable'] = get_option('wp_subscription_email_user_register_enable');
            $data['wp_subscription_email_user_register_subject'] = get_option('wp_subscription_email_user_register_subject');
            $data['wp_subscription_email_user_register_content'] = get_option('wp_subscription_email_user_register_content');

            $data['wp_subscription_register_list_id'] = get_option('wp_subscription_register_list_id');
            $data['wp_subscription_register_list_id_enable'] = get_option('wp_subscription_register_list_id_enable');

            $data['wp_subscription_wp_user_register_list_id'] = get_option('wp_subscription_wp_user_register_list_id');
            $data['wp_subscription_wp_user_register_list_id_enable'] = get_option('wp_subscription_wp_user_register_list_id_enable');

             $data['wp_subscription_comment_list_id_enable'] = get_option('wp_subscription_comment_list_id_enable');
            $data['wp_subscription_comment_list_id'] = get_option('wp_subscription_comment_list_id');
            
            global $wpdb;  
                $categories = $wpdb->get_results( "SELECT id,wp_subscription_title,created_date FROM {$wpdb->prefix}wpsp_forms");
 
                $dataform = array();
    
    foreach ($categories as $category){ 
                    $dataform[] = array(
                    "id"            => $category->id,
                    "wp_subscription_title"     => $category->wp_subscription_title
                    );
    }
           $data['wpsp_forms']=$dataform;

           $pages  = get_pages();
            $pageids = array();
                foreach ( $pages as $page ) {
                     $pageids[] = array(
                    "id"            =>$page->ID,
                    "text"     =>$page->post_name
                    );                   
                }
                $data['pageids']=$pageids;
                    print_r(json_encode($data));
                    die();
        //return json_encode($data);  
    }

    function update_setting() {

        global $wpdb;
        $cu = wp_get_current_user();
        if ($cu->has_cap('manage_options')) {
            $haystack= array('wp_subscription_show_term_data','wp_subscription_email_admin_register_content','wp_subscription_email_user_register_content','wp_subscription_email_user_forgot_content');
            $data = json_decode(file_get_contents("php://input"), true);
            foreach ($data as $key => $item) {
                if($key=='pageids' || $key=='categorieids'){
                    $item=implode(',', $item);
                }
                if(in_array($key, $haystack)){
                    update_option($key,($item));
                }else{
                    if($key=='wp_subscription_woocommerce_campaign_text'){
                         update_option($key,$item);
                    }else{                    
                        update_option($key, sanitize_text_field($item));
                    }
                }
            }
        }
        echo "true";
        die();
        //return json_encode($data);  
    }    

}
