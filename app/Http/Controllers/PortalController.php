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

        $s1 = Season::find(1);
        $s2 = Season::find(1);

        $matchweek = $s1->getCurrentMatchweek();
        $pmatchweek = $matchweek->getPreviousMatchweek()->first();

        $table  = $s1->generateTable();
        $ptable = $s2->generateTable($pmatchweek);

        return view('index', compact('table', 'ptable'));
    }
}
