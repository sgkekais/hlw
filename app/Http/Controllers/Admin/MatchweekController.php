<?php

namespace App\Http\Controllers\Admin;

use App\Matchweek;
use App\Season;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class MatchweekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matchweeks = Matchweek::all();

        return view('admin.matchweeks.index', compact('matchweeks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $seasons = Season::all();

        return view('admin.matchweeks.create', compact('seasons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'number_consecutive' => 'required|integer',
            'begin' => 'required|date',
            'end' => 'required|date|after_or_equal:begin'
        ]);

        // create a new object
        $matchweek = new Matchweek($request->all());

        // save the season
        $matchweek->save();

        // flash success message and return competition name as test
        Session::flash('success', 'Spielwoche '.$matchweek->number_consecutive.' erfolgreich angelegt.');

        // return to index
        return redirect()->route('matchweeks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Matchweek  $matchweek
     * @return \Illuminate\Http\Response
     */
    public function show(Matchweek $matchweek)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Matchweek  $matchweek
     * @return \Illuminate\Http\Response
     */
    public function edit(Matchweek $matchweek)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Matchweek  $matchweek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matchweek $matchweek)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Matchweek  $matchweek
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matchweek $matchweek)
    {
        //
    }
}
