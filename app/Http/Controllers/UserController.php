<?php namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Routing\Redirector;
use Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Cookie\CookieJar;

class UserController extends Controller {

	public static $numVote = 5;

	public function register(Request $request)
	{
		$rules = array(
		    'email'    => 'required|email',
		    'password' => 'required|min:6',
		    'username' => 'required|min:3'
		);

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
		    return Redirect::to('register')
		        ->withErrors($validator) 
		        ->withInput($request->except('password')); 
		} else {
			if(($this->check_username($request)=="false") || ($this->check_email($request)=="false"))
				return Redirect::to('register');
			$user = new User();
			$user->email = $request->get('email');
		    $user->password = md5(sha1($request->get('password')));
		    $user->name = $request->get('username');
		    $user->save();
		    return Redirect::to('/');
		}
	}


	public function login(CookieJar $cookieJar, Request $request) {
		$username_email = $request->get('username-email');
		$password = md5(sha1($request->get('password')));
		if($request->get('remember'))
		$remember = $request->get('remember');
		if(User::check_valid($username_email,$password))
		{	
			$userid = User::getId($username_email);
			$user = User::getUserById($userid);
			if(User::getStatusbyId($userid)==1){

				Session::put("logined",true);
				Session::put("userid",$userid);
				Session::put("userlevel",$user->level);
				if (isset($remember))
				{
					$remember_token = sha1(uniqid(rand()));
					$cookieJar->queue(cookie('remember_token', $remember_token, 45000));
					$user->remember_token = $remember_token;
					$user->save();
				}
				//$user->update(['remember_token' => $request->get('remember')]);

				return Redirect::to('home');
			}else{
				return Redirect::to('login')->withErrors('This username/email was blocked!');
			}		
			
		}
		else
		{
			return Redirect::to('login')->withErrors('Invalid username/email or password!');
		}
	}

	public function googlelogin() {
		
		if(\Input::has('state'))
		{
			 	$gguser = \Socialize::with('google')->user();

			 	
		 			if(!User::social_id_exist($gguser->getId())&&!User::email_exist($gguser->getEmail())){
						$user = new User();
						$user->saveSocialUser($gguser);
		 			}
		 			if(User::getStatusbyId(User::getId($gguser->getEmail()))==1){
		 				Session::put("logined",true);
			 			Session::put("userid",User::getId($gguser->getEmail()));
			 			Session::put("userlevel",User::getLevelbyemail($gguser->getEmail()));
			 			return Redirect::to('home');	
		 			}else{
		 				return Redirect::to('login')->withErrors('This username/email was blocked!');
		 			}
		 			
		 			
		}
		else
		{
			return \Socialize::with('google')->redirect();;
		}
	}

	public function facebooklogin() {
		
		if(\Input::has('code'))
		{
			 	$fbuser = \Socialize::with('facebook')->user();
			 	//dd($fbuser);
			 	
		 			if(!User::social_id_exist($fbuser->getId())&&!User::email_exist($fbuser->getEmail())){
						$user = new User();
						$user->saveSocialUser($fbuser);
		 			}
		 		 	Session::put("logined",true);
		 		 	Session::put("userid",User::getId($fbuser->getEmail()));
					Session::put("userlevel",User::getLevelbyemail($fbuser->getEmail()));
		 			return Redirect::to('home');
		 			
		}
		else
		{
			return \Socialize::with('facebook')->redirect();;
		}
	}

	public function logout(CookieJar $cookieJar){
		if(Session::has("logined"))
		{
			Session::forget("logined");
			$cookieJar->forget("remember_token");
		}
		return Redirect::to('login');
	}

	public function check_username(Request $request){
		$username = $request->get('username');
		if(User::username_exist($username))
			return "false";
		return "true";
	}

	public function check_email(Request $request){
		$email = $request->get('email');
		if(User::email_exist($email))
			return "false";
		return "true";
	}


	public function testmail(Request $request){				

		$email = $request->get('email');
		if(User::where("email","=",$email)->count()>0){

				Mail::send('test', ["token"=>$request->get('token')], function($message) use ($request)
			{
				$message->to($request->get('email'),$request->get('token'))->subject('Music');
			});
				
				$user = new User();
				$user = User::where("email","=",$email)->update(['remember_token' => $request->get('token')]);
			

			return Redirect::to('home');	
		}					
		return Redirect::to('login')->withErrors('Invalid email ');
	}
	

	public function resetpassword(Request $input) {		
		
		return view('resetpassword_form',['token' => $input->get('token')]);
		         
	}


	public function getdata(Request $input) {

		$token = $input->get('token');
		$pass = $input->get('new_pass');
		$pass1 = $input->get('new_pass_1');
		
		if ($pass == $pass1) {
			if (User::check_token($token)) {

			$user = new User();
			$user = User::where("remember_token","=",$token)->update(['password' =>  md5(sha1($input->get('new_pass')))]);
			
			return view('login');

			}	
		}
			
		return Redirect::to('reset?token='.$token);
		        
	}

	public function restvote() {
		$user = User::find(Session::get("userid"));
		
		return  UserController::$numVote - $user->votes->count();
		        
	}

	public function votedlist()
	{
		$user = User::getUserById(Session::get('userid'));
		$songs = $user->votes;
		return view('voted',compact('songs'));
	}
	public function userslist()
	{	
		$users=User::all();
		foreach ($users as $user) {
			$user->avatar= User::getAvatarbyId($user->id);
		}
		
		
		$data = compact('users');
		return view('userslist',$data);
	}
	public function usersmanager()
	{
		$avatar=User::getAvatarbyId(Session::get("userid"));
		$name=User::getNamebyId(Session::get("userid"));
		$data = compact('avatar','name');
		return view('usersmanager',$data);
	}

	public function setstatus(Request $input)
	{
		$userid=$input->get('id');
		$userlevel=User::getLevelbyId($userid);
		if(Session::get('level')==0)
			if($userlevel!=0) User::updatestatus($userid);
			else return "failed";
		else if(Session::get('level')==1)
			if($userlevel!=0&&$userlevel!=1) User::updatestatus($userid);
			else return "failed";
		return "success";
	}

	public function setlevel(Request $input)
	{
		$userid=$input->get('id');
		$level=$input->get('role');
		User::updatelevel($userid,$level);
		return "success";
	}

}