@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
            </div>
            <div class="panel panel-default">
                <div id="eli-style-heading" class="panel-heading">Write a Post</div>
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
            
     
            <div id="mypost" class="col-md-8 panel-default" ng-repeat="post in myposts ">
                <div id="eli-style-heading" class="panel-heading"><% post.user.name %></div>
                <div class="panel-body panel">
                    <figure>
                        <p> <% post.body %></p>
                        <p>  <% post.created_at %></p>
                    </figure>
                    <span>
                       
                     <i style="color:red;" class="glyphicon glyphicon-remove" ng-click="deletePost(post)" ng-if="post.deletable"></i>
                      
                        <span><a href="/" data-toggle="modal" data-target="#editModal">Edit</a></span>
                    </span>
                </div>
            </div>

    


        
        </div>
    </div>
</div>
@endsection