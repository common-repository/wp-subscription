<?php
$form_id=999;

            $wp_subscription_title = empty(get_option('wp_subscription_title')) ? "Subscribe" : get_option('wp_subscription_title');
             $wp_subscription_sub_title = empty(get_option('wp_subscription_sub_title')) ? " " : get_option('wp_subscription_sub_title');

             $wp_subscription_enable_first_name = empty(get_option('wp_subscription_enable_first_name')) ? " " : get_option('wp_subscription_enable_first_name');

             $wp_subscription_enable_last_name = empty(get_option('wp_subscription_enable_last_name')) ? " " : get_option('wp_subscription_enable_last_name');

             $wp_subscription_first_name = empty(get_option('wp_subscription_first_name')) ? "First Name" : get_option('wp_subscription_first_name');

             $wp_subscription_last_name = empty(get_option('wp_subscription_last_name')) ? "Last Name" : get_option('wp_subscription_last_name');

               $wp_subscription_email_label = empty(get_option('wp_subscription_email_label')) ? "Email" : get_option('wp_subscription_email_label');

               $wp_subscription_button_label = empty(get_option('wp_subscription_button_label')) ? "Subscribe" : get_option('wp_subscription_button_label');


               $wp_subscription_error_msg_required = empty(get_option('wp_subscription_error_msg_required')) ? "Requred * field" : get_option('wp_subscription_error_msg_required');

               $wp_subscription_error_msg_invalid_email = empty(get_option('wp_subscription_error_msg_invalid_email')) ? "Invalid Email" : get_option('wp_subscription_error_msg_invalid_email');

                $wp_subscription_error_msg_email_exist = empty(get_option('wp_subscription_error_msg_email_exist')) ? "Email address already exist" : get_option('wp_subscription_error_msg_email_exist');

                $wp_subscription_success_msg = empty(get_option('wp_subscription_success_msg')) ? "Thank you for your subscription." : get_option('wp_subscription_success_msg');

                 $wp_subscription_appearance_skin = empty(get_option('wp_subscription_appearance_skin')) ? " " : get_option('wp_subscription_appearance_skin');

                  $wp_subscription_appearance_icon = empty(get_option('wp_subscription_appearance_icon')) ? ")" : get_option('wp_subscription_appearance_icon');


                  $wp_subscription_appearance_custom_css = empty(get_option('wp_subscription_appearance_custom_css')) ? "" : get_option('wp_subscription_appearance_custom_css');

                    $wp_subscription_language = empty(get_option('wp_subscription_language')) ? "English" : get_option('wp_subscription_language');
          
          
               $list_id=get_option('list_id');
          

 if(isset($atts['id'])){
                    global $wpdb;   
                   
                    $form_id= $index= $atts['id']; 
                    $forms = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpsp_forms WHERE id=$index" );
                     $data = array();
                 if(!empty($forms)) {                  
                foreach ($forms as $category)  
                 {
                     //Form Setting
            
           $wp_subscription_title = (empty($category->wp_subscription_title)) ? $wp_subscription_title : $category->wp_subscription_title;
            $wp_subscription_sub_title = (empty($category->wp_subscription_sub_title)) ? '' : $category->wp_subscription_sub_title;

             $wp_subscription_first_name = (empty($category->wp_subscription_first_name)) ? $wp_subscription_first_name : $category->wp_subscription_first_name;

              $wp_subscription_last_name = (empty($category->wp_subscription_last_name)) ? $wp_subscription_last_name : $category->wp_subscription_last_name;

            $wp_subscription_enable_first_name =$category->wp_subscription_enable_first_name;   
           
            $wp_subscription_enable_last_name = $category->wp_subscription_enable_last_name;

            $wp_subscription_email_label = (empty($category->wp_subscription_email_label)) ? $wp_subscription_email_label : $category->wp_subscription_email_label;

             $wp_subscription_button_label = (empty($category->wp_subscription_button_label)) ? $wp_subscription_button_label : $category->wp_subscription_button_label;

             $wp_subscription_error_msg_required = (empty($category->wp_subscription_error_msg_required)) ? $wp_subscription_error_msg_required : $category->wp_subscription_error_msg_required;

              $wp_subscription_error_msg_invalid_email = (empty($category->wp_subscription_error_msg_invalid_email)) ? $wp_subscription_error_msg_invalid_email : $category->wp_subscription_error_msg_invalid_email;

               $wp_subscription_error_msg_email_exist = (empty($category->wp_subscription_error_msg_email_exist)) ? $wp_subscription_error_msg_email_exist : $category->wp_subscription_error_msg_email_exist;


               $wp_subscription_success_msg = (empty($category->wp_subscription_success_msg)) ? $wp_subscription_success_msg : $category->wp_subscription_success_msg;
         
         
            
             $list_id=$category->list_id;           
           
            //Form Setting -Appearance           
            $wp_subscription_appearance_skin = $category->wp_subscription_appearance_skin;
            $wp_subscription_appearance_icon = $category->wp_subscription_appearance_icon; 
            $wp_subscription_appearance_custom_css = $category->wp_subscription_appearance_custom_css;  
            $wp_subscription_language = $category->wp_subscription_language;  
                 }
             }
}