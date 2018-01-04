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
        $fixtures_grouped_by_divisions = Fixture::whereBetween('datetime', ['2017-10-30', '2017-11-11'])
            ->with([
                'matchweek.season.division',
                'clubHome',
                'clubAway',
                'stadium',
                'rescheduledTo.rescheduledBy',
            ])
            ->get()
        ->sortBy('matchweek.season.division.id')
        ->groupBy('matchweek.season.division.id');

        return view('index', compact('divisions', 'fixtures_grouped_by_divisions'));
    }

    public function imprint() {
        return view('static.imprint');
    }

}
