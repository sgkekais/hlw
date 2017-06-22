<?php

namespace App\Http\Controllers\Admin;

use App\Competition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $competitions = Competition::all();

        return view('admin.competitions.index', compact('competitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.competitions.create');
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
           'name' => 'required|min:4'
        ]);

        // create a new object
        $competition = new Competition($request->all());

        // published checkbox set?
        if($request->has('published')){
            $competition->published = 1;
        }else{
            $competition->published = 0;
        }

        // store the new object
        $competition->save();

        // flash success message
        Session::flash('success', 'Wettbewerb '.$competition->name.' erfolgreich angelegt.');

        // return to index
        return redirect()->route('competitions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition)
    {
        // eager load divisions
        $competition->load('divisions');

        return view('admin.competitions.show', compact('competition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function edit(Competition $competition)
    {
        return view('admin.competitions.edit', compact('competition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competition $competition)
    {
        // validate the input data
        $this->validate($request, [
            'name' => 'required|min:4'
        ]);

        $competition->name = $request->name;

        // published checkbox set?
        if($request->has('published')){
            $competition->published = 1;
        }else{
            $competition->published = 0;
        }

        // update the model
        $competition->save();

        // flash success message
        Session::flash('success', 'Wettbewerb '.$competition->name.' erfolgreich geändert.');

        return redirect()->route('competitions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competition $competition)
    {
        $name = $competition->name;
        $id = $competition->id;

        // delete the model
        $competition->delete();

        // flash message
        Session::flash('success', 'Wettbewerb '.$name.' mit der ID '.$id.' gelöscht.');

        // return to index
        return redirect()->route('competitions.index');
    }
}
