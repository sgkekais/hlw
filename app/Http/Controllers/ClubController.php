<?php

namespace HLW\Http\Controllers;

use HLW\Club;
use HLW\Season;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Season $season = null)
    {
        // TODO: if no season, display all clubs?
        $division = $season->division;

        $clubs = $season->clubs()->orderBy('name')->get();

        return view('clubs.index', compact('season', 'division', 'clubs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \HLW\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club)
    {
        $club->load('players');

        $season = Season::current()->first();
        $season->load('matchweeks.fixtures');
        $division = $season->division;

        return view('clubs.show', compact('club', 'season', 'division'));
    }

}
