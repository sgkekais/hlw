<?php

namespace HLW\Http\Controllers;

use HLW\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index(Division $division)
    {
        $season = $division->seasons()->current()->first();
        $season->load('matchweeks','clubs');

        $c_matchweek = $season->currentMatchweek();
        $p_matchweek = $c_matchweek->previousMatchweek();

        $table_current = $season->generateTable($c_matchweek);
        $table_previous = $season->generateTable($p_matchweek);

        return view('divisions.index', compact('season','table_current', 'table_previous'));
    }
}
