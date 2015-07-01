var ListController = app.controller('ListController', 
			   ['$scope', '$rootScope', 'Purchases', '$routeParams','$timeout','$filter',
			   function ($scope, $rootScope, Purchases, $routeParams, $timeout,$filter) {
			   
	$scope.isNew = true;
	$scope.purchases = {};
	$scope.purchases = Purchases.get();
	$scope.purchase = {};
	$scope.addPurch = {};
	$scope.editing = false;
	$scope.purch = {};
	$scope.viewproduct = {};
	
	$scope.saving = false;
	$scope.editSuccess = false;
	$scope.editError = false;
	$scope.addSuccess = false;
	$scope.addError = false;
	
	$scope.start_start = '';
	$scope.start_end = '';
	$scope.end_start = '';
	$scope.end_end = '';
	
	$scope.currentPage = 1;
	$scope.maxSize = 5;
	$scope.totalItems = $scope.purchases.length;
	
    $scope.$watch('currentPage', function(newPage){
			
			$scope.watchPage = newPage*$scope.maxSize - $scope.maxSize;
			$scope.maxSizes = newPage*$scope.maxSize;
	});
	
	var sliderFunc = function() {
		timer = $timeout(function() {
			Purchases.reload();
			timer = $timeout(sliderFunc, 3000);
			$scope.$apply(function(){
				$scope.purchases = Purchases.get();
			});
		}, 3000);
	};
	
	sliderFunc();

	
	$rootScope.$on('purchases:loaded', function() {
		
		if ($scope.purchases.length === 0) 
		{
			$scope.purchases = Purchases.get();
			$scope.totalItems = $scope.purchases.length;
		}
	});
	
	$scope.showAdd = function(){
	
		$scope.purch = '';
		$scope.adding = true;
		$scope.editing = false;
		$scope.editSuccess = false;
		$scope.editError = false;
	
	};
	
	$scope.create = function(purchase){
		$scope.adding = true;
		$scope.editSuccess = false;
		$scope.editError = false;
		Purchases.add(purchase);
	};


	 $scope.del = function(purchase){
		$scope.saving = true;
		$scope.editing = false;
		$scope.adding = false;
		$scope.editSuccess = false;
		$scope.editError = false;
		$scope.purchase = purchase;
		Purchases.del(purchase);
	};
	
	$scope.edit = function(purchase){
		$scope.purch = purchase;
		$scope.editing = true;
		$scope.adding = false;
		$scope.editError = false;
		$scope.editSuccess = false;
	};
	
	$scope.save = function(purchase){
		
		$scope.editing = true;
		$scope.editSuccess = false;
		$scope.editError = false;
		Purchases.update(purchase);
	};
	
	$rootScope.$on('purchases:added', function() {
		
		var result = Purchases.getNew();
		
		if(result === true)
		{
			$scope.purchases.push($scope.addPurch);
			$scope.addSuccess = false;
			$scope.addError = false;	
		}
	});
	
	$rootScope.$on('purchases:updated', function() {
		$scope.editing = false;
		$scope.purchases = Purchases.get();
		$scope.totalItems = $scope.purchases.length;

		angular.forEach($scope.purchases, function(prod, key){
			if($scope.purch.id === prod.id)
			{
				$scope.purchases[key] = $scope.purch;
			}
			
		});
		$scope.editSuccess = true;
		$scope.editError = false;
		$(window).scrollTop(0);
	});
	
	$rootScope.$on('purchases:deleted', function() {
	
		$scope.saving = false;
		$scope.editError = false;
		
		result = Purchases.getDel();

		if(result === true)
		{
			angular.forEach($scope.purchases, function(prod, key){
				if(prod.id === $scope.purchase.id)
				{
					$scope.purchases.splice(key, 1);
				}
				
			});
		}
		
	});
	
	$rootScope.$on('purchases:error', function() {
		$scope.editError = true;
		$scope.addError = false;
	});
	
	$rootScope.$on('purchases:adderror', function() {
		$scope.addError = true;
		$scope.editError = false;
	});
	
	$scope.reset = function(){
		window.location.reload();
	};
	
//--------------------datapicker-------------------------
 
  $scope.disabled = function(date, mode) {
    //return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
  };
  
  $scope.clear = function () {
    $scope.start_start = '';
	$scope.start_end = '';
  };

  $scope.toggleMin = function() {
    $scope.minDate = $scope.minDate ? null : new Date();
  };
  $scope.toggleMin();

  $scope.openStart = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.openedStart = true;
  };
  
  $scope.openStartNext = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.openedStartNext = true;
  };
  
  $scope.openEnd = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.openedEnd = true;
  };
  
  $scope.openEndNext = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.openedEndNext = true;
  };

  $scope.dateOptions = {
    formatYear: 'yy',
    startingDay: 1
  };

  $scope.formats = ['dd.MM.yyyy'];
  $scope.format = $scope.formats[0];

	
}]);