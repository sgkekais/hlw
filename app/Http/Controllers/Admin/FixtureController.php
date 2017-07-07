<?php

namespace App\Http\Controllers\Admin;

use App\Fixture;
use App\Matchweek;
use App\Stadium;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class FixtureController extends Controller
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
    public function create(Matchweek $matchweek, Fixture $fixture)
    {
        // get all clubs of the season
        $clubs = $matchweek->season->clubs;
        // get all stadiums
        $stadiums = Stadium::all();

        return view('admin.fixtures.create', compact('matchweek','clubs', 'stadiums', 'fixture'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Matchweek $matchweek)
    {
        $this->validate($request, [
            'date' => 'nullable|date',
            'time' => 'nullable',
            'stadium_id' => 'nullable',
            'club_id_home' => 'nullable',
            'club_id_away' => 'nullable',
            'goals_home' => 'nullable|integer|min:0',
            'goals_away' => 'nullable|integer|min:0',
            'goals_home_11m' => 'nullable|integer|min:0',
            'goals_away_11m' => 'nullable|integer|min:0',
            'goals_home_rated' => 'nullable|integer|min:0',
            'goals_away_rated' => 'nullable|integer|min:0'
        ]);

        $fixture = new Fixture($request->all());

        $matchweek->fixtures()->save($fixture);

        Session::flash('success', 'Paarung angelegt');

        return redirect()->route('seasons.matchweeks.show',[$matchweek->season, $matchweek]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fixture  $fixture
     * @return \Illuminate\Http\Response
     */
    public function show(Fixture $fixture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fixture  $fixture
     * @return \Illuminate\Http\Response
     */
    public function edit(Matchweek $matchweek, Fixture $fixture)
    {
        // get all clubs of the season
        $clubs = $matchweek->season->clubs;
        // get all stadiums
        $stadiums = Stadium::all();

        return view('admin.fixtures.edit', compact('matchweek', 'fixture', 'clubs', 'stadiums'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fixture  $fixture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matchweek $matchweek, Fixture $fixture)
    {
        $this->validate($request, [
            'date'              => 'nullable|date',
            'time'              => 'nullable',
            'stadium_id'        => 'nullable',
            'club_id_home'      => 'nullable',
            'club_id_away'      => 'nullable',
            'goals_home'        => 'nullable|integer|min:0',
            'goals_away'        => 'nullable|integer|min:0',
            'goals_home_11m'    => 'nullable|integer|min:0',
            'goals_away_11m'    => 'nullable|integer|min:0',
            'goals_home_rated'  => 'nullable|integer|min:0',
            'goals_away_rated'  => 'nullable|integer|min:0'
        ]);

        $fixture->update($request->all());

        Session::flash('success', 'Paarung geändert');

        return redirect()->route('seasons.matchweeks.show',[$matchweek->season, $matchweek]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fixture  $fixture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matchweek $matchweek, Fixture $fixture)
    {
        $id = $fixture->id;

        // TODO: consider reschedule relationships
        $fixture->delete();

        Session::flash('success', 'Paarung mit der id '.$id.' gelöscht.');

        return redirect()->route('seasons.matchweeks.show', [$matchweek->season, $matchweek]);
    }
}
