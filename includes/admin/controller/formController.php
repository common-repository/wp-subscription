<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


final class WPSubscriptionform {

	function get_form(){
		 $cu = wp_get_current_user();
                if ($cu->has_cap('manage_options')) {
		global $wpdb;  
                $categories = $wpdb->get_results( "SELECT id,wp_subscription_title,created_date FROM {$wpdb->prefix}wpsp_forms");
 
                $data = array();
	
	foreach ($categories as $category){	
        $data[] = array(
                    "id"            => $category->id,
                    "wp_subscription_title"     => $category->wp_subscription_title
                    );


    }



           
    print_r(json_encode($data));die();
    //return json_encode($data);  
    }
        }


         function get_embeded_form(){
        
        global $wpdb;               
                $cu = wp_get_current_user();                
                if ($cu->has_cap('manage_options')) {
                    $data = json_decode(file_get_contents("php://input"));  
                    $wp_subscription='<link rel="stylesheet" href="'.WPSP_PLUGIN_URL.'assets/css/bootstrap.min.css" type="text/css" media="all"/>';
                    $wp_subscription.='<link rel="stylesheet" href="'.WPSP_PLUGIN_URL . 'assets/dist/css/AdminLTE.css"  type="text/css" media="all"/>';
                     $wp_subscription.="<script type='text/javascript' src='https://code.jquery.com/jquery-2.2.4.min.js'></script>";
                    $wp_subscription.=do_shortcode("[wp_subscription id='".$data->id."']");
                    print_r($wp_subscription);

die;

    }
}

        function get_form_all_data(){
         $cu = wp_get_current_user();
                if ($cu->has_cap('manage_options')) {
        global $wpdb;  
                $categories = $wpdb->get_results( "SELECT *  FROM {$wpdb->prefix}wpsp_forms");
          print_r(json_encode($categories));die();
    //return json_encode($data);  
    }
        }
        
        
        function add_form(){
		
		global $wpdb;
                $data = json_decode(file_get_contents("php://input")); 
                $cu = wp_get_current_user();
                if ($cu->has_cap('manage_options')) {
                    if(!empty($data->wp_subscription_title)){
                        $values=array();
                         
            if(isset($data->wp_subscription_title))             
            $values['wp_subscription_title'] = sanitize_text_field($data->wp_subscription_title);

         if(isset($data->wp_subscription_sub_title))     
            $values['wp_subscription_sub_title'] = sanitize_text_field($data->wp_subscription_sub_title);

         if(isset($data->wp_subscription_enable_first_name))     
            $values['wp_subscription_enable_first_name'] = (sanitize_text_field($data->wp_subscription_enable_first_name));   

         if(isset($data->wp_subscription_first_name))     
            $values['wp_subscription_first_name'] = sanitize_text_field($data->wp_subscription_first_name);             
         if(isset($data->wp_subscription_enable_last_name))     
            $values['wp_subscription_enable_last_name'] = sanitize_text_field($data->wp_subscription_enable_last_name);

         if(isset($data->wp_subscription_last_name))     
            $values['wp_subscription_last_name'] = sanitize_text_field($data->wp_subscription_last_name); 

         if(isset($data->wp_subscription_email_label))     
            $values['wp_subscription_email_label'] = sanitize_text_field($data->wp_subscription_email_label);

             if(isset($data->wp_subscription_button_label))       
            $values['wp_subscription_button_label'] = sanitize_text_field($data->wp_subscription_button_label);  

            //Form Setting - Error Messages
         if(isset($data->wp_subscription_error_msg_required))     
            $values['wp_subscription_error_msg_required'] = sanitize_text_field($data->wp_subscription_error_msg_required);

         if(isset($data->wp_subscription_error_msg_invalid_email))     
            $values['wp_subscription_error_msg_invalid_email'] = sanitize_text_field($data->wp_subscription_error_msg_invalid_email);

         if(isset($data->wp_subscription_error_msg_email_exist))     
            $values['wp_subscription_error_msg_email_exist'] = sanitize_text_field($data->wp_subscription_error_msg_email_exist);   

         if(isset($data->wp_subscription_success_msg))     
            $values['wp_subscription_success_msg'] = sanitize_text_field($data->wp_subscription_success_msg);             
           
            //Form Setting -Appearance        
             if(isset($data->wp_subscription_appearance_skin))        
            $values['wp_subscription_appearance_skin'] = sanitize_text_field($data->wp_subscription_appearance_skin);

         if(isset($data->wp_subscription_appearance_icon))     
            $values['wp_subscription_appearance_icon'] = sanitize_text_field($data->wp_subscription_appearance_icon); 

         if(isset($data->wp_subscription_appearance_custom_css))     
            $values['wp_subscription_appearance_custom_css'] = sanitize_text_field($data->wp_subscription_appearance_custom_css);  

         if(isset($data->wp_subscription_language))     
            $values['wp_subscription_language'] = sanitize_text_field($data->wp_subscription_language); 

         if(isset($data->list_id))     
              $values['list_id'] = sanitize_text_field($data->list_id); 

               if(isset($data->wp_subscription_mailchimp_list))     
               $values['wp_subscription_mailchimp_list'] = sanitize_text_field($data->wp_subscription_mailchimp_list);
                    
                        if ($wpdb->insert("{$wpdb->prefix}wpsp_forms",$values)) {
                            $arr = array('msg' => "Form Added Successfully!!!", 'error' => '');
                            $jsn = json_encode($arr);
                            // print_r($jsn);
                        } 
                        else {
                            $arr = array('msg' => "", 'error' => 'Error In inserting record');
                            $jsn = json_encode($arr);
                            // print_r($jsn);
                        }
                    }else {
                            $arr = array('msg' => "", 'error' => 'Please enter list name');
                            $jsn = json_encode($arr);
                            // print_r($jsn);
                        }
                        }else {
                            $arr = array('msg' => "", 'error' => 'Error In inserting record');
                            $jsn = json_encode($arr);
                            // print_r($jsn);
                        }
                
    //return json_encode($data);  
    
        }
        
