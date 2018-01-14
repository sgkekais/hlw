<?php

namespace HLW\Http\Controllers;

use HLW\Club;
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
        //
    }

    public function profile()
    {
        // get public HLW clubs that have not resigned
        $clubs = Club::isNotRealClub()->notResigned()->published()->get();
        // get the user's favorites
        $favorite_clubs = Auth::user()->clubs;
        // remove already assigned favorites from clubs
        $clubs = $clubs->diff($favorite_clubs);

        return view('users.profile', compact('clubs'));
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

    /**
     * Add a club to the user's favorites
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addClubFavorite(Request $request)
    {
        $club = Club::find($request->club);

        $user = Auth::user();

        $user->clubs()->attach($club);

        return redirect()->route('frontend.user.profile.show');
    }

    /**
     * Remove a club from the user's favorites
     * @param Club $club
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteClubFavorite(Club $club)
    {
        $user = Auth::user();

        // delete assignment
        $user->clubs()->detach($club);

        // return to the profile
        return redirect()->route('frontend.user.profile.show');
    }
}
