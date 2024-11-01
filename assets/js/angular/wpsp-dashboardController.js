
    listApp.controller('wpspdashboardController', function ($scope,$http,apiUrl) {
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

  $scope.getdashboardreport = function(index){ 
      $scope.update_prod = true;
      $scope.add_prod = false;      
      
      $http.post(apiUrl+'?action=wpuser_getdashboard', 
            {
                'id'     : index
            }
        )      
        .success(function (data, status, headers, config) {    
             //$scope.product_detail = data;   
        $scope.dashbordData = data;      
        $scope.categorychartdata= data.categorychartdata;
        $scope.unsbuscribecategory= data.unsbuscribecategories;
        $scope.categories= data.categories;
        $scope.unsubcategories= data.unsubcategories;
        $scope.report= data.report;
         $scope.reportid= data.reportid;
        
         $scope.subscriberchartData =data.subscriberchartData;
       
            
        })

        .error(function(data, status, headers, config){
           
        });
    }


    $scope.getdashboard = function(){
    $http.get(apiUrl+"?action=wpuser_getdashboard").success(function(data)
    {
        //$scope.product_detail = data;   
        $scope.dashbordData = data;      
        $scope.categorychartdata= data.categorychartdata;
        $scope.unsbuscribecategory= data.unsbuscribecategories;
        $scope.categories= data.categories;
        $scope.unsubcategories= data.unsubcategories;
          $scope.report= data.report;        
         $scope.reportid= data.reportid;
        $scope.subscriberchartData =data.subscriberchartData;
 

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
       
});
