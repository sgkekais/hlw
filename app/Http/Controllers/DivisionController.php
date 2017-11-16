<?php

namespace HLW\Http\Controllers;

use HLW\Division;
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
        $season = $division->seasons()->current()->first();
        $season->load('matchweeks', 'clubs');
        $c_matchweek = $season->currentMatchweek();

        return view('divisions.tables', compact('division', 'season', 'c_matchweek'));
    }

    /**
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetFullTable(Division $division)
    {
        $season = $division->seasons()->current()->first();
        $season->load('matchweeks', 'clubs');

        $c_matchweek = $season->currentMatchweek();
        $p_matchweek = $c_matchweek->previousMatchweek();

        $table_current = $season->generateTable($c_matchweek);
        $table_previous = $season->generateTable($p_matchweek);

        return view('divisions.response_table', compact('division', 'season', 'table_current', 'table_previous', 'c_matchweek', 'p_matchweek'));
    }

    /**
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetHomeTable(Division $division)
    {
        $season = $division->seasons()->current()->first();
        $season->load('matchweeks', 'clubs');

        $c_matchweek = $season->currentMatchweek();
        $p_matchweek = $c_matchweek->previousMatchweek();

        $table_current = $season->generateTable($c_matchweek, 1);
        $table_previous = $season->generateTable($p_matchweek, 1);

        return view('divisions.response_table', compact('division', 'season', 'table_current', 'table_previous', 'c_matchweek', 'p_matchweek'));
    }

    /**
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetAwayTable(Division $division)
    {
        $season = $division->seasons()->current()->first();
        $season->load('matchweeks', 'clubs');

        $c_matchweek = $season->currentMatchweek();
        $p_matchweek = $c_matchweek->previousMatchweek();

        $table_current = $season->generateTable($c_matchweek, 2);
        $table_previous = $season->generateTable($p_matchweek, 2);

        return view('divisions.response_table', compact('division', 'season', 'table_current', 'table_previous', 'c_matchweek', 'p_matchweek'));
    }

    /**
     * Display a cross table for the given division
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetCrossTable(Division $division)
    {
        $season = $division->seasons()->current()->first();
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
