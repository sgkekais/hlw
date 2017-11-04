<?php

namespace HLW\Http\Controllers;

use HLW\Club;
use HLW\Season;

class ClubController extends Controller
{
    /**
     * @param Season $season
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Season $season)
    {
        $division = $season->division;

        $clubs = $season->clubs()->orderBy('name')->get();
        $clubs->load('championships');

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
        $club->load('players', 'seasons');

        $season = Season::current()->first();
        $season->load('matchweeks.fixtures');
        $division = $season->division;

        return view('clubs.show', compact('club', 'season', 'division'));
    }

}
