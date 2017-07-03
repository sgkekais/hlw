<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use App\Person;
use App\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PlayerController extends Controller
{
    /**
     * Show the form for creating a new player (in pivot table clubs_people) for the given club
     * @param Club $club
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Club $club){

        $people     = Person::orderBy('last_name','asc')->orderBy('first_name','asc')->get();
        $positions  = Position::all();

        return view('admin.players.create', compact('club', 'people', 'positions'));
    }

    /**
     * Store the newly created player for the club in the pivot table
     * @param Request $request
     * @param Club $club
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Club $club){

        $this->validate($request, [
            'sign_on' => 'required|date',
            'sign_off'=> 'nullable|date|after_or_equal:sign_on',
            'number'  => 'nullable|max:4'
        ]);

        $person = Person::find($request->person_id);

        // attach to pivot table by accessing relationship on the club
        $club->players()->attach($person, [
            'sign_on'       => $request->sign_on,
            'sign_off'      => $request->sign_off,
            'number'        => $request->number,
            'position_id'   => $request->position_id
        ]);

        Session::flash('success', 'Spieler '.$person->first_name.' '.$person->last_name.' erfolgreich Mannschaft '.$club->name.' zugeordnet.');

        return redirect()->route('clubs.show', compact('club'));
    }

    /**
     * Show the edit form for a given club/player relationship
     * @param Club $club
     * @param Person $person
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Club $club, Person $person){

        $positions = Position::all();
        $player    = $club->players->find($person);

        return view('admin.players.edit', compact('club', 'player','positions'));
    }

    /**
     * Update the relationship
     * @param Request $request
     * @param Club $club
     * @param Person $person
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Club $club, Person $person){

        $this->validate($request, [
            'sign_on' => 'required|date',
            'sign_off'=> 'nullable|date|after_or_equal:sign_on',
            'number'  => 'nullable|max:4'
        ]);

        $sign_on = $request->sign_on;
        $sign_off = $request->sign_off;
        $number = $request->number;
        $position_id = $request->position_id;

        // sync with existing pivot entry
        $club->players()->updateExistingPivot($person->id, [
            'sign_on'       => $sign_on,
            'sign_off'      => $sign_off,
            'number'        => $number,
            'position_id'   => $position_id
        ]);

        Session::flash('success', 'Spieler '.$person->first_name.' '.$person->last_name.' erfolgreich geändert.');

        return redirect()->route('clubs.show', compact('club'));
    }

    public function destroy(Club $club, Person $person){

        $club->players()->detach($person->id);

        Session::flash('success', 'Zuordnung gelöscht.');

        return redirect()->route('clubs.show', $club);
    }
}
