app.controller('CreateController', 
			   ['$scope', '$rootScope', 'Customers', 'Orders', '$routeParams', '$location', '$window','$anchorScroll','$http',
			   function ($scope, $rootScope, Customers, Orders, $routeParams, $location, $window, $anchorScroll, $http) {


    $scope.customer = {};
    $scope.isNew = true;
    $scope.saving = false;
	$scope.success = false;
	$scope.successOrder = false;
	$scope.orders = [];
	$scope.order = {};
	$scope.newCutomer = {};
	$scope.newOrder = {};
	$scope.isEmpty = true;
	$scope.isNewOrder = true;
    $scope.showErrors = false;
    $scope.errors = [];
	$scope.scenario = 'add';
	
	if($routeParams.id !== undefined)
	{
		$scope.isNew = false;
		Orders.view({id:$routeParams.id});
		Orders.orders({id:$routeParams.id});
		$scope.isNewOrder = false;
		if($scope.orders.length > 0)
		{
			$scope.scenario = 'edit';
		}
		
	}
	
	$rootScope.$on('customer:viewed', function(event, data) {
		
		$scope.customer = Orders.viewData()[0];
		$scope.success = true;
		$scope.newCutomer.id =  $scope.customer.id;
		
	});
	
	$rootScope.$on('order:viewed', function(event, data) {
		$scope.orders = '';
		$scope.orders = Orders.viewOrders()[0];
		if($scope.orders.length > 0)
		{
			$scope.isEmpty = false;
		}
		
	});

	$scope.save = function() {
		Customers.add($scope.customer);
		$scope.saving = true;
		$scope.showErrors = false;
		
	}
	
	$scope.updateCustomer = function() {
	
		Customers.update($scope.customer);
		$scope.saving = true;
		$scope.showErrors = false;
		
	}
	
	$scope.saveOrder = function() {
	
		$scope.order.customer_id = $scope.newCutomer.id;
		if($scope.scenario === 'add')
		{
			Orders.add($scope.order, $scope.isNewOrder);
		}
		else
		{
			Orders.update($scope.order);
		}
		$scope.saving = true;
		$scope.showErrors = false;
		
	}

	$scope.update = function(value) {
	
		if($scope.orders.length > 0)
		{
			$scope.scenario ='edit';
		}

		$scope.successOrder = false;
		$scope.order = value;
		
	}
	
	$scope.del = function(order) {
		$scope.saving = true;
		Orders.del(order);
		
		$rootScope.$on('order:deleted', function(event, data) {
			$scope.saving = false;
				
			var result = '';
			
			result = Orders.getDel();

				if(result === true)
				{
					angular.forEach($scope.orders, function(prod, key){
						if(prod.id === order.id)
						{
							$scope.orders.splice(key, 1);
						}
						
					});
				}
		});
	}
	
	
	$rootScope.$on('customer:added', function(event, data) {
		$scope.saving = false;
		$scope.isNew = false;
		$scope.success = true;
		$scope.newCutomer = Customers.getNew();
	});
	
	$rootScope.$on('customer:updated', function(event, data) {
		$scope.saving = false;
		$scope.isNew = false;
		$scope.success = true;
	});
	
	$rootScope.$on('order:added', function(event, data) {
		$scope.saving = false;
		if($routeParams.id !== undefined)
		{
			$scope.orders = Orders.viewOrders()[0];
		}
		else
		{
			$scope.orders = Orders.viewOrders();
		}
		$scope.isNew = false;
		$scope.successOrder = true;
		
		$scope.isEmpty = false;
	});
	
	$rootScope.$on('order:updated', function(event, data) {
			$scope.saving = false;
			$scope.successOrder = true;
		});

//--------------------datapicker-------------------------
 $scope.today = function() {
    $scope.order.posted_at = null;
  };
  

  $scope.clear = function () {
    $scope.order.posted_at = null;
  };


  $scope.disabled = function(date, mode) {
    return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
  };

  $scope.toggleMin = function() {
    $scope.minDate = $scope.minDate ? null : new Date();
  };
  $scope.toggleMin();

  $scope.open = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.opened = true;
  };
  
  $scope.openNext = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.openedNext = true;
  };

  $scope.dateOptions = {
    formatYear: 'yy',
    startingDay: 1
  };

  $scope.formats = ['dd.MM.yyyy HH:mm:ss'];
  $scope.format = $scope.formats[0];
 //--------------------------------------------------------------------
	
	
	$rootScope.$on('order:error', function(event, data) {
		$scope.showErrors = true;
		$scope.errors = [];
		angular.forEach(data.errors, function(error) {
			if (typeof error == 'object') {
				angular.forEach(error, function(err) {
					$scope.errors.push(err);
				});
			}
			else {
				$scope.errors.push(error);
			}
		});
		$scope.saving = false;
	});
	
	function in_array(search, array)
	{

		angular.forEach(array, function(value, key){
				
			if(value.id == search.model.id)
			{
				return true;
			}
		
		});
		return false;
	}
	
}]);