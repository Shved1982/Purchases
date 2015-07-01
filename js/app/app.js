var app = angular.module('Test', ['ngRoute', 'ui.bootstrap']);

	app.config(['$routeProvider',function($routeProvider){
		$routeProvider.when('/',
		{
			templateUrl:'/site/default',
			controller:'ListController'
		});
		
		$routeProvider.otherwise({
			redirectTo: '/'
		});
	}]);
	
		app.filter('pagination', function() {
		  return function(arr, start, end) {
			return arr.slice(start, end);
		  };
		});
		
		app.filter('start', function() {
		  return function(arr, start, end) {
			
			
			var startDate = new Date("2000-01-01");
			var endDate = new Date("2999-01-01");	
			if(start !== undefined && start !== '')
			{
				var startDate = new Date(start);	
			}
			
			if(end !== undefined && end !== '')
			{
				var endDate = new Date(end);	
			}
			var result = [];
			angular.forEach(arr, function(val, key){
				value = new Date(val.date_start);
			
				if(startDate <= value && endDate >= value)
				{
					result.push(val);
				}
			});
			
			return result;
		  };
		});
		
		app.filter('end', function() {
		  return function(arr, start, end) {
			
			
			var startDate = new Date("2000-01-01");
			var endDate = new Date("2999-01-01");	
			
			if(start !== undefined && start !== '')
			{
				var startDate = new Date(start);	
			}
			
			if(end !== undefined && end !== '')
			{
				var endDate = new Date(end);	
			}
			
			var result = [];
			angular.forEach(arr, function(val, key){
				value = new Date(val.date_start);
				
				if(startDate <= value && endDate >= value)
				{
					result.push(val);
				}
			});
			
			return result;
		  };
		});