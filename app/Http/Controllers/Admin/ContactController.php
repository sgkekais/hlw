<?php

namespace App\Http\Controllers\Admin;

use App\Club;
use App\Contact;
use App\Person;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @param Club $club
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Club $club)
    {
        $people = Person::orderBy('last_name','asc')->orderBy('first_name','asc')->get();

        return view('admin.contacts.create', compact('club', 'people'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param Club $club
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Club $club)
    {
        $this->validate($request, [
            'hierarchy_level'   => 'nullable|integer|min:1',
            'mail'              => 'nullable|email',
            'mobile'            => 'nullable'
        ]);

        $contact = new Contact($request->all());

        $club->contacts()->save($contact);

        Session::flash('success', 'Kontakt angelegt');

        return redirect()->route('clubs.show', $club);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club, Contact $contact)
    {
        $people = Person::orderBy('last_name','asc')->orderBy('first_name','asc')->get();

        return view('admin.contacts.edit', compact('club', 'contact', 'people'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club, Contact $contact)
    {
        $this->validate($request, [
            'hierarchy_level'   => 'nullable|integer|min:1',
            'mail'              => 'nullable|email',
            'mobile'            => 'nullable'
        ]);

        $contact->update($request->all());

        Session::flash('success', 'Kontakt geändert.');

        return redirect()->route('clubs.show', $club);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club, Contact $contact)
    {
        $contact->delete();

        Session::flash('success', 'Kontakt gelöscht.');

        return redirect()->route('clubs.show', $club);
    }
}