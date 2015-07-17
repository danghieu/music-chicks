<?php namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Cookie\CookieJar;
use App\User;

class Authenticate {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		if (!Session::has("logined"))
		{
			if($request->cookie("remember_token")!=NULL)
			{
				$user = User::getUserByRememberToken($request->cookie("remember_token"));
				if($user!=NULL)
				{
					Session::put("logined",true);
					Session::put("userid",$user->id);
					Session::put("userlevel",$user->level);
					return $next($request);
				}
			}

			if ($request->ajax())
			{
				return response('failed');
			}
			else
			{
				return redirect('login');
			}
		}

		return $next($request);
	}

}
