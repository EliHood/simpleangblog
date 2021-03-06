@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
               @if(Session::has('message'))
                    <p class="alert alert-warning">{{ Session::get('message') }}</p>
                @endif

            <div class="panel panel-default">
                <div class="panel-heading">Register</div>



                <div class="panel-body">
                    <form name="userForm" class="form-horizontal" method="POST" action="{{ route('signup') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" ng-model="userForm.model.name" class="form-control" name="name" value="{{ old('name') }}" name-validator required autofocus>
                                    
                                    <span style="color:green;"  ng-if="userForm.name.$pending">
                                      Checking Username...
                                    </span>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}"ng-class="{ 'has-error' : userForm.email.$invalid && !userForm.email.$pristine }">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" ng-model="user.email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                  <p ng-show="userForm.email.$invalid && !userForm.email.$pristine" class="help-block">Enter a Valid Email</p>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}" 
                        ng-class="{ 'has-error' : userForm.password.$invalid && !userForm.password.$pristine }">
                            <label for="password"  class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" ng-model="user.password" ng-minlength="3" ng-maxlength="28" type="password" class="form-control" name="password" required>
                                 <p ng-show="userForm.password.$error.minlength" class="help-block">Password is too short.</p>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection