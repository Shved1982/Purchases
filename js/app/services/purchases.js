app.factory('Purchases', ['$http', '$rootScope', function($http, $rootScope){

	var purchases = [];
	
	function getPurchases() {
		$http.get('/site/getList')
			.success(function(data, status, headers, config) {
				purchases = data;
				
				$rootScope.$broadcast('purchases:loaded');
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
	
	service.reload = function() {
		getPurchases();
	}
	
	var newPurchase = {};
	service.add = function(purchase) {
		newPurchase = false;
		
		$http.post('/site/addPurchase/', {data: purchase, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				newPurchase = true;
				$rootScope.$broadcast('purchases:added', data);
			})
			.error(function(data, status, headers, config) {
				newPurchase = false;
				$rootScope.$broadcast('purchases:adderror', data);
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
		$http.post('/site/updatePurchase',{data: purchase, YII_CSRF_TOKEN : app.csrfToken})
			.success(function(data, status, headers, config) {
				$rootScope.$broadcast('purchases:updated', purchase);
			})
			.error(function(data, status, headers, config) {
				$rootScope.$broadcast('purchases:error', data);
			});
	}
	
	return service;
	}]);