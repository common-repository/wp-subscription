<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


final class WPSubscriptioncategory {
	function get_category(){
		  $cu = wp_get_current_user();
                if ($cu->has_cap('manage_options')) {
		global $wpdb;  
                $categories = $wpdb->get_results( "SELECT l.id,l.list_name,l.list_defualt_from_name,l.list_defualt_email ,count(s.id) as subscriber_count FROM {$wpdb->prefix}wpsp_list l LEFT JOIN {$wpdb->prefix}wpsp_subscribers s ON l.id=s.list_id group by l.id"); 
                $data = array();
	
	foreach ($categories as $category){	
        $data[] = array(
                    "id"            => $category->id,
                    "list_name"     => $category->list_name,
                    "list_defualt_email"     => $category->list_defualt_email,
                    "list_defualt_from_name"     => $category->list_defualt_from_name,
                    "list_defualt_from_name"     => $category->list_defualt_from_name,
                    "subscriber_count"     => $category->subscriber_count       
                    );
    }
    print_r(json_encode($data));die();
    //return json_encode($data);  
    }
        }

        function getCategoryCsvData(){
           global $wpdb;  
             $cu = wp_get_current_user();
                if ($cu->has_cap('manage_options')) {
           $condition="";             
                if(!empty($_POST['list_id'])){
                    $condition=" AND s.list_id=".$_POST['list_id'];
                }
                 $categories = $wpdb->get_results( "SELECT s.email,s.frist_name,s.last_name,s.is_active,l.list_name,s.list_id FROM {$wpdb->prefix}wpsp_subscribers s ,wp_wpsp_list l WHERE s.list_id=l.id $condition"); 
              
             print_r(json_encode($categories));die();
         }
    //return json_encode($data);  
        }
        
        function add_category(){
		
		global $wpdb;
                $data = json_decode(file_get_contents("php://input")); 
                $cu = wp_get_current_user();
                if ($cu->has_cap('manage_options')) {
                    if(!empty($data->list_name)){
                         $values=array();

                        $values['list_name']=sanitize_text_field($data->list_name);

                         if(isset($data->list_defualt_email))     
                         $values['list_defualt_email']=sanitize_text_field($data->list_defualt_email);

                          if(isset($data->list_defualt_from_name))     
                          $values['list_defualt_from_name']=sanitize_text_field($data->list_defualt_from_name);

                       
                        
                        if ($wpdb->insert("{$wpdb->prefix}wpsp_list",$values)) {
                            $arr = array('msg' => "List Added Successfully!!!", 'error' => '');
                         //   $jsn = json_encode($arr);                              
                             
                        } 
                        else {
                            $arr = array('msg' => "", 'error' => 'Error In inserting record');
                          //  $jsn = json_encode($arr);
                            // print_r($jsn);
                        }
                    }else {
                            $arr = array('msg' => "", 'error' => 'Please enter list name');
                          //  $jsn = json_encode($arr);
                            // print_r($jsn);
                        }
                        }else {
                            $arr = array('msg' => "", 'error' => 'Error In inserting record');
                          //  $jsn = json_encode($arr);
                            // print_r($jsn);
                        }
                        
                print_r(json_encode($arr));die;
    //return json_encode($data);  
    
        }
        
        function edit_category(){
		
		global $wpdb;               
                $cu = wp_get_current_user();                
                if ($cu->has_cap('manage_options')) {
                    $data = json_decode(file_get_contents("php://input"));     
                    $index = $data->id; 
                    $categories = $wpdb->get_results( "SELECT id,list_name,list_defualt_email,list_defualt_from_name FROM {$wpdb->prefix}wpsp_list WHERE id=$index" );
                                    $data = array();
                foreach ($categories as $category)	
                 {
                     $data[] = array(
                    "id"            => $category->id,
                    "list_name"     => $category->list_name,
                    "list_defualt_email"     => $category->list_defualt_email,
                    "list_defualt_from_name"     => $category->list_defualt_from_name
                    
                             
                    );
                 }
                 print_r(json_encode($data));die();
                 //return json_encode($data);  
                             }
    //return json_encode($data);  
    
        }
        
        function update_category(){
		
		global $wpdb;               
                $cu = wp_get_current_user();                
                if ($cu->has_cap('manage_options')) {
                    $data = json_decode(file_get_contents("php://input"));
                     if(!empty($data->list_name)){
                if($wpdb->update($wpdb->prefix.'wpsp_list',array('list_name'=>$data->list_name,'list_defualt_email'=>$data->list_defualt_email,'list_defualt_from_name'=>$data->list_defualt_from_name),array('id'=>$data->id)))
                 {
                        $arr = array('msg' => "List Updated Successfully!!!", 'error' => '');
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
        
         function delete_category(){
		
		global $wpdb;               
                $cu = wp_get_current_user();                
                if ($cu->has_cap('manage_options')) {
                     $data = json_decode(file_get_contents("php://input"));     
                     $index = $data->id; 
                     $values=array(
                            'id'=>1
                    );
                    //$wpdb->update($wpdb->prefix.'wpbdp_listings',$values,array('cid'=>$index));
	
                    if($wpdb->delete($wpdb->prefix.'wpsp_list',array('id'=>$index)))
                            return true;
                            
                    return false;     
                }
            //return json_encode($data);  
    
        }
       
}
		

