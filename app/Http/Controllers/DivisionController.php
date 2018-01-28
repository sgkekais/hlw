<?php

namespace HLW\Http\Controllers;

use Carbon\Carbon;
use HLW\Card;
use HLW\Division;
use HLW\Player;
use HLW\Season;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Div;

class DivisionController extends Controller
{
    /**
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Division $division)
    {
        $season = $division->seasons()->current()->first();

        // no current season found, get last season
        if (!$season) {
            $season = $division->seasons()->orderBy('season_nr','desc')->first();
        }

        // if season, eager load relationships and fixtures of the current week
        if ($season) {
            $season->load([
               'clubs', 'fixtures'
            ]);
            $matchweek = $season->currentMatchweek();

            // get the fixtures of the current week
            $monday = Carbon::now()->startOfWeek();
            $sunday = Carbon::now()->endOfWeek();
            $fixtures = $season->fixtures()->whereBetween('datetime',[$monday,$sunday])->get()->where('published', true);
            if ($fixtures) {
                $fixtures->load([
                    'matchweek', 'clubHome', 'clubAway', 'stadium'
                ]);
            }

            $scorers = collect();

            $season->load('matchweeks.fixtures.goals');
            $goals = $season->goals();
            foreach ($goals->groupBy('player.id') as $index => $player_goals) {
                // get the player and load the person relationship
                $player = Player::find($index);
                if ($player) {
                    $player->load([
                        'person', 'club'
                    ]);
                }
                // add a goals attribute
                $player->goals = $player_goals->count();
                // push the player to the scorers collection
                $scorers->push($player);
            }
        }

        // different jumbo backgrounds for different divisions
        $jumbo_bg = asset('storage/grass_green.jpg');
        if ($division->competition->name_short == "HLW") {
            if ($division->hierarchy_level == 1) {
                $jumbo_bg = asset('storage/grass_green.jpg');
            } else {
                $jumbo_bg = asset('storage/grass_brown.jpg');
            }
        } elseif ($division->competition->name_short == "AHL") {
            $jumbo_bg = asset('storage/grass_bw.jpg');
        } elseif ($division->competition->name_short == "P") {
            $jumbo_bg = asset('storage/cup.jpg');
        }

        return view('divisions.index', compact('division', 'season', 'matchweek', 'fixtures', 'jumbo_bg', 'scorers'));
    }

    /**
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tables(Division $division)
    {
        // eager load seasons for season selector
        $division->load('seasons');
        // also get the current season
        $season = $division->seasons()->current()->first();
        if ($season) {
            // eager load the current season's matchweeks and clubs
            $season->load([
                'matchweeks', 'clubs'
            ]);
            // also get the current matchweek of the current season
            $c_matchweek = $season->currentMatchweek();
        } else {
            // no current season found, get last season
            $season = $division->seasons()->orderBy('season_nr','desc')->first();
            $season->load([
                'matchweeks', 'clubs'
            ]);
            $c_matchweek = $season->matchweeks()->get()->sortByDesc('number_consecutive')->first();
        }

        return view('divisions.tables', compact('division', 'season', 'c_matchweek'));
    }

    /**
     * @param Request $request
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetFullTable(Request $request, Division $division)
    {
        // check whether a season id is in the request
        if (!$request->filled('season_id')) {
            $season = $division->seasons()->current()->first();
        } else {
            $season = Season::findOrFail($request->season_id);
        }

        // eager load matchweeks and clubs
        $season->load('matchweeks', 'clubs');

        // get the current and previous matchweek
        $c_matchweek = $season->currentMatchweek();
        $p_matchweek = $c_matchweek->previousMatchweek();

        // generate the tables for the current and previous matchweek
        $table_current = $season->generateTable($c_matchweek);
        $table_previous = $season->generateTable($p_matchweek);

        return view('divisions.response_table', compact('division', 'season', 'table_current', 'table_previous', 'c_matchweek', 'p_matchweek'));
    }

    /**
     * @param Request $request
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetHomeTable(Request $request, Division $division)
    {
        // check whether a season id is in the request
        if (!$request->filled('season_id')) {
            $season = $division->seasons()->current()->first();
        } else {
            $season = Season::findOrFail($request->season_id);
        }

        $season->load('matchweeks', 'clubs');

        $c_matchweek = $season->currentMatchweek();
        $p_matchweek = $c_matchweek->previousMatchweek();

        $table_current = $season->generateTable($c_matchweek, 1);
        $table_previous = $season->generateTable($p_matchweek, 1);

        return view('divisions.response_table', compact('division', 'season', 'table_current', 'table_previous', 'c_matchweek', 'p_matchweek'));
    }

    /**
     * @param Request $request
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetAwayTable(Request $request, Division $division)
    {
        // check whether a season id is in the request
        if (!$request->filled('season_id')) {
            $season = $division->seasons()->current()->first();
        } else {
            $season = Season::findOrFail($request->season_id);
        }

        $season->load('matchweeks', 'clubs');

        $c_matchweek = $season->currentMatchweek();
        $p_matchweek = $c_matchweek->previousMatchweek();

        $table_current = $season->generateTable($c_matchweek, 2);
        $table_previous = $season->generateTable($p_matchweek, 2);

        return view('divisions.response_table', compact('division', 'season', 'table_current', 'table_previous', 'c_matchweek', 'p_matchweek'));
    }

    /**
     * @param Request $request
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetCrossTable(Request $request, Division $division)
    {
        // check whether a season id is in the request
        if (!$request->filled('season_id')) {
            $season = $division->seasons()->current()->first();
        } else {
            $season = Season::findOrFail($request->season_id);
        }

        $season->load(['clubs','fixtures']);

        return view('divisions.response_crosstable', compact('season'));
    }

    /**
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function fixtures(Division $division)
    {
        $season = $division->seasons()->current()->first();

        if (!$season) {
            // no current season found, get last season
            $season = $division->seasons()->orderBy('season_nr','desc')->first();
        }

        $season->load([
            'clubs',
            'matchweeks',
            'matchweeks.fixtures',
            'matchweeks.fixtures.clubHome',
            'matchweeks.fixtures.clubAway',
            'matchweeks.fixtures.stadium'
        ]);
        $c_matchweek = $season->currentMatchweek();

        $jumbo_bg = asset('storage/cup.jpg');

        return view('divisions.fixtures', compact('division', 'season', 'c_matchweek', 'jumbo_bg'));
    }

    /**
     * @param Request $request
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetFixtures(Request $request, Division $division)
    {
        // check whether a season id is in the request
        if (!$request->filled('season_id')) {
            $season = $division->seasons()->current()->first();
        } else {
            $season = Season::findOrFail($request->season_id);
        }

        $season->load([
            'clubs',
            'matchweeks',
            'matchweeks.fixtures',
            'matchweeks.fixtures.clubHome',
            'matchweeks.fixtures.clubAway',
            'matchweeks.fixtures.stadium'
        ]);

        return view('divisions.response_fixtures', compact('season'));
    }

    /**
     * Get cards for the given division and current or last season
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sinners(Division $division)
    {
        $division->load('seasons');

        $season = $division->seasons()->current()->first();

        if (!$season) {
            // no current season found, get last season
            $season = $division->seasons()->orderBy('season_nr','desc')->first();
        }

        $lifetime_bans = Card::lifetimeBan()->get();

        return view('divisions.sinners', compact('division', 'season', 'lifetime_bans'));
    }

    /**
     * @param Request $request
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetSinners(Request $request, Division $division)
    {
        // check whether a season id is in the request
        if (!$request->filled('season_id')) {
            $season = $division->seasons()->current()->first();
        } else {
            $season = Season::find($request->season_id);
        }

        if ($season) {
            $season->load('matchweeks.fixtures.cards');
            $cards = $season->cards()->sortByDesc('fixture.datetime');
        }

        return view('divisions.response_sinners', compact('cards'));
    }

    /**
     * Get goals for the given division and current or last season
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function scorers(Division $division)
    {
        $season = $division->seasons()->current()->first();

        if (!$season) {
            // no current season found, get last season
            $season = $division->seasons()->orderBy('season_nr','desc')->first();
        }

        return view('divisions.scorers', compact('division', 'season'));
    }

    /**
     * @param Request $request
     * @param Division $division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ajaxGetScorers(Request $request, Division $division)
    {
        // check whether a season id is in the request
        if (!$request->filled('season_id')) {
            $season = $division->seasons()->current()->first();
        } else {
            $season = Season::find($request->season_id);
        }

        $scorers = collect();

        if ($season) {
            $season->load('matchweeks.fixtures.goals');
            $goals = $season->goals();
            foreach ($goals->groupBy('player.id') as $index => $player_goals) {
                // get the player and load the person relationship
                $player = Player::find($index);
                if ($player) {
                    $player->load([
                        'person', 'club'
                    ]);
                }
                // add a goals attribute
                $player->goals = $player_goals->count();
                // push the player to the scorers collection
                $scorers->push($player);
            }
        }

        return view('divisions.response_scorers', compact('scorers'));
    }
}
