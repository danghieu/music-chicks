<?php namespace App\Http\Middleware;

use Closure;
use Session;

class AdminAuthenticate {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!Session::has("logined") || ((Session::get('userlevel')!=1)&&(Session::get('userlevel')!=0)))
		{
			if ($request->ajax())
			{
				return response('failed');
			}
			else
			{
				return response('You have not permission to do this action.');
			}
		}

		return $next($request);
	}

}
