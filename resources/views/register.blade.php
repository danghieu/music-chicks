@extends("main")

@section('title')
Register
@endsection

@section('content')

<div id="register">
	<h2>Register</h2>

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
			<form method="post" action="{{Asset('register')}}" id="form-register"name="form-register">		
				<input type="text" name="username" id="username" placeholder="Username" class="form-control my-form-control"/>
				<input type="password" name="password" id="password"  placeholder="Password" class="form-control my-form-control"/>
				<input type="password" name="password_confirmation"  id="password_confirmation" placeholder="Re-password" class="form-control my-form-control"/>
				<input type="email" name="email" id="email" placeholder="Email" class="form-control my-form-control"/>
					
	      			<div class="checkbox">
	        			<label>
	          				<input type="checkbox" name="remember" id="remember">Remember me?</br>
	       				 </label>
	      			</div>	
		<div class=" col-sm-12">
		      	<button class="btn btn-bg">Register</button><br>
		</div>
	    		
	    	</form>
  		</div>		
			
	</div><!-- form-register -->

<script type="text/javascript" src="{{Asset('../resources/assets/js/register-validate.js')}}"></script>
@endsection


