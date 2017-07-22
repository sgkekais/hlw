@extends('admin.adminlayout')

@section('content')

    <!-- create a new card for a fixture -->
    <h1 class="mb-4">Karte eintragen</h1>
    <form method="POST" action="{{ route('fixtures.cards.store', $fixture ) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <!-- fixture -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="fixture">Für Paarung</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="fixture" aria-describedby="fixtureHelp" value="({{ $fixture->id }}) {{ $fixture->datetime->toDateString() }} - {{ $fixture->club_home->name_short }} vs. {{ $fixture->club_away->name_short }}" disabled>
                <small id="matchweek_idHelp" class="form-text text-muted">Zuordnung zu welcher Paarung?</small>
            </div>
        </div>
        <!-- Spieler -->
        <div class="form-group row">
            <label for="player_id" class="col-md-2 col-form-label">Spieler</label>
            <div class="col-md-4">
                <select class="form-control" aria-describedby="player_idHelp" name="player_id" id="player_id">
                    @foreach($players as $player)
                        <option value="{{ $player->id }}">{{ $player->club->name_short }} | {{ $player->person->last_name}}, {{ $player->person->first_name }}</option>
                    @endforeach
                </select>
                <small id="player_idHelp" class="form-text text-muted">Welcher Spieler?</small>
            </div>
        </div>
        <!-- color of the card -->
        <div class="form-group row">
            <label for="color" class="col-md-2 col-form-label">Farbe</label>
            <div class="col-md-4">
                <select class="form-control" aria-describedby="colorHelp" name="color" id="color">
                    <option>Gelb</option>
                    <option>Gelb/Rot</option>
                    <option>Rot</option>
                </select>
                <small id="stadium_idHelp" class="form-text text-muted">Welche Art von Platzverweis?</small>
            </div>
        </div>
        <!-- bans -->
        <div class="form-group row">
            <label for="ban_matches" class="col-md-2 col-form-label">Anzahl Spiele</label>
            <div class="col-md-2">
                <input type="number" class="form-control" aria-describedby="ban_matchesHelp" name="ban_matches" id="ban_matches">
                <small id="ban_matchesHelo" class="form-text text-muted">Länge der Sperre als Spielanzahl</small>
            </div>
            <label for="ban_season" class="col-md-2 col-form-label">Saisonsperre</label>
            <div class="col-md-2">
                <select class="form-control" name="ban_season" id="ban_season" aria-describedby="ban_seasonHelp">
                    <option value="0">Nein</option>
                    <option value="1">Ja</option>
                </select>
                <small id="ban_seasonHelp" class="form-text text-muted">Spieler für gesamte laufende Saison gesperrt?</small>
            </div>
            <label for="ban_lifetime" class="col-md-2 col-form-label">Auf Lebenszeit</label>
            <div class="col-md-2">
                <select class="form-control" name="ban_lifetime" id="ban_lifetime" aria-describedby="ban_lifetimeHelp">
                    <option value="0">Nein</option>
                    <option value="1">Ja</option>
                </select>
                <small id="ban_lifetimeHelp" class="form-text text-muted">Spieler auf Lebenszeit gesperrt?</small>
            </div>
        </div>
        <!-- note -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="note">Notiz</label>
            </div>
            <div class="col-md-4">
                <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp">{{ old('note') }}</textarea>
                <small id="noteHelp" class="form-text text-muted">Interne Notiz</small>
            </div>
        </div>
        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Eintragen</button>
        <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]) }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection