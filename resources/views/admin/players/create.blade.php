@extends('admin.adminlayout')

@section('content')

    <!-- create a new player and assign to club and person -->
    <h1 class="mb-4">Spieler anlegen</h1>
    <p>
        Ein Spieler ist eine Person, die in einem bestimmten Zeitraum für eine Mannschaft spielt. Die Person muss zuvor angelegt werden. Sollte eine Person den Verein wechseln, so ist hier das Austrittsdatum zu vermerken und anschließend ein neuer Spieler anzulegen.
    </p>
    <form method="POST" action="{{ route('players.store', $club) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <!-- which person is this? -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="person_id">Person</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="person_id" name="person_id" aria-describedby="person_idHelp">
                    @foreach($people as $person)
                        <option value="{{ $person->id }}">{{ $person->last_name }}, {{ $person->first_name }}</option>
                    @endforeach
                </select>
                <small id="person_idHelp" class="form-text text-muted">Um welche Person handelt es sich?</small>
            </div>
        </div>
        <!-- club -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="club_id">Mannschaft</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="club_id" aria-describedby="club_idHelp" value="{{ $club->name }}" disabled>
                <small id="club_idHelp" class="form-text text-muted">Welcher Mannschaft soll der Spieler zugeordnet werden?</small>
            </div>
        </div>
        <!-- sign on and off -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="sign_on">Anmeldung</label>
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control" name="sign_on" id="sign_on" aria-describedby="sign_onHelp" placeholder="{{ old('sign_on') }}">
                <small id="sign_onHelp" class="form-text text-muted">JJJJ-MM-TT</small>
            </div>
            <div class="col-md-2">
                <label for="sign_off">Abmeldung</label>
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control" name="sign_off" id="sign_off" aria-describedby="sign_offHelp" placeholder="{{ old('sign_off') }}">
                <small id="sign_offHelp" class="form-text text-muted">JJJJ-MM-TT</small>
            </div>
        </div>
        <!-- number -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="number">Rückennummer</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="number" id="number" aria-describedby="numberHelp" placeholder="{{ old('number') }}">
                <small id="numberHelp" class="form-text text-muted">Alphanumerisch (alles erlaubt...)</small>
            </div>
            <div class="col-md-2">
                <label for="positions_id">Position</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="position_id" name="position_id" aria-describedby="position_idHelp">
                    <option></option>
                    @foreach($positions as $position)
                        <option value="{{ $position->id }}">
                            {{ $position->name }}
                        </option>
                    @endforeach
                </select>
                <small id="positions_idHelp" class="form-text text-muted">Welche Position hat der Spieler?</small>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Anlegen</button>
            <a class="btn btn-secondary" href="{{ route('clubs.show', $club) }}"><span class="fa fa-ban"></span> Abbrechen</a>
        </div>
    </form>

@endsection