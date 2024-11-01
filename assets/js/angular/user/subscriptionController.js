    listApp.controller('subscriptionController', function ($scope,$http,apiUrl) {
   
     $scope.get_list = function(){
    $http.get(apiUrl+"?action=wpuser_getCategory").success(function(data)
    {
        //$scope.product_detail = data;   
        $scope.listItems = data;          

    });
    }
  $scope.add_prod = true;

    $scope.product_submit = function() {
        $http.post(apiUrl+'?action=wpuser_addsubscriber', 
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

   
      
});
