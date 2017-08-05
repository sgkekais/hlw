<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Matchweek;
use HLW\Season;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Excel;

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
    public function create(Season $season)
    {
        return view('admin.matchweeks.create', compact('season'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Season $season)
    {
        $this->validate($request, [
            'number_consecutive' => 'required|integer',
            'begin' => 'required|date',
            'end' => 'required|date|after_or_equal:begin'
        ]);

        // create a new object
        $matchweek = new Matchweek($request->all());

        // save the season
        $season->matchweeks()->save($matchweek);

        // flash success message and return competition name as test
        Session::flash('success', 'Spielwoche '.$matchweek->number_consecutive.' erfolgreich angelegt.');

        // return to index
        return redirect()->route('seasons.show', $season);
    }

    /**
     * Display the specified resource.
     *
     * @param  \HLW\Matchweek  $matchweek
     * @return \Illuminate\Http\Response
     */
    public function show(Season $season, Matchweek $matchweek)
    {
        $matchweek->load('fixtures.clubHome','fixtures.clubAway','fixtures.stadium', 'fixtures.rescheduledFrom', 'fixtures.rescheduledTo', 'fixtures.rescheduledBy');

        return view('admin.matchweeks.show', compact('season', 'matchweek'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \HLW\Matchweek  $matchweek
     * @return \Illuminate\Http\Response
     */
    public function edit(Season $season, Matchweek $matchweek)
    {
        return view('admin.matchweeks.edit',compact('season','matchweek'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \HLW\Matchweek  $matchweek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Season $season, Matchweek $matchweek)
    {
        $this->validate($request, [
            'number_consecutive' => 'required|integer',
            'begin' => 'required|date',
            'end' => 'required|date|after_or_equal:begin'
        ]);

        $matchweek->update($request->all());

        Session::flash('success','Spielwoche erfoglreich geändert.');

        return redirect()->route('seasons.show', $season);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \HLW\Matchweek  $matchweek
     * @return \Illuminate\Http\Response
     */
    public function destroy(Season $season, Matchweek $matchweek)
    {
        $matchweek->delete();

        Session::flash('success', 'Spielwoche erfolgreich gelöscht.');

        return redirect()->route('seasons.show', $season);
    }

    public function importCSV(Request $request, Season $season)
    {
        $importData = Excel::load($request->csvfile, function ($reader) {} )->get();

        foreach ($importData as $csvLine) {
            $season->matchweeks()->create([
                    'number_consecutive'    => $csvLine->number_consecutive,
                    'name'                  => $csvLine->name,
                    'begin'                 => $csvLine->begin,
                    'end'                   => $csvLine->end,
                    'published'             => $csvLine->published ?? '0'
                ]
            );
        }

        return redirect()->route('seasons.show', $season);
    }
}
