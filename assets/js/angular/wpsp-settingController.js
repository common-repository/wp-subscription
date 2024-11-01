
listApp.controller('wpspsettingController', function ($scope, $http, apiUrl,wpsubscriptionLang,translationService) {
    //i18n
    $scope.selectedLanguage = wpsubscriptionLang;
    //Run translation if selected language changes
    $scope.translate = function(){
       translationService.getTranslation($scope, $scope.selectedLanguage);
   };
    $scope.translate();
     
  
  $scope.checkAll = function() {
    $scope.user.roles = $scope.roles.map(function(item) { return item.id; });
  };
  $scope.uncheckAll = function() {
    $scope.user.roles = [];
  };
    $scope.get_list = function(){
    $http.get(apiUrl+"?action=wpuser_getCategory").success(function(data)
    {
        //$scope.product_detail = data;   
        $scope.listItems = data;          

    });
    }

    $scope.get_setting_form = function () {

        $http.get(apiUrl + "?action=wpuser_getSetting").success(function (data)
        {

            $scope.wp_subscription_title = data['wp_subscription_title'];
            $scope.wp_subscription_sub_title = data['wp_subscription_sub_title'];
            $scope.wp_subscription_enable_first_name = data['wp_subscription_enable_first_name'];
            $scope.wp_subscription_first_name = data['wp_subscription_first_name'];
            $scope.wp_subscription_enable_last_name = data['wp_subscription_enable_last_name'];
            $scope.wp_subscription_last_name = data['wp_subscription_last_name'];
            $scope.wp_subscription_email_label = data['wp_subscription_email_label'];
            $scope.wp_subscription_button_label = data['wp_subscription_button_label'];
            $scope.wpsp_forms = data['wpsp_forms'];
            $scope.wpsp_form_popup = data['wpsp_form_popup'];
            $scope.wpsp_form_popup_count = data['wpsp_form_popup_count'];
            $scope.wpsp_form_popup_time = data['wpsp_form_popup_time'];
            //  $scope.selectedpageids = data['selectedpageids'];
            $scope.selectedpageids=data['selectedpageids'];
            
          var arrayOfStrings =data['selectedpageids'];
          var arrayOfNumbers = arrayOfStrings.map(Number);           

              $scope.roles = data['pageids'];
              
              $scope.user = {
                roles:  arrayOfNumbers
              };

          $scope.wp_subscription_email_name = data['wp_subscription_email_name'];
            $scope.wp_subscription_email_id = data['wp_subscription_email_id'];
            $scope.wp_subscription_email_admin_register_enable = data['wp_subscription_email_admin_register_enable'];
            $scope.wp_subscription_email_admin_register_subject = data['wp_subscription_email_admin_register_subject'];
            $scope.wp_subscription_email_admin_register_content = data['wp_subscription_email_admin_register_content'];
            $scope.wp_subscription_email_user_register_enable = data['wp_subscription_email_user_register_enable'];
            $scope.wp_subscription_email_user_register_subject = data['wp_subscription_email_user_register_subject'];
            $scope.wp_subscription_email_user_register_content = data['wp_subscription_email_user_register_content'];

            $scope.wp_subscription_error_msg_required = data['wp_subscription_error_msg_required'];
            $scope.wp_subscription_error_msg_invalid_email = data['wp_subscription_error_msg_invalid_email'];
            $scope.wp_subscription_error_msg_email_exist = data['wp_subscription_error_msg_email_exist'];
            $scope.wp_subscription_success_msg = data['wp_subscription_success_msg'];    

            $scope.wp_subscription_appearance_skin = data['wp_subscription_appearance_skin'];
            $scope.wp_subscription_appearance_icon = data['wp_subscription_appearance_icon'];
            $scope.wp_subscription_appearance_custom_css = data['wp_subscription_appearance_custom_css'];
            $scope.wp_subscription_language = data['wp_subscription_language'];
                   


             $scope.wp_subscription_register_list_id = data['wp_subscription_register_list_id'];
             $scope.wp_subscription_register_list_id_enable = data['wp_subscription_register_list_id_enable'];

              $scope.wp_subscription_wp_user_register_list_id = data['wp_subscription_wp_user_register_list_id'];
             $scope.wp_subscription_wp_user_register_list_id_enable = data['wp_subscription_wp_user_register_list_id_enable'];

             $scope.wp_subscription_comment_list_id_enable = data['wp_subscription_comment_list_id_enable'];
             $scope.wp_subscription_comment_list_id = data['wp_subscription_comment_list_id'];

        });
    }
 $scope.update_setting_form = function () {

        $http.post(apiUrl + '?action=wpuser_updateSetting',
                {
                    'wp_subscription_title': $scope.wp_subscription_title,
                    'wp_subscription_sub_title': $scope.wp_subscription_sub_title,
 		             'wp_subscription_enable_first_name': $scope.wp_subscription_enable_first_name,
                    'wp_subscription_first_name': $scope.wp_subscription_first_name,
 	                  'wp_subscription_enable_last_name': $scope.wp_subscription_enable_last_name,
                    'wp_subscription_last_name': $scope.wp_subscription_last_name,
                     'wp_subscription_email_label': $scope.wp_subscription_email_label,
                      'wp_subscription_button_label': $scope.wp_subscription_button_label,
                      


                }
        )
                .success(function (data, status, headers, config) {
                    // $scope.get_setting_general();
                    toastr["success"]("Form setting has been Updated Successfully", "Success");
                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-center"
                    }

                })
                .error(function (data, status, headers, config) {
                    toastr["error"]("Sorry, Setting not updated", "Error");
                });
    }

     $scope.update_setting_integration = function () {

        $http.post(apiUrl + '?action=wpuser_updateSetting',
                {
                    'wp_subscription_register_list_id_enable': $scope.wp_subscription_register_list_id_enable,
                    'wp_subscription_register_list_id': $scope.wp_subscription_register_list_id,
                    'wp_subscription_comment_list_id_enable': $scope.wp_subscription_comment_list_id_enable,
                    'wp_subscription_comment_list_id': $scope.wp_subscription_comment_list_id,
                     'wp_subscription_wp_user_register_list_id': $scope.wp_subscription_wp_user_register_list_id,
                    'wp_subscription_wp_user_register_list_id_enable': $scope.wp_subscription_wp_user_register_list_id_enable,
                }
             
        )
                .success(function (data, status, headers, config) {
                    // $scope.get_setting_general();
                    toastr["success"]("Setting has been Updated Successfully", "Success");
                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-center"
                    }

                })
                .error(function (data, status, headers, config) {
                    toastr["error"]("Sorry, Setting not updated", "Error");
                });
    }
 $scope.update_setting_form_err_msg = function () {

        $http.post(apiUrl + '?action=wpuser_updateSetting',
                {
                    'wp_subscription_error_msg_required': $scope.wp_subscription_error_msg_required,
                    'wp_subscription_error_msg_invalid_email': $scope.wp_subscription_error_msg_invalid_email,
                     'wp_subscription_error_msg_email_exist': $scope.wp_subscription_error_msg_email_exist,
                    'wp_subscription_success_msg': $scope.wp_subscription_success_msg,
                      
                      


                }
        )
                .success(function (data, status, headers, config) {
                    // $scope.get_setting_general();
                    toastr["success"]("Setting has been Updated Successfully", "Success");
                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-center"
                    }

                })
                .error(function (data, status, headers, config) {
                    toastr["error"]("Sorry, Setting not updated", "Error");
                });
    }
   
    
     $scope.update_setting_general_appearance = function () {

        $http.post(apiUrl + '?action=wpuser_updateSetting',
                {
                    'wp_subscription_appearance_skin': $scope.wp_subscription_appearance_skin,
                    'wp_subscription_appearance_icon': $scope.wp_subscription_appearance_icon,
                    'wp_subscription_appearance_custom_css': $scope.wp_subscription_appearance_custom_css,
                    'wp_subscription_language': $scope.wp_subscription_language,
                }
        )
                .success(function (data, status, headers, config) {
                    // $scope.get_setting_general();
                    toastr["success"]("Setting has been Updated Successfully", "Success");
                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-center"
                    }

                })
                .error(function (data, status, headers, config) {
                    toastr["error"]("Sorry, Setting not updated", "Error");
                });
    }

    $scope.update_setting_popup = function () {

        $http.post(apiUrl + '?action=wpuser_updateSetting',
                {
                    'wpsp_form_popup': $scope.wpsp_form_popup,
                    'pageids': $scope.user.roles,       
                    'wpsp_form_popup_count': $scope.wpsp_form_popup_count, 
                    'wpsp_form_popup_time' : $scope.wpsp_form_popup_time,            
                }
        )
                .success(function (data, status, headers, config) {
                    // $scope.get_setting_general();
                    toastr["success"]("Setting has been Updated Successfully", "Success");
                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-center"
                    }

                })
                .error(function (data, status, headers, config) {
                    toastr["error"]("Sorry, Setting not updated", "Error");
                });
    }

    $scope.update_setting_email = function () {

        $http.post(apiUrl + '?action=wpuser_updateSetting',
                {
                    'wp_subscription_email_name': $scope.wp_subscription_email_name,
                    'wp_subscription_email_id': $scope.wp_subscription_email_id,
                    'wp_subscription_email_admin_register_enable': $scope.wp_subscription_email_admin_register_enable,
                    'wp_subscription_email_admin_register_subject': $scope.wp_subscription_email_admin_register_subject,
                     'wp_subscription_email_admin_register_content': $scope.wp_subscription_email_admin_register_content,
                     'wp_subscription_email_user_register_enable': $scope.wp_subscription_email_user_register_enable,
                    'wp_subscription_email_user_register_subject': $scope.wp_subscription_email_user_register_subject,
                     'wp_subscription_email_user_register_content': $scope.wp_subscription_email_user_register_content 
                     

                }
        )
                .success(function (data, status, headers, config) {
                    // $scope.get_setting_general();
                    toastr["success"]("Email setting has been Updated Successfully", "Success");
                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-center"
                    }

                })
                .error(function (data, status, headers, config) {
                    toastr["error"]("Sorry, Setting not updated", "Error");
                });
    }
});
