<?php

namespace HLW\Http\Controllers;

use HLW\Club;
use HLW\Season;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @param Request $request
     * @param Club $club
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetClubResults(Request $request, Club $club)
    {
        if (!$request->filled('season_id')) {
            $season = $club->seasons()->current()->first();
        } else {
            $season = Season::findOrFail($request->season_id);
        }

        $fixtures = $season->fixtures()->ofClub($club->id)->orderBy('datetime')->get();

        return view('clubs.response_results', compact('club', 'fixtures', 'season'));
}

}
