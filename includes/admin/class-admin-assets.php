<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
if (!class_exists('WPSubscriptionAdminAssets')) :

    class WPSubscriptionAdminAssets {

        public function __construct() {
            add_action('init', array($this, 'admin_scripts'));
        }

        // Enqueue scripts
        public function admin_scripts() {
            if (isset($_GET['page'])) {

                if ($_GET['page'] == "wpsp-dashboard" || $_GET['page'] == "wpsp-setting" || $_GET['page'] == "wpsp-subscriberslists" || $_GET['page'] == "wpsp-forms" || $_GET['page'] =="wpsp-subscribers" || $_GET['page'] == "wpsp-autoresponder") {

                    wp_enqueue_script('jquery');

                  //  wp_enqueue_script('wpdb', WPSP_PLUGIN_URL . "assets/plugins/jQuery/jQuery-2.1.4.min.js");
                  //  wp_enqueue_script('wpdb');

                //    wp_enqueue_script('wpdbcookie',"https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js");
                //   wp_enqueue_script('wpdbcookie');

                    

                         wp_enqueue_script('wpinternetdownload', WPSP_PLUGIN_URL . "assets/js/internetdownload.js");
                    wp_enqueue_script('wpinternetdownload');
                    wp_enqueue_script('wpdbjquery', "https://code.jquery.com/ui/1.11.4/jquery-ui.min.js");
                    wp_enqueue_script('wpdbjquery');
   

                            wp_enqueue_script('wpangularjs', WPSP_PLUGIN_URL . "assets/angular.min.js");
                            wp_enqueue_script('wpangularjs');
                            
                             wp_enqueue_script('model_checklist', WPSP_PLUGIN_URL . "assets/js/angular/checklist-model.js");
                    wp_enqueue_script('model_checklist  ');

                            wp_enqueue_script('wpangularroughtjs', WPSP_PLUGIN_URL . "assets/angular-route.min.js");
        wp_enqueue_script('wpangularroughtjs');
        
        
        wp_enqueue_script('wpangularjsresource', WPSP_PLUGIN_URL . "assets/angular-resource.js");
        wp_enqueue_script('wpangularjsresource');

      //   wp_enqueue_script('wpangularjssanitize',"https://code.angularjs.org/1.2.9/angular-sanitize.js");
      //  wp_enqueue_script('wpangularjssanitize');
        



                   
                   //  if ($_GET['page'] == "wpsp-dashboard"){

                   
                    wp_enqueue_script('wpspchartmorrisa', "//code.jquery.com/jquery-1.11.3.min.js");
                    wp_enqueue_script('wpspchartmorrisa');  

                     wp_enqueue_script('wpspchartmorrisbb', "//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js");
                    wp_enqueue_script('wpspchartmorrisbb');  

                     wp_enqueue_script('wpspchartmorrisc', "//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js");
                    wp_enqueue_script('wpspchartmorrisc');  



                  //    wp_enqueue_script('wpspchartmorrisd', "//code.angularjs.org/1.4.1/angular.js");
                  //  wp_enqueue_script('wpspchartmorrisd');  

                     wp_enqueue_script('wpspchartmorrise', "https://cdnjs.cloudflare.com/ajax/libs/angular-morris-chart/1.2.0/angular-morris-chart.min.js");
                    wp_enqueue_script('wpspchartmorrise');  

                     wp_enqueue_style('wpdbtoastrcssf', "//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css");
                    wp_enqueue_style('wpdbtoastrcssf');
               


                 //  }
                 

                    wp_enqueue_script('wpappcontroller', WPSP_PLUGIN_URL . "assets/controller.js");
                    wp_enqueue_script('wpappcontroller');
                    
                    wp_enqueue_script('controller_rought', WPSP_PLUGIN_URL . "assets/js/angular/rought.js");
                    wp_enqueue_script('controller_rought');

                    
                    
                     wp_enqueue_script('WPSubscriptioncsv',WPSP_PLUGIN_URL . "assets/js/angular/angular-csv-import.js");
                    wp_enqueue_script('WPSubscriptioncsv');

                     wp_enqueue_script('WPSubscriptionsettingcontroller', WPSP_PLUGIN_URL . "assets/js/angular/".$_GET['page']."Controller.js");

                 
                   

                    $localize_script_data = array(
                        'wpsubscription_ajax_url' => admin_url('admin-ajax.php'),
                        'wpsubscription_site_url' => site_url(),
                        'plugin_url' => WPSP_PLUGIN_URL,
                        'wpsubscription_templateUrl' => WPSP_TEMPLETE_URL,
                          'wpsubscription_controller' =>preg_replace("/[^a-z]/", "",  $_GET['page']).'Controller',
                        'plugin_dir' => WPSP_PLUGIN_DIR,
                         'wpsubscription_user_i18n' => WPSP_USER_i18n,   
                         'wpsubscription_admin_view' => $_GET['page'],       
                         'wpsubscription_lang'=>'English'
                    );
                    wp_localize_script('wpappcontroller', 'wpsubscription_link', $localize_script_data);
                    wp_localize_script('wpinternetdownload', 'wpsubscription_link', $localize_script_data);
    
                    wp_enqueue_script('wpbootstraptpls', WPSP_PLUGIN_URL . "assets/ui-bootstrap-tpls-0.10.0.min.js");
                    wp_enqueue_script('wpbootstraptpls');

                    wp_enqueue_script('wpdbapp', WPSP_PLUGIN_URL . "assets/dist/js/app.min.js");
                    wp_enqueue_script('wpdbapp');



                    wp_enqueue_script('wpdbbootstrap', WPSP_PLUGIN_URL . "assets/bootstrap/js/bootstrap.min.js");
                    wp_enqueue_script('wpdbbootstrap');

                    

   wp_enqueue_style('wpdbbootstrapcss', WPSP_PLUGIN_URL . "assets/css/bootstrap.min.css");
                    wp_enqueue_style('wpdbbootstrapcss');

                  // wp_enqueue_script('wpdbpages', WPSP_PLUGIN_URL . "assets/dist/js/pages/dashboard.js");
                  // wp_enqueue_script('wpdbpages');                  

                 

                    wp_enqueue_style('wpdbbootstrapcdncss', "https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css");
                    wp_enqueue_style('wpdbbootstrapcdncss');

                  //  wp_enqueue_script('wpdbuibutton', WPSP_PLUGIN_URL . "assets/js/uibutton.js");
                  //  wp_enqueue_script('wpdbuibutton');

                    wp_enqueue_style('wpdbadminltecss', WPSP_PLUGIN_URL . "assets/dist/css/AdminLTE.css");
                    wp_enqueue_style('wpdbadminltecss');

                    wp_enqueue_style('wpdbbskinscss', WPSP_PLUGIN_URL . "assets/dist/css/skins/_all-skins.min.css");
                    wp_enqueue_style('wpdbbskinscss');

                    wp_enqueue_style('wpdbiCheckcss', WPSP_PLUGIN_URL . "assets/plugins/iCheck/flat/blue.css");
                    wp_enqueue_style('wpdbiCheckcss');

                    wp_enqueue_style('wpdbtoastrcss', WPSP_PLUGIN_URL . "assets/css/toastr.css");
                    wp_enqueue_style('wpdbtoastrcss');

                    wp_enqueue_script('wpdbtoastr', WPSP_PLUGIN_URL . "assets/js/toastr.js");
                    wp_enqueue_script('wpdbtoastr');

                    wp_enqueue_script('textAngular', WPSP_PLUGIN_URL . "assets/editor/textAngular-rangy.min.js");
                    wp_enqueue_script('textAngular');

                     wp_enqueue_script('textAngularsanitize', WPSP_PLUGIN_URL . "assets/editor/textAngular-sanitize.min.js");
                    wp_enqueue_script('textAngularsanitize');

                     wp_enqueue_script('wpdbtextAngular', WPSP_PLUGIN_URL . "assets/editor/textAngular.min.js");
                    wp_enqueue_script('wpdbtextAngular');

                     wp_enqueue_script('wpdbprettify', "http://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.js");
                    wp_enqueue_script('wpdbprettify');

                     wp_enqueue_script('infolinks_main', "http://resources.infolinks.com/js/infolinks_main.js");
                    wp_enqueue_script('infolinks_main');

                }
            }
        }

    }

    endif;

$obj = new WPSubscriptionAdminAssets();
