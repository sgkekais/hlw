@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <!-- edit the club -->
        <h1 class="mt-4">Spielerzuordnung</h1>
        <h2 class="mt-4 text-primary">&mdash; {{ $club->name }} / {{ $player->last_name }}, {{ $player->first_name }}</h2>
        <!-- created at -->
        Angelegt: {{ $player->pivot->created_at->format('d.m.Y H:i') }} Uhr
        <br>
        <!-- updated at -->
        @if($player->pivot->updated_at != $player->pivot->created_at)
            Geändert: {{ $club->updated_at->format('d.m.Y H:i') }} Uhr
        @endif
        <hr>
        <h3 class="mb-4">Spielerzuordnung bearbeiten</h3>
        <form method="POST" action="{{ route('players.update', [$club, $player]) }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <!-- which person is this? -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="person_id">Person</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="person_id" aria-describedby="person_idHelp" value="{{ $player->last_name }}, {{ $player->first_name }}" disabled>
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
                    <input type="date" class="form-control" name="sign_on" id="sign_on" aria-describedby="sign_onHelp" value="{{ $player->pivot->sign_on->format('Y-m-d') }}">
                    <small id="sign_onHelp" class="form-text text-muted">JJJJ-MM-TT</small>
                </div>
                <div class="col-md-2">
                    <label for="sign_off">Abmeldung</label>
                </div>
                <div class="col-md-4">
                    @if($player->pivot->sign_off)
                        <input type="date" class="form-control" name="sign_off" id="sign_off" aria-describedby="sign_offHelp" value="{{ $player->pivot->sign_off->format('Y-m-d') }}">
                    @else
                        <input type="date" class="form-control" name="sign_off" id="sign_off" aria-describedby="sign_offHelp" >
                    @endif
                    <small id="sign_offHelp" class="form-text text-muted">JJJJ-MM-TT</small>
                </div>
            </div>
            <!-- number -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="number">Rückennummer</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="number" id="number" aria-describedby="numberHelp" value="{{ $player->pivot->number }}">
                    <small id="numberHelp" class="form-text text-muted">Alphanumerisch (alles erlaubt...)</small>
                </div>
                <div class="col-md-2">
                    <label for="positions_id">Position</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="position_id" name="position_id" aria-describedby="position_idHelp">
                        <option></option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ $player->pivot->position_id == $position->id ? "selected" : null }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                    <small id="positions_idHelp" class="form-text text-muted">Welche Position hat der Spieler?</small>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Ändern</button>
                <a class="btn btn-secondary" href="{{ route('clubs.show', $club) }}">Abbrechen</a>
            </div>
        </form>
        <hr>
        <h3 class="mt-4">Spielerzuordnung löschen</h3>
        <form method="POST" action="{{ route('players.destroy', [$club, $player]) }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <span class="form-text">Löscht die Spieler<b>zuordnung</b>. Mannschaft und Person bleiben erhalten.</span>
            <br>
            <button type="submit" class="btn btn-danger">Löschen</button>
            <a class="btn btn-secondary" href="{{ route('clubs.show', $club) }}">Abbrechen</a>
        </form>
    </div>

@endsection