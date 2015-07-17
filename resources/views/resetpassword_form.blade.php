@extends("main")

@section('title')
Reset Password
@endsection

@section('content')
<div class="row forgot-email">
	@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
<div class="row">
	<div class=".col-xs-12 .col-sm-6 .col-md-8 ">
	<h2>Reset password</h2></div><hr>
			
			    <div class="form-register col-sm-6 col-md-offset-3">
			    	<h5>Please enter new password</h5>
				<form method="post" action="{{Asset('getdata')}}" id="form_resetpassword" name="form_resetpassword">

				<input type="password" name="new_pass" id="password" placeholder="Password" class="form-control" /><br>
				<input type="password" name="new_pass_1" id="newpassword_1" placeholder= "Retype Password" class="form-control"/></br>
				<input type="hidden" name="token" id="token" class="token" value="{{$token}}">
				<button class="btn btn-default btn-bg float-right " id="confirm" name="confirm">Confirm</button>
				</form>
			
		</div>
			  </div>
		</div>	
		
	</div>
</div>
@endsection

