<?php

namespace HLW\Http\Controllers;

use Carbon\Carbon;
use HLW\Competition;
use HLW\Division;
use HLW\Fixture;
use HLW\Matchweek;
use HLW\Season;
use Illuminate\Http\Request;
use Forecast\Forecast;

class PortalController extends Controller
{
    public function index()
    {

        $divisions = Division::published()->get()->where('competition.type', 'league');
        $divisions->load(['seasons' => function ($query) {
            $query->published()->current();
        }], 'seasons.clubs', 'seasons.matchweeks');

        // get the fixtures of the current week
        $monday = Carbon::now()->startOfWeek();
        $sunday = Carbon::now()->endOfWeek();
        $fixtures = Fixture::whereBetween('datetime', [$monday, $sunday])->orderBy('datetime')->get();

        return view('index', compact('divisions', 'fixtures'));
    }
}
