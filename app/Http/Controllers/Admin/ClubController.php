<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Club;
use HLW\Stadium;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Excel;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clubs = Club::orderBy('name')->get();

        return view('admin.clubs.index',compact('clubs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clubs.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|min:2',
            'name_short'    => 'nullable|min:2',
            'name_code'     => 'nullable|min:2',
            'founded'       => 'nullable|date',
            'league_entry'  => 'nullable|date',
            'league_exit'   => 'nullable|date|after_or_equal:league_entry',
            'website'       => 'nullable|url',
            'facebook'      => 'nullable|url',
            'logo'          => 'nullable|image|mimes:png|dimensions:width=200,height=200'
        ]);

        // create a new object with the request data
        $club = new Club($request->all());

        // ignore checkbox set?
        if($request->has('ignore_kit_home'))
        {
            $club->colours_kit_home_primary     = null;
            $club->colours_kit_home_secondary   = null;
        }

        if($request->has('ignore_kit_away'))
        {
            $club->colours_kit_away_primary     = null;
            $club->colours_kit_away_secondary   = null;
        }

        // save the club to get the id
        $club->save();

        // is there a logo?
        $store_message = "";
        if ($request->hasFile('logo')) {
            // store the uploaded logo and save the path to the logo in the database
            if ($club->logo_url = $request->file('logo')->store('public/clublogos/'.$club->id)) {
                $store_message = "Vereinswappen erfoglreich hochgeladen. ";

                // save the club again
                $club->save();
            }
        }

        // is there a cover image?
        if ($request->hasFile('cover')) {
            if ($club->cover_url = $request->file('cover')->store('public/clubcovers/'.$club->id)) {
                $store_message .= " Cover erfolgreich hochgeladen.";

                $club->save();
            }
        }

        // flash success message and return club name as test
        Session::flash('success', 'Mannschaft '.$club->name.' erfolgreich angelegt. '.$store_message);

        // return to index
        return redirect()->route('clubs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \HLW\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club)
    {
        // lazy eager load relationships
        $club->load('seasons','players.person','contacts','stadiums');

        return view('admin.clubs.show', compact('club'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \HLW\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club)
    {
        return view('admin.clubs.edit', compact('club'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \HLW\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club)
    {
        $this->validate($request, [
            'name'          => 'required|min:2',
            'name_short'    => 'nullable|min:2',
            'name_code'     => 'nullable|min:2',
            'founded'       => 'nullable|date',
            'league_entry'  => 'nullable|date',
            'league_exit'   => 'nullable|date|after_or_equal:league_entry',
            'website'       => 'nullable|url',
            'facebook'      => 'nullable|url',
            'logo'          => 'nullable|image|mimes:png|dimensions:width=200,height=200'
        ]);

        // is there a new logo selected?
        if ($request->hasFile('logo')) {
            // then delete the old logo
            Storage::delete($club->logo_url);
            // and save the new logo
            $club->logo_url = $request->file('logo')->store('public/clublogos/'.$club->id);
            // save the club
            $club->save();
        }

        // is there a new cover selected?
        if ($request->hasFile('cover')) {
            // then delete the old logo
            Storage::delete($club->cover_url);
            // and save the new cover
            $club->cover_url = $request->file('cover')->store('public/clubcovers/'.$club->id);
            // save the club
            $club->save();
        }

        // update the remaining changes
        $club->update($request->all());

        // flash success message
        Session::flash('success', 'Mannschaft '.$club->name.' erfolgreich geändert.');

        // return to index
        return redirect()->route('clubs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \HLW\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club)
    {
        $name = $club->name;
        $id = $club->id;

        // delete the club logo first
        $delete_message = "";
        if ($club->logo_url) {
            if (Storage::delete($club->logo_url)) {
                $delete_message = "Vereinswappen vom Dateiserver gelöscht.";
            }
        }

        // delete the cover
        if ($club->cover_url) {
            if (Storage::delete($club->cover_url)) {
                $delete_message .= "Cover vom Dateiserver gelöscht.";
            }
        }

        // then delete the club
        $club->delete();

        // flash success message
        Session::flash('success', 'Mannschaft '.$name.' mit der ID '.$id.' gelöscht. '.$delete_message);

        // return to index
        return redirect()->route('clubs.index');
    }

    /**
     * Import clubs via .csv-files
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importCSV(Request $request)
    {
        $this->validate($request, [
            'csvfile' => 'required|file'
        ]);

        $importData = Excel::load($request->csvfile, function ($reader) {} )->get();

        if ($num_of_records = $importData->count()) {
            // temporarily unguard the model to be able to manually set the id
            Club::unguard();
            foreach ($importData as $csvLine) {
                $club = new Club([
                    'id'                        => $csvLine->id,
                    'name'                      => $csvLine->name,
                    'name_short'                => $csvLine->name_short,
                    'name_code'                 => $csvLine->name_code,
                    'founded'                   => $csvLine->founded,
                    'league_entry'              => $csvLine->league_entry,
                    'league_exit'               => $csvLine->league_exit,
                    'colours_club_primary'      => $csvLine->colours_club_primary,
                    'colours_club_secondary'    => $csvLine->colours_club_secondary,
                    'colours_kit_home_primary'  => $csvLine->colours_kit_home_primary,
                    'colours_kit_home_secondary'=> $csvLine->colours_kit_home_secondary,
                    'colours_kit_away_primary'  => $csvLine->colours_kit_away_primary,
                    'colours_kit_away_secondary'=> $csvLine->colours_kit_away_secondary,
                    'website'                   => $csvLine->website,
                    'facebook'                  => $csvLine->facebook,
                    'note'                      => $csvLine->note,
                    'is_real_club'              => $csvLine->is_real_club ?? "0",
                    'published'                 => $csvLine->published ?? "0"
                ]);

                $club->save();
            }
            // reguard the model
            Club::reguard();
        }

        Session::flash('success', $num_of_records.' Mannschaft(en) erfolreich importiert.');

        return redirect()->route('clubs.index');
    }

    /**
     * @param Club $club
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createStadiumAssignment(Club $club)
    {
        // determine the stadiums which are not assigned to the club, yet
        $all_stadiums           = Stadium::orderBy('name')->get();
        $unassigned_stadiums    = $all_stadiums->diff($club->stadiums);

        return view('admin.clubs.createStadiumAssignment', compact('club', 'unassigned_stadiums'));
    }

    /**
     * @param Request $request
     * @param Club $club
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeStadiumAssignment(Request $request, Club $club)
    {
        // get the stadium
        $stadium = Stadium::find($request->stadium_id);

        // store the assignment in the pivot table
        $club->stadiums()->attach($stadium, [
            'regular_home_day'      => $request->regular_home_day,
            'regular_home_time'     => $request->regular_home_time,
            'is_regular_stadium'    => $request->is_regular_stadium,
            'note'                  => $request->note
        ]);

        Session::flash('success', 'Stadion '.$stadium->name.'erfolgreich zugeordnet.');

        return redirect()->route('clubs.show', $club);
    }

    /**
     * @param Club $club
     * @param Stadium $stadium
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editStadiumAssignment(Club $club, Stadium $stadium)
    {
        // get the pivot values
        $stadium = $club->stadiums->find($stadium);

        return view('admin.clubs.editStadiumAssignment', compact('club', 'stadium'));
    }

    /**
     * @param Request $request
     * @param Club $club
     * @param Stadium $stadium
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStadiumAssignment(Request $request, Club $club, Stadium $stadium)
    {
        // sync with existing pivot entry
        $club->stadiums()->updateExistingPivot($stadium->id, [
            'regular_home_day'      => $request->regular_home_day,
            'regular_home_time'     => $request->regular_home_time,
            'is_regular_stadium'    => $request->is_regular_stadium,
            'note'                  => $request->note
        ]);

        Session::flash('success', 'Zuordnung erfolgreich geändert.');

        return redirect()->route('clubs.show', $club);
    }

    /**
     * @param Club $club
     * @param Stadium $stadium
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyStadiumAssignment(Club $club, Stadium $stadium)
    {
        // detach the stadium from the club
        $club->stadiums()->detach($stadium);

        Session::flash('success', 'Stadionzuordnung '.$stadium->name.'erfolgreich entfernt.');

        return redirect()->route('clubs.show', $club);
    }
}
