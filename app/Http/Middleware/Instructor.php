<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Instructor
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
        if (Auth::check()) {
            $user = Auth::user();
            if ( ! $user->isInstructor() ){
        //         Session::flush();
        // Auth::logout();
        // return redirect('/');
        return redirect(route('no-access'))->with('error', __t('access_restricted'));

            }
        }

        return $next($request);
    }
}
