<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Card;
use HLW\Fixture;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CardController extends Controller
{
    /**
     * Assign permission middleware to specific actions
     * CardController constructor.
     */
    public function __construct()
    {
        // Permissions
        $this->middleware('permission:list cards')->only('index');
        $this->middleware('permission:create card')->only([
            'create',
            'store']);
        $this->middleware('permission:read card')->only('show');
        $this->middleware('permission:update card')->only([
            'edit',
            'update'
        ]);
        $this->middleware('permission:delete card')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cards = Card::with('fixture')->get()->sortByDesc('fixture.datetime');
        $cards->load([
            'player',
            'player.person',
            'fixture.matchweek',
            'fixture.clubHome',
            'fixture.clubAway'
        ]);
        return view('admin.cards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Fixture $fixture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Fixture $fixture)
    {
        $fixture->load('clubHome','clubAway');

        // get the players of both teams and merge them into a single collection
        $players_home = $fixture->clubHome->players->load('person');
        $players_away = $fixture->clubAway->players->load('person');
        $players      = $players_home->sortBy('person.last_name')->merge($players_away->sortBy('person.last_name'));

        return view('admin.cards.create', compact('fixture', 'players'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Fixture $fixture
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Fixture $fixture)
    {
        $this->validate($request, [
            'ban_matches' => 'nullable|integer|min:0',
            'ban_reduced_by' => 'nullable|integer|min:0|'
        ]);

        $card = new Card($request->all());

        $fixture->cards()->save($card);

        Session::flash('success', $card->color.'e Karte mit '.$card->ban_matches.' Spiel(en) Sperre gepflegt.');

        return redirect()->route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \HLW\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \HLW\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Fixture $fixture, Card $card)
    {
        // get the players of both teams and merge them into a single collection
        $players_home = $fixture->clubHome->players->load('person');
        $players_away = $fixture->clubAway->players->load('person');
        $players      = $players_home->sortBy('person.last_name')->merge($players_away->sortBy('person.last_name'));

        return view('admin.cards.edit', compact('fixture', 'card', 'players'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \HLW\Card  $card
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
     * @param  \HLW\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fixture $fixture, Card $card)
    {
        $card->delete();

        Session::flash('success', 'Karte erfolgreich gelöscht');

        return redirect()->route('matchweeks.fixtures.show', [ $fixture->matchweek, $fixture ] );
    }
}
