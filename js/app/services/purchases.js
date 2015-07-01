app.factory('Purchases', ['$http', '$rootScope', function($http, $rootScope){

	var purchases = [];
	
	function getPurchases() {
		$http.get('/site/getList')
			.success(function(data, status, headers, config) {
				purchases = data;
				
				$rootScope.$broadcast('purchases:updated');
			})
			.error(function(data, status, headers, config) {
				console.log(data);
			});
	}
	
	getPurchases();
	
	var service = {};

	service.get = function() {
		return purchases;
	}
	
	var newPurchase = {};
	service.add = function(purchase) {
		newPurchase = '';
		
		$http.post('/site/addPurchase/', {data: purchase, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				newPurchase = data;
				getPurchases();
				$rootScope.$broadcast('purchases:added', data);
			})
			.error(function(data, status, headers, config) {
				$rootScope.$broadcast('purchases:error', data);
			});
	}

	service.getNew = function(){
		return newPurchase;
	}
	
	var deletingResult = false;
	
	service.del = function(purchase) {
		deletingResult = '';
		$http.post('/site/deletePurchase',{data: purchase.id, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				deletingResult = true;
				getPurchases();
				$rootScope.$broadcast('purchases:deleted', data);
			})
			.error(function(data, status, headers, config) {
				deletingResult = false;
				$rootScope.$broadcast('purchases:error', data);
			});

	}
	
	service.getDel = function() {
		return deletingResult;
	}
	
	service.update = function(purchase) {
		$http.post('/site/updateCustomer',{data: purchase, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				$rootScope.$broadcast('purchases:updated', purchase);
			})
			.error(function(data, status, headers, config) {
				$rootScope.$broadcast('purchases:error', data);
			});
	}
	
	return service;
	}]);