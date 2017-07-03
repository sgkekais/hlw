<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use App\Person;
use App\Player;
use App\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PlayerControllerOld extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO
        // return view('admin.players.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // TODO: persons, clubs und positions schon mitgeben und nicht in view machen
        $positions = Position::all();

        return view('admin.players.create', compact('positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'sign_on'  => 'required|date',
            'sign_off' => 'nullable|date|after_or_equal:sign_on'
        ]);

        $player = new Player($request->all());

        $player->save();

        Session::flash('success','Spieler erfolgreich angelegt.');

        return redirect()->route('clubs.show', $player->club);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player)
    {
        $positions = Position::all();

        return view('admin.players.edit', compact('player', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Player $player)
    {
        $this->validate($request,[
            'sign_on'  => 'required|date',
            'sign_off' => 'nullable|date|after_or_equal:sign_on'
        ]);

        $player->update($request->all());

        Session::flash('success','Spieler erfolgreich geändert.');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        //
    }
}
