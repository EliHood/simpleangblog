@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-2 ">
            @if ($errors->any())
            <div class="panel panel-danger">
                <div class="panel-heading">{{$errors->first()}}</div>
            </div>
            @endif
             @foreach ($user as $myuser)

        <div class="col-md-6 ">
                  
            <div class="profiledoe">
                <h4>{{ $myuser->name }} Profile</h4>
         
                    

                    <div class="profile_pic_container">

                        <div class="overlay"></div>
                        <img src="/uploads/avatars/{{ $myuser->avatar }}" style="width:250px; height:250px;">
                        @if($myuser->id == auth()->user()->id)
                        <div class="pic">
                            <form enctype="multipart/form-data" action="/upload" method="POST">
                                <h4> Update Profile Image</h4>
                                <input id="file" type="file" name="avatar">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input id="pic-sub2" type="submit"  class="btn btn-sm btn-primary">
                            </form>
                        </div>
                    </div>
                    </div>
                    @endif
        
                  
             
                
                
                <!-- maybe there should be a blade function that can hide the following below -->
                @if($myuser->id != auth()->user()->id)
                <div id="profile" data='{{ $myuser }}'></div>
            
                @endif
                <div style="margin:50px 0px;">
                    <h4>Followers
                    @foreach($myuser->followers as $use)
                    <span>
                        ({{$use->follow->count()}})
                    </span>
                    @endforeach
                    </h4>
                </div>
             
               @endforeach
                  </div>
            </div>
            @forelse ($myuser->posts as $post)
            <div class="col-md-4">
                <div id="mypost3" class="col-md-8 panel-default">
                    <div id="eli-style-heading" class="panel-heading"><a class="link_profile" href="/profile/{{$post->user->name}}">{{$post->user->name}}</a></div>
                    <div class="panel-body panel">
                        
                        <i style="color:tomato; float:right; font-size:24px;"
                        class="{{ $post->likedByMe() ? 'glyphicon glyphicon-heart' : 'glyphicon glyphicon-heart-empty' }}" >
                        <h3 style="font-size:20px; margin:20px 0px; text-align:center;" > {{ $post->likes->count() }}  </h3>
                        </i>
                        
                        
                        
                        <figure>
                            <p class="mybody2" ng-model="post.body" editable-text="post.body" e-form="textBtnForm"> {{ $post->body }}</p>
                            <p name="post.created_at" >{{ $post->created_at->diffForHumans() }} </p>
                        </figure>
                        
                    </div>
                </div>
            </div>
            @empty
            <p>No posts so far !!</p>
            @endforelse
        </div>
    </div>
    
</div>
@endsection