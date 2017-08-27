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
        $clubs = $season->clubs()->orderBy('name')->get();

        return $clubs;
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

        return view('clubs.show', compact('club', 'season'));
    }

}
