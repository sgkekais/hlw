<?php

namespace HLW\Http\Controllers;

use HLW\Club;
use HLW\Competition;
use HLW\Matchweek;
use HLW\Season;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        // test returning the table of a season
        // TODO "current" only works here because we have one season, needs to account for competition, remove first in scope!!

        $competition = Competition::find(1);
        $division    = $competition->divisions()->find(1);
        $season      = $division->seasons()->current()->get()->first();
        $season->load('matchweeks');
        $current_matchweek   = $season->getCurrentMatchweek();
        $previous_matchweek   = $current_matchweek->getPreviousMatchweek()->first();
        $table              = $season->generateTable($current_matchweek);
        $table_previous_mw  = $season->generateTable($previous_matchweek);

        return view('index', compact('table','table_previous_mw' ));
    }
}
