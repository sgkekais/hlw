<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Competition;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CompetitionController extends Controller
{
    /**
     * Assign permission middleware to specific actions
     * CompetitionController constructor.
     */
    public function __construct()
    {
        // Permissions
        $this->middleware('permission:list competitions')->only('index');
        $this->middleware('permission:create competition')->only([
            'create',
            'store']);
        $this->middleware('permission:read competition')->only('show');
        $this->middleware('permission:update competition')->only([
            'edit',
            'update'
        ]);
        $this->middleware('permission:delete competition')->only('destroy');
    }

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
     * @param  \HLW\Competition  $competition
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
     * @param  \HLW\Competition  $competition
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
     * @param  \HLW\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competition $competition)
    {
        // validate the input data
        $this->validate($request, [
            'name' => 'required|min:4'
        ]);

        // update the model
        $competition->update($request->all());

        // flash success message
        Session::flash('success', 'Wettbewerb '.$competition->name.' erfolgreich geändert.');

        // redirect to updated competition
        return redirect()->route('competitions.show', $competition);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \HLW\Competition  $competition
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
