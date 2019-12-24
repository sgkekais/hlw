<?php

namespace HLW\Http\Controllers;

use HLW\Club;
use HLW\Division;
use HLW\Season;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{

    public function index() {

        $divisions = Division::all()->sortBy('name');

        $seasons = Season::published()->withCount([
          'matchweeks',
          'fixtures',
          'clubs'
        ])
        ->get()->sortByDesc('name')
        ->load('division', 'champion', 'clubs')
        ->groupBy('name');

        return view('archive.index', compact('divisions','seasons'));
    }

    /**
     * Hall of Fame
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hallOfFame() {
        $champions = Club::published()->has('championships')->withCount('championships')->get()->sortByDesc('championships_count');

        return view('archive.halloffame', compact('champions'));
    }

    /**
     * Former Clubs
     */
    public function formerClubs() {
        $former_clubs = Club::published()->resigned()->orderBy('league_exit', 'desc')->with('championships')->get();

        return view('archive.formerclubs', compact('former_clubs'));
    }
}
