<?php 
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}


final class WPSubscriptiondashboard {
  function get_dashboard(){   
    global $wpdb;  
            $data = array();
             $data = json_decode(file_get_contents("php://input"), true);
            
             
             if(isset($data['id']) && $data['id']=='year'){

                 $timeCondition="date_format(created_date, '%Y') = date_format(now(), '%Y')";
                 $timeConditionJoin="date_format(s.created_date, '%Y') = date_format(now(), '%Y')";

                  $paid_listings_status = $wpdb->get_results("SELECT MONTHNAME(created_date) as y ,is_active,count(YEAR(created_date)) as count FROM {$wpdb->prefix}wpsp_subscribers  where  $timeCondition group by MONTHNAME(created_date),is_active order by created_date");

                }else if(isset($data['id']) && $data['id']=='current_month'){
                  $timeCondition="date_format(created_date, '%Y-%m') = date_format(now(), '%Y-%m')";
                    $timeConditionJoin="date_format(s.created_date, '%Y-%m') = date_format(now(), '%Y-%m')";
                   $paid_listings_status = $wpdb->get_results("SELECT DATE_FORMAT(created_date,'%d-%b') as y ,is_active,count(YEAR(created_date)) as count FROM {$wpdb->prefix}wpsp_subscribers where $timeCondition group by DAY(created_date),is_active order by created_date");
                   

                }else if(isset($data['id']) && $data['id']=='last_month'){
                   $timeCondition="created_date > DATE_SUB(now(), INTERVAL 1 MONTH)";
                    $timeConditionJoin="s.created_date > DATE_SUB(now(), INTERVAL 1 MONTH)";
                 $paid_listings_status = $wpdb->get_results("SELECT DATE_FORMAT(created_date,'%d-%b') as y ,is_active,count(YEAR(created_date)) as count FROM {$wpdb->prefix}wpsp_subscribers where $timeCondition group by DAY(created_date),is_active order by created_date");


                }else if(isset($data['id']) && $data['id']=='last_seven_day'){
                    $timeCondition="created_date > DATE_SUB(now(), INTERVAL 7 DAY)";
                      $timeConditionJoin="s.created_date > DATE_SUB(now(), INTERVAL 7 DAY)";

                $paid_listings_status = $wpdb->get_results("SELECT DATE_FORMAT(created_date,'%d-%b') as y ,is_active,count(YEAR(created_date)) as count FROM {$wpdb->prefix}wpsp_subscribers where $timeCondition group by DAY(created_date),is_active order by created_date");

             
                }else{
                    $timeCondition="1=1";
                    $timeConditionJoin="1=1";

                   $paid_listings_status = $wpdb->get_results("SELECT YEAR(created_date) as y ,is_active,count(YEAR(created_date)) as count FROM {$wpdb->prefix}wpsp_subscribers group by YEAR(created_date),is_active order by created_date");
                   
                }

                  $scribersCount= $wpdb->get_results( "SELECT count(id) as count,SUM(IF(is_active=0,1,0)) as nonsubscribersCount,SUM(IF(is_active=1,1,0)) as subscribersCount FROM {$wpdb->prefix}wpsp_subscribers  where $timeCondition"); 

                  $wpsp_list= $wpdb->get_results( "SELECT count(id) as count FROM {$wpdb->prefix}wpsp_list where  $timeCondition");
                    $totaforms= $wpdb->get_results( "SELECT count(id) as count FROM {$wpdb->prefix}wpsp_forms where  $timeCondition"); 

                      $categories = $wpdb->get_results( "SELECT l.id,l.list_name,count(s.id) as subscriber_count FROM {$wpdb->prefix}wpsp_list l LEFT JOIN {$wpdb->prefix}wpsp_subscribers s ON l.id=s.list_id AND is_active='1' AND  $timeConditionJoin group by l.id order by subscriber_count DESC"); 

                      $unsbuscribecategories = $wpdb->get_results( "SELECT l.id,l.list_name,count(s.id) as subscriber_count FROM {$wpdb->prefix}wpsp_list l LEFT JOIN {$wpdb->prefix}wpsp_subscribers s ON l.id=s.list_id AND is_active='0' AND $timeConditionJoin group by l.id order by subscriber_count DESC"); 

                       $total_campaigns = $wpdb->get_results("SELECT count(id) as count FROM {$wpdb->prefix}wpsp_campaigns WHERE $timeCondition");
                       
                
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
                    $chart_data[$i]['y']=$newary['y'];                   
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

                  $data['subscriberchartData']= $chart_data;    
                  $data['subscribers_count']= $scribersCount[0]->count;
                  $data['total_campaigns']= $total_campaigns[0]->count;
               $data['site_url']=site_url();
               $data['subscribersCount']= empty($scribersCount[0]->subscribersCount)? 0:$scribersCount[0]->subscribersCount;
               $data['nonsubscribersCount']= empty($scribersCount[0]->nonsubscribersCount) ? 0 :$scribersCount[0]->nonsubscribersCount;

                 $data['list_count']= $wpsp_list[0]->count;

                $data['totaforms']= $totaforms[0]->count;

                 $i=0;
    foreach ($categories as  $categorie) {
       $data['categorychartdata'][$i]['label']= $categorie->list_name;
       $data['categorychartdata'][$i]['value']=$categorie->subscriber_count;
       $i++;
    }

     
               
      $i=0;
    foreach ($unsbuscribecategories as  $categorie) {
       $data['unsbuscribecategories'][$i]['label']= $categorie->list_name;
       $data['unsbuscribecategories'][$i]['value']=$categorie->subscriber_count;
       $i++;
    }

    $data['categories'] =array_slice($categories, 0, 5);
   $data['unsubcategories'] =array_slice($unsbuscribecategories, 0, 5);
    $data['reportid']=(isset($data['id'])) ? $data['id']:'All';
    $data['report']=(isset($data['id'])) ? Ucfirst(str_replace('_',' ',$data['id'])):'All';

    print_r(json_encode($data));die();
    
        }    
       
}
    

