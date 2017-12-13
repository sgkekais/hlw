<?php

namespace HLW\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyAdmins
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
        // if a user has the role 'visitor', redirect him / her to the front page
        if (Auth::user()->hasRole('visitor')) {
            return redirect('/')->with('');
        }

        return $next($request);
    }
}
