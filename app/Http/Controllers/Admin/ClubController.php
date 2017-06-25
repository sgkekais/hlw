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

        // real club checkbox set?
        if($request->has('is_real_club')){
            $club->is_real_club = 1;
        }else{
            $club->is_real_club = 0;
        }
        // published checkbox set?
        if($request->has('published')){
            $club->published = 1;
        }else{
            $club->published = 0;
        }

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club)
    {
        //
    }
}
