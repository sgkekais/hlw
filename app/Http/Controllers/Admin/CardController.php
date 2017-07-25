<?php

namespace App\Http\Controllers\Admin;

use App\Card;
use App\Fixture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Fixture $fixture)
    {
        $fixture->load('club_home','club_away');

        // get the players of both teams and merge them into a single collection
        $players_home = $fixture->club_home->players->load('person');
        $players_away = $fixture->club_away->players->load('person');
        $players      = $players_home->sortBy('person.last_name')->merge($players_away->sortBy('person.last_name'));

        return view('admin.cards.create', compact('fixture', 'players'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Fixture $fixture)
    {
        $this->validate($request, [
           'ban_matches' => 'nullable|integer|min:0'
        ]);

        $card = new Card($request->all());

        $fixture->cards()->save($card);

        Session::flash('success', $card->color.'e Karte mit '.$card->ban_matches.' Spiel(en) Sperre gepflegt.');

        return redirect()->route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Fixture $fixture, Card $card)
    {
        // get the players of both teams and merge them into a single collection
        $players_home = $fixture->club_home->players->load('person');
        $players_away = $fixture->club_away->players->load('person');
        $players      = $players_home->sortBy('person.last_name')->merge($players_away->sortBy('person.last_name'));

        return view('admin.cards.edit', compact('fixture', 'card', 'players'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fixture $fixture, Card $card)
    {
        $this->validate($request, [
            'ban_matches' => 'nullable|integer|min:0'
        ]);

        $card->update($request->all());

        Session::flash('success', 'Karte erfolgreich geändert.');

        return redirect()->route('matchweeks.fixtures.show', [ $fixture->matchweek, $fixture ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fixture $fixture, Card $card)
    {
        $card->delete();

        Session::flash('success', 'Karte erfolgreich gelöscht');

        return redirect()->route('matchweeks.fixtures.show', [ $fixture->matchweek, $fixture ] );
    }
}
