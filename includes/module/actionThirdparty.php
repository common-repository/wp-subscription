<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_action('user_register', array('WPSPActionThirdparty', 'user_register'));
//add_action( 'wpcf7_before_send_mail', array('WPSPActionThirdparty', 'wpcf7_before_send_mail'));
//WooCommerce to Trigger After an Order is Placed
add_action('woocommerce_order_status_completed', array('WPSPActionThirdparty', 'woocommerce_order_status_completed'), 10, 1);
//Add New Member in BuddyPress
add_action('bp_core_signup_user', array('WPSPActionThirdparty', 'bp_core_signup_user'), 10, 5);
class WPSPActionThirdparty{

    public static function user_register($user_id) {
        $user_info=get_userdata( $user_id );
          $email = $user_info->email;
	      $first_name = $user_info->first_name;
	      $last_name = $user_info->last_name;
    }

    public static function wpcf7_before_send_mail( $cf7 ) {
     $email = $cf7->posted_data['email'];
      error_log("wpcf7_before_send_mail");
     
     WPSubscriptionModule::add_subscriber_data($email,22,'','');

    
}

public static function woocommerce_order_status_completed($order_id) {
   $order = new WC_Order($order_id);
    $myuser_id = (int)$order->user_id;
    $user_info = get_userdata($myuser_id);
     $email = $user_info->email;
	 $frist_name = $user_info->first_name;
	  $last_name = $user_info->last_name;
	  $list_id=22;
	   error_log(print_r($order, true)); 
	  error_log( "Order email $email", 0 );
	  error_log( "Order myuser_id for order $myuser_id", 0 );
	   $arr=WPSubscriptionModule::add_subscriber_data($email,$list_id,$frist_name,$last_name);
	    error_log("woocommerce_payment_complete");
     error_log(var_dump($arr));
}
function bp_core_signup_user($user_id, $user_login, $user_password, $user_email, $usermeta){
   
}

}

// Start Register Form
add_action( 'user_register', 'wp_subscription_register_hook', 10, 1 );
function wp_subscription_register_hook( $user_id ) {
    if (isset( $_POST['wpsp_email_opt_in'] ) && isset( $user_id ) && !empty( $user_id )){
            $email=isset( $_POST['user_email'] ) ?  $_POST['user_email'] : '';
            $frist_name=isset( $_POST['user_login'] ) ?  $_POST['user_login'] : '';
            $list_id=get_option('wp_subscription_register_list_id'); 

            if(!empty($email) && !empty($list_id))
                WPSubscriptionModule::add_subscriber_data($email,$list_id,$frist_name,'','Register');
    }
}

add_action( 'register_form', 'wpsp_email_opt_in' );
function wpsp_email_opt_in() { 
if(get_option('wp_subscription_register_list_id_enable')){
 echo '<label style="font-size:13px;">
      <input type="checkbox" name="wpsp_email_opt_in" id="wpsp_email_opt_in" class="input" checked="checked" value="1" tabindex="99" style="width:12px; padding:0; margin:0 3px 0 0; font-size: 13px;" /> 
      Join our e-mail list
      </label>'; }
}
// End Register Form

/*function wp_subscription_wpcf7_hook (&$WPCF7_ContactForm) {
  if(get_option('wp_subscription_register_list_id_enable')){
   $email = $WPCF7_ContactForm->posted_data['email'];
   $list_id=get_option('wp_subscription_register_list_id'); 

   if(!empty($email) && !empty($list_id))
                WPSubscriptionModule::add_subscriber_data($email,$list_id,'','','Contact Form 7');
 }
}*/
//add_action("wpcf7_before_send_mail", "wp_subscription_wpcf7_hook");

// Start Comment Form
add_action( 'comment_form_logged_in_after', 'wp_subscription_comment_additional_fields' );
add_action( 'comment_form_after_fields', 'wp_subscription_comment_additional_fields' );

function wp_subscription_comment_additional_fields () {
 if(get_option('wp_subscription_comment_list_id_enable')){ 
     
      echo '<label style="font-size:13px;">
      <input type="checkbox" name="wpsp_email_opt_in" id="wpsp_email_opt_in" class="input" checked="checked" value="1" tabindex="99" style="width:12px; padding:0; margin:0 3px 0 0; font-size: 13px;" /> 
      Join our e-mail list
      </label>';
    }
}

add_action( 'comment_post', 'wp_subscription_comment_hook', 10, 3 );
function wp_subscription_comment_hook( $comment_ID, $comment_approved ,$commentdata) {
  if ( ( isset( $_POST['wpsp_email_opt_in'] ) ) && ( $_POST['wpsp_email_opt_in'] != '') ){

     $email = $commentdata['comment_author_email'];
     $comment_author=(!empty($commentdata['comment_author'])) ? $commentdata['comment_author'] : ' ' ;
     $list_id=get_option('wp_subscription_comment_list_id'); 

    if(!empty($email) && !empty($list_id))
                WPSubscriptionModule::add_subscriber_data($email,$list_id,$comment_author,'','Comment Form');
  } 

}
// End Comment Form