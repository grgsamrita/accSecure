<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<link href='http://fonts.googleapis.com/css?family=Josefin+Sans:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic' rel='stylesheet' type='text/css'>

    	<!--bootstrap-->
    	<!-- {!! HTML::style('assets/css/bootstrap.css') !!} -->
    	{!! HTML::style('assets/css/bootstrap-theme.css') !!}
    	{!! HTML::style('assets/css/bootstrap.min.css') !!}
    	
    	{!! HTML::script('assets/js/jquery.js') !!}
    	<!-- {!! HTML::script('assets/js/bootstrap.js') !!} -->
    	{!! HTML::script('assets/js/bootstrap.min.js') !!}

    	{!! HTML::style('assets/css/style.css') !!}



	</head>
	<body>
		<div class="wrapper">
		<div id="header">
			<div id="header-title"><a href="{{URL::to('/')}}">accSecure</a></div>
			<div id="nav">
				@if(Auth::check())
				<ul class="nav nav-tabs">
					<li><a href="{{URL::to('accountdata/account')}}">Welcome {{Auth::user()->name}}</a></li>
					<li><a href="{{URL::to('auth/logout')}}">Logout</a></li>
				</ul>

				@else
				<ul class="nav nav-tabs">
					<li><a href="{{URL::to('/')}}">Login</a></li>
					<li><a href="{{URL::to('auth/register')}}">Sign up</a></li>
				</ul>
				@endif
			</div>
		</div>		
			@yield('content')
			@yield('script')
		</div>
		<!-- <footer class="footer"> -->
			<!-- copyright@accSecure.com -->
		<!-- </footer> -->
	</body>
</html>