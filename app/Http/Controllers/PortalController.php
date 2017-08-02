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
        return $table = $season->generateTable();

        // return view('index', compact('table'));
    }
}
