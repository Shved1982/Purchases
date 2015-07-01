app.controller('ViewController', 
			   ['$scope', '$rootScope', 'Customers', 'Orders', '$routeParams', '$location', '$window','$anchorScroll','$http',
			   function ($scope, $rootScope, Customers, Orders, $routeParams, $location, $window, $anchorScroll, $http) {
	
	$scope.viewcustomers = {};
	$scope.orders = [];
	$scope.isEmpty = true;
	
   if($routeParams.id !== undefined)
	{
		Orders.view({id:$routeParams.id});
		$scope.orders = Orders.orders({id:$routeParams.id});
		
	}
	$rootScope.$on('customer:viewed', function() {
		if ($scope.viewcustomer === undefined || $scope.viewcustomers.length === 0) 
		{
			$scope.viewcustomers = Orders.viewData();
		}
	});
	
	$rootScope.$on('order:viewed', function() {
		if ($scope.orders === undefined || $scope.orders.length === 0) 
		{
			
			$scope.orders = Orders.valueOrders();
			
			if($scope.orders.length > 0)
			{
				$scope.isEmpty = false;
			}
		}
	});
	
}]);