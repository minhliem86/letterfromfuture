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
		if(!Auth::check() || !Auth::user()->can('can_login')){
			return redirect()->route('admin.getlogin')->withErrors('Bạn không có quyền đăng nhập!');
		}
		return $next($request);
	}

}