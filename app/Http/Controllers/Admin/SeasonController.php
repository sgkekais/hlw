<?php

namespace App\Http\Controllers\Admin;

use App\Season;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all seasons
        $seasons = Season::all();

        // return index view
        return view('admin.seasons.index', compact('seasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.seasons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$this->validate($request, [
            'name' => 'required|min:2',
            'hierarchy_level' => 'required' // TODO
        ]);*/

        // create a new object
        $season = new Season($request->all());

        // save the season
        $season->save();

        // flash success message and return competition name as test
        Session::flash('success', 'Saison '.$season->year_begin.' / '.$season->year_end.' erfolgreich angelegt und Wettbewerb '.$season->division->name.' zugeordnet.');

        // return to index
        return redirect()->route('seasons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function show(Season $season)
    {
        // eager load matchweeks
        $season->load('matchweeks');

        return view('admin.seasons.show', compact('season'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function edit(Season $season)
    {
        return view('admin.seasons.edit', compact('season'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Season $season)
    {
        $this->validate($request, [
            'name' => 'required|min:2',
            'hierarchy_level' => 'required' // TODO
        ]);

        // update the season
        $season->update($request->all());

        // flash success message and return competition name as test
        Session::flash('success', 'Saison '.$season->year_begin.' / '.$season->year_end.' erfolgreich geändert.');

        // return to index
        return redirect()->route('seasons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function destroy(Season $season)
    {
        //
    }
}
