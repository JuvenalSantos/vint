define(['app'], function (app) {
	'use strict';
	return app.config(['$routeProvider', function ($routeProvider) {

		$routeProvider
                  .when('/Home', {templateUrl: 'app/view/home/Home.html',controller: 'HomeController'})
                  .when('/LoadFile', {templateUrl: 'app/view/loadfile/LoadFile.html',controller: 'LoadFileController'})
                  .when('/VisSingleLine/:id', {templateUrl: 'app/view/vissingleline/VisSingleLine.html',controller: 'VisSingleLine'})
                  .when('/VisMultiLine/:id', {templateUrl: 'app/view/vismultiline/VisMultiLine.html',controller: 'VisMultiLine'})
                  .when('/VisCircle/:id', {templateUrl: 'app/view/viscircle/VisCircle.html',controller: 'VisCircle'})


                  /* USER */
                  .when('/User', {templateUrl: 'app/view/user/User.html',controller: 'UserController'})
                  .when('/User/add', {templateUrl: 'app/view/user/UserAdd.html',controller: 'UserAddController'})
                  .when('/User/:id', {templateUrl: 'app/view/user/UserEdit.html',controller: 'UserEditController'})
                  .when('/User/remove/:id', {templateUrl: 'app/view/blank.html',controller: 'UserRemoveController'})
                  .when('/User/activate/:id', {templateUrl: 'app/view/blank.html',controller: 'UserActivateController'}) 
			
                  .otherwise({redirectTo: '/Home'});
	}]);
});