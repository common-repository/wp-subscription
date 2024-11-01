<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


final class WPSubscriptionModule {
	
        
        function add_subscriber(){
		
	
                $data = json_decode(file_get_contents("php://input"));                
                $cu = wp_get_current_user();
                $form='Form ';
             if(isset($data) && !empty($data)){

              if(isset($data->wp_subscription_token) && !empty($data->wp_subscription_token)) {
                         if(get_option('wp_subscription_token')!=sanitize_text_field($data->wp_subscription_token)){
                           $arr = array('status' => "warning", 'message' => 'Invalid Token');
                            print_r(json_encode($arr));die;
                       }                    
                   }else{
                     $arr = array('status' => "warning", 'message' => 'Invalid Token');
                      print_r(json_encode($arr));die;
                   } 

                   $frist_name=(isset($data->frist_name) && !empty($data->frist_name)) ? sanitize_text_field($data->frist_name) : '';

                   $last_name=(isset($data->last_name) && !empty($data->last_name)) ? sanitize_text_field($data->last_name) : '';

                    $email=(isset($data->email) && !empty($data->email)) ? sanitize_text_field($data->email) : '';

                   $list_id=(isset($data->list_id) && !empty($data->list_id)) ? sanitize_text_field($data->list_id) : '';
               }else if (isset($_POST) && !empty($_POST)){
                   
                   if(isset($_POST['wp_subscription_token']) && !empty($_POST['wp_subscription_token'])) {
                         if(get_option('wp_subscription_token')!=sanitize_text_field($_POST['wp_subscription_token'])){
                           $arr = array('status' => "warning", 'message' => 'Invalid Token');
                            print_r(json_encode($arr));die;
                       }                    
                   }else{
                     $arr = array('status' => "warning", 'message' => 'Invalid Token');
                      print_r(json_encode($arr));die;
                   }
                
                  $frist_name=(isset($_POST['frist_name']) && !empty($_POST['frist_name'])) ? sanitize_text_field($_POST['frist_name']) : '';

                   $last_name=(isset($_POST['last_name']) && !empty($_POST['last_name'])) ? sanitize_text_field($_POST['last_name']) : '';

                    $email=(isset($_POST['email']) && !empty($_POST['email'])) ? sanitize_text_field($_POST['email']) : '';

                   $list_id=(isset($_POST['list_id']) && !empty($_POST['list_id'])) ? sanitize_text_field($_POST['list_id']) : '';

                    $form =(isset($_POST['form']) && !empty($_POST['form'])) ? sanitize_text_field($_POST['form']) : '';

               }
              $arr=WPSubscriptionModule::add_subscriber_data($email,$list_id,$frist_name,$last_name,$form);
                   
    print_r(json_encode($arr));die;
    
        }
         public static function get_subscriber_list_name_by_id($list_id){
           global $wpdb;
           $categories = $wpdb->get_results( "SELECT id,list_name,list_defualt_email,list_defualt_from_name FROM {$wpdb->prefix}wpsp_list WHERE id=$list_id" );
                                    $data = array();
                foreach ($categories as $category)  
                 {
                    return $category->list_name;
                 }
         }

          public static function add_subscriber_data($email,$list_id,$frist_name,$last_name,$form=null){
              global $wpdb;

              $wp_subscription_error_msg_required = empty(get_option('wp_subscription_error_msg_required')) ? "Requred * field" : get_option('wp_subscription_error_msg_required');

               $wp_subscription_error_msg_invalid_email = empty(get_option('wp_subscription_error_msg_invalid_email')) ? "Invalid Email" : get_option('wp_subscription_error_msg_invalid_email');

                $wp_subscription_error_msg_email_exist = empty(get_option('wp_subscription_error_msg_email_exist')) ? "Email address already exist" : get_option('wp_subscription_error_msg_email_exist');

                $wp_subscription_success_msg = empty(get_option('wp_subscription_success_msg')) ? "Thank you for your subscription." : get_option('wp_subscription_success_msg');
                 $wp_subscription_mailchimp_list ='';

                if(isset($form) && is_numeric($form)){
                   $forms = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpsp_forms WHERE id=$form" );
                     $data = array();
                 if(!empty($forms)) {
                    foreach ($forms as $category)  
                     {

                       $wp_subscription_error_msg_required = (empty($category->wp_subscription_error_msg_required)) ? $wp_subscription_error_msg_required : $category->wp_subscription_error_msg_required;

                        $wp_subscription_error_msg_invalid_email = (empty($category->wp_subscription_error_msg_invalid_email)) ? $wp_subscription_error_msg_invalid_email : $category->wp_subscription_error_msg_invalid_email;

                         $wp_subscription_error_msg_email_exist = (empty($category->wp_subscription_error_msg_email_exist)) ? $wp_subscription_error_msg_email_exist : $category->wp_subscription_error_msg_email_exist;


                         $wp_subscription_success_msg = (empty($category->wp_subscription_success_msg)) ? $wp_subscription_success_msg : $category->wp_subscription_success_msg;         

                          $wp_subscription_mailchimp_list = (empty($category->wp_subscription_mailchimp_list)) ? '' : $category->wp_subscription_mailchimp_list;         
         
                     }

                 }
                  $form='Form '.$form;                 
                }


             if(!empty($email)){

                      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        return $arr = array('status' => "warning", 'message' => $wp_subscription_error_msg_invalid_email);
                      }

                       $values=array();
                    if(!empty($list_id)){                       
                

                  $values['frist_name'] = sanitize_text_field($frist_name);
                  $values['last_name'] = sanitize_text_field($last_name);
                  $email=$values['email'] = sanitize_text_field($email);   
                  $list_id=$values['list_id'] = sanitize_text_field($list_id); 
                  $values['form'] = sanitize_text_field($form); 
                  $subscribers = $wpdb->get_results( "SELECT email FROM {$wpdb->prefix}wpsp_subscribers WHERE email LIKE '$email' AND list_id=$list_id" );
                           
                             if($wpdb->num_rows > 0){
                                $arr = array('status' => "warning", 'message' => $wp_subscription_error_msg_email_exist);
                             }else{

                        if ($wpdb->insert("{$wpdb->prefix}wpsp_subscribers",$values)) {
                            $args = array($list_id,$email,$frist_name,$last_name,$wp_subscription_mailchimp_list);
                            do_action_ref_array('wp_subscription_add_subscriber', array(&$args));
                            $arr = array('message' => $wp_subscription_success_msg, 'status' => 'success');                          
                        } 
                        else {
                            $arr = array('status' => "warning", 'message' => 'Error In inserting record');
                        }
                    }

                        
                    }else{
                         $arr = array('status' => "warning", 'message' => 'Please select list');
                    }
                    }else {
                            $arr = array('status' => "warning", 'message' => 'Please enter email address');
                        }
                    
                return $arr;

          }
        
       
       
}
		

