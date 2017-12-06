@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="panel panel-default">
                <div class="panel-heading ">Dashboard</div>

            </div>
            <div class="panel panel-default">
                <div id="eli-style-heading" class="panel-heading">Twit Something</div>
                <div class="panel-body">
                    <form ng-model="postForm" name="postform" method="POST" novalidate>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="post.title">Post</label>
                            <textarea ng-model="post.body" type="text" class="form-control" name="body" id="" cols="10" rows="5"></textarea>
                        </div>
                        <button id="eli-style-button" ng-click="addPost()" class="btn btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
            
     
                <div id="mypost" class="col-md-10 panel-default" ng-repeat="post in myposts  ">
                    <!-- beginnging of ng-repeat post in myposts -->
                    <div id="eli-style-heading" class="panel-heading"><a class="link_profile" href="/profile/<% post.user.name | lowercase %>"><% post.user.name %></a></div>
                    <div class="panel-body panel" ng-init="getLikeText(post); getLikecount(post)">
                        
                        <i style="color:tomato; float:right; font-size:24px;" ng-click="like(post); toggle = !toggle"
                        ng-class="{[noheart] : !post.likedByMe, [heart]: post.likedByMe }">
                        <h3 style="font-size:20px; margin:20px 0px; text-align:center;"  ng-bind="post.likesCount">   </h3>
                        </i>
                        
                        
                        <figure>
                            <p class="mybody2" ng-model="post.body" editable-text="post.body" e-form="textBtnForm"> <% post.body %></p>
                            <p name="post.created_at" ><% post.createdAt %> </p>
                        </figure>
                        <i style="color:red;" class="glyphicon glyphicon-remove" ng-click="deletePost(post)" ng-if="post.deletable"></i>
                        <span style="float:right;">
                            
                            
                            
                            
                            <button ng-if="post.update" class="btn btn-default" ng-click="textBtnForm.$show()" ng-hide="textBtnForm.$visible">
                            Edit
                            </button>
                            
                            <span><button ng-if="post.update" type="submit" class="btn btn-primary" ng-click="updatePost(post)">Update</button></span>
                        </span>
                        <hr>
                        <span class="toggle-comments">
                            <a ng-show="post.comments.length !== 0"  ng-click="comments = !comments; " > View Comments</a>
                            <a ng-click="writecomment =! writecomment"> Write A Comment </a>
                        </span>
                    </div>
                    <div ng-show="comments" id="comments" class="col-md-offset-2 comment-ng-repeat  animated fadeIn panel-default" ng-repeat="comment in post.comments">
                        <div style="font-size:10px;" id="eli-style-heading" class="panel-heading">
                          <a class="link_profile" href="/profile/<% comment.user.name | lowercase %>"><% comment.user.name %></a>
                        </div>
                        <figure class="my-comment">
                            <p> <% comment.comment_body%>

                            </p>
                          
                            <p><% comment.created_at_formatted %> </p>
                              <hr>
                        </figure>
                    </div>
                    <!-- Comment form Inside Ng-repeat -->
                    <div class="comment-class animated bounceInUp" ng-show="writecomment">

                        <div class="panel-body">
                            <ng-form ng-model="commentForm" name="commentForm" method="POST" novalidate>
                            <div class="form-group">
                                <label>Write a Comment</label>
                              

                                <textarea ng-model="post.comment" type="text" class="form-control" name="comment_body" cols="2" rows="2"></textarea>

                            </div>
                           <button id="eli-style-button" ng-click="addComment(post); commentShow()" class="btn btn-primary" type="submit">Submit</button>
                            </form>
                        </div>
            <!-- END Comment form Inside Ng-repeat -->
                    </div>
                <!-- End of ng-repeat post in mypost -->
                </div>



    


        
        </div>
    </div>
</div>
@endsection