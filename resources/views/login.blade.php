@extends("main")

@section('title')
Login
@endsection

@section('content')

<div id="register">
	<h2>Sign in</h2>
	@if(isset($errors))
	<h4 class="warning">{{$errors->first()}}</h4>
	@endif
	<div class="social-register col-sm-6 ">
		<div class="col-sm-offset-4 col-sm-6 ">
				<a href="fblogin" class="btn btn-primary btn-block "  role="button">  <i class="fa fa-facebook"></i> | Connect with Facebook</a>
				<a href="gglogin" class="btn btn-default btn-block btn-google"  role="button">  <i class="fa fa-google"></i> | Connect with Google</a>
		</div><!-- social-register -->
		<div class=" col-sm-2 or "> 
			<h3> OR </h3>
		</div>
	</div>
	
	

	<div class=" form-register col-sm-6">
		<div class=" col-sm-6">
			<form method="post" action="{{Asset('login')}}" id="form-login" name="form-login">			
				<input type="text" name="username-email" id="username-email" placeholder="Username or Email address" class="form-control my-form-control"/>
				<input type="password" name="password" id="password" placeholder="Password" class="form-control my-form-control"/>
					
	      			<div class="checkbox">
	        			<label>
	          				<input type="checkbox" name="remember" id="remember">Remember me?</br>
	       				 </label>
	      			</div>	
		<div class=" col-sm-12">
		      	<button class="btn btn-bg">Sign in</button><br>
		</div>
	    		<a href="forgot" id="forgot">Forgot your password?</a>
	    	</form>
  		</div>		
			
	</div><!-- form-register -->
	
	
</div><!-- register -->


@endsection