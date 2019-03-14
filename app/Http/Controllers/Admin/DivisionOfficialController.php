<?php

namespace HLW\Http\Controllers\Admin;

use HLW\DivisionOfficial;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class DivisionOfficialController extends Controller
{
    /**
     * Assign permission middleware to specific actions
     * DivisionOfficialController constructor.
     */
    public function __construct()
    {
        // Permissions
        $this->middleware('permission:list divisions_official')->only('index');
        $this->middleware('permission:create division_official')->only([
            'create',
            'store']);
        $this->middleware('permission:update division_official')->only([
            'edit',
            'update'
        ]);
        $this->middleware('permission:delete division_official')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $official_divisions = DivisionOfficial::orderBy('name')->get();

        return view('admin.divisions_official.index', compact('official_divisions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.divisions_official.create');
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
            'name_short' => 'required'
        ]);

        // create a new object
        $official_division = new DivisionOfficial($request->all());

        // save the division
        $official_division->save();

        // flash success message and return competition name as test
        Session::flash('success', 'Off. Spielklasse '.$official_division->name.' erfolgreich angelegt.');

        // return to index
        return redirect()->route('divisions-official.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \HLW\DivisionOfficial  $divisionOfficial
     * @return \Illuminate\Http\Response
     */
    public function show(DivisionOfficial $divisionOfficial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \HLW\DivisionOfficial  $divisionOfficial
     * @return \Illuminate\Http\Response
     */
    public function edit(DivisionOfficial $divisionOfficial)
    {
        return view('admin.divisions_official.edit', compact('divisionOfficial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \HLW\DivisionOfficial  $divisionOfficial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DivisionOfficial $divisionOfficial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \HLW\DivisionOfficial  $divisionOfficial
     * @return \Illuminate\Http\Response
     */
    public function destroy(DivisionOfficial $divisionOfficial)
    {
        //
    }
}
