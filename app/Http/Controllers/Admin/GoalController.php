<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Fixture;
use HLW\Goal;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class GoalController extends Controller
{
    /**
     * Assign permission middleware to specific actions
     * CardController constructor.
     */
    public function __construct()
    {
        // Permissions
        $this->middleware('permission:list goals')->only('index');
        $this->middleware('permission:create goal')->only([
            'create',
            'store']);
        $this->middleware('permission:read goal')->only('show');
        $this->middleware('permission:update goal')->only([
            'edit',
            'update'
        ]);
        $this->middleware('permission:delete goal')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Fixture $fixture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Fixture $fixture)
    {
        $fixture->load('clubHome','clubAway');

        // get the players of both teams and merge them into a single collection
        $players_home = $fixture->clubHome->players->load('person')->whereNull('sign_off');
        $players_away = $fixture->clubAway->players->load('person')->whereNull('sign_off');
        $players      = $players_home->sortBy('person.last_name')->merge($players_away->sortBy('person.last_name'));

        return view('admin.goals.create', compact('fixture', 'players'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Fixture $fixture
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Fixture $fixture)
    {
        foreach ($request->entities as $entity)
        {
            if(!array_key_exists('ignore', $entity))
            {
                $goal = new Goal($entity);

                $fixture->goals()->save($goal);
            }
        }

        return redirect()->route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \HLW\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function show(Goal $goal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \HLW\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function edit(Fixture $fixture, Goal $goal)
    {
        $fixture->load('clubHome','clubAway');

        // get the players of both teams and merge them into a single collection
        $players_home = $fixture->clubHome->players->load('person');
        $players_away = $fixture->clubAway->players->load('person');
        $players      = $players_home->sortBy('person.last_name')->merge($players_away->sortBy('person.last_name'));

        return view('admin.goals.edit', compact('fixture', 'goal', 'players'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \HLW\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fixture $fixture, Goal $goal)
    {
        $goal->update($request->all());

        Session::flash('success', 'Torschütze erfolgreich geändert.');

        return redirect()->route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \HLW\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fixture $fixture, Goal $goal)
    {
        $goal->delete();

        Session::flash('success', 'Torschützen-Eintrag erfolgreich gelöscht.');

        return redirect()->route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]);
    }
}
