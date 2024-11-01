
    listApp.controller('wpspformsController', function ($scope,$http,apiUrl,wpsubscriptionLang,translationService) {
    $scope.filteredItems =  [];
    $scope.groupedItems  =  [];
    $scope.itemsPerPage  =  3;
    $scope.pagedItems    =  [];
    $scope.currentPage   =  0;
    $scope.embeded_form ="";

   //i18n
    $scope.selectedLanguage = wpsubscriptionLang;
    //Run translation if selected language changes
    $scope.translate = function(){
       translationService.getTranslation($scope, $scope.selectedLanguage);
   };
    $scope.translate();
     

    /** Scope argument specify the function by name remove and passed index of list item as a parameter , which splice the list by 1 , as click on remove button **/
            
    $scope.remove = function (index) {
        $scope.phones.splice(index,1);
    }

    $scope.funding = { startingEstimate: 0 };

    $scope.computeNeeded = function() {           
        $scope.needed = $scope.funding.startingEstimate * 10;                
    };


    /** Check if value for funding is 0 or more **/

    $scope.requestFunding = function() {               
        if( $scope.needed == "" || !$scope.needed )
       // window.alert("Sorry, please get more Form first.");
        toastr["error"]("Sorry, please get more Form first.", "Error");
    };

    $scope.reset = function() {
        $scope.funding.startingEstimate = 0;
        $scope.needed = 0;
    };

    /** toggleMenu Function to show menu by toggle effect , by default the stage of the menu is false as we click on toggle button, we make it to true or show and reverse on anothe click event. **/

    $scope.menuState = false;
    $scope.add_prod = true;

    $scope.toggleMenu = function() {                
        if($scope.menuState) {                    
            $scope.menuState= false;
        }
        else {
            $scope.menuState= !$scope.menuState.show;
        }
    };

     $scope.get_list = function(){
    $http.get(apiUrl+"?action=wpuser_getCategory").success(function(data)
    {
        //$scope.product_detail = data;   
        $scope.listItems = data;          

    });
    }

    $scope.get_setting_form = function () {

        $http.get(apiUrl + "?action=wpuser_getAutoresponderSetting").success(function (data)
        {

            $scope.mailchimp_apikey = data['mailchimp_apikey'];
            $scope.mailchimp_apikey_test = data['mailchimp_apikey_test'];
            $scope.mailchimp_apikey_list_message = data['mailchimp_apikey_list_message'];
            $scope.mailchimp_lists = data['mailchimp_lists'];
            $scope.wp_subscription_mailchimp_list = data['wp_subscription_mailchimp_list'];
            

        });
    }

    /** function to get detail of product added in mysql referencing php **/

    $scope.get_product = function(){
    $http.get(apiUrl+"?action=wpuser_getForm").success(function(data)
    {
        //$scope.product_detail = data;   
        $scope.pagedItems = data;    
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 5; //max no of items to display in a page
        $scope.filteredItems = $scope.pagedItems.length; //Initially for no filter  
        $scope.totalItems = $scope.pagedItems.length;

    });
    }

  
    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };
    $scope.filter = function() {
        $timeout(function() { 
            $scope.filteredItems = $scope.filtered.length;
        }, 10);
    };
    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    };

    /** function to add details for products in mysql referecing php **/

    $scope.product_submit = function() {
        $http.post(apiUrl+'?action=wpuser_addForm', 
            {
                'wp_subscription_title': $scope.wp_subscription_title,
                    'wp_subscription_sub_title': $scope.wp_subscription_sub_title,
                 'wp_subscription_enable_first_name': $scope.wp_subscription_enable_first_name,
                    'wp_subscription_first_name': $scope.wp_subscription_first_name,
                    'wp_subscription_enable_last_name': $scope.wp_subscription_enable_last_name,
                    'wp_subscription_last_name': $scope.wp_subscription_last_name,
                     'wp_subscription_email_label': $scope.wp_subscription_email_label,
                      'wp_subscription_button_label': $scope.wp_subscription_button_label,
                      'wp_subscription_error_msg_required': $scope.wp_subscription_error_msg_required,
                    'wp_subscription_error_msg_invalid_email': $scope.wp_subscription_error_msg_invalid_email,
                     'wp_subscription_error_msg_email_exist': $scope.wp_subscription_error_msg_email_exist,
                    'wp_subscription_success_msg': $scope.wp_subscription_success_msg,
                      'wp_subscription_appearance_skin': $scope.wp_subscription_appearance_skin,
                    'wp_subscription_appearance_icon': $scope.wp_subscription_appearance_icon,
                    'wp_subscription_appearance_custom_css': $scope.wp_subscription_appearance_custom_css,
                    'wp_subscription_language': $scope.wp_subscription_language,
                    'list_id': $scope.list_id,
                    'wp_subscription_mailchimp_list': $scope.wp_subscription_mailchimp_list,
                
                
            }
        )
        .success(function (data, status, headers, config) {
        toastr["success"]("Form has been Submitted Successfully", "Success");
	toastr.options = {
                  "closeButton": true,
                  "positionClass": "toast-top-center"
             }
                $scope.get_product();
         // alert("Form has been Submitted Successfully!!!!");
          $scope.update_prod = false;
                    $scope.add_prod = true;   
                     $scope.wp_subscription_title = '';
            $scope.wp_subscription_sub_title =   '';
            $scope.wp_subscription_enable_first_name =    '';
            $scope.wp_subscription_first_name =    '';
            $scope.wp_subscription_enable_last_name =   '';
            $scope.wp_subscription_last_name =  '';
             $scope.wp_subscription_email_label =   '';
            $scope.wp_subscription_button_label =   '';

        $scope.wp_subscription_error_msg_required =    '';
            $scope.wp_subscription_error_msg_invalid_email =   '';
            $scope.wp_subscription_error_msg_email_exist =    '';
            $scope.wp_subscription_success_msg =   '';

        $scope.wp_subscription_appearance_skin =   '';
            $scope.wp_subscription_appearance_icon =   '';
            $scope.wp_subscription_appearance_custom_css =   '';
            $scope.wp_subscription_language =   '';
             $scope.list_id =   '';
               $scope.wp_subscription_mailchimp_list =   '';

        })

        .error(function(data, status, headers, config){
           toastr["error"]("Sorry,Form not inserted", "Error");
        });

    }

    /** function to delete product from list of product referencing php **/

    $scope.prod_delete = function(index) {  
     var x = confirm("Are you sure to delete the selected form");
     if(x){
      $http.post(apiUrl+'?action=wpuser_deleteForm', 
            {
                'id' : index
            }
        )      
        .success(function (data, status, headers, config) {               
             $scope.get_product();
             toastr["success"]("Form has been deleted Successfully", "Success");
             toastr.options = {
                  "closeButton": true,
                  "positionClass": "toast-top-center"
             }
             //toastr.success('Form has been deleted Successfully')
             //alert("Form has been deleted Successfully");
        })

        .error(function(data, status, headers, config){
           toastr["error"]("Sorry, Form not deleted", "Error");
        });
      }else{

      }
    }

    /** fucntion to edit product details from list of product referencing php **/

 $scope.get_embeded_form = function(index) {       
      $http.post(apiUrl+'?action=wpuser_get_embeded_form', 
            {
                'id'     : index
            }
        )  
      .success(function (data, status, headers, config) {              
              $scope.embeded_form =   data;
             
        })
    } 
    
    $scope.editForm = function(index) {  
      $scope.update_prod = true;
      $scope.add_prod = false;      
      
      $http.post(apiUrl+'?action=wpuser_editForm', 
            {
                'id'     : index
            }
        )      
        .success(function (data, status, headers, config) {    
          $scope.id =   data['id'];
             $scope.wp_subscription_title =   data['wp_subscription_title'];
            $scope.wp_subscription_sub_title =   data['wp_subscription_sub_title'];
            $scope.wp_subscription_enable_first_name =   data['wp_subscription_enable_first_name'];
            $scope.wp_subscription_first_name =   data['wp_subscription_first_name'];
            $scope.wp_subscription_enable_last_name =   data['wp_subscription_enable_last_name'];
            $scope.wp_subscription_last_name =   data['wp_subscription_last_name'];
             $scope.wp_subscription_email_label =   data['wp_subscription_email_label'];
            $scope.wp_subscription_button_label =   data['wp_subscription_button_label'];

        $scope.wp_subscription_error_msg_required =   data['wp_subscription_error_msg_required'];
            $scope.wp_subscription_error_msg_invalid_email =   data['wp_subscription_error_msg_invalid_email'];
            $scope.wp_subscription_error_msg_email_exist =   data['wp_subscription_error_msg_email_exist'];
            $scope.wp_subscription_success_msg =   data['wp_subscription_success_msg'];

        $scope.wp_subscription_appearance_skin =   data['wp_subscription_appearance_skin'];
            $scope.wp_subscription_appearance_icon =   data['wp_subscription_appearance_icon'];
            $scope.wp_subscription_appearance_custom_css =   data['wp_subscription_appearance_custom_css'];
            $scope.wp_subscription_language =   data['wp_subscription_language'];
            $scope.list_id =   data['list_id'];
             $scope.wp_subscription_mailchimp_list =   data['wp_subscription_mailchimp_list'];
             
            
        })

        .error(function(data, status, headers, config){
           
        });
    }

    /** function to update product details after edit from list of products referencing php **/

    $scope.update_form = function() {

        $http.post(apiUrl+'?action=wpuser_updateForm', 
                    {
                       'id'            : $scope.id,
                       'wp_subscription_title': $scope.wp_subscription_title,                      
                    'wp_subscription_sub_title': $scope.wp_subscription_sub_title,
                 'wp_subscription_enable_first_name': $scope.wp_subscription_enable_first_name,
                    'wp_subscription_first_name': $scope.wp_subscription_first_name,
                    'wp_subscription_enable_last_name': $scope.wp_subscription_enable_last_name,
                    'wp_subscription_last_name': $scope.wp_subscription_last_name,
                     'wp_subscription_email_label': $scope.wp_subscription_email_label,
                      'wp_subscription_button_label': $scope.wp_subscription_button_label,
                      'wp_subscription_error_msg_required': $scope.wp_subscription_error_msg_required,
                    'wp_subscription_error_msg_invalid_email': $scope.wp_subscription_error_msg_invalid_email,
                     'wp_subscription_error_msg_email_exist': $scope.wp_subscription_error_msg_email_exist,
                    'wp_subscription_success_msg': $scope.wp_subscription_success_msg,
                      'wp_subscription_appearance_skin': $scope.wp_subscription_appearance_skin,
                    'wp_subscription_appearance_icon': $scope.wp_subscription_appearance_icon,
                    'wp_subscription_appearance_custom_css': $scope.wp_subscription_appearance_custom_css,
                    'wp_subscription_language': $scope.wp_subscription_language,
                     'list_id': $scope.list_id,
                      'wp_subscription_mailchimp_list': $scope.wp_subscription_mailchimp_list,
                    }
                  )
                .success(function (data, status, headers, config) {                 
                  $scope.get_product();
		 toastr["success"]("Form has been Updated Successfully", "Success");
		toastr.options = {
                  "closeButton": true,
                  "positionClass": "toast-top-center"
             }
                   //alert("Form has been Updated Successfully");
                    $scope.update_prod = false;
                    $scope.add_prod = true;   
                     $scope.wp_subscription_title = '';
            $scope.wp_subscription_sub_title =   '';
            $scope.wp_subscription_enable_first_name =    '';
            $scope.wp_subscription_first_name =    '';
            $scope.wp_subscription_enable_last_name =   '';
            $scope.wp_subscription_last_name =  '';
             $scope.wp_subscription_email_label =   '';
            $scope.wp_subscription_button_label =   '';

        $scope.wp_subscription_error_msg_required =    '';
            $scope.wp_subscription_error_msg_invalid_email =   '';
            $scope.wp_subscription_error_msg_email_exist =    '';
            $scope.wp_subscription_success_msg =   '';

        $scope.wp_subscription_appearance_skin =   '';
            $scope.wp_subscription_appearance_icon =   '';
            $scope.wp_subscription_appearance_custom_css =   '';
            $scope.wp_subscription_language =   '';
             $scope.list_id =   '';
               $scope.wp_subscription_mailchimp_list =   '';
                    
                })
                .error(function(data, status, headers, config){
                   toastr["error"]("Sorry, Form not updated", "Error");
                });
    }

   
});
