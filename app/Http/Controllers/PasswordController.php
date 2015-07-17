<?php namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\User;
use App\Password;
use Illuminate\Routing\Redirector;
use Session;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller {

	public function forgotpassword(Request $request){				

		$email = $request->get('email');
		if($email==""){
			return Redirect::to('forgot')->withErrors('The email address does not empty');
		}else{
			if(User::where("email","=",$email)->count()>0){

				Mail::send('mailreset', ["token"=>$request->get('token')], function($message) use ($request)
				 {
					$message->to($request->get('email'),$request->get('token'))->subject('[Music-chicks] Please reset your password');
				 });
				
				$add = new Password();
				$user = new User();

				$user=User::select('id')->where("email","=",$email)->first();

				$add->token = $request->get('token');
				$add->user_id = $user->id;
				$add->save();	
			return Redirect::to('forgot')->withErrors("We have just sent you a link, you can login your email to check");;	
		}					
		return Redirect::to('forgot')->withErrors("That e-mail address doesn't match any user accounts");
		}
		
	}
	

	public function resetpassword(Request $input) {		
		
		return view('resetpassword_form',['token' => $input->get('token')]);
		         
	}


	public function getdata(Request $input) {

		$token = $input->get('token');
		$pass = $input->get('new_pass');
		$pass1 = $input->get('new_pass_1');
		if($pass==""){
			return Redirect::to('reset?token='.$token)->withErrors('The field password does not empty');
		}else{
			if ($pass == $pass1) {
			if (Password::check_token($token)) {
				$pwd = Password::where("token",$token)->first();
				$user=$pwd->user;
				$user->password = md5(sha1($pass));
				$user->save();
				return view('login')->withErrors('Please login with new password !');
			}	
		}
			
		return Redirect::to('reset?token='.$token)->withErrors('Passwords do not match');
		}
		
		        
	}

}