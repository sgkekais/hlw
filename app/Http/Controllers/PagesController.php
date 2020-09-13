<?php

namespace HLW\Http\Controllers;

use Carbon\Carbon;
use HLW\Club;
use HLW\Competition;
use HLW\Division;
use HLW\Fixture;
use HLW\Matchweek;
use HLW\Referee;
use HLW\Season;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $divisions = Division::published()->get()->where('competition.type', 'league');
        $division_count = $divisions->count();
        $divisions->load(['seasons' => function ($query) {
            $query->published()->current();
        }], 'seasons.clubs', 'seasons.matchweeks');

        // get the fixtures of the current week
        $monday = Carbon::now()->startOfWeek();
        $sunday = Carbon::now()->endOfWeek();
        $fixtures_grouped_by_divisions = Fixture::whereBetween('datetime', [$monday, $sunday])
            ->with([
                'matchweek.season.division',
                'clubHome',
                'clubAway',
                'stadium',
                'rescheduledTo.rescheduledBy',
            ])
            ->whereHas('matchweek.season', function ($query) {
                $query->where('published', '=', '1');
            })
            ->get()
        ->sortBy('matchweek.season.division.id')
        ->groupBy('matchweek.season.division.id');

        return view('index', compact('divisions', 'fixtures_grouped_by_divisions', 'division_count'));
    }

    /**
     * Imprint
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function imprint() {
        return view('static.imprint');
    }

    /**
     * Infos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function infos() {
        $referees = Referee::with('person')->get();

        return view('static.infos', compact('referees'));
    }

    public function matchReport() {

        $storage_path = storage_path('app/public/spielberichtsbogen.pdf');

        return response()->download($storage_path);
    }

    public function jhvCorona(){
        $storage_path = storage_path('app/public/hlw-jhv-2020-09-03_2.pdf');

        return response()->download($storage_path);
    }

    public function datenschutz() {
        return view('static.datenschutz');
    }

}
