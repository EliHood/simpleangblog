

var app = angular.module('eli', ["xeditable", 'angularMoment', 'angular-async-validation']);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});




app.controller('mainCtrl', ['$scope', '$filter', '$http', function($scope, $filter,  $http){


	


	// scope data for posts
	$scope.myposts = [];
	$scope.myimages = [];
	$scope.myusers = [];

	
	// Form that works outside of ng-repeat adding posts which works flawlessly
	$scope.addPost = function(){    
	    $http.post('/auth/post', {
	        body: $scope.post.body, 
	    }).then(function(data, status, headers, config){
	        data.data['user'] = {
	            name: data.data.name
	        },

          

	        $scope.myposts.push(data.data);

	    });

	    $scope.post.body = '';
	};

	// comment form that doesnt work inside ng-repeat

	$scope.addComment = function(post){

	    $http.post('/post/' + post.id +'/comment',{
	        comment_body: post.comment,
	    }).then(function(result){

	       	result.data['user'] = {
	            name: result.data.name
	        },

	       	post.comments.push(result.data);
	        post.comment = '';
	    });
	};

	$scope.uploadPic = function(profile)
	{
		$http.post('/upload', {
			avatar: profile.pic
		}).then(function(result) {
			console.log("success");
		});
	}

	$scope.comments = false;

	$scope.commentShow = function(){

		var owl = $scope.comments = true;


	}
    

// $scope.getImageLike = function(image){ 

// 	$http.get('/image/'+ image.id +'/islikedbyme').then(function(result) { 




    
// 	    if (result.data === 'true') { 
// 		    console.log("Unlike block !!!!!"); 
// 		    $scope.like_btn_text = "Unlike"; 
// 	    } else{ 
// 		    console.log("Like block !!!!!"); 
// 		    $scope.like_btn_text = "Like"; 
// 		 }
// 	}); 
// }

$scope.image_like = function(image) {
    $http.post('/image/like/'+ image.id).then(function(result) {
        image.likedByMe = !image.likedByMe;
        if (image.likedByMe) {
        	image.ImagelikesCount++;
        } else {
        	image.ImagelikesCount--;
        }
        $scope.ImagelikeCount = image.ImagelikeCount;
    });
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

$scope.myfollow = function(user) {
    $http.post('/user/follow/'+ user.id).then(function(result) {
    	console.log("user id is:"+ user.id);
    });
};



$scope.getLike = function(post){ 

	$http.get('/post/'+ post.id +'/islikedbyme').then(function(result) { 




  
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

	$scope.getLikeImageText = function(image){
        console.log("getImageLikeText for imageId = "+image.id+ " image.likedByme = "+image.likedByMe);
		console.log("image.likedByMe === true returns "+ (image.likedByMe === true));

        $scope.toggle = image.likedByMe === true;
    }

    




        $scope.noheart = 'glyphicon glyphicon-heart-empty';
        $scope.heart = 'glyphicon glyphicon-heart';

  
       
    
        

	$scope.updatePost = function(post){
		
		$http.post('/auth/upost/' + post.id, {
		 	body: post.body,
		 	updatedAt:post.updatedAt

		}).then(function(result, status, headers, config){
			
			 $scope.updatedAt = result.data.updatedAt;

		
			
		
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
				}).then(function(result){ 
					
				}); 
		}; 



	$scope.getImages = function(){ 

		$http.get('/auth/gallery').then(function(data){ 

			$scope.myimages= data.data;
				}).then(function(result, status, header, config){ 
				
				}); 
	}; 


	$scope.getPosts();
	$scope.getImages();



}]);
