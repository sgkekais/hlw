<?php

namespace HLW\Http\Controllers\Admin;

use HLW\Club;
use HLW\Person;
use HLW\Player;
use HLW\Position;
use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use PDF;

class PlayerController extends Controller
{
    public function __construct()
    {
        // Permissions
        $this->middleware('permission:list players')->only('index');
        $this->middleware('permission:create club_player_assignment')->only([
            'create',
            'store']);
        $this->middleware('permission:read club_player_assignment')->only('show');
        $this->middleware('permission:update club_player_assignment')->only([
            'edit',
            'update'
        ]);
        $this->middleware('permission:delete club_player_assignment')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        $players = Player::with('person')->get();

        return $players;
    }

    /**
     * Show the form for creating a new resource.
     * @param Club $club
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Club $club)
    {
        /*$people = Person::active()->orderBy('last_name','asc')->orderBy('first_name','asc')->get();*/
        // doesnt work, compares player id with person id, should be player->person id with person id
        // $unassigned_people = $people->diff($club->players);
        $unassigned_people = Person::whereDoesntHave('players', function ($query) use ($club) {
            $query->where('club_id', $club->id);
        })
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->get();

        $positions  = Position::all();

        return view('admin.players.create', compact('club', 'unassigned_people', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Club $club)
    {
        $this->validate($request, [
            'sign_on' => 'required|date',
            'sign_off'=> 'nullable|date|after_or_equal:sign_on',
            'number'  => 'nullable|max:4'
        ]);

        $player = new Player($request->all());

        $club->players()->save($player);

        Session::flash('success', 'Spieler '.$player->person->last_name.', '.$player->person->first_name.' erfolgreich Mannschaft '.$club->name.' zugeordnet.');

        return redirect()->route('clubs.show', compact('club'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \HLW\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param Club $club
     * @param Player $player
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Club $club, Player $player)
    {
        $positions = Position::all();

        return view('admin.players.edit', compact('club', 'player','positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \HLW\Club $club
     * @param  \HLW\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club, Player $player)
    {
        $this->validate($request, [
            'sign_on' => 'required|date',
            'sign_off'=> 'nullable|date|after_or_equal:sign_on',
            'number'  => 'nullable|max:4'
        ]);

        $player->update($request->all());

        Session::flash('success', 'Spieler '.$player->person->first_name.' '.$player->person->last_name.' erfolgreich geändert.');

        return redirect()->route('clubs.show', compact('club'));
    }

    public function generatePlayerPassportDebug(Player $player) {

        $player->load([
            'person',
            'club'
        ]);

        return view('admin.players.playerPassport', compact('player'));
    }

    public function generatePlayerPassport() {

        $passport = PDF::loadView('admin.players.playerPassport');

        return $passport->setPaper('a5', 'landscape')->download('Pass.pdf');
    }

    /**
     * Remove the specified resource from storage.
     * @param Club $club
     * @param Player $player
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Club $club, Player $player)
    {
        $player->delete();

        return redirect()->route('clubs.show', $club)
            ->with('success', 'Zuordnung gelöscht.');
    }
}
