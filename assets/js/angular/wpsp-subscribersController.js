
    listApp.controller('wpspsubscribersController', function ($scope,$http,apiUrl) {
    $scope.filteredItems =  [];
    $scope.groupedItems  =  [];
    $scope.itemsPerPage  =  3;
    $scope.pagedItems    =  [];
    $scope.currentPage   =  0;

 

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
       // window.alert("Sorry, please get more subscriber first.");
        toastr["error"]("Sorry, please get more subscriber first.", "Error");
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

      $scope.get_setting = function(){
    $http.get(apiUrl+"?action=wpuser_getsetting").success(function(data)
    {
        //$scope.product_detail = data;   
        $scope.wpuser_getSetting = data;          

    });
    }


    /** function to get detail of product added in mysql referencing php **/

    $scope.get_product = function(){
    $http.get(apiUrl+"?action=wpuser_getsubscriber").success(function(data)
    {
        //$scope.product_detail = data;   
        $scope.pagedItems = data;    
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 5; //max no of items to display in a page
        $scope.filteredItems = $scope.pagedItems.length; //Initially for no filter  
        $scope.totalItems = $scope.pagedItems.length;

    });
    }


     $scope.submit_csv_list = function() {
        $http.post(apiUrl+'?action=wpuser_addsubscriber_csv', 
            {

                'fileContent'     : $scope.fileContent,
                'table'     :  'Subscription',
                
            }
        )
        .success(function (data, status, headers, config) {
         /* toastr["success"](data['error'], "Success");
          toastr.options = {
                  "closeButton": true,
                  "positionClass": "toast-top-center"
             }*/
                     $scope.message=data['message'];
                     $scope.status=data['status'];
 
          $scope.get_product();
           $scope.frist_name="";
          $scope.last_name="";
    $scope.email="";
          $scope.list_id="";
     

        })

        .error(function(data, status, headers, config){
           toastr["error"]("Sorry,subscriber not inserted", "Error");
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
        $http.post(apiUrl+'?action=wpuser_addsubscriber_admin', 
            {
                'frist_name'     : $scope.frist_name,
		'last_name'     : $scope.last_name,
                'email'     : $scope.email,
                 'list_id'     : $scope.list_id,
                
                
            }
        )
        .success(function (data, status, headers, config) {
         /* toastr["success"](data['error'], "Success");
	        toastr.options = {
                  "closeButton": true,
                  "positionClass": "toast-top-center"
             }*/
                     $scope.message=data['message'];
                     $scope.status=data['status'];
 
          $scope.get_product();
           $scope.frist_name="";
          $scope.last_name="";
	  $scope.email="";
          $scope.list_id="";
     

        })

        .error(function(data, status, headers, config){
           toastr["error"]("Sorry,subscriber not inserted", "Error");
        });

    }

    /** function to delete product from list of product referencing php **/

    $scope.prod_delete = function(index) {  
     var x = confirm("Are you sure to delete the selected subscriber");
     if(x){
      $http.post(apiUrl+'?action=wpuser_deletesubscriber', 
            {
                'id' : index
            }
        )      
        .success(function (data, status, headers, config) {               
             $scope.get_product();
             toastr["success"]("subscriber has been deleted Successfully", "Success");
             toastr.options = {
                  "closeButton": true,
                  "positionClass": "toast-top-center"
             }
             //toastr.success('subscriber has been deleted Successfully')
             //alert("subscriber has been deleted Successfully");
        })

        .error(function(data, status, headers, config){
           toastr["error"]("Sorry, subscriber not deleted", "Error");
        });
      }else{

      }
    }

    /** fucntion to edit product details from list of product referencing php **/

    $scope.editsubscriber = function(index) {  
      $scope.update_prod = true;
      $scope.add_prod = false;      
      
      $http.post(apiUrl+'?action=wpuser_editsubscriber', 
            {
                'id'     : index
            }
        )      
        .success(function (data, status, headers, config) {    
            //alert(data[0]["list_name"]);
           
            $scope.id          =   data[0]["id"];
            $scope.frist_name        =   data[0]["frist_name"];
            $scope.last_name       =   data[0]["last_name"];
            $scope.email=data[0]["email"];
             $scope.list_id=data[0]["list"];
            $scope.is_active=data[0]["is_active"];
          
            
        })

        .error(function(data, status, headers, config){
           
        });
    }

    /** function to update product details after edit from list of products referencing php **/

    $scope.update_subscriber = function() {

        $http.post(apiUrl+'?action=wpuser_updatesubscriber', 
                    {
                        'id'            : $scope.id,
                        'frist_name'     : $scope.frist_name,
    'last_name'     : $scope.last_name,
                'email'     : $scope.email,
                 'list_id'     : $scope.list_id,
                    }
                  )
                .success(function (data, status, headers, config) {                 
                  $scope.get_product();
		 toastr["success"]("subscriber has been Updated Successfully", "Success");
		toastr.options = {
                  "closeButton": true,
                  "positionClass": "toast-top-center"
             }
                   //alert("subscriber has been Updated Successfully");
                    $scope.update_prod = false;
                    $scope.add_prod = true;   
                    $scope.frist_name="";
                    $scope.last_name="";
		    $scope.email="";
          $scope.list_id="";
                   // $scope.list_defualt_from_name="";
                    
                })
                .error(function(data, status, headers, config){
                   toastr["error"]("Sorry, subscriber not updated", "Error");
                });
    }

   
});

listApp.directive('fileReader', function() {
  return {
    scope: {
      fileReader:"="
    },
    link: function(scope, element) {
      jQuery(element).on('change', function(changeEvent) {
        var files = changeEvent.target.files;
        if (files.length) {
          var r = new FileReader();
          r.onload = function(e) {
              var contents = e.target.result;
              scope.$apply(function () {               
                scope.fileReader = contents;
              });
          };
          
          r.readAsText(files[0]);
        }
      });
    }
  };
});