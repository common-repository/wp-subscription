<div ng-app="listpp" ng-app lang="en">
                   <div class="login-box-body" ng-controller="subscriptionController">
           <form name="userForm" role="form" ng-submit="product_submit(userForm.$valid)" novalidate>
                  <div class="box-body">
                    <div class="alert alert-{{status}} alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>{{message}}</div>                  
                    <div class="form-group">
                      <label for="frist_name">First Name</label><br>
                      <input type="text" id="frist_name" name="frist_name" ng-model="frist_name" placeholder="Enter First Name">
                    </div> 
                     <div class="form-group">
                      <label for="last_name">Last</label><br>
                      <input type="text" id="last_name" name="last_name" ng-model="last_name" placeholder="Enter last name">
                    </div> 
                    <div class="form-group">
                      <label for="email">Email *</label><br>
                      <input type="text" id="email" name="email" ng-model="email" placeholder="Enter email address" required>
                       </br><p class="label label-danger" ng-show="userForm.email.$error.required">Email is required.</p>
                      <p class="label label-danger" ng-show="userForm.email.$error.email">Invalid email address.</p>
                    </div> 
                    <div ng-show='add_prod' class="form-group" ng-init="get_list()">
                      <label for="list_id">List *</label><br>
                    
<select required ng-show='add_prod' name="list_id" id="list_id" ng-model="list_id">
      <option ng-repeat="option in listItems" value="{{option.id}}">{{option.list_name}}</option>
    </select>
     </br><p class="label label-danger" ng-show="userForm.list_id.$error.required">Select list.</p>
     </div>                      
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                      <input type="button" class="btn btn-primary" name="submit_product" ng-show='add_prod' value="Submit" ng-click="product_submit()" ng-disabled="userForm.$invalid">
            <input type="button" class="btn btn-primary" name="update_subscriber" ng-show='update_prod' value="Update" ng-click="update_subscriber()" ng-disabled="userForm.$invalid">  
                   
                  </div>
                </form>
</div> 
</div>