<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Club;
use HLW\Person;
use HLW\Player;
use HLW\Position;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = Player::with('person')->get();

        return $players;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Club $club)
    {
        $people     = Person::active()->orderBy('last_name','asc')->orderBy('first_name','asc')->get();
        $positions  = Position::all();

        return view('admin.players.create', compact('club', 'people', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Club $club)
    {
        $this->validate($request, [
            'sign_on' => 'required|date',
            'sign_off'=> 'nullable|date|after_or_equal:sign_on',
            'number'  => 'nullable|max:4'
        ]);

        $player = new Player($request->all());

        $club->players()->save($player);

        Session::flash('success', 'Spieler '.$player->person->last_name.', '.$player->person->first_name.' erfolgreich Mannschaft '.$club->name.' zugeordnet.');

        return redirect()->route('clubs.show', compact('club'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \HLW\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \HLW\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club, Player $player)
    {
        $positions = Position::all();

        return view('admin.players.edit', compact('club', 'player','positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \HLW\Club $club
     * @param  \HLW\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club, Player $player)
    {
        $this->validate($request, [
            'sign_on' => 'required|date',
            'sign_off'=> 'nullable|date|after_or_equal:sign_on',
            'number'  => 'nullable|max:4'
        ]);

        $player->update($request->all());

        Session::flash('success', 'Spieler '.$player->person->first_name.' '.$player->person->last_name.' erfolgreich geändert.');

        return redirect()->route('clubs.show', compact('club'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Club $club
     * @param Player $player
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Club $club, Player $player)
    {
        $player->delete();

        Session::flash('success', 'Zuordnung gelöscht.');

        return redirect()->route('clubs.show', $club);
    }
}
