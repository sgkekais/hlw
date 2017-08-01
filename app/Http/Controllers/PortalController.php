<?php

namespace App\Http\Controllers;

use App\Club;
use App\Matchweek;
use App\Season;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        // test returning the table of a season
        // TODO "current" only works here because we have one season, needs to account for competition, remove first in scope!!
        return $table = Season::current()->generateTable();

        // return view('index', compact('table'));
    }
}
