<?php namespace App\Http\Controllers;
use App\Song;
use App\User;
use Session;
use App\TimeToPlay;
class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{		
		$avatar=User::getAvatarbyId(Session::get("userid"));
		$name=User::getNamebyId(Session::get("userid"));
		$userlevel = Session::get("userlevel");
		$data = compact('avatar','name','userlevel');		
		return view('home',$data);
	}

}
