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



        return view('index');
    }

    public function generateTable(Season $season, Matchweek $matchweek = null)
    {
        $clubs = $season->clubs;

        if (!$matchweek) {
            $matchweek = $season->matchweeks()->current()->get();
        }


    }
}
