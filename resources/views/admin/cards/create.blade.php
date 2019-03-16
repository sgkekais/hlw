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
                <input type="text" class="form-control" name="fixture" aria-describedby="fixtureHelp" value="({{ $fixture->id }}) {{ $fixture->datetime->toDateString() }} - {{ $fixture->clubHome->name_short }} vs. {{ $fixture->clubAway->name_short }}" disabled>
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
                    <option value="yellow">Gelb</option>
                    <option value="yellow-red">Gelb/Rot</option>
                    <option value="red">Rot</option>
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
        <!-- reduce ban by number of games -->
        <div class="form-group row">
            <label for="ban_reduced_by" class="col-md-2 col-form-label">Sperre reduzieren</label>
            <div class="col-md-2">
                <input type="number" class="form-control" aria-describedby="ban_reduced_byHelp" name="ban_reduced_by" id="ban_reduced_by" value="0" >
                <small id="ban_reduced_byHelp" class="form-text text-muted">Länge der Sperre reduzieren</small>
            </div>
        </div>
        <div class="form-group">
            <h4>Spielklasse zuordnen</h4>
            Für welche Spielklassen soll die Sperre gelten?
            @if (!$divisions->isEmpty())
                @foreach ($divisions as $division)
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" name="divisions[]" type="checkbox" value="{{ $division->id }}" {{ $fixture->matchweek->season->division->id == $division->id ? "checked" : null  }}>
                                {{ $division->competition->name }} | {{ $division->name }}
                        </label>
                    </div>
                @endforeach
            @endif
        </div>
        <!-- ban reason and note -->
        <div class="form-group row">
            <label for="ban_reason" class="col-md-2 col-form-label">Grund</label>
            <div class="col-md-4">
                <textarea class="form-control" id="ban_reason" name="ban_reason" rows="3" aria-describedby="ban_reasonHelp">{{ old('ban_reason') }}</textarea>
                <small id="ban_reasonHelp" class="form-text text-muted">Grund für Sperre</small>
            </div>
            <label for="note" class="col-md-2 col-form-label">Notiz</label>
            <div class="col-md-4">
                <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp">{{ old('note') }}</textarea>
                <small id="noteHelp" class="form-text text-muted">Interne Notiz</small>
            </div>
        </div>
        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Eintragen</button>
        <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]) }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection