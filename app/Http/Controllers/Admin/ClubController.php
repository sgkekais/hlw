<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clubs = Club::all();

        return view('admin.clubs.index',compact('clubs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clubs.create');
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
            'name' => 'required|min:2',
            'name_short' => 'nullable|min:2',
            'name_code' => 'nullable|min:2',
            'founded' => 'nullable|date',
            'league_entry' => 'nullable|date',
            'league_exit' => 'nullable|date',
            'website' => 'nullable|url',
            'facebook' => 'nullable|url'
        ]);

        // create a new object
        $club = new Club($request->all());

        // save the club
        $club->save();

        // flash success message and return club name as test
        Session::flash('success', 'Mannschaft '.$club->name.' erfolgreich angelegt.');

        // return to index
        return redirect()->route('clubs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club)
    {
        return view('admin.clubs.edit', compact('club'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club)
    {
        $this->validate($request, [
            'name' => 'required|min:2',
            'name_short' => 'nullable|min:2',
            'name_code' => 'nullable|min:2',
            'founded' => 'nullable|date',
            'league_entry' => 'nullable|date',
            'league_exit' => 'nullable|date',
            'website' => 'nullable|url',
            'facebook' => 'nullable|url'
        ]);

        // save the remaining changes
        $club->update($request->all());

        // flash success message and return club name as test
        Session::flash('success', 'Mannschaft '.$club->name.' erfolgreich geändert.');

        // return to index
        return redirect()->route('clubs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club)
    {
        $name = $club->name;
        $id = $club->id;

        // delete the model
        $club->delete();

        // flash message
        Session::flash('success', 'Mannschaft '.$name.' mit der ID '.$id.' gelöscht.');

        // return to index
        return redirect()->route('clubs.index');
    }
}
