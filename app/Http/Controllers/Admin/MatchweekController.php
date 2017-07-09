<?php

namespace App\Http\Controllers\Admin;

use App\Matchweek;
use App\Season;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class MatchweekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matchweeks = Matchweek::all();

        return view('admin.matchweeks.index', compact('matchweeks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Season $season)
    {
        return view('admin.matchweeks.create', compact('season'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Season $season)
    {
        $this->validate($request, [
            'number_consecutive' => 'required|integer',
            'begin' => 'required|date',
            'end' => 'required|date|after_or_equal:begin'
        ]);

        // create a new object
        $matchweek = new Matchweek($request->all());

        // save the season
        $season->matchweeks()->save($matchweek);

        // flash success message and return competition name as test
        Session::flash('success', 'Spielwoche '.$matchweek->number_consecutive.' erfolgreich angelegt.');

        // return to index
        return redirect()->route('seasons.show', $season);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Matchweek  $matchweek
     * @return \Illuminate\Http\Response
     */
    public function show(Season $season, Matchweek $matchweek)
    {
        $matchweek->load('fixtures.club_home','fixtures.club_away','fixtures.stadium', 'fixtures.fixture_rescheduled_from', 'fixtures.fixture_rescheduled_to', 'fixtures.fixture_rescheduled_by');

        return view('admin.matchweeks.show', compact('season', 'matchweek'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Matchweek  $matchweek
     * @return \Illuminate\Http\Response
     */
    public function edit(Season $season, Matchweek $matchweek)
    {
        return view('admin.matchweeks.edit',compact('season','matchweek'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Matchweek  $matchweek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Season $season, Matchweek $matchweek)
    {
        $this->validate($request, [
            'number_consecutive' => 'required|integer',
            'begin' => 'required|date',
            'end' => 'required|date|after_or_equal:begin'
        ]);

        $matchweek->update($request->all());

        Session::flash('success','Spielwoche erfoglreich geändert.');

        return redirect()->route('seasons.show', $season);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Matchweek  $matchweek
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matchweek $matchweek)
    {
        //
    }
}
