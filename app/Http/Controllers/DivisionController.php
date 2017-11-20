<?php

namespace HLW\Http\Controllers;

use HLW\Division;
use HLW\Season;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Division $division)
    {
        $season = $division->seasons()->current()->first();

        return view('divisions.index', compact('division', 'season'));
    }

    /**
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tables(Division $division)
    {
        // eager load seasons for season selector
        $division->load('seasons');
        // also get the current season
        $season = $division->seasons()->current()->first();
        // eager load the current season's matchweeks and clubs
        $season->load('matchweeks', 'clubs');
        // also get the current matchweek of the current season
        $c_matchweek = $season->currentMatchweek();

        return view('divisions.tables', compact('division', 'season', 'c_matchweek'));
    }

    /**
     * @param Request $request
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetFullTable(Request $request, Division $division)
    {
        // check whether a season id is in the request
        if (!$request->filled('season_id')) {
            $season = $division->seasons()->current()->first();
        } else {
            $season = Season::findOrFail($request->season_id);
        }

        // eager load matchweeks and clubs
        $season->load('matchweeks', 'clubs');

        // get the current and previous matchweek
        $c_matchweek = $season->currentMatchweek();
        $p_matchweek = $c_matchweek->previousMatchweek();

        // generate the tables for the current and previous matchweek
        $table_current = $season->generateTable($c_matchweek);
        $table_previous = $season->generateTable($p_matchweek);

        return view('divisions.response_table', compact('division', 'season', 'table_current', 'table_previous', 'c_matchweek', 'p_matchweek'));
    }

    /**
     * @param Request $request
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetHomeTable(Request $request, Division $division)
    {
        // check whether a season id is in the request
        if (!$request->filled('season_id')) {
            $season = $division->seasons()->current()->first();
        } else {
            $season = Season::findOrFail($request->season_id);
        }

        $season->load('matchweeks', 'clubs');

        $c_matchweek = $season->currentMatchweek();
        $p_matchweek = $c_matchweek->previousMatchweek();

        $table_current = $season->generateTable($c_matchweek, 1);
        $table_previous = $season->generateTable($p_matchweek, 1);

        return view('divisions.response_table', compact('division', 'season', 'table_current', 'table_previous', 'c_matchweek', 'p_matchweek'));
    }

    /**
     * @param Request $request
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetAwayTable(Request $request, Division $division)
    {
        // check whether a season id is in the request
        if (!$request->filled('season_id')) {
            $season = $division->seasons()->current()->first();
        } else {
            $season = Season::findOrFail($request->season_id);
        }

        $season->load('matchweeks', 'clubs');

        $c_matchweek = $season->currentMatchweek();
        $p_matchweek = $c_matchweek->previousMatchweek();

        $table_current = $season->generateTable($c_matchweek, 2);
        $table_previous = $season->generateTable($p_matchweek, 2);

        return view('divisions.response_table', compact('division', 'season', 'table_current', 'table_previous', 'c_matchweek', 'p_matchweek'));
    }

    /**
     * @param Request $request
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetCrossTable(Request $request, Division $division)
    {
        // check whether a season id is in the request
        if (!$request->filled('season_id')) {
            $season = $division->seasons()->current()->first();
        } else {
            $season = Season::findOrFail($request->season_id);
        }

        $season->load(['clubs','fixtures']);

        return view('divisions.response_crosstable', compact('season'));
    }

    /**
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function fixtures(Division $division)
    {
        $season = $division->seasons()->current()->first();

        $season->load('clubs', 'matchweeks', 'matchweeks.fixtures');
        $c_matchweek = $season->currentMatchweek();

        return view('divisions.fixtures', compact('division', 'season', 'c_matchweek'));
    }
}
