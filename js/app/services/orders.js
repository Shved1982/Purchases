app.factory('Orders', ['$http', '$rootScope', function($http, $rootScope){
	
	var service = {};
	var ordersData = [];
	var value = [];
	
	service.get = function() {
		return ordersData;
	}
		
	service.orders = function(product) {
		
		$http.post('/site/getOrders',{data: product, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				value = data;
				ordersData.push(data);
				$rootScope.$broadcast('order:viewed', data);
			})
			.error(function(data, status, headers, config) {
				$rootScope.$broadcast('order:error', data);
			});
	}
	
	service.viewOrders = function() {
		return ordersData;
	}
	
	service.valueOrders = function() {
		return value;
	}
	

	service.update = function(order) {
		$http.post('/site/updateOrder',{data: order, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				$rootScope.$broadcast('order:updated', order);
			})
			.error(function(data, status, headers, config) {
				$rootScope.$broadcast('order:error', data);
			});
	}
	
	var newOrder = [];
	
	service.add = function(order, isNewOrder) {
		$http.post('/site/createOrder',{data: order, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				if(isNewOrder === false)
				{
					ordersData[0].push(data.model);
				}
				else
				{
					ordersData.push(data.model);
				}
				newOrder.push(data.model);
				$rootScope.$broadcast('order:added', data);
			})
			.error(function(data, status, headers, config) {
				$rootScope.$broadcast('order:error', data);
			});
	}
	
	service.getNew = function(){
		return newOrder;
	}
	
	var customerData = {};
	service.view = function(product) {
		$http.post('/site/getCustomer',{data: product, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				customerData = data;
				$rootScope.$broadcast('customer:viewed', data);
			})
			.error(function(data, status, headers, config) {
				$rootScope.$broadcast('customer:error', data);
			});
	}
	
	service.viewData = function() {
		return customerData;
	}
	
	var deletingResult = false;
	
	service.del = function(order) {
		deletingResult = '';
		$http.post('/site/deleteOrder',{data: order.id, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				deletingResult = true;
				$rootScope.$broadcast('order:deleted', data);
			})
			.error(function(data, status, headers, config) {
				deletingResult = false;
				$rootScope.$broadcast('order:error', data);
			});

	}
	
	service.getDel = function() {
		return deletingResult;
	}
	
	return service;
	}]);