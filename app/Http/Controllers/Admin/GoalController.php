<?php

namespace App\Http\Controllers\Admin;

use App\Fixture;
use App\Goal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class GoalController extends Controller
{
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
        $fixture->load('club_home','club_away');

        // get the players of both teams and merge them into a single collection
        $players_home = $fixture->club_home->players->load('person');
        $players_away = $fixture->club_away->players->load('person');
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
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function show(Goal $goal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function edit(Fixture $fixture, Goal $goal)
    {
        $fixture->load('club_home','club_away');

        // get the players of both teams and merge them into a single collection
        $players_home = $fixture->club_home->players->load('person');
        $players_away = $fixture->club_away->players->load('person');
        $players      = $players_home->sortBy('person.last_name')->merge($players_away->sortBy('person.last_name'));

        return view('admin.goals.edit', compact('fixture', 'goal', 'players'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Goal  $goal
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
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fixture $fixture, Goal $goal)
    {
        $goal->delete();

        Session::flash('success', 'Torschützen-Eintrag erfolgreich gelöscht.');

        return redirect()->route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]);
    }
}
