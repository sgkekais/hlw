<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Stadium;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class StadiumController extends Controller
{
    /**
     * Assign permission middleware to specific actions
     * StadiumController constructor.
     */
    public function __construct()
    {
        // Permissions
        $this->middleware('permission:list stadiums')->only('index');
        $this->middleware('permission:create stadium')->only([
            'create',
            'store']);
        $this->middleware('permission:read stadium')->only('show');
        $this->middleware('permission:update stadium')->only([
            'edit',
            'update'
        ]);
        $this->middleware('permission:delete stadium')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stadiums = Stadium::with('clubs')->orderBy('name')->get();

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
     * @param  \HLW\Stadium  $stadium
     * @return \Illuminate\Http\Response
     */
    public function show(Stadium $stadium)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \HLW\Stadium  $stadium
     * @return \Illuminate\Http\Response
     */
    public function edit(Stadium $stadium)
    {
        return view('admin.stadiums.edit', compact('stadium'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \HLW\Stadium  $stadium
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stadium $stadium)
    {
        $this->validate($request, [
            'name'          => 'required|min:2',
            'name_short'    => 'required|min:2',
            'gmaps'         => 'nullable|url'
        ]);

        $stadium->update($request->all());

        Session::flash('success', 'Spielort '.$stadium->name_short.' erfolgreich geändert.');

        return redirect()->route('stadiums.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \HLW\Stadium  $stadium
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stadium $stadium)
    {
        $stadium->delete();

        Session::flash('message', 'Spielort erfolgreich gelöscht.');

        return redirect()->route('stadiums.index');
    }

}
