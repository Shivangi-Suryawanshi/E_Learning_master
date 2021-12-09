<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ( ! Auth::check()){
            return redirect()->guest(route('login'))->with('error', trans('app.unauthorized_access'));
        }

        $user = Auth::user();


        if ( ! $user->isAdmin() && ! $user->isSubAdmin())
        // Session::flush();
        // Auth::logout();
        // return redirect('/');
            return redirect(route('no-access'))->with('error', __t('access_restricted'));


        return $next($request);
    }
}
