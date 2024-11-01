
     listApp.service('translationService', function($resource) {  

        this.getTranslation = function($scope, language) {
            var languageFilePath = wpsubscription_link.wpsubscription_user_i18n+'/English.json';
            console.log(languageFilePath);
            $resource(languageFilePath).get(function (data) {
                $scope.translation = data;
            });
        };
    });
    listApp .config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/settingController', {
        templateUrl: wpsubscription_link.wpsubscription_templateUrl+'templates/'+wpsubscription_link.wpsubscription_admin_view+'.html',
        controller: 'settingController'
      }). 
 when('/subscribersController', {
        templateUrl: wpsubscription_link.wpsubscription_templateUrl+'templates/'+wpsubscription_link.wpsubscription_admin_view+'.html',
        controller: 'subscribersController'
      }). 
      otherwise({
        templateUrl: wpsubscription_link.wpsubscription_templateUrl+'templates/'+wpsubscription_link.wpsubscription_admin_view+'.html',
        controller: wpsubscription_link.wpsubscription_controller
      });
  }]);
  
  
   
