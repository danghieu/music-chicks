@extends("main")

@section('title')
Forgot Password
@endsection

@section('content')

		@if (count($errors) > 0)
	    <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	    @endif
<div class="row">
<div class=".col-xs-12 .col-sm-6 .col-md-8 ">
	<h2>Forgot password</h2></div>
	  <hr>
	  <form method="post" action="{{Asset('forgot')}}" id="form-forgot" name="form-forgot" class="form-inline">			
				<div class="form-register col-sm-6 col-md-offset-3 ">
					<h5>Please enter the email address for your account ! You will be able to choose a new password for your account.</h5>
					<div class="form-group">
						<input type="email" name="email" id="email" class="form-control" placeholder="Email address" style="width:304px;"/>
						<input type="hidden" name ="token" id="token" class="token" value="{{$md5 = md5(rand())}}">	
					</div>
					<button type="submit" class="btn btn-default btn-bg" style="margin-top:10px">Confirm</button><br>
				</div>
			
			</form>

	  </div>
@endsection