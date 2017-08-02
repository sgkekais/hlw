<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Competition;
use HLW\Division;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

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
            'hierarchy_level' => 'required' // TODO: should be unique for one competition
        ]);

        // create a new object
        $division = new Division($request->all());

        // save the division
        $division->save();

        // flash success message and return competition name as test
        Session::flash('success', 'Spielklasse '.$division->name.' erfolgreich angelegt und Wettbewerb '.$division->competition->name.' zugeordnet.');

        // return to index
        return redirect()->route('divisions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \HLW\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function show(Division $division)
    {
        // eager load divisions
        $division->load('seasons');

        return view('admin.divisions.show', compact('division'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \HLW\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division)
    {
        return view('admin.divisions.edit', compact('division'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \HLW\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Division $division)
    {
        // validate the input data
        $this->validate($request, [
            'name' => 'required|min:4',
            'hierarchy_level' => 'required' // TODO: should be unique for one competition
        ]);

        // update the changes
        $division->update($request->all());

        // flash success message
        Session::flash('success', 'Spielklasse '.$division->name.' erfolgreich geändert.');

        // redirect to updated competition
        return redirect()->route('divisions.index', $division);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \HLW\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy(Division $division)
    {
        $name = $division->name;
        $id = $division->id;

        // delete the model
        $division->delete();

        // flash message
        Session::flash('success', 'Spielklasse '.$name.' mit der ID '.$id.' gelöscht.');

        // return to index
        return redirect()->route('divisions.index');
    }
}
