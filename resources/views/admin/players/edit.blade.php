@extends('admin.adminlayout')

@section('content')

<div class="container">
    <!-- edit a player -->
    <h1 class="mt-4 mb-4">Spieler</h1>
    <h2 class="mt-4 text-primary">&mdash;
        {{ $player->person->first_name }}
        {{ $player->person->last_name }} für
        {{ $player->club->name }}
    </h2>
    <!-- created at -->
    Angelegt: {{ $player->created_at->format('d.m.Y H:i') }} Uhr
    @if($causer = ModelHelper::causerOfAction($player,'created'))
        von {{ $causer->name }}
    @endif
    <br>
    <!-- updated at -->
    @if($player->updated_at != $player->created_at)
        Geändert: {{ $player->updated_at->format('d.m.Y H:i') }} Uhr
        @if($causer = ModelHelper::causerOfAction($player,'updated'))
            von {{ $causer->name }}
        @endif
    @endif
    <hr>
    <h3 class="mt-4 mb-4">Spieler bearbeiten</h3>
    <p>
        Ein Spieler ist eine Person, die in einem bestimmten Zeitraum für eine Mannschaft spielt. Die Person muss zuvor angelegt werden. Sollte eine Person den Verein wechseln, so ist hier das Austrittsdatum zu vermerken und anschließend ein neuer Spieler anzulegen.
    </p>
    <form method="POST" action="{{ route('players.update', $player) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <!-- which person is this? -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="person_id">Person</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="person_id" id="person_id" aria-describedby="person_idHelp" value="{{ $player->person->first_name }} {{ $player->person->last_name }}" disabled>
                <small id="person_idHelp" class="form-text text-muted">Um welche Person handelt es sich?</small>
            </div>
        </div>
        <!-- club -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="club_id">Mannschaft</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="club_id" id="club_id" aria-describedby="club_idHelp" value="{{ $player->club->name }}" disabled>
                <small id="club_idHelp" class="form-text text-muted">Welcher Mannschaft soll der Spieler zugeordnet werden?</small>
            </div>
        </div>
        <!-- sign on and off -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="sign_on">Anmeldung</label>
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control" name="sign_on" id="sign_on" aria-describedby="sign_onHelp" value="{{ $player->sign_on->format('Y-m-d') }}">
                <small id="sign_onHelp" class="form-text text-muted">JJJJ-MM-TT</small>
            </div>
            <div class="col-md-2">
                <label for="sign_off">Abmeldung</label>
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control" name="sign_off" id="sign_off" aria-describedby="sign_offHelp" value="{{ $player->sign_off ? $player->sign_off->format('Y-m-d') : null }}">
                <small id="sign_offHelp" class="form-text text-muted">JJJJ-MM-TT</small>
            </div>
        </div>
        <div class="form-group row">
            <!-- number -->
            <div class="col-md-2">
                <label for="number">Rückennummer</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="number" id="number" aria-describedby="numberHelp" value="{{ $player->number }}">
                <small id="numberHelp" class="form-text text-muted">Alphanumerisch (alles erlaubt...)</small>
            </div>
            <!-- position -->
            <div class="col-md-2">
                <label for="position_id">Position</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="position_id" name="position_id" aria-describedby="position_idHelp">
                    <option></option>
                    @foreach($positions as $position)
                        <option value="{{ $position->id }}" {{ $player->position == $position ? "selected" : null }}>
                            {{ $position->name }}
                        </option>
                    @endforeach
                </select>
                <small id="positions_idHelp" class="form-text text-muted">Welche Position hat der Spieler?</small>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Ändern</button>
            <a class="btn btn-secondary" href="{{ route('clubs.show', $player->club ) }}">Abbrechen</a>
        </div>
    </form>
</div>

@endsection