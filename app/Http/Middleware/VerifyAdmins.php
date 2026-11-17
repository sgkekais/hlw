<?php

namespace HLW\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyAdmins
{
    /**
     * Roles that may use the admin area.
     */
    const ROLES = ['super_admin', 'admin'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // users without an admin role are logged out, e.g. a role was revoked during the session
        if (!Auth::user()->hasAnyRole(self::ROLES)) {
            Auth::logout();
            $request->session()->invalidate();

            abort(403);
        }

        return $next($request);
    }
}
