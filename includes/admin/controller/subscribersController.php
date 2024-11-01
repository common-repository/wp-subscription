<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


final class WPSubscriptionsubscriber {
	function get_subscriber(){
		 $cu = wp_get_current_user();
                if ($cu->has_cap('manage_options')) {
		global $wpdb;  
                $subscribers = $wpdb->get_results( "SELECT s.id,s.list_id,s.frist_name,s.last_name,s.email,s.is_active,l.list_name as list FROM {$wpdb->prefix}wpsp_subscribers s LEFT JOIN {$wpdb->prefix}wpsp_list l ON s.list_id=l.id");
 
                $data = array();
	
	foreach ($subscribers as $subscriber){	
        $data[] = array(
                    "id"            => $subscriber->id,
                     "frist_name"     => $subscriber->frist_name,
                    "last_name"     => $subscriber->last_name,
                    "email"     => $subscriber->email,
                    "list"   =>$subscriber->list,
                    "list_id"   =>$subscriber->list_id,
                    "is_active"     => $subscriber->is_active
                   
                    );
    }
  
    print_r(json_encode($data));die();
    //return json_encode($data);  
    }
        }

        function get_setting(){
          $cu = wp_get_current_user();
                if ($cu->has_cap('manage_options')) {
      $data['wp_subscription_token']=get_option('wp_subscription_token') ;
    print_r(json_encode($data));die();
}
    //return json_encode($data);  
    }

        
          function addsubscriber_csv(){
        
                 global $wpdb;
                $data = json_decode(file_get_contents("php://input")); 
                $cu = wp_get_current_user();
                if ($cu->has_cap('manage_options')) {
                   
                    var_dump( $data->fileContent);die;

                }
        }
        function add_subscriber(){
		
		$data = json_decode(file_get_contents("php://input"));                
                $cu = wp_get_current_user();
                $form='Form ';
             if(isset($data) && !empty($data)){

             
                      

                   $frist_name=(isset($data->frist_name) && !empty($data->frist_name)) ? sanitize_text_field($data->frist_name) : '';

                   $last_name=(isset($data->last_name) && !empty($data->last_name)) ? sanitize_text_field($data->last_name) : '';

                    $email=(isset($data->email) && !empty($data->email)) ? sanitize_text_field($data->email) : '';

                   $list_id=(isset($data->list_id) && !empty($data->list_id)) ? sanitize_text_field($data->list_id) : '';
               
              $arr=WPSubscriptionModule::add_subscriber_data($email,$list_id,$frist_name,$last_name,$form);
                   
    print_r(json_encode($arr));die;
}
    
        }
        
        function edit_subscriber(){
		
		global $wpdb;               
                $cu = wp_get_current_user();                
                if ($cu->has_cap('manage_options')) {
                    $data = json_decode(file_get_contents("php://input"));     
                    $index = $data->id; 
                    $subscribers = $wpdb->get_results( "SELECT id,frist_name,last_name,email,is_active,list_id as list FROM {$wpdb->prefix}wpsp_subscribers WHERE id=$index" );
                                    $data = array();
                foreach ($subscribers as $subscriber)	
                 {
                     $data[] = array(
                     "id"            => $subscriber->id,
                     "frist_name"     => $subscriber->frist_name,
                    "last_name"     => $subscriber->last_name,
                    "email"     => $subscriber->email,
                    "list"   =>$subscriber->list,
                    "is_active"     => $subscriber->is_active                        
                             
                    );
                 }
                 print_r(json_encode($data));die();
                 //return json_encode($data);  
                             }
    //return json_encode($data);  
    
        }
        
        function update_subscriber(){
		
		global $wpdb;               
                $cu = wp_get_current_user();                
                if ($cu->has_cap('manage_options')) {
                    $data = json_decode(file_get_contents("php://input"));
                    if(!empty($data->email)){
                       $values=array();
                        
                  $values['frist_name'] = sanitize_text_field($data->frist_name);
            $values['last_name'] = sanitize_text_field($data->last_name);
            $values['email'] = sanitize_text_field($data->email);   
            $values['list_id'] = sanitize_text_field($data->list_id); 
                if($wpdb->update($wpdb->prefix.'wpsp_subscribers',$values,array('id'=>$data->id)))
                 {
                        $arr = array('msg' => "Subscriber Updated Successfully!!!", 'error' => '');
                        $jsn = json_encode($arr);
                        // print_r($jsn);
                    } else {
                                $arr = array('msg' => "", 'error' => 'Error In Updating record');
                                $jsn = json_encode($arr);
                                // print_r($jsn);
                    }
                }else {
                            $arr = array('msg' => "", 'error' => 'Please enter list name');
                            $jsn = json_encode($arr);
                            // print_r($jsn);
                        }
                                     }
            //return json_encode($data);  
    
        }
        
         function delete_subscriber(){
		
		global $wpdb;               
                $cu = wp_get_current_user();                
                if ($cu->has_cap('manage_options')) {
                     $data = json_decode(file_get_contents("php://input"));                  
                    if($wpdb->delete($wpdb->prefix.'wpsp_subscribers',array('id'=>$data->id)))
                            return true;
                            
                    return false;     
                }
            //return json_encode($data);  
    
        }
       
}
		

