var app = angular.module('eli', []);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});



app.controller('mainCtrl', ['$scope', '$filter', '$http', function($scope, $filter,  $http){




	$scope.myposts = [];

	$scope.addPost = function(){
		
		$http.post('/auth/post', {
			body: $scope.post.body, 

		}).then(function(data, status, headers, config){
			console.log(data);	
			data.data['user'] = {
		    	name: data.data.name
			}

			$scope.myposts.push(data.data);
			
		
		});

		$scope.post.body = '';


	};

	$scope.deletePost = function(post){
		var index = $scope.myposts.indexOf(post);

		if(index != -1){
			$scope.myposts.splice(index, 1);
		}

		$http.delete('auth/post/' + post.id);

	};

	$scope.getPosts = function(){

		$http.get('/auth/posts').then(function(data){
			$scope.myposts = data.data;
		}).then(function(data, status, header, config){
		});



	};


	$scope.getPosts();





}]);
