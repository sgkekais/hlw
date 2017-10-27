<?php

namespace HLW\Http\Controllers;

use HLW\Competition;
use HLW\Division;
use HLW\Matchweek;
use HLW\Season;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        $divisions = Division::published()->get()->where('competition.type', 'league');
        $divisions->load(['seasons' => function ($query) {
            $query->published()->current();
        }], 'seasons.clubs', 'seasons.matchweeks');

        return view('index', compact('divisions'));
    }
}
