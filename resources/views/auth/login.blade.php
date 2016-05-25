@extends('default')
@section('content')	
	<div id="content">
    <div class="container">
      

      {!! Form::open(array('url'=>'auth/login','role'=>'form','class'=>'form-horizontal')) !!}
      
        <div class="form-group">
          <h3 class="h3-login">Please sign in and access the app</h3>
        </div>

        @if(session()->has('message'))
          <p class="access-page">{{session('message')}}</p>
        @endif

        @if($errors->has('error'))
          <p class="access-page">{{$errors->first('error')}}</p>
        @endif

        @if(session()->has('name'))
          <p class="access-page">Thank you {{session()->has('name')}} for registering</p>
        @endif

        <div class="form-group">
          {!! Form::label('Username/Email:',null,['class'=>'control-label col-sm-2']) !!}  
          <div class="col-sm-10">
            {!! Form::text('username',null,['class' => 'form-control','placeholder'=>'Enter username']) !!}@if ($errors->has('username'))<p style="color:red;">{!!$errors->first('username')!!}</p>@endif
          </div>
        </div>

        <div class="form-group">
          {!! Form::label('Password:',null,['class'=>'control-label col-sm-2']) !!}
          <div class="col-sm-10"> 
            {!! Form::password('password',array('class' => 'form-control','placeholder'=>'Enter password','type'=>'password')) !!}@if ($errors->has('password'))<p style="color:red;">{!!$errors->first('password')!!}</p>@endif
          </div>
        </div>

        <div class="form-group"> 
          <div class="col-sm-offset-2 col-sm-10">            
            <a href="{{URL::to('auth/register')}}"<label> or register?</label></a>      
          </div>
        </div>

        <div class="form-group"> 
          <div class="col-sm-offset-2 col-sm-10">            
            <a href="{{URL::to('facebook/fblogin')}}"><label> Login with Facebook</label></a>      
          </div>
        </div>

        <div class="form-group"> 
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" name="submit" class="btn btn-default">Log In</button>
          </div>
        </div>
        
      {!! Form::close() !!}

    </div> <!-- /container -->

  </div> <!-- /content -->
@stop
