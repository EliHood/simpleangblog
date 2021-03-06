@extends('layouts.app')
@section('content')
<div class="container">
    
        <div class="row">

            @if ($errors->any())
            <div class="panel panel-danger">
                <div class="panel-heading">{{$errors->first()}}</div>
            </div>
            @endif
            
            <div class="col-md-4 offset-md-3 ">
                <h1>{{ $user->name}} Profile</h1>
                <img src="/uploads/avatars/{{ $user->avatar }}" style="width:150px; height:150px; border-radius:50%;">
                @if(auth()->user()->id )
                <form enctype="multipart/form-data" action="/upload" method="POST">
                    <label>Update Profile Image</label>
                    <input type="file" name="avatar">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="pull-left btn btn-sm btn-primary">
                </form>
                @endif
            </div>
            
            @forelse ($user->posts as $post)
            <div class="col-lg-8 offset-md-3">
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
</div>
@endsection