@extends('default')
@section('content')	
	<div id="content">
    <div class="container">

      {!! Form::open(array('url'=>'auth/register','role'=>'form','class'=>'form-horizontal')) !!}

        <div class="form-group">
          <h3 class="h3-login">Please fill up the following details</h3>
        </div>

        <div class="form-group">
          {!! Form::label('Name:',null,['class'=>'control-label col-sm-2']) !!}  
          <div class="col-sm-10">
            {!! Form::text('name',null,['class' => 'form-control','placeholder'=>'Enter name']) !!}@if ($errors->has('name'))<p style="color:red;">{!!$errors->first('name')!!}</p>@endif
          </div>
        </div>

        <div class="form-group">
          {!! Form::label('Email:',null,['class'=>'control-label col-sm-2']) !!}  
          <div class="col-sm-10">
            {!! Form::email('email',null,['class' => 'form-control','placeholder'=>'Enter email','type'=>'email']) !!}@if ($errors->has('email'))<p style="color:red;">{!!$errors->first('email')!!}</p>@endif
          </div>
        </div>

        <div class="form-group">
          {!! Form::label('Username:',null,['class'=>'control-label col-sm-2']) !!}  
          <div class="col-sm-10">
            {!! Form::text('username',null,['class' => 'form-control','placeholder'=>'Enter username']) !!}@if ($errors->has('username'))<p style="color:red;">{!!$errors->first('username')!!}</p>@endif
          </div>
        </div>

        <div class="form-group">
          {!! Form::label('Password:',null,['class'=>'control-label col-sm-2']) !!}
          <div class="col-sm-10"> 
            {!! Form::password('password',array('class' => 'form-control','placeholder'=>'Enter password')) !!}@if ($errors->has('password'))<p style="color:red;">{!!$errors->first('password')!!}</p>@endif
          </div>
        </div>
        
        <div class="form-group"> 
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" name="submit" class="btn btn-default">Sign Up</button>
          </div>
        </div>

      {!! Form::close() !!}

    </div> <!-- /container -->

  </div> <!-- /content -->
@stop
