<?php

namespace HLW\Http\Controllers;

use HLW\Matchweek;
use HLW\Season;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        // test returning the table of a season
        // TODO "current" only works here because we have one season, needs to account for competition, remove first in scope!!

        $season = Season::find(1);
        $season->load('matchweeks','clubs');

        $c_matchweek = $season->matchweeks()->where('number_consecutive','1')->first();
        $p_matchweek = $season->matchweeks()->where('number_consecutive','1')->first();

        $table_current = $season->generateTable($c_matchweek);
        $table_previous = $season->generateTable($p_matchweek);

        return view('index', compact('table_current', 'table_previous'));
    }
}
