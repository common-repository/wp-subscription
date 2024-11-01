    var listApp = angular.module('listpp', ['ngRoute','ngResource','angular.morris-chart','ui.bootstrap','checklist-model','ngCsvImport','textAngular']);    
     listApp.constant('apiUrl', wpsubscription_link.wpsubscription_ajax_url); 
      listApp.constant('wpsubscriptionLang', wpsubscription_link.wpsubscription_lang);       
    listApp.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
    });
    

