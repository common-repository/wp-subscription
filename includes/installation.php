<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
global $wpdb;


  $sql="CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wpsp_list (
   id int(11) NOT NULL AUTO_INCREMENT,
  list_name varchar(100) NOT NULL,
  list_defualt_email varchar(100) DEFAULT NULL,
  list_defualt_from_name varchar(100) NOT NULL,
  created_date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  modify_date date DEFAULT NULL,
  PRIMARY KEY (id),
  KEY id (id)
);";

 dbDelta( $sql );


 $sql="CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wpsp_subscribers (
  id int(11) NOT NULL AUTO_INCREMENT,
  frist_name varchar(100) DEFAULT NULL,
  last_name varchar(100) DEFAULT NULL,
  created_date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  created_by int(11) DEFAULT NULL,
  modify_date date DEFAULT NULL,
  is_active tinyint(1) DEFAULT 1,
  email varchar(100) NOT NULL,
  list_id int(11) DEFAULT NULL,
  form varchar(40) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY id (id),
  KEY list_id (list_id) 
);";

dbDelta( $sql );

  

 $sql="CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wpsp_forms (
  id int(11) NOT NULL AUTO_INCREMENT,
  wp_subscription_title varchar(200) NOT NULL,
  wp_subscription_sub_title varchar(1000) DEFAULT NULL,
  wp_subscription_enable_first_name tinyint(1) DEFAULT 0,
  wp_subscription_first_name varchar(100) DEFAULT NULL,
  wp_subscription_enable_last_name tinyint(1) DEFAULT 0,
  wp_subscription_last_name varchar(100) DEFAULT NULL,
  wp_subscription_email_label varchar(100) DEFAULT NULL,
  wp_subscription_button_label varchar(100) DEFAULT NULL,
  wp_subscription_error_msg_required varchar(200) DEFAULT NULL,
  wp_subscription_error_msg_invalid_email varchar(200) DEFAULT NULL,
  wp_subscription_error_msg_email_exist varchar(200) DEFAULT NULL,
  wp_subscription_success_msg varchar(200) DEFAULT NULL,
  wp_subscription_appearance_skin varchar(200) DEFAULT NULL,
  wp_subscription_appearance_icon tinyint(1) DEFAULT 0,
  wp_subscription_appearance_custom_css varchar(500) DEFAULT NULL,
  wp_subscription_mailchimp_list  varchar(50) DEFAULT NULL,
  wp_subscription_aweber_list  varchar(50) DEFAULT NULL,
  wp_subscription_campainmonitor_list  varchar(50) DEFAULT NULL,
  wp_subscription_language varchar(20) DEFAULT 'English',
  list_id int(11) NOT NULL,
  created_date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  modify_date datetime DEFAULT NULL,
  created_by int(11) DEFAULT NULL,
  modify_by int(11) DEFAULT NULL,
  width int(11) DEFAULT 500,
  PRIMARY KEY (id),
  KEY list_id (list_id) 
);";
dbDelta( $sql );

/*$sql="ALTER TABLE {$wpdb->prefix}wpsp_subscribers
  ADD CONSTRAINT {$wpdb->prefix}wpsp_subscribers_ibfk_1 FOREIGN KEY (list_id) REFERENCES {$wpdb->prefix}wpsp_list (id) ON DELETE SET NULL";

$wpdb->query($sql);


  $sql="ALTER TABLE {$wpdb->prefix}wpsp_forms
  ADD CONSTRAINT {$wpdb->prefix}wpsp_forms_ibfk_1 FOREIGN KEY (list_id) REFERENCES {$wpdb->prefix}wpsp_list (id) ON DELETE CASCADE ON UPDATE CASCADE";

$wpdb->query($sql);
*/
 add_option('wp_subscription_title',"SUBSCRIBE OUR NEWSLETTER");
 add_option('wp_subscription_sub_title',"Subscribe with your name and email to get updates fresh updates.");
 add_option('wp_subscription_title',"");
 add_option('wp_subscription_enable_first_name',1);
 add_option('wp_subscription_first_name',"First Name");
 add_option('wp_subscription_enable_last_name',1);
 add_option('wp_subscription_last_name',"Last Name");
 add_option('wp_subscription_email_label',"Email");
 add_option('wp_subscription_button_label',"Subscribe");

 add_option('wp_subscription_error_msg_required',"Requred * field");
 add_option('wp_subscription_error_msg_invalid_email',"Invalid Email");
 add_option('wp_subscription_error_msg_email_exist',"Email address already exist");
 add_option('wp_subscription_success_msg',"Thanks for Subscription");

 add_option('wp_subscription_appearance_skin',"");
 add_option('wp_subscription_appearance_icon',"");
 add_option('wp_subscription_appearance_custom_css',"");
 add_option('wp_subscription_language',"English");

 add_option('selectedpageids',"");
 add_option('wpsp_form_popup',"");
 add_option('wpsp_form_popup_count',5);
 add_option('wpsp_form_popup_time',5);

 add_option('wp_subscription_email_name',"Admin");
 add_option('wp_subscription_email_id',get_option('admin_email'));
 add_option('wp_subscription_email_admin_register_enable',1);
 add_option('wp_subscription_email_admin_register_subject',"Subscription");
 add_option('wp_subscription_email_admin_register_content',"New subscription");
 add_option('wp_subscription_email_user_register_enable',0);
 add_option('wp_subscription_email_user_register_subject',"Subscription");
 add_option('wp_subscription_email_user_register_content',"Thanks for subscription");

 add_option('mailchimp_apikey',"");
 add_option('wp_subscription_enable_auto_opt_mailchimp',1);
 add_option('wp_subscription_enable_ignore_email_mailchimp',1);
 add_option('wp_subscription_token',md5(get_option('admin_email')));

 add_option('wp_subscription_register_list_id_enable',0);
 add_option('wp_subscription_comment_list_id_enable',0);
 