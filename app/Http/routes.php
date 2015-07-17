<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get("register",function(){	
	return View::make("register");
});

Route::post('register', 'UserController@register');

Route::get("forgot",function(){
	return View::make("forgotpassword");
});

Route::group(array("prefix"=>"check"), function(){
	Route::post("check-username",'UserController@check_username');
	Route::post("check-email",'UserController@check_email');
});

Route::get("login",function(){	
	return View::make("login");
});

Route::post("login","UserController@login");
Route::get("gglogin","UserController@googlelogin");
Route::get("fblogin","UserController@facebooklogin");

Route::group(['middleware' => 'auth'], function()
{
	Route::get('/', 'HomeController@index');
	Route::get('home', 'HomeController@index');
	Route::get("logout","UserController@logout");
	Route::match(['get', 'post'],"search","SearchController@searchZing");
	Route::get("addsong", "SongController@addsong");
	Route::get("listsong","SongController@songlist");
	Route::get("getlink", "SongController@getlink");
	Route::get("remove-from-list", "SongController@removeFromList");
	Route::get("vote","SongController@vote");	
	Route::get("settimelist",'TimeController@settimelist');
	Route::get("restvote","UserController@restvote");
	Route::get("voted","UserController@votedlist");
	Route::get("clockview","TimeController@clockview");

	Route::get('information', 'EditProfileController@edit');
	
	
	Route::post("edit",'EditProfileController@editprofile');
});

Route::group(['middleware' => 'admin'], function()
{
	Route::get("remove-time",'TimeController@removetime');
	Route::get("settime","TimeController@setTime");
	Route::get("usersmanager","UserController@usersmanager");
	Route::get("userslist","UserController@userslist");
	Route::get("setstatus","UserController@setstatus");
	Route::get("setlevel","UserController@setlevel");
});

Route::get('check-time','TimeController@checkTime');

Route::post('forgot',"PasswordController@forgotpassword");
Route::get("reset", 'PasswordController@resetpassword');
Route::post("getdata", 'PasswordController@getdata');


