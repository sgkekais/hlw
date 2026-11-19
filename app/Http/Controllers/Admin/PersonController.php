<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Club;
use HLW\DivisionOfficial;
use HLW\Person;
use HLW\Support\PassportPhoto;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PersonController extends Controller
{
    /**
     * Passport photos: common image formats only (no SVG), at most 15 MB and
     * big enough for printing, they are optimized when stored.
     */
    const PHOTO_RULES = 'nullable|image|mimes:jpeg,png,webp|max:15360|dimensions:min_width=300,min_height=300';

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
        $people->load('players','contacts','referees', 'realDivision');

        $can_read_person = Auth::user()->can('read person') ? true : false;
        $can_update_person = Auth::user()->can('update person') ? true : false;

        return view('admin.people.index', compact('people', 'can_read_person', 'can_update_person'));
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
            'photo'         => self::PHOTO_RULES,
        ]);

        // the photo first, so an unreadable image does not leave a person behind
        $photo = $this->optimizedPhoto($request);

        $person = new Person($request->except('photo'));

        // save the model
        $person->save();

        // is there a photo? only an optimized copy is stored, see PassportPhoto
        $store_message = "";
        if($photo !== null)
        {
            $person->photo = PassportPhoto::store($photo, $person->id);
            $store_message = "Passbild erfoglreich hochgeladen. ";
            $person->save();
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
            'photo'         => self::PHOTO_RULES,
        ]);

        $photo = $this->optimizedPhoto($request);

        // update the changes
        $person->update($request->except('photo'));

        // is there a new photo selected? replace the old one
        if($photo !== null)
        {
            $old_photo = $person->photo;
            $person->photo = PassportPhoto::store($photo, $person->id);
            $person->save();
            PassportPhoto::delete($old_photo);
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

        // delete the model and the photo
        $photo = $person->photo;
        $person->delete();
        PassportPhoto::delete($photo);

        // return to index
        return redirect()->route('people.index')
            ->with('success', 'Person '.$first_name.' '.$last_name.' mit der ID '.$id.' gelöscht.');
    }

    /**
     * The optimized JPEG data of the uploaded photo, null without upload.
     */
    private function optimizedPhoto(Request $request): ?string
    {
        if (!$request->hasFile('photo')) {
            return null;
        }

        try {
            return PassportPhoto::optimize($request->file('photo')->getRealPath());
        } catch (RuntimeException $e) {
            throw ValidationException::withMessages([
                'photo' => 'Das Passbild konnte nicht verarbeitet werden. Bitte als JPEG oder PNG mit höchstens 30 Megapixeln speichern und erneut hochladen.',
            ]);
        }
    }
}
