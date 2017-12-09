<?php

namespace HLW\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     *
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'password'  => 'required|string|min:6|confirmed'
        ]);

        $user = Auth::user();

        $user->password = bcrypt($request->password);

        if ($user->save()) {
            Session::flash('success', 'Passwort erfolgreich geändert.');
        }

        return redirect()->route('frontend.user.profile.show');
    }
}
