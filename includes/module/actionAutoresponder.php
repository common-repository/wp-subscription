<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_action('wp_subscription_add_subscriber', array('WPSPActionAutoresponder', 'wp_subscription_add_subscriber_autoresponder'),11);

class WPSPActionAutoresponder{

    public static function wp_subscription_add_subscriber_autoresponder(&$args) {
        
    }
}