<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class WPSubscriptionSetting {

    public function __construct() {
        add_action('init', array('WPSubscriptionSetting', 'init'));
    }

  
    static function version() {
        return VERSION;
    }

    static function init() {
        add_action('admin_menu', array('WPSubscriptionSetting', 'adminPage'));
    }

    static function adminPage() {
       add_menu_page('WP Subscription', 'WP Subscription', 'update_plugins', 'wpsp-dashboard', array('WPSubscriptionSetting','renderAdminPage'),WPSP_PLUGIN_URL.'/assets/images/wpsubscription.png' );
        
    add_submenu_page( 'wpsp-dashboard', 'Autoresponder', 'Autoresponder', 'manage_options', 'wpsp-autoresponder', array('WPSubscriptionSetting','renderAdminPage'));
        add_submenu_page( 'wpsp-dashboard', 'Lists', 'Lists', 'manage_options', 'wpsp-subscriberslists', array('WPSubscriptionSetting','renderAdminPage'));
        add_submenu_page( 'wpsp-dashboard', 'Subscribers', 'Subscribers', 'manage_options', 'wpsp-subscribers', array('WPSubscriptionSetting','renderAdminPage'));
         add_submenu_page( 'wpsp-dashboard', 'Forms', 'Forms', 'manage_options', 'wpsp-forms', array('WPSubscriptionSetting','renderAdminPage'));
        add_submenu_page( 'wpsp-dashboard', 'Settings', 'Settings', 'manage_options', 'wpsp-setting', array('WPSubscriptionSetting','renderAdminPage'));

    }

    static function renderAdminPage() {
       include('views/admin-setting-view.php');
    }
    
    static function autoresponderAdminPage() {
      
      include( 'views/autoresponder-admin-views.php' );
     
    } 
}

$WPSubscriptionSetting = new WPSubscriptionSetting();