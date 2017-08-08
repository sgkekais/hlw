<?php

namespace HLW\Http\Controllers;

use HLW\Season;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        // test returning the table of a season
        // TODO "current" only works here because we have one season, needs to account for competition, remove first in scope!!

        $s1 = Season::find(1);
        $s2 = Season::find(1);

        $c_matchweek = $s1->currentMatchweek();
        $p_matchweek = $c_matchweek->previousMatchweek();

        $table_current = $s1->generateTable();
        $table_previous = $s2->generateTable($p_matchweek);

        return view('index', compact('table_current', 'table_previous'));
    }
}
