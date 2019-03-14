<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Fixture;
use HLW\Matchweek;
use HLW\Referee;
use HLW\Season;
use HLW\Stadium;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Excel;
use Illuminate\Support\Facades\Storage;

class FixtureController extends Controller
{
    /**
     * Assign permission middleware to specific actions
     * CardController constructor.
     */
    public function __construct()
    {
        // Permissions
        $this->middleware('permission:list fixtures')->only('index');
        $this->middleware('permission:create fixture')->only([
            'create',
            'store']);
        $this->middleware('permission:read fixture')->only('show');
        $this->middleware('permission:update fixture')->only([
            'edit',
            'update'
        ]);
        $this->middleware('permission:delete fixture')->only('destroy');

        // Referee permissions
        $this->middleware('permission:create referee_assignment')->only([
            'createRefereeAssignment',
            'storeRefereeAssignment'
        ]);
        $this->middleware('permission:update referee_assignment')->only([
            'editRefereeAssignment',
            'updateRefereeAssignment'
        ]);
        $this->middleware('permission:delete referee_assignment')->only('destroyRefereeAssignment');

        // Match Report
        $this->middleware('permission:create matchreport')->only('storeMatchReport');
        $this->middleware('permission:delete matchreport')->only('deleteMatchReport');
    }

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
     * @param Matchweek $matchweek
     * @param Fixture $fixture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Matchweek $matchweek, Fixture $fixture)
    {
        // get all clubs of the season
        $clubs = $matchweek->season->clubs->sortBy('name');
        // get all stadiums
        $stadiums = Stadium::published()->orderBy('name')->get();

        return view('admin.fixtures.create', compact('matchweek', 'clubs', 'stadiums', 'fixture'));

    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Matchweek $matchweek)
    {
        $this->validate($request, [
            'datetime'          => 'nullable|date',
            'stadium_id'        => 'nullable',
            'club_id_home'      => 'nullable',
            'club_id_home_alt_text' => 'nullable',
            'club_id_away'      => 'nullable',
            'club_id_away_alt_text' => 'nullable',
            'goals_home'        => 'nullable|integer|min:0',
            'goals_away'        => 'nullable|integer|min:0',
            'goals_home_11m'    => 'nullable|integer|min:0',
            'goals_away_11m'    => 'nullable|integer|min:0',
            'goals_home_rated'  => 'nullable|integer|min:0',
            'goals_away_rated'  => 'nullable|integer|min:0'
        ]);

        $fixture = new Fixture($request->all());

        $matchweek->fixtures()->save($fixture);

        // is this a rescheduled fixture? Then set counts_in_tables for the old fixture to 0
        $old_fixture = null;
        if ($request->filled('rescheduled_from_fixture_id')) {
            $old_fixture = Fixture::find($request->rescheduled_from_fixture_id);
            $old_fixture->counts_in_tables = 0;
            $old_fixture->save();
            $old = true;
        }

        return redirect()->route('seasons.matchweeks.show', [$matchweek->season, $matchweek])
            ->with('success', 'Paarung erfolgreich angelegt.'.($old_fixture ? "Paarung ".$old_fixture->id." wird nicht mehr in der Tabelle berücksichtigt." : null ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \HLW\Fixture $fixture
     * @return \Illuminate\Http\Response
     */
    public function show(Matchweek $matchweek, Fixture $fixture)
    {
        return view('admin.fixtures.show', compact('matchweek', 'fixture'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \HLW\Fixture $fixture
     * @return \Illuminate\Http\Response
     */
    public function edit(Matchweek $matchweek, Fixture $fixture)
    {
        // get all clubs of the season
        $clubs = $matchweek->season->clubs->sortBy('name');;
        // get all stadiums
        $stadiums = Stadium::published()->orderBy('name')->get();

        return view('admin.fixtures.edit', compact('matchweek', 'fixture', 'clubs', 'stadiums'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \HLW\Fixture $fixture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matchweek $matchweek, Fixture $fixture)
    {
        $this->validate($request, [
            'datetime'          => 'nullable|date',
            'stadium_id'        => 'nullable',
            'club_id_home'      => 'nullable',
            'club_id_home_alt_text' => 'nullable',
            'club_id_away'      => 'nullable',
            'club_id_away_alt_text' => 'nullable',
            'goals_home'        => 'nullable|integer|min:0',
            'goals_away'        => 'nullable|integer|min:0',
            'goals_home_11m'    => 'nullable|integer|min:0',
            'goals_away_11m'    => 'nullable|integer|min:0',
            'goals_home_rated'  => 'nullable|integer|min:0',
            'goals_away_rated'  => 'nullable|integer|min:0'
        ]);

        $fixture->update($request->all());

        return redirect()->route('seasons.matchweeks.show', [$matchweek->season, $matchweek])
            ->with('success', 'Paarung geändert');
    }

    /**
     * Remove the specified resource from storage.
     * @param Matchweek $matchweek
     * @param Fixture $fixture
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Matchweek $matchweek, Fixture $fixture)
    {
        $id = $fixture->id;

        // TODO: consider reschedule relationships
        $fixture->delete();

        return redirect()->route('seasons.matchweeks.show', [$matchweek->season, $matchweek])
            ->with('success', 'Paarung mit der id ' . $id . ' gelöscht.');
    }

    /**
     * @param Fixture $fixture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createRefereeAssignment(Fixture $fixture)
    {
        // determine the referees which are not assigned to the fixture, yet
        $all_referees = Referee::with('person')->get();
        $unassigned_referees = $all_referees->diff($fixture->referees);

        return view('admin.fixtures.createRefereeAssignment', compact('fixture', 'unassigned_referees'));
    }

    /**
     * @param Request $request
     * @param Fixture $fixture
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRefereeAssignment(Request $request, Fixture $fixture)
    {
        // get the referee
        $referee = Referee::find($request->referee_id);

        // store the assignment in the pivot table
        $fixture->referees()->attach($referee, [
            'note'      => $request->note,
            'confirmed' => $request->confirmed
        ]);

        Session::flash('success', 'Schiedsrichter ' . $referee->person->last_name . ', ' . $referee->person->first_name . 'erfolgreich zugeordnet.');

        return redirect()->route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]);
    }

    /**
     * @param Fixture $fixture
     * @param Referee $referee
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editRefereeAssignment(Fixture $fixture, Referee $referee)
    {
        // get the pivot values
        $referee = $fixture->referees->find($referee);

        return view('admin.fixtures.editRefereeAssignment', compact('fixture', 'referee'));
    }

    /**
     * @param Request $request
     * @param Fixture $fixture
     * @param Referee $referee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRefereeAssignment(Request $request, Fixture $fixture, Referee $referee)
    {
        // sync with existing pivot entry
        $fixture->referees()->updateExistingPivot($referee->id, [
            'note'      => $request->note,
            'confirmed' => $request->confirmed
        ]);

        Session::flash('success', 'Zuordnung erfolgreich geändert.');

        return redirect()->route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]);
    }

    /**
     * @param Fixture $fixture
     * @param Referee $referee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyRefereeAssignment(Fixture $fixture, Referee $referee)
    {
        // detach the stadium from the club
        $fixture->referees()->detach($referee);

        Session::flash('success', 'Schiedsrichterzuordnung erfolgreich entfernt.');

        return redirect()->route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]);
    }

    /**
     * TODO: messages, record number, progress
     * Import fixtures from csv-files
     * @param Request $request
     * @param Season $season
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importCSV(Request $request, Season $season)
    {
        $this->validate($request, [
            'csvfile' => 'required|file'
        ]);

        $importData = Excel::load($request->csvfile, function ($reader) {
        })->get();
        // TODO: number format -> string in csv?
        if ($number_of_records = $importData->count()) {
            // temporarily unguard the model to set id
            Fixture::unguard();
            foreach ($importData as $csvLine) {
                $fixture = Fixture::create([
                    'id'                => intval($csvLine->id),
                    'matchweek_id'      => $csvLine->matchweek_id ? intval($csvLine->matchweek_id) : null,
                    'datetime'          => $csvLine->datetime,
                    'stadium_id'        => $csvLine->stadium_id ? intval($csvLine->stadium_id) : null,
                    'club_id_home'      => $csvLine->club_id_home,
                    'club_id_away'      => $csvLine->club_id_away,
                    'goals_home'        => $csvLine->goals_home,
                    'goals_away'        => $csvLine->goals_away,
                    'goals_home_11m'    => $csvLine->goals_home_11m,
                    'goals_away_11m'    => $csvLine->goals_away_11m,
                    'goals_home_rated'  => $csvLine->goals_home_rated,
                    'goals_away_rated'  => $csvLine->goals_away_rated,
                    'rated_note'        => $csvLine->rated_note,
                    'cancelled'         => $csvLine->cancelled,
                    'note'              => $csvLine->note,
                    'published'         => $csvLine->published,
                    'rescheduled_from_fixture_id'   => $csvLine->rescheduled_from_fixture_id ? intval($csvLine->rescheduled_from_fixture_id) : null,
                    'rescheduled_by_club'   => $csvLine->rescheduled_by_club ? intval($csvLine->rescheduled_by_club) : null,
                    'reschedule_reason'     => $csvLine->reschedule_reason,
                    'reschedule_count'      => $csvLine->reschedule_count
                ]);
            }
            // reguard the model
            Fixture::reguard();
        }

        Session::flash('success', $number_of_records . ' Paarung(en) erfolreich importiert.');

        return redirect()->route('seasons.show', $season);
    }

    /**
     * Upload a match report
     * @param Request $request
     * @param Fixture $fixture
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeMatchReport(Request $request, Fixture $fixture)
    {
        $this->validate($request, [
            'match_report' => 'image'
        ]);

        // is there a report?
        if ($request->hasFile('match_report')) {
            // store the uploaded report and save the path to the report in the database
            if ($request->file('match_report')->store('public/matchreports/'.$fixture->id)) {
                $report_path = 'matchreports/'.$fixture->id.'/'.$request->file('match_report')->hashName();
                $fixture->match_report_url = $report_path;
                // save the club again
                $fixture->save();

                return redirect()->back()->with('success', 'Spielbericht erfoglreich hochgeladen.');
            }
        }

        return redirect()->back()->with('danger', 'Spielbericht konnte nicht hochgeladen werden.');
    }

    /**
     * Delete a match report
     * @param Fixture $fixture
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteMatchReport(Fixture $fixture)
    {
        if (Storage::delete($fixture->match_report_url)) {
            return redirect()->back->with('success', 'Spielbericht erfolgreich gelöscht.');
        }

        return redirect()->back()->with('danger', 'Spielbericht konnte nicht gelöscht werden.');
    }
}
