<?php

namespace App\Http\Controllers\Admin;

use App\Club;
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
        $this->validate($request, [
            'begin' => 'required|date',
            'end' => 'required|date|after_or_equal:begin',
            'max_rescheduling' => 'nullable|integer|min:1'
        ]);

        // create a new object
        $season = new Season($request->all());

        // save the season
        $season->save();

        // flash success message and return competition name as test
        Session::flash('success', 'Saison '.$season->begin.' / '.$season->end.' erfolgreich angelegt und Wettbewerb '.$season->division->name.' zugeordnet.');

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
        $season->load('matchweeks','clubs');

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
            'begin' => 'required|date',
            'end' => 'required|date|after_or_equal:begin',
            'max_rescheduling' => 'nullable|integer|min:1'
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
        $year_begin = $season->year_begin;
        $year_end = $season->year_end;
        $id = $season->id;

        // delete the model
        $season->delete();

        // flash message
        Session::flash('success', 'Saison '.$year_begin.'/'.$year_end.' mit der ID '.$id.' gelöscht.');

        // return to index
        return redirect()->route('seasons.index');
    }

    /*************************************************************/

    /**
     * Show the form for assigning a new club to a specific season
     * @param Season $season
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createClubAssignment(Season $season)
    {
        // determine the clubs (not real clubs!) which are not assigned to the season, yet
        $all_clubs          = Club::IsNotRealClub()->get();
        $unassigned_clubs = $all_clubs->diff($season->clubs);

        return view('admin.seasons.createClubAssignment', compact('season', 'unassigned_clubs'));
    }

    public function storeClubAssignment(Request $request, Season $season)
    {
        $this->validate($request, [
            'rank'              => 'nullable|integer|min:1',
            'deduction_points'  => 'nullable|integer|min:1',
            'deduction_goals'   => 'nullable|integer|min:1',
            'withdrawal'        => 'nullable|date'
        ]);

        // get the club
        $club = Club::find($request->club_id);

        // store the assignment in the pivot table
        $season->clubs()->attach($club, [
            'rank'              => $request->rank,
            'deduction_points'  => $request->deduction_points,
            'deduction_goals'   => $request->deduction_goals,
            'withdrawal'        => $request->withdrawal,
            'note'              => $request->note
        ]);

        Session::flash('success', 'Mannschaft '.$club->name.'erfolgreich zugeordnet.');

        return redirect()->route('seasons.show', $season);
    }

    public function editClubAssignment(Season $season, Club $club)
    {
        // get the pivot values
        $club = $season->clubs->find($club);

        return view('admin.seasons.editClubAssignment', compact('season','club'));
    }

    public function updateClubAssignment(Request $request, Season $season, Club $club)
    {
        $this->validate($request, [
            'rank'              => 'nullable|integer|min:1',
            'deduction_points'  => 'nullable|integer|min:1',
            'deduction_goals'   => 'nullable|integer|min:1',
            'withdrawal'        => 'nullable|date'
        ]);

        // sync with existing pivot entry
        $season->clubs()->updateExistingPivot($club->id, [
            'rank'              => $request->rank,
            'deduction_points'  => $request->deduction_points,
            'deduction_goals'   => $request->deduction_goals,
            'withdrawal'        => $request->withdrawal,
            'note'              => $request->note
        ]);

        Session::flash('success', 'Zuordnung erfolgreich geändert.');

        return redirect()->route('seasons.show', $season);
    }
}
