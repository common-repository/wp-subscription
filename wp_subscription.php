<?php
/* Plugin Name: WP Subscription
Plugin URI: http://www.wpseeds.com/product/wp_subscription
Description: WP Subscribe is a simple but powerful subscription plugin which supports MailChimp, Aweber and Campaign Monitor.
Author: Prashant Walke
Author URI: http://www.wpseeds.com/wp-subscription/
Version: 2.2
Text Domain: wp-subscription
Domain Path: /lang
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

 if ( ! class_exists( 'WPSubscription' ) ) :
final class WPSubscription {
	
	public $version = '1.0.0';
	public $wpbdp_prefix="wpsp";
	
	protected static $_instance = null;

	public $query = null;

		public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0' );
	}

	public function __construct() {	
		
		// Define constants
		$this->define_constants();
        register_activation_hook( __FILE__, array($this,'installation') );
        register_activation_hook( __FILE__, array($this,'my_plugin_install_function'));
		add_action( 'plugins_loaded', array($this,'load_textdomain') );	
		$this->installation();
		// Include required files		
		$this->includes();


		
	}
	function my_plugin_install_function()
            {
             
            }
            
	private function define_constants() {
		define( 'WPSP_PLUGIN_FILE', __FILE__ );
        define( 'WPSP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );               
	    define( 'WPSP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );   

	    define('WPSP_TEMPLETE_URL', plugin_dir_url(__FILE__) . 'includes/admin/views/');
            define('WPSP_USER_TEMPLETE_URL', plugin_dir_url(__FILE__) . 'includes/user/views/');
            define('WPSP_USER_i18n', plugin_dir_url(__FILE__) . 'i18n');

            
            define('WPSP_VERSION', $this->version);
            define('WPSP_PREFIX', $this->wpbdp_prefix);
            define('WPSP_TYPE', 'FREE');
            define('WPSP_ENV', 'LIVE'); //LIVE OR DEV    

		
		
		}
		
	 function includes() {
	 	       include_once( 'includes/admin/class-admin-assets.php' );
	 	       include_once( 'includes/admin/class-admin-settings.php' );
            include_once( 'lib/mailchimp-sync/mailchimp-sync.php' );
             //        include_once( 'lib/campaign-monitor-dual-registration/campaign-monitor-dual-registration.php' );
             //        include_once( 'lib/aweber-web-form-widget/aweber.php' );
	           if (is_admin()) {
                include_once(WPSP_PLUGIN_DIR . 'includes/admin/controller/settingController.php' );
                $WPSubscriptionSetting = new WPSubscriptionSettingController();

                add_action('wp_ajax_wpuser_getSetting', array($WPSubscriptionSetting, 'get_setting'));
                add_action('wp_ajax_wpuser_updateSetting', array($WPSubscriptionSetting, 'update_setting'));

                 include_once(WPSP_PLUGIN_DIR . 'includes/admin/controller/autoresponderController.php' );
                $WPSubscriptionAutoresponder = new WPSubscriptionautoresponderController();

                add_action('wp_ajax_wpuser_getAutoresponderSetting', array($WPSubscriptionAutoresponder, 'get_setting'));

                
                  include_once(WPSP_PLUGIN_DIR.'includes/admin/controller/categoryController.php' );
                  $WPSubscriptioncategory = new WPSubscriptioncategory();

                    add_action( 'wp_ajax_wpuser_getCategory', array( $WPSubscriptioncategory, 'get_category' ) );
                        add_action( 'wp_ajax_wpuser_addCategory', array( $WPSubscriptioncategory, 'add_category' ) );
                        add_action( 'wp_ajax_wpuser_editCategory', array( $WPSubscriptioncategory, 'edit_category' ) );
                        add_action( 'wp_ajax_wpuser_updateCategory', array( $WPSubscriptioncategory, 'update_category' ) );
                        add_action( 'wp_ajax_wpuser_deleteCategory', array( $WPSubscriptioncategory, 'delete_category' ) );

                         add_action( 'wp_ajax_wpuser_getCategoryCsvData', array( $WPSubscriptioncategory, 'getCategoryCsvData' ) );

                         include_once(WPSP_PLUGIN_DIR.'includes/admin/controller/formController.php' );
                        $WPSubscriptionform = new WPSubscriptionform();

                        add_action( 'wp_ajax_wpuser_getForm', array( $WPSubscriptionform, 'get_form' ) );
                        add_action( 'wp_ajax_wpuser_getFormAllData', array( $WPSubscriptionform, 'get_form_all_data' ) );
                        add_action( 'wp_ajax_wpuser_addForm', array( $WPSubscriptionform, 'add_form' ) );
                        add_action( 'wp_ajax_wpuser_editForm', array( $WPSubscriptionform, 'edit_form' ) );
                        add_action( 'wp_ajax_wpuser_updateForm', array( $WPSubscriptionform, 'update_form' ) );
                        add_action( 'wp_ajax_wpuser_deleteForm', array( $WPSubscriptionform, 'delete_form' ) );
                         add_action( 'wp_ajax_wpuser_get_embeded_form', array( $WPSubscriptionform, 'get_embeded_form' ) );
                        include_once(WPSP_PLUGIN_DIR.'includes/admin/controller/subscribersController.php' );
                        $WPSubscriptionsubscriber = new WPSubscriptionsubscriber();

                       add_action( 'wp_ajax_wpuser_getsubscriber', array( $WPSubscriptionsubscriber, 'get_subscriber' ) );
                        add_action( 'wp_ajax_wpuser_addsubscriber_admin', array( $WPSubscriptionsubscriber, 'add_subscriber' ) );
                      // add_action( 'wp_ajax_wpuser_getsetting', array( $WPSubscriptionsubscriber, 'get_setting' ) );
                        add_action( 'wp_ajax_wpuser_editsubscriber', array( $WPSubscriptionsubscriber, 'edit_subscriber' ) );
                        add_action( 'wp_ajax_wpuser_updatesubscriber', array( $WPSubscriptionsubscriber, 'update_subscriber' ) );
                        add_action( 'wp_ajax_wpuser_deletesubscriber', array( $WPSubscriptionsubscriber, 'delete_subscriber' ) );

                         add_action( 'wp_ajax_wpuser_addsubscriber_csv', array( $WPSubscriptionsubscriber, 'addsubscriber_csv' ) );

                         include_once(WPSP_PLUGIN_DIR.'includes/admin/controller/dashboardController.php' );
                        $WPSubscriptiondashboard = new WPSubscriptiondashboard();
                         add_action( 'wp_ajax_wpuser_getdashboard', array( $WPSubscriptiondashboard, 'get_dashboard' ) );

                          include_once(WPSP_PLUGIN_DIR.'includes/admin/controller/reportController.php' );
                        $WPSubscriptionreport = new WPSubscriptionreport();
                         add_action( 'wp_ajax_wpuser_getreport', array( $WPSubscriptionreport, 'get_report' ) );
            }

             include_once(WPSP_PLUGIN_DIR.'includes/module/subscribersModule.php' );
             $WPSubscriptionModule = new WPSubscriptionModule();

             add_action( 'wp_ajax_wpuser_addsubscriber', array( $WPSubscriptionModule, 'add_subscriber' ) );
              add_action( 'wp_ajax_nopriv_wpuser_addsubscriber', array( $WPSubscriptionModule, 'add_subscriber' ) );
              include_once(WPSP_PLUGIN_DIR.'includes/module/actionMail.php');
              include_once(WPSP_PLUGIN_DIR.'includes/module/actionAutoresponder.php');
              include_once(WPSP_PLUGIN_DIR.'includes/module/actionThirdparty.php');
             
                //     include_once( 'lib/campaign-monitor-dual-registration/campaign-monitor-dual-registration.php' );
                //     include_once( 'lib/aweber-web-form-widget/aweber.php' );
                //     include_once( 'includes/front_end/shortcode.php' );  
                 include_once( 'includes/user/shortcode.php' );	
		             include_once( 'includes/widget.php' ); 
				 

	}  

	function installation(){
	 include('includes/installation.php');
	}

	function load_textdomain(){
		load_plugin_textdomain( 'wp-subscription',plugin_dir_path( __FILE__ ).'/lang' , 'wp-subscription/lang' );
	}
}
endif;
function WPSubscriptionBD() {
	return WPSubscription::instance();
}
$GLOBALS['WPSubscriptionBDplugin'] = WPSubscriptionBD();?>