<?php 
 wp_enqueue_script( 'jquery' );
              
        wp_enqueue_style('wpce_bootstrap', WPSP_PLUGIN_URL . 'assets/css/bootstrap.min.css');
       wp_enqueue_style('wpdbadminltecss', WPSP_PLUGIN_URL . "assets/dist/css/AdminLTE.css");  
        
        if($atts['type']=='angular' || $atts['type']=='popup' ){
        wp_enqueue_script('wpdbbootstrap', WPSP_PLUGIN_URL . "assets/bootstrap/js/bootstrap.min.js");
        wp_enqueue_script('wpdbbootstrap');
        }
    //    wp_enqueue_script('jquery');

       $localize_script_data = array(
            'wpuser_ajax_url' => admin_url('admin-ajax.php'),
            'wpuser_site_url' => site_url(),
            'plugin_url' =>  WPSP_PLUGIN_URL,
            'plugin_dir' =>  WPSP_PLUGIN_DIR,
            'wpuser_user_templateUrl' =>  WPSP_USER_TEMPLETE_URL,
            'wpuser_user_i18n' =>  WPSP_USER_i18n,            
            'wpuser_lang'=>get_option('wp_user_language')
        ); 

        if($atts['type']=='angular'){
       
        wp_enqueue_script('wpangularjs', WPSP_PLUGIN_URL . "assets/angular.min.js");
        wp_enqueue_script('wpangularjs');
        
        wp_enqueue_script('wpangularjsresource', WPSP_PLUGIN_URL . "assets/angular-resource.js");
        wp_enqueue_script('wpangularjsresource');
        
        wp_enqueue_script('wpangularroughtjs', WPSP_PLUGIN_URL . "assets/angular-route.min.js");
        wp_enqueue_script('wpangularroughtjs');

        wp_enqueue_script('wpuserappcontroller', WPSP_PLUGIN_URL . "assets/userController.js");
        wp_enqueue_script('wpuserappcontroller');
        
      

        wp_localize_script('wpuserappcontroller', 'wpuser_link', $localize_script_data);

        wp_enqueue_script('subscriptionController', WPSP_PLUGIN_URL . "assets/js/angular/user/subscriptionController.js");
      
       

        wp_enqueue_script('wpbootstraptpls', WPSP_PLUGIN_URL . "assets/ui-bootstrap-tpls-0.10.0.min.js");
        wp_enqueue_script('wpbootstraptpls');

       

        wp_enqueue_script('wpdbraphael', "https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js");
        wp_enqueue_script('wpdbraphael');  

    }