        function edit_form(){
		
		global $wpdb;               
                $cu = wp_get_current_user();                
                if ($cu->has_cap('manage_options')) {
                    $data = json_decode(file_get_contents("php://input"));     
                    $index = $data->id; 
                    $categories = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpsp_forms WHERE id=$index" );
                                    $data = array();
                foreach ($categories as $category)	
                 {
                     //Form Setting
            $data['id'] = $category->id;

            
            $data['wp_subscription_title'] = $category->wp_subscription_title;
            $data['wp_subscription_sub_title'] = $category->wp_subscription_sub_title;
            $data['wp_subscription_enable_first_name'] =$category->wp_subscription_enable_first_name;   
            $data['wp_subscription_first_name'] = $category->wp_subscription_first_name;             
            $data['wp_subscription_enable_last_name'] = $category->wp_subscription_enable_last_name;
            $data['wp_subscription_last_name'] = $category->wp_subscription_last_name; 
            $data['wp_subscription_email_label'] = $category->wp_subscription_email_label;  
            $data['wp_subscription_button_label'] = $category->wp_subscription_button_label;  

            //Form Setting - Error Messages
            $data['wp_subscription_error_msg_required'] = $category->wp_subscription_error_msg_required;
            $data['wp_subscription_error_msg_invalid_email'] = $category->wp_subscription_error_msg_invalid_email;
            $data['wp_subscription_error_msg_email_exist'] = $category->wp_subscription_error_msg_email_exist;   
            $data['wp_subscription_success_msg'] = $category->wp_subscription_success_msg;             
           
            //Form Setting -Appearance           
            $data['wp_subscription_appearance_skin'] = $category->wp_subscription_appearance_skin;
            $data['wp_subscription_appearance_icon'] = $category->wp_subscription_appearance_icon; 
            $data['wp_subscription_appearance_custom_css'] = $category->wp_subscription_appearance_custom_css;  
            $data['wp_subscription_language'] = $category->wp_subscription_language;  
            $data['list_id'] = $category->list_id;  
            $data['wp_subscription_mailchimp_list'] = $category->wp_subscription_mailchimp_list;  

            
                 }
                 print_r(json_encode($data));die();
                 //return json_encode($data);  
                             }
    //return json_encode($data);  
    
        }
        
