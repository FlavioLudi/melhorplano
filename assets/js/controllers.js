var myApp = angular.module('myApp', []);

myApp.controller('MyController', ['$scope', '$http', function($scope, $http) {

	// Recebe dados de todas combinações de planos
	$http.get('/list-all-broadband').success(function(data) {
		$scope.plans_options = data;
	});

	// Exibe ícone TV
	$scope.hasTvType = function(types) {
		var hasTv = false;
		for(var i = 0; i < types.length; i++) {
			if (types[i] == 'tv') {
				hasTv = true;
				break;
			}
		}
		return hasTv;
	}

	// Exibe ícone BroadBand
	$scope.hasBbType = function(types) {
		var hasBb = false;
		for(var i = 0; i < types.length; i++) {
			if (types[i] == 'bb') {
				hasBb = true;
				break;
			}
		}
		return hasBb;
	}

	// Exibe ícone LandLine
	$scope.hasLlType = function(types) {
		var hasLl = false;
		for(var i = 0; i < types.length; i++) {
			if (types[i] == 'll') {
				hasLl = true;
				break;
			}
		}
		return hasLl;
	}

}]);