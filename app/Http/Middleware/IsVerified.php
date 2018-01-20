<?php

namespace HLW\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsVerified
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
        if (!auth()->user()->verified) {
            Auth::logout();
            return redirect()->route('login')->with('warning', 'Bitte bestätige zuerst deine E-Mail-Adresse.');
        }

        return $next($request);
    }
}
