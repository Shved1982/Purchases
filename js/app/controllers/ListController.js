var ListController = app.controller('ListController', 
			   ['$scope', '$rootScope', 'Purchases', '$routeParams','$timeout',
			   function ($scope, $rootScope, Purchases, $routeParams, $timeout) {
			   
	$scope.isNew = true;
	$scope.purchases = {};
	$scope.purchases = Purchases.get();
	$scope.viewproduct = {};
	
	$scope.currentPage = 1;
	$scope.maxSize = 25;
	$scope.totalItems = $scope.purchases.length;
	
    $scope.$watch('currentPage', function(newPage){
			
			$scope.watchPage = newPage*$scope.maxSize - $scope.maxSize;
			$scope.maxSizes = newPage*$scope.maxSize;
	});
	
	$rootScope.$on('purchases:updated', function() {
	
		if ($scope.purchases.length === 0) 
		{
			$scope.purchases = Purchases.get();
			$scope.totalItems = $scope.purchases.length;
		}
	});

	 $scope.del = function(purchase){
		Purchases.del(purchase);
		
	};
	$scope.$watch(function() {
		
		$timeout(function() {
			$scope.purchases = {};
			
			$scope.purchases = Purchases.get();
			
		},1000);

	});
	
	
}]);