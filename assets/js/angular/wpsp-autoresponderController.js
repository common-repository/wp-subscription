
listApp.controller('wpspautoresponderController', function ($scope, $http, apiUrl,wpsubscriptionLang,translationService) {
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
   

    $scope.get_setting_form = function () {

        $http.get(apiUrl + "?action=wpuser_getAutoresponderSetting").success(function (data)
        {

            $scope.mailchimp_apikey = data['mailchimp_apikey'];
            $scope.mailchimp_apikey_test = data['mailchimp_apikey_test'];
            $scope.mailchimp_apikey_list_message = data['mailchimp_apikey_list_message'];
            $scope.mailchimp_lists = data['mailchimp_lists'];
            $scope.wp_subscription_enable_auto_opt_mailchimp = data['wp_subscription_enable_auto_opt_mailchimp'];
            $scope.wp_subscription_enable_ignore_email_mailchimp = data['wp_subscription_enable_ignore_email_mailchimp'];
            

        });
    }
 $scope.update_setting_form = function () {

        $http.post(apiUrl + '?action=wpuser_getAutoresponderSetting',
                {
                    'mailchimp_apikey': $scope.mailchimp_apikey,
                    'wp_subscription_enable_auto_opt_mailchimp': $scope.wp_subscription_enable_auto_opt_mailchimp,
                    'wp_subscription_enable_ignore_email_mailchimp': $scope.wp_subscription_enable_ignore_email_mailchimp,
                }
        )
                .success(function (data, status, headers, config) {
                    // $scope.get_setting_general();
                    toastr["success"]("Form setting has been Updated Successfully", "Success");
                    toastr.options = {
                        "closeButton": true,
                        "positionClass": "toast-top-center"
                    }

                    $scope.mailchimp_apikey = data['mailchimp_apikey'];
                    $scope.mailchimp_apikey_test = data['mailchimp_apikey_test'];
                    $scope.mailchimp_apikey_list_message = data['mailchimp_apikey_list_message'];
                    $scope.mailchimp_lists = data['mailchimp_lists'];
                   // $scope.wp_subscription_enable_auto_opt_mailchimp = data['wp_subscription_enable_auto_opt_mailchimp'];
                  //  $scope.wp_subscription_enable_ignore_email_mailchimp = data['wp_subscription_enable_ignore_email_mailchimp'];
                })
                .error(function (data, status, headers, config) {
                    toastr["error"]("Sorry, Setting not updated", "Error");
                });
    }

 

});
