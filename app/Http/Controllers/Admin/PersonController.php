<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use App\Person;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $people = Person::orderBy('last_name')->orderBy('first_name')->get();

        return view('admin.people.index', compact('people'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $real_clubs = Club::where('is_real_club', true)->get();

        return view('admin.people.create', compact('real_clubs'));
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
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'date_of_birth' => 'nullable|date'
        ]);

        $person = new Person($request->all());

        $person->save();

        Session::flash('success','Person '.$person->first_name." ".$person->last_name." erfolgreich mit der ID ".$person->id." angelegt.");

        return redirect()->route('people.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        $person->load('players','referees','contacts');

        return view('admin.people.show', compact('person'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        $real_clubs = Club::where('is_real_club', true)->get();

        return view('admin.people.edit', compact('person', 'real_clubs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        $this->validate($request, [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'date_of_birth' => 'nullable|date'
        ]);

        $person->update($request->all());

        Session::flash('success','Person '.$person->first_name.' '.$person->last_name.' erfolgreich geändert.');

        return redirect()->route('people.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        $first_name = $person->first_name;
        $last_name = $person->last_name;
        $id = $person->id;

        // delete the model
        $person->delete();

        // flash message
        Session::flash('success', 'Person '.$first_name.' '.$last_name.' mit der ID '.$id.' gelöscht.');

        // return to index
        return redirect()->route('people.index');
    }
}
