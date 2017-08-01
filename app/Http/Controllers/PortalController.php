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
        return $table = $this->generateTable(Season::current());

        // return view('index', compact('table'));
    }

    public function generateTable(Season $season, Matchweek $matchweek = null)
    {
        $clubs = $season->clubs;

        if (!$matchweek) {
            $matchweek = $season->matchweeks()->current();
        }

        // data collection
        $table = collect();

        /*
         * Table:
         * Rank    Played Won Drawn Loss GF GA GD Points Form
         */
        foreach ($season->matchweeks()->orderBy('number_consecutive')->get() as $matchweek) {
            $table->push($matchweek);
        }

        return $table;

        // sorting
    }
}
