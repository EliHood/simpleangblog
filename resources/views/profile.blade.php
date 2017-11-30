@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <h1>Profile</h1>

        
        @if ($errors->any())
               <div class="panel panel-danger">
                    <div class="panel-heading">{{$errors->first()}}</div>     
                </div>

          @endif
            <h3>Welcome {{ $user->name}}</h3>
    

    </div>
 </div>
@endsection