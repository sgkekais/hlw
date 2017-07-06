<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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
     * TODO: ignore checkbox for colors so that null is inserted into db
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|min:2',
            'name_short'    => 'nullable|min:2',
            'name_code'     => 'nullable|min:2',
            'founded'       => 'nullable|date',
            'league_entry'  => 'nullable|date',
            'league_exit'   => 'nullable|date|after_or_equal:league_entry',
            'website'       => 'nullable|url',
            'facebook'      => 'nullable|url',
            'logo'          => 'nullable|image|mimes:png'
        ]);

        // create a new object with the request data
        $club = new Club($request->all());

        // store the uploaded logo and save the path to the logo in the database
        $club->logo_url = $request->file('logo')->store('public/clublogos');

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
        // lazy eager load relationships
        $club->load('players','stadiums');

        return view('admin.clubs.show', compact('club'));
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
            'name'          => 'required|min:2',
            'name_short'    => 'nullable|min:2',
            'name_code'     => 'nullable|min:2',
            'founded'       => 'nullable|date',
            'league_entry'  => 'nullable|date',
            'league_exit'   => 'nullable|date|after_or_equal:league_entry',
            'website'       => 'nullable|url',
            'facebook'      => 'nullable|url',
            'logo'          => 'nullable|image|mimes:png'
        ]);

        // is there a new logo selected?
        if($request->hasFile('logo'))
        {
            // then delete the old logo
            Storage::delete($club->logo_url);
            // and save the new logo
            $club->logo_url = $request->file('logo')->store('public/clublogos');
            // save the club
            $club->save();
        }

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

        // delete the club logo first
        if($club->logo_url)
        {
            if(Storage::delete($club->logo_url))
            {
                $delete_message = "Vereinswappen vom Dateiserver gelöscht.";
            }
        }

        // then delete the club
        $club->delete();

        // flash message
        Session::flash('success', 'Mannschaft '.$name.' mit der ID '.$id.' gelöscht. '.$delete_message);

        // return to index
        return redirect()->route('clubs.index');
    }
}
