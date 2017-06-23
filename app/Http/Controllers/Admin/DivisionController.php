<?php

namespace App\Http\Controllers\Admin;

use App\Competition;
use App\Division;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = Division::all();

        return view('admin.divisions.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.divisions.create');
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
            'hierarchy_level' => 'required' // TODO: sollte unique sein fuer gleiche competition
        ]);

        // create a new object
        $division = new Division($request->all());
        return $division;
//        // published checkbox set?
//        if($request->has('published')){
//            $division->published = 1;
//        }else{
//            $division->published = 0;
//        }
//
//        // find the associated competiton and create new division
//        $competition = Competition::find($division->competition_id)->get();
//        $competition->divisions()->save($division);
//
//        // flash success message
//        Session::flash('success', 'Spielklasse '.$division->name.' erfolgreich angelegt und Wettbewerb '.$competition->name.' zugeordnet.');
//
//        // return to index
//        return redirect()->route('divisions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function show(Division $division)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Division $division)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy(Division $division)
    {
        //
    }
}
