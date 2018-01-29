<?php

namespace HLW\Http\Controllers\Auth;

use HLW\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Overwrite trait functionality:
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string'
            // 'g-recaptcha-response' => 'required|captcha'
        ]);
    }

    /**
     * Handle a login request to the application.
     * Overwrite this so it checks whether the user has verified the account.
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            // Make sure the use is not banned
            if (!$user->ban_date && $this->attemptLogin($request)) {
                // Make sure the user is verified
                if ($user->verified && $this->attemptLogin($request)) {
                    // Send the normal successful login response
                    return $this->sendLoginResponse($request);
                } else {
                    // User is not verified
                    // Increment the failed login attempts and redirect back to the
                    // login form with an error message.
                    $this->incrementLoginAttempts($request);
                    return redirect()
                        ->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->with('warning', 'Bitte bestätige zuerst deine E-Mail-Adresse.');
                }
            } else {
                // User is banned
                // Increment the failed login attempts and redirect back to the
                // login form with an error message.
                $this->incrementLoginAttempts($request);
                return redirect()
                    ->back()
                    ->with('danger', 'Du wurdest am '.$user->ban_date->format('d.m.Y H:i').' gebannt. Grund: '.($user->ban_reason ?? 'nicht angegeben'));
            }
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        Session::flash('authenticated', true);
    }
}
