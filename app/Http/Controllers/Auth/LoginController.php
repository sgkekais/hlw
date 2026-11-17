<?php

namespace HLW\Http\Controllers\Auth;

use HLW\Http\Controllers\Controller;
use HLW\Http\Middleware\VerifyAdmins;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Login for the admin area. There is no public login, registration
 * or password reset anymore: admins are created by a super admin.
 */
class LoginController extends Controller
{
    /**
     * Failed attempts per e-mail and IP before the login is locked.
     */
    const MAX_ATTEMPTS = 5;

    /**
     * Failed attempts per IP, whatever e-mail addresses are tried.
     */
    const MAX_ATTEMPTS_PER_IP = 20;

    /**
     * Lockout in seconds after too many failed attempts.
     */
    const DECAY_SECONDS = 300;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request, RateLimiter $limiter)
    {
        $credentials = $this->validate($request, [
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        $key = Str::lower($request->input('email')) . '|' . $request->ip();
        $ipKey = 'login|' . $request->ip();

        foreach ([$key => self::MAX_ATTEMPTS, $ipKey => self::MAX_ATTEMPTS_PER_IP] as $limitKey => $maxAttempts) {
            if ($limiter->tooManyAttempts($limitKey, $maxAttempts)) {
                throw ValidationException::withMessages([
                    'email' => 'Zu viele Anmeldeversuche. Bitte in ' . ceil($limiter->availableIn($limitKey) / 60) . ' Minuten erneut versuchen.',
                ]);
            }
        }

        $guard = Auth::guard();

        // check banned users and the role before the session is started
        if (!$guard->validate($credentials)
            || $guard->getLastAttempted()->ban_date
            || !$guard->getLastAttempted()->hasAnyRole(VerifyAdmins::ROLES)) {
            $limiter->hit($key, self::DECAY_SECONDS);
            $limiter->hit($ipKey, self::DECAY_SECONDS);

            throw ValidationException::withMessages([
                'email' => 'Die Anmeldedaten sind ungültig.',
            ]);
        }

        $limiter->clear($key);
        $guard->login($guard->getLastAttempted(), $request->filled('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('admin'));
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
