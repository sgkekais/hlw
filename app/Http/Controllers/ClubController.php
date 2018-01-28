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
        if ($club->published) {
            $club->load([
                'championships',
                'players',
                'seasons',
                'stadiums',
                'regularStadium'
            ]);

            $season = $club->seasons()->current()->first();
            $is_current_season = true;

            if (!$season) {
                $season = $club->seasons()->published()->orderBy('season_nr', 'desc')->get()->where('type','league')->first();
                $is_current_season = false;
            }

            $reschedulings = null;
            if ($season) {
                $season->load('matchweeks.fixtures');
                $division = $season->division;
                $reschedulings = $club->reschedulings->where('matchweek.season.id', $season->id);
                if ($reschedulings) {
                    $reschedulings->load('matchweek', 'clubHome', 'clubAway');
                }
            }

            return view('clubs.show', compact('club', 'season', 'division', 'reschedulings'));

        } else {
            return redirect()->route('home');
        }
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
            if (!$season) {
                $season = $club->seasons()->orderBy('season_nr', 'desc')->first();
            }
        } else {
            $season = Season::find($request->season_id);
        }

        if ($season) {
            $fixtures = $season->fixtures()->ofClub($club->id)->orderBy('datetime')->get();
            if ($fixtures) {
                $fixtures->load([
                    'clubHome',
                    'clubAway',
                    'goals',
                    'cards'
                ]);
            }
        }

        return view('clubs.response_results', compact('club', 'fixtures', 'season'));
}

}
