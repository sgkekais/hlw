<?php

namespace HLW\Http\Controllers\Auth;

use HLW\Club;
use HLW\User;
use HLW\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Jrean\UserVerification\Facades\UserVerification;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Exceptions\UserNotFoundException;
use Jrean\UserVerification\Exceptions\UserIsVerifiedException;
use Jrean\UserVerification\Exceptions\TokenMismatchException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    // TODO: notify me when a user registers

    use RegistersUsers;
    use VerifiesUsers;

    /**
     * laravel-user-verification overwrites
     */
    protected $redirectIfVerified = '/login';
    protected $redirectAfterVerification = '/login';
    protected $redirectIfVerificationFails = '/email-verification/error';
    protected $verificationErrorView = 'laravel-user-verification::user-verification';
    protected $verificationEmailView = 'laravel-user-verification::email';
    protected $userTable = 'users';

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest',['except' => ['getVerification', 'getVerificationError']]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $clubs = Club::published()->isNotRealClub()->notResigned()->orderBy('name')->get();

        return view('auth.register', compact('clubs'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => 'required|string|min:2|max:20|unique:users',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:6|confirmed',
            'clubs'     => 'nullable|array|max:3'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \HLW\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => bcrypt($data['password']),
        ]);

        // create club favorites, if selected
        if (isset($data['clubs']) && !empty($data['clubs'])) {
            foreach ($data['clubs'] as $club) {
                $user->clubs()->attach($club);
            }
        }

        // assign the "visitor" role
        // TODO: write db seed
        $user->assignRole('visitor');

        return $user;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        // event(new Registered($user));

        // generate a verification token
        UserVerification::generate($user);
        // and send the mail to the user
        UserVerification::send($user, 'Bestätigung deines Accounts');

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath())->with('registered', 'Um deine Registrierung abzuschließen, bestätige bitte deine E-Mail. Klick dazu auf den Link in der E-Mail, die wir soeben an dich geschickt haben.');
    }

    /**
     * Handle the user verification.
     * Change this to display a success message
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function getVerification(Request $request, $token)
    {
        if (! $this->validateRequest($request)) {
            return redirect($this->redirectIfVerificationFails());
        }

        try {
            $user = UserVerification::process($request->input('email'), $token, $this->userTable());
        } catch (UserNotFoundException $e) {
            return redirect($this->redirectIfVerificationFails());
        } catch (UserIsVerifiedException $e) {
            return redirect($this->redirectIfVerified());
        } catch (TokenMismatchException $e) {
            return redirect($this->redirectIfVerificationFails());
        }

        if (config('user-verification.auto-login') === true) {
            auth()->loginUsingId($user->id);
        }

        return redirect($this->redirectAfterVerification())->with('success', 'Du hast deinen Account erfolgreich bestätigt und kannst dich jetzt anmelden!');
    }

    /**
     * TODO
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendVerificationToken(User $user)
    {
        // generate a verification token
        UserVerification::generate($user);
        // and send the mail to the user
        UserVerification::send($user, 'Bestätigung deines Accounts');

        return redirect()->route('login')->with('status', 'Die E-Mail zur Bestätigung deines Accounts wurde dir erneut zugeschickt.');
    }
}
