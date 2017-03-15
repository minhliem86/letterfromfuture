<?php namespace App\Http\Middleware;

use Closure;
use Auth;

class LoginPermission {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(!Auth::check() || !Auth::user()->can('logincms')){
			Auth::logout();
			return redirect()->route('admin.getlogin')->withErrors('You do not have permission to access thi page!');
		}
		return $next($request);
	}

}
