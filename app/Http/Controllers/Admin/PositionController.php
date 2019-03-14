<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Position;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PositionController extends Controller
{
    /**
     * Assign permission middleware to specific actions
     * PositionController constructor.
     */
    public function __construct()
    {
        // Permissions
        $this->middleware('permission:list positions')->only('index');
        $this->middleware('permission:create position')->only([
            'create',
            'store']);
        $this->middleware('permission:update position')->only([
            'edit',
            'update'
        ]);
        $this->middleware('permission:delete position')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::all();

        return view('admin.positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.positions.create');
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
            'name' => 'required|min:2'
        ]);

        $position = new Position($request->all());

        $position->save();

        Session::flash('success', 'Position '.$position->name.' erfolgreich angelegt.');

        return redirect()->route('positions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \HLW\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        return view('admin.positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \HLW\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        return view('admin.positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \HLW\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        $this->validate($request, [
            'name' => 'required|min:2'
        ]);

        $position->update($request->all());

        Session::flash('success', 'Position '.$position->name.' erfolgreich geändert.');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \HLW\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        $id = $position->id;
        $name = $position->name;

        $position->delete();

        Session::flash('success', 'Position '.$name.' mit ID '.$id.' erfolgreich gelöscht.');

        return redirect()->route('positions.index');
    }
}
