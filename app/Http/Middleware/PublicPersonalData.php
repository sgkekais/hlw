<?php

namespace HLW\Http\Middleware;

use Closure;

class PublicPersonalData
{
    /**
     * Hide public pages with personal data unless they are enabled in config/hlw.php.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        abort_unless(config('hlw.public_personal_data'), 404);

        return $next($request);
    }
}
