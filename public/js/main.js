



var app = angular.module('eli', ["xeditable", 'angularMoment']);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});



app.run(function(editableOptions) {
  editableOptions.theme = 'bs3';
});



app.filter('phpDate', function() {
    return function(input, format) {

  	
        
        if (format == "human") {
   

            return moment(input).startOf(input).fromNow(); 
        } else {
            // Covert the moment to a string using the passed format
            // If nothing is passed, uses default JavaScript date format
            return moment(input).startOf(input).fromNow(); 
        }
    };
});

app.controller('mainCtrl', ['$scope', '$filter', '$http', function($scope, $filter,  $http){

$scope.userposts = [];

	$scope.getUserPosts = function(post){

		$http.get('/auth/userposts/timmy').then(function(result){ 

			$scope.myposts = data.data;
					
			}).then(function(result){
				
				
					
			});


	
	};

	
$scope.getUserPosts();


	$scope.myposts = [];

	

	$scope.addPost = function(){    
	    $http.post('/auth/post', {
	        body: $scope.post.body, 
	    }).then(function(data, status, headers, config){
	        console.log(data);  
	        data.data['user'] = {
	            name: data.data.name
	        },

	        $scope.myposts.push(data.data);

	    });

	    $scope.post.body = '';
	};


		
      	


$scope.like = function(post) {
    $http.post('/post/like/'+ post.id).then(function(result) {
        post.likedByMe = !post.likedByMe;
        if (post.likedByMe) {
        	post.likesCount++;
        } else {
        	post.likesCount--;
        }
        $scope.likeCount = post.likeCount;
    });
};



$scope.getLike = function(post){ 

	$http.get('/post/'+ post.id +'/islikedbyme').then(function(result) { 

		console.log("result for postId = "+post.id+" is " +result.data);


    
	    if (result.data === 'true') { 
		    console.log("Unlike block !!!!!"); 
		    $scope.like_btn_text = "Unlike"; 
	    } else{ 
		    console.log("Like block !!!!!"); 
		    $scope.like_btn_text = "Like"; 
		 }
	}); 
}

		  


	$scope.getLikeText = function(post){
        console.log("getLikeText for postId = "+post.id+ " post.likedByme = "+post.likedByMe);
		console.log("post.likedByMe === true returns "+ (post.likedByMe === true));

        $scope.toggle = post.likedByMe === true;
    }



        $scope.noheart = 'glyphicon glyphicon-heart-empty';
        $scope.heart = 'glyphicon glyphicon-heart';

  
       
    
        

	$scope.updatePost = function(post){
		
		$http.post('/auth/upost/' + post.id, {
		 	body: post.body,
		 	updatedAt:post.updatedAt

		}).then(function(result, status, headers, config){
			
			 $scope.updatedAt = result.data.updatedAt;
			 console.log($scope.updatedAt);
		
			
		
		});

		


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
				
				console.log(data.data); 
					}).then(function(data, status, header, config){ 
				}); 
		}; 


	

	$scope.getPosts();



}]);
