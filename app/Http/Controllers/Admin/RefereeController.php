<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Person;
use HLW\Referee;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

// TODO: Schiedsrichter evtl. nur änder-/löschbar machen, wenn keinem Spiel zugeordnet

class RefereeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $referees = Referee::all();

        return view('admin.referees.index', compact('referees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $people = Person::orderBy('last_name','asc')->orderBy('first_name','asc')->get();

        return view('admin.referees.create', compact('people'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ref = new Referee($request->all());

        $ref->save();

        Session::flash('success', 'Schiedsrichter erfolgreich angelegt.');

        return redirect()->route('referees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \HLW\Referee  $referee
     * @return \Illuminate\Http\Response
     */
    public function show(Referee $referee)
    {
        $referee->load('fixtures');

        return view('admin.referees.show', compact('referee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \HLW\Referee  $referee
     * @return \Illuminate\Http\Response
     */
    public function edit(Referee $referee)
    {
        $people = Person::orderBy('last_name','asc')->orderBy('first_name','asc')->get();

        return view('admin.referees.edit', compact('referee', 'people'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \HLW\Referee  $referee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Referee $referee)
    {
        $referee->update($request->all());

        Session::flash('success', 'Schiedsrichter erfolgreich geändert.');

        return redirect()->route('referees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \HLW\Referee  $referee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Referee $referee)
    {
        $referee->delete();

        Session::flash('success', 'Schiedsrichter erfolgreich gelöscht.');

        return redirect()->route('referees.index');
    }
}