        function update_form(){
		
		global $wpdb;               
                $cu = wp_get_current_user();                
                if ($cu->has_cap('manage_options')) {
                    $data = json_decode(file_get_contents("php://input"));
                     if(!empty($data->wp_subscription_title)){
                        $values=array();
                        
                if(isset($data->wp_subscription_title))             
            $values['wp_subscription_title'] = sanitize_text_field($data->wp_subscription_title);

         if(isset($data->wp_subscription_sub_title))     
            $values['wp_subscription_sub_title'] = sanitize_text_field($data->wp_subscription_sub_title);

         if(isset($data->wp_subscription_enable_first_name))     
            $values['wp_subscription_enable_first_name'] = (sanitize_text_field($data->wp_subscription_enable_first_name));   

         if(isset($data->wp_subscription_first_name))     
            $values['wp_subscription_first_name'] = sanitize_text_field($data->wp_subscription_first_name);             
         if(isset($data->wp_subscription_enable_last_name))     
            $values['wp_subscription_enable_last_name'] = sanitize_text_field($data->wp_subscription_enable_last_name);

         if(isset($data->wp_subscription_last_name))     
            $values['wp_subscription_last_name'] = sanitize_text_field($data->wp_subscription_last_name); 

         if(isset($data->wp_subscription_email_label))     
            $values['wp_subscription_email_label'] = sanitize_text_field($data->wp_subscription_email_label);

             if(isset($data->wp_subscription_button_label))       
            $values['wp_subscription_button_label'] = sanitize_text_field($data->wp_subscription_button_label);  

            //Form Setting - Error Messages
         if(isset($data->wp_subscription_error_msg_required))     
            $values['wp_subscription_error_msg_required'] = sanitize_text_field($data->wp_subscription_error_msg_required);

         if(isset($data->wp_subscription_error_msg_invalid_email))     
            $values['wp_subscription_error_msg_invalid_email'] = sanitize_text_field($data->wp_subscription_error_msg_invalid_email);

         if(isset($data->wp_subscription_error_msg_email_exist))     
            $values['wp_subscription_error_msg_email_exist'] = sanitize_text_field($data->wp_subscription_error_msg_email_exist);   

         if(isset($data->wp_subscription_success_msg))     
            $values['wp_subscription_success_msg'] = sanitize_text_field($data->wp_subscription_success_msg);             
           
            //Form Setting -Appearance        
             if(isset($data->wp_subscription_appearance_skin))        
            $values['wp_subscription_appearance_skin'] = sanitize_text_field($data->wp_subscription_appearance_skin);

         if(isset($data->wp_subscription_appearance_icon))     
            $values['wp_subscription_appearance_icon'] = sanitize_text_field($data->wp_subscription_appearance_icon); 

         if(isset($data->wp_subscription_appearance_custom_css))     
            $values['wp_subscription_appearance_custom_css'] = sanitize_text_field($data->wp_subscription_appearance_custom_css);  

         if(isset($data->wp_subscription_language))     
            $values['wp_subscription_language'] = sanitize_text_field($data->wp_subscription_language); 

         if(isset($data->list_id))     
              $values['list_id'] = sanitize_text_field($data->list_id); 

               if(isset($data->wp_subscription_mailchimp_list))     
               $values['wp_subscription_mailchimp_list'] = sanitize_text_field($data->wp_subscription_mailchimp_list);
                if($wpdb->update($wpdb->prefix.'wpsp_forms',$values,array('id'=>$data->id)))
                 {
                        $arr = array('msg' => "Form Updated Successfully!!!", 'error' => '');
                        $jsn = json_encode($arr);
                        // print_r($jsn);
                    } else {
                                $arr = array('msg' => "", 'error' => 'Error In Updating record');
                                $jsn = json_encode($arr);
                                // print_r($jsn);
                    }
                }else {
                            $arr = array('msg' => "", 'error' => 'Please enter heading');
                            $jsn = json_encode($arr);
                            // print_r($jsn);
                        }
                                     }
            //return json_encode($data);  
    
        }
        
         function delete_form(){
		
		global $wpdb;               
                $cu = wp_get_current_user();                
                if ($cu->has_cap('manage_options')) {
                     $data = json_decode(file_get_contents("php://input"));     
                     $index = $data->id; 
                    	
                    if($wpdb->delete($wpdb->prefix.'wpsp_forms',array('id'=>$index)))
                            return true;
                            
                    return false;     
                }
            //return json_encode($data);  
    
        }
       
}
		

