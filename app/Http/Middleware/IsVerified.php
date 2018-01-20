<?php

namespace HLW\Http\Middleware;

use Closure;

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
            Session::flush();
            return redirect('login')->withAlert('Bitte bestätige zuerst deine E-Mail-Adresse.');
        }

        return $next($request);
    }
}
