<?php

namespace App\Http\Controllers\Admin;

use App\Stadium;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class StadiumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stadiums = Stadium::all();

        return view('admin.stadiums.index', compact('stadiums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.stadiums.create');
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
            'name_short' => 'required|min:2',
            'gmaps' => 'nullable|url'
        ]);

        $stadium = new Stadium($request->all());

        $stadium->save();

        Session::flash('success', 'Spielort '.$stadium->name_short.' erfolgreich angelegt.');

        return redirect()->route('stadiums.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stadium  $stadium
     * @return \Illuminate\Http\Response
     */
    public function show(Stadium $stadium)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stadium  $stadium
     * @return \Illuminate\Http\Response
     */
    public function edit(Stadium $stadium)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stadium  $stadium
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stadium $stadium)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stadium  $stadium
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stadium $stadium)
    {
        //
    }
}
