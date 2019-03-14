<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Club;
use HLW\DivisionOfficial;
use HLW\Person;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PersonController extends Controller
{
    public function __construct()
    {
        // Permissions
        $this->middleware('permission:list people')->only('index');
        $this->middleware('permission:create person')->only([
            'create',
            'store']);
        $this->middleware('permission:read person')->only('show');
        $this->middleware('permission:update person')->only([
            'edit',
            'update'
        ]);
        $this->middleware('permission:delete person')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $people = Person::orderBy('last_name')->orderBy('first_name')->get();
        $people->load('players','contacts','referees');

        return view('admin.people.index', compact('people'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $real_clubs = Club::where('is_real_club', true)->orderBy('name')->get();
        $official_divisions = DivisionOfficial::orderBy('name')->get();

        return view('admin.people.create', compact('real_clubs', 'official_divisions'));
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
            'first_name'    => 'required|min:2',
            'last_name'     => 'required|min:2',
            'date_of_birth' => 'nullable|date',
            'photo'         => 'nullable|image|mimes:png,jpg,jpeg'
        ]);

        $person = new Person($request->all());

        // save the model
        $person->save();

        // is there a photo?
        $store_message = "";
        if($request->hasFile('photo'))
        {
            // store the uploaded logo and save the path to the logo in the database
            if ($request->file('photo')->store('public/passportphotos/'.$person->id)) {
                $photo_path = 'passportphotos/'.$person->id.'/'.$request->file('photo')->hashName();
                $person->photo = $photo_path;
                $store_message = "Passbild erfoglreich hochgeladen. ";
                // save the club again
                $person->save();
            }
        }

        return redirect()->route('people.index')
            ->with('success','Person '.$person->first_name." ".$person->last_name." erfolgreich mit der ID ".$person->id." angelegt".($store_message ? " und Passbild hochgeladen " : null).".");
    }

    /**
     * Display the specified resource.
     *
     * @param  \HLW\Person  $person
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
     * @param  \HLW\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        $real_clubs = Club::where('is_real_club', true)->orderBy('name')->get();
        $official_divisions = DivisionOfficial::orderBy('name')->get();

        return view('admin.people.edit', compact('person', 'real_clubs', 'official_divisions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \HLW\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        $this->validate($request, [
            'first_name'    => 'required|min:2',
            'last_name'     => 'required|min:2',
            'date_of_birth' => 'nullable|date',
            'photo'         => 'nullable|image|mimes:png,jpg,jpeg'
        ]);

        // update the changes
        $person->update($request->all());

        // is there a new photo selected?
        if($request->hasFile('photo'))
        {
            // then delete the old logo
            Storage::delete($person->photo);#

            // store the uploaded logo and save the path to the logo in the database
            if ($request->file('photo')->store('public/passportphotos/'.$person->id)) {
                $photo_path = 'passportphotos/'.$person->id.'/'.$request->file('photo')->hashName();
                $person->photo = $photo_path;
                $store_message = "Passbild erfoglreich hochgeladen. ";
                // save the club again
                $person->save();
            }
        }

        return redirect()->route('people.index')
            ->with('success','Person '.$person->first_name.' '.$person->last_name.' erfolgreich geändert.');
    }

    /**
     * Remove the specified resource from storage.
     * @param Person $person
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Person $person)
    {
        $first_name = $person->first_name;
        $last_name = $person->last_name;
        $id = $person->id;

        // delete the model
        $person->delete();

        // return to index
        return redirect()->route('people.index')
            ->with('success', 'Person '.$first_name.' '.$last_name.' mit der ID '.$id.' gelöscht.');
    }
}
