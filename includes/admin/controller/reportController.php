<?php 
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}


final class WPSubscriptionreport {

  
  function get_report(){   
    global $wpdb;  
            $data = array();
             $data = json_decode(file_get_contents("php://input"), true);
            
             
             if(isset($_POST['id']) && $_POST['id']=='year'){

                 $timeCondition="date_format(created_date, '%Y') = date_format(now(), '%Y')";
                 $timeConditionJoin="date_format(s.created_date, '%Y') = date_format(now(), '%Y')";

                 if(isset($_POST['repoty_type']) && $_POST['repoty_type']=='subscribers')
                  $paid_listings_status = $wpdb->get_results("SELECT MONTHNAME(created_date) as y ,is_active,count(YEAR(created_date)) as count FROM {$wpdb->prefix}wpsp_subscribers  where  $timeCondition group by MONTHNAME(created_date),is_active order by created_date");

                }else if(isset($_POST['id']) && $_POST['id']=='current_month'){
                  $timeCondition="date_format(created_date, '%Y-%m') = date_format(now(), '%Y-%m')";
                    $timeConditionJoin="date_format(s.created_date, '%Y-%m') = date_format(now(), '%Y-%m')";
                   $paid_listings_status = $wpdb->get_results("SELECT DATE_FORMAT(created_date,'%d-%b') as y ,is_active,count(YEAR(created_date)) as count FROM {$wpdb->prefix}wpsp_subscribers where $timeCondition group by DAY(created_date),is_active order by created_date");
                   

                }else if(isset($_POST['id']) && $_POST['id']=='last_month'){
                   $timeCondition="created_date > DATE_SUB(now(), INTERVAL 1 MONTH)";
                    $timeConditionJoin="s.created_date > DATE_SUB(now(), INTERVAL 1 MONTH)";

                    if(isset($_POST['repoty_type']) && $_POST['repoty_type']=='subscribers')
                 $paid_listings_status = $wpdb->get_results("SELECT DATE_FORMAT(created_date,'%d-%b') as y ,is_active,count(YEAR(created_date)) as count FROM {$wpdb->prefix}wpsp_subscribers where $timeCondition group by DAY(created_date),is_active order by created_date");


                }else if(isset($_POST['id']) && $_POST['id']=='last_seven_day'){
                    $timeCondition="created_date > DATE_SUB(now(), INTERVAL 7 DAY)";
                      $timeConditionJoin="s.created_date > DATE_SUB(now(), INTERVAL 7 DAY)";

                if(isset($_POST['repoty_type']) && $_POST['repoty_type']=='subscribers')
                  $paid_listings_status = $wpdb->get_results("SELECT DATE_FORMAT(created_date,'%d-%b') as y ,is_active,count(YEAR(created_date)) as count FROM {$wpdb->prefix}wpsp_subscribers where $timeCondition group by DAY(created_date),is_active order by created_date");

             
                }else{
                    $timeCondition="1=1";
                    $timeConditionJoin="1=1";

                   if(isset($_POST['repoty_type']) && $_POST['repoty_type']=='subscribers')
                    $paid_listings_status = $wpdb->get_results("SELECT YEAR(created_date) as y ,is_active,count(YEAR(created_date)) as count FROM {$wpdb->prefix}wpsp_subscribers group by YEAR(created_date),is_active order by created_date");
                   
                }
               
           if(isset($_POST['repoty_type']) && $_POST['repoty_type']=='subscribers'){
                $newary=array();
                foreach ($paid_listings_status as $paid_listings_status){
                     if($paid_listings_status->is_active==1)
                     {                       
                        $newary[$paid_listings_status->y]['y']=$paid_listings_status->y;
                        $newary[$paid_listings_status->y]['subscribed']=$paid_listings_status->count;
                        
                     }  else {                        
                        $newary[$paid_listings_status->y]['y']=$paid_listings_status->y;
                        $newary[$paid_listings_status->y]['unsubscribed']=$paid_listings_status->count;
                     }
                 }

                 $chart_data=array();
                $newary_html=array();
                $newary_html=$newary;
                $i=0;
                foreach($newary as $newary){
                    $chart_data[$i]['Duration']=$newary['y'];                   
                    if(isset($newary['subscribed'])){
                         $chart_data[$i]['subscribed']=$newary['subscribed'];
                    }else{
                        $chart_data[$i]['subscribed']=0;
                    }
                   if(isset($newary['unsubscribed'])){
                         $chart_data[$i]['unsubscribed']=$newary['unsubscribed'];
                    }else{
                        $chart_data[$i]['unsubscribed']="0";
                    }
                    $i++;
                }

                  $data= $chart_data;    
              }
                  
   if(isset($_POST['repoty_type']) && $_POST['repoty_type']=='unsubscribed_category' || $_POST['repoty_type']=='subscribers_category'){
    if($_POST['repoty_type']=='unsubscribed_category'){
    $is_active=0;
  }else{
  $is_active=1;
  }
                
                     $data = $wpdb->get_results( "SELECT l.id,l.list_name as List,count(s.id) as Count  FROM {$wpdb->prefix}wpsp_list l LEFT JOIN {$wpdb->prefix}wpsp_subscribers s ON l.id=s.list_id AND is_active='$is_active' AND  $timeConditionJoin group by l.id order by Count DESC"); 
     }

    print_r(json_encode($data));die();
    
        }    
       
}
    

