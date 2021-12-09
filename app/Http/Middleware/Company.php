<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Company
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

        if ( ! $user->user_type == "company")
            return redirect(route('dashboard'))->with('error', __t('access_restricted'));


        return $next($request);
    }
}
