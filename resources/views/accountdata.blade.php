@extends('default')
@section('content')
	<div class="content">
   <div class="box-content">
    <table class="main-table" style="width:100%; margin-top: 50px; border: none;" cellpadding="5" cellspacing="0">
        <thead>          
          <tr>
            <th colspan="2px" class="notify" style="background-color: white; text-align: center; font-size:20px; color:green;" ></th>            
          </tr>          
        </thead>

        <tbody>         
          <tr>
            <td style="background-color: white; border: none; text-align:right; padding-right:60px;">              
              <button type="submit" id="add" class="btn btn-default">Add account</button>         
            </td>
            <td style="background-color: white; border: none; text-align:left; padding-left:60px;">               
              <button type="submit" id="view" class="btn btn-default">View your accounts</button>
            </td>            
          </tr>          
        </tbody>

      </table>
     </div>  <!--/box-content-->
	</div> <!--content-->

<!-- add account-->
<div id="add-account">

	<div class="container">
      

      {!! Form::open(array('role'=>'form','class'=>'form-horizontal')) !!}
        
        <div class="form-group">
          <div id="errors" style="margin-top:40px; margin-left:10px; color:red; "></div>
          <div><h3 class="h3-login">Add the following details</h3></div>        
          
        </div>

        <div class="form-group">
          {!! Form::label('Account ID:',null,['class'=>'control-label col-sm-2']) !!}  
          <div class="col-sm-10">
            {!! Form::email('account',null,['id'=>'accountid','class' => 'form-control','placeholder'=>'Enter your email ID']) !!}
          </div>
        </div>

        <div class="form-group">
          {!! Form::label('Account Name:',null,['class'=>'control-label col-sm-2']) !!}  
          <div class="col-sm-10">
            {!! Form::text('account_name',null,['id'=>'accountname','class' => 'form-control','placeholder'=>'eg: gmail, yahoo, outlook, facebook, etc.']) !!}
          </div>
        </div>

        <div class="form-group">
          {!! Form::label('Username:',null,['class'=>'control-label col-sm-2']) !!}  
          <div class="col-sm-10">
            {!! Form::text('username',null,['id'=>'username','class' => 'form-control','placeholder'=>'Enter username']) !!}
          </div>
        </div>

        <div class="form-group">
          {!! Form::label('Password:',null,['class'=>'control-label col-sm-2']) !!}
          <div class="col-sm-10"> 
            {!! Form::password('password',array('id'=>'password','class' => 'form-control','placeholder'=>'Enter password')) !!}
          </div>
        </div>
        
        <div class="form-group"> 
          <div class="col-sm-offset-2 col-sm-10">
            <button type="button" id="save" name="submit" class="btn btn-default">Save</button>
          </div>
        </div>

      {!! Form::close() !!}

    </div> <!-- /container -->
</div>  <!-- /add-account -->

 <!-- display account -->
<div id="display-account">
  <h1>Accounts</h1>  
 
    <div class="box-content">
      <table class="account-table" style="margin-top: 50px; width:100%;" cellpadding="5" cellspacing="0">
        <thead>
          <tr><th colspan="6px"><p id="success" style="color: green; text-align: center;"></th></tr></p>
          <tr>
            <th>Account</th>
            <th>Account name</th>
            <th>Username</th>
            <th></th>
            <th></th>
            <th></th>
            
          </tr>
        </thead>
        <tbody>
          @if(count($accountdata) > 0)
          @foreach($accountdata as $eachdata)
          <tr>
            <td>
                <p class="account">{{ $eachdata->account }}</p>
            </td>
            <td>
                <p class="accname">{{ $eachdata->account_name }}</p>
            </td>
            <td>
                <p class="username">{{ $eachdata->username }}</p>
            </td>
            
            <td>
              <button type="button" class="btn btn-primary modal-view" data-id="{{$eachdata->id}}" data-toggle="modal" data-target="#myModal">
                View password?
              </button>
            </td>
            <td>
              <button type="button" class="btn btn-primary modal-update" data-id="{{$eachdata->id}}" data-toggle="modal" data-target="#update">
                Edit
              </button>
            </td>
            <td>
              <button type="button" class="btn btn-primary delete" onclick="return confirm('Are you sure, you want to delete this account?');" data-id="{{$eachdata->id}}">
                Delete
              </button>
            </td>
          </tr>
          @endforeach
          @endif 
        </tbody>
      </table>
  </div>
       
</div> <!-- /disply-account -->

<!-- Modal -->
<!-- data-backdrop="static" is an attribute of modal, not to close the modal when clicked outside the modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close viewClose" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="main-title" class="js-title-step">You need to retype your current password to view respective account's password</h4>
        <h4 id="pass-header"></h4>
      </div>

      @if(count($user))
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4"><h4 style="color:blue;">You are '{{$user->name}}'</h4></div>
          <div class="col-md-4 col-md-offset-4"></div>
        </div>
        <div class="row">
          <div class="col-md-4">Please retype your password</div>
          <div class="col-md-4 col-md-offset-4">{!! Form::password('password',array('class' => 'view-password form-control','placeholder'=>'Enter password')) !!}</div>
        </div>
        
      </div>
      <div id="pass-show" style="color: red; text-align:center;"></div>
      <div id="pass-pass" style="color: green; text-align:center;"></div>

      <div class="modal-footer">
        <input type="hidden" value="" id="data_id" />
        <button type="button" class="btn btn-primary" id="ok-view" aria-hidden="true">Submit</button>           
      </div>
      @endif
    </div>
  </div>
</div>  <!--/modal-->

 <!--account update-->
<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close updateClose" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="update-title" class="js-title-step">Edit your account details</h4>
        <h4 id="update-header" style='color:red; margin-top:40px;'></h4>
        <h4 id="success-header" style='color:green; margin-top:40px;'></h4>
      </div>
      {!! Form::open(array('class'=>'form-horizontal')) !!}
      <div class="modal-body">
        
        <div class="form-group">
          {!! Form::label('Username:',null,['class'=>'control-label col-sm-2']) !!}  
          <div class="col-sm-10">
            {!! Form::text('username',null,['id'=>'updateusername','class' => 'form-control']) !!}
          </div>
        </div>

        <div class="form-group">
          {!! Form::label('Old Password:',null,['class'=>'control-label col-sm-2']) !!}
          <div class="col-sm-10"> 
            {!! Form::password('old_password',array('id'=>'updateoldpass','class' => 'form-control')) !!}
          </div>
        </div> 

        <div class="form-group">
          {!! Form::label('New Password:',null,['class'=>'control-label col-sm-2']) !!}
          <div class="col-sm-10"> 
            {!! Form::password('new_password',array('id'=>'updatenewpass','class' => 'form-control')) !!}
          </div>
        </div>

        <div class="form-group">
          {!! Form::label('Remember Password:',null,['class'=>'control-label col-sm-2']) !!}
          <div class="col-sm-10"> 
            {!! Form::password('rem_password',array('id'=>'updaterempass','class' => 'form-control')) !!}
          </div>
        </div>          
        

      <div class="modal-footer">
        <input type="hidden" value="" id="datahidden_id" />
       <div class="form-group"> 
          <div class="col-sm-offset-2 col-sm-5">
            <button type="button" id="dataupdate" name="submit" class="btn btn-default">Update</button>
            <button type="button" id="updatecancel" data-dismiss="modal" aria-hidden="true" class="btn btn-default">cancel</button>
          </div>
          
        </div>          
      </div>
     {!! Form::close() !!}
    </div>
  </div>
</div>  <!-- /modal -->


<input type="hidden" value="{{url('/')}}" id="base_url" />
<input type="hidden" value="{{csrf_token()}}" id="token" />
@stop


@section('script')
{!! HTML::script('assets/js/pswdview.js') !!}
{!! HTML::script('assets/js/datasave.js') !!}
{!! HTML::script('assets/js/dataupdate.js') !!}
{!! HTML::script('assets/js/datadel.js') !!}
<script type="text/javascript">
$(document).ready(function(){	
	$('#add-account').hide();
  $('#display-account').hide();

	$('#add').click(function(){
		$('#add-account').show();
    $('#display-account').hide();
	});	

  $('#view').click(function(){
    $('#display-account').show();
    $('#add-account').hide();
  });

  $('.modal-view').click(function(){
    var thisbtn = $(this);
    var id = thisbtn.data("id");
    $('#data_id').val(id);
   });

  $('.modal-update').click(function(){
    var thisbtn = $(this);
    var id = thisbtn.data("id");
    $('#datahidden_id').val(id);
   });  

});
</script>
@stop