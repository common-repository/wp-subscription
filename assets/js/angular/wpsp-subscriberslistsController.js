
    listApp.controller('wpspsubscriberslistsController', function ($scope,$http,apiUrl) {
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
       // window.alert("Sorry, please get more category first.");
        toastr["error"]("Sorry, please get more category first.", "Error");
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

    /** function to get detail of product added in mysql referencing php **/

    $scope.get_product = function(){
    $http.get(apiUrl+"?action=wpuser_getCategory").success(function(data)
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
        $http.post(apiUrl+'?action=wpuser_addCategory', 
            {
                'list_name'     : $scope.list_name,
		       'list_defualt_email'     : $scope.list_defualt_email,
                'list_defualt_from_name'     : $scope.list_defualt_from_name,
                
                
            }
        )
        .success(function (data, status, headers, config) {
        toastr["success"]("Category has been Submitted Successfully", "Success");
	      toastr.options = {
                  "closeButton": true,
                  "positionClass": "toast-top-center"
             }
         // alert("Category has been Submitted Successfully!!!!");
          $scope.get_product();
          $scope.list_name="";
	        $scope.list_defualt_email="";
          $scope.list_defualt_from_name="";
      //     $scope.list_defualt_from_name="";

        })

        .error(function(data, status, headers, config){
           toastr["error"]("Sorry,Category not inserted", "Error");
        });

    }

    /** function to delete product from list of product referencing php **/

    $scope.prod_delete = function(index) {  
     var x = confirm("Are you sure to delete the selected product");
     if(x){
      $http.post(apiUrl+'?action=wpuser_deleteCategory', 
            {
                'id' : index
            }
        )      
        .success(function (data, status, headers, config) {               
             $scope.get_product();
             toastr["success"]("Category has been deleted Successfully", "Success");
             toastr.options = {
                  "closeButton": true,
                  "positionClass": "toast-top-center"
             }
             //toastr.success('Category has been deleted Successfully')
             //alert("Category has been deleted Successfully");
        })

        .error(function(data, status, headers, config){
           toastr["error"]("Sorry, Category not deleted", "Error");
        });
      }else{

      }
    }

    /** fucntion to edit product details from list of product referencing php **/

    $scope.editCategory = function(index) {  
      $scope.update_prod = true;
      $scope.add_prod = false;      
      
      $http.post(apiUrl+'?action=wpuser_editCategory', 
            {
                'id'     : index
            }
        )      
        .success(function (data, status, headers, config) {    
            //alert(data[0]["list_name"]);
           
            $scope.id          =   data[0]["id"];
            $scope.list_name        =   data[0]["list_name"];
            $scope.list_defualt_email       =   data[0]["list_defualt_email"];
            $scope.list_defualt_from_name=data[0]["list_defualt_from_name"];
            $scope.list_defualt_from_name_cat=data[0]["list_defualt_from_name_cat"];
           // $scope.list_defualt_from_name       =   data[0]["list_defualt_from_name"];
            
        })

        .error(function(data, status, headers, config){
           
        });
    }

    /** function to update product details after edit from list of products referencing php **/

    $scope.update_category = function() {

        $http.post(apiUrl+'?action=wpuser_updateCategory', 
                    {
                        'id'            : $scope.id,
                        'list_name'     : $scope.list_name,  
			'list_defualt_email'     : $scope.list_defualt_email,
                        'list_defualt_from_name'     : $scope.list_defualt_from_name        
                    }
                  )
                .success(function (data, status, headers, config) {                 
                  $scope.get_product();
		 toastr["success"]("Category has been Updated Successfully", "Success");
		toastr.options = {
                  "closeButton": true,
                  "positionClass": "toast-top-center"
             }
                   //alert("Category has been Updated Successfully");
                    $scope.update_prod = false;
                    $scope.add_prod = true;   
                    $scope.list_name="";
                    $scope.list_defualt_from_name="";
		    $scope.list_defualt_email="";
                   // $scope.list_defualt_from_name="";
                    
                })
                .error(function(data, status, headers, config){
                   toastr["error"]("Sorry, Category not updated", "Error");
                });
    }

   
});
