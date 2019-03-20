@extends('admin.adminlayout')

@section('content')

    <!-- edit a card -->
    <h1 class="">Karte</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $card->color }}e Karte für {{ $card->player->person->last_name }}, {{ $card->player->person->first_name }}</h2>
    <!-- created at -->
    Angelegt: {{ $card->created_at->format('d.m.Y H:i') }} Uhr
    @if($causer = ModelHelper::causerOfAction($card,'created'))
        von {{ $causer->name }}
    @endif
    <br>
    <!-- updated at -->
    @if($card->updated_at != $card->created_at)
        Geändert: {{ $card->updated_at->format('d.m.Y H:i') }} Uhr
        @if($causer = ModelHelper::causerOfAction($card,'updated'))
            von {{ $causer->name }}
        @endif
    @endif
    <hr>
    <h3 class="mt-4 mb-4">Karte ändern</h3>
    <form method="POST" action="{{ route('fixtures.cards.update', [ $fixture, $card ] ) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <!-- fixture -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="fixture">Für Paarung</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="fixture" aria-describedby="fixtureHelp" value="({{ $fixture->id }}) {{ $fixture->datetime ? $fixture->datetime->toDateString() : null }} - {{ $fixture->clubHome->name_short }} vs. {{ $fixture->clubAway->name_short }}" disabled>
                <small id="card_idHelp" class="form-text text-muted">Zuordnung zu welcher Paarung?</small>
            </div>
        </div>
        <!-- Spieler -->
        <div class="form-group row">
            <label for="player_id" class="col-md-2 col-form-label">Spieler</label>
            <div class="col-md-4">
                <select class="form-control" aria-describedby="player_idHelp" name="player_id" id="player_id">
                    @foreach($players as $player)
                        <option value="{{ $player->id }}" {{ $player->id === $card->player_id ? "selected" : null }}>{{ $player->club->name_short }} | {{ $player->person->last_name}}, {{ $player->person->first_name }}</option>
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
                    <option value="yellow" {{ $card->color == "gelb" ? "selected" : null }}>Gelb</option>
                    <option value="yellow-red" {{ $card->color == "gelb-rot" ? "selected" : null }}>Gelb/Rot</option>
                    <option value="red" {{ $card->color == "rot" ? "selected" : null }}>Rot</option>
                </select>
                <small id="stadium_idHelp" class="form-text text-muted">Welche Art von Platzverweis?</small>
            </div>
        </div>
        <!-- bans -->
        <div class="form-group row">
            <label for="ban_matches" class="col-md-2 col-form-label">Anzahl Spiele</label>
            <div class="col-md-2">
                <input type="number" class="form-control" aria-describedby="ban_matchesHelp" name="ban_matches" id="ban_matches" value="{{ $card->ban_matches }}">
                <small id="ban_matchesHelo" class="form-text text-muted">Länge der Sperre als Spielanzahl</small>
            </div>
            <label for="ban_season" class="col-md-2 col-form-label">Saisonsperre</label>
            <div class="col-md-2">
                <select class="form-control" name="ban_season" id="ban_season" aria-describedby="ban_seasonHelp">
                    <option value="0">Nein</option>
                    <option value="1" {{ $card->ban_season ? "selected" : null }}>Ja</option>
                </select>
                <small id="ban_seasonHelp" class="form-text text-muted">Spieler für gesamte laufende Saison gesperrt?</small>
            </div>
            <label for="ban_lifetime" class="col-md-2 col-form-label">Auf Lebenszeit</label>
            <div class="col-md-2">
                <select class="form-control" name="ban_lifetime" id="ban_lifetime" aria-describedby="ban_lifetimeHelp">
                    <option value="0">Nein</option>
                    <option value="1" {{ $card->ban_lifetime ? "selected" : null }}>Ja</option>
                </select>
                <small id="ban_lifetimeHelp" class="form-text text-muted">Spieler auf Lebenszeit gesperrt?</small>
            </div>
        </div>
        <!-- reduce ban by number of games -->
        <div class="form-group row">
            <label for="ban_reduced_by" class="col-md-2 col-form-label">Sperre reduzieren</label>
            <div class="col-md-2">
                <input type="number" class="form-control" aria-describedby="ban_reduced_byHelp" name="ban_reduced_by" id="ban_reduced_by" value="{{ $card->ban_reduced_by }}">
                <small id="ban_reduced_byHelp" class="form-text text-muted">Länge der Sperre reduzieren</small>
            </div>
        </div>
        <div class="form-group">
        @foreach ($divisions as $division)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $division->id }}" id="role{{ $loop->iteration }}" name="divisions[]" {{ $card->divisions->contains($division->id) ? "checked" : null }}>
                <label class="form-check-label" for="role{{ $loop->iteration }}">
                    {{ $division->competition->name }} | {{ $division->name }}
                </label>
            </div>
        @endforeach
        </div>
        <!-- ban reason and note -->
        <div class="form-group row">
            <label for="ban_reason" class="col-md-2 col-form-label">Grund</label>
            <div class="col-md-4">
                <textarea class="form-control" id="ban_reason" name="ban_reason" rows="3" aria-describedby="ban_reasonHelp">{{ $card->ban_reason }}</textarea>
                <small id="ban_reasonHelp" class="form-text text-muted">Grund für Sperre</small>
            </div>
            <label for="note" class="col-md-2 col-form-label">Notiz</label>
            <div class="col-md-4">
                <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp">{{ $card->note }}</textarea>
                <small id="noteHelp" class="form-text text-muted">Interne Notiz</small>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Ändern</button>
        <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]) }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>
    <hr>
    <h3 class="mt-4">Karte löschen</h3>
    <form method="POST" action="{{ route('fixtures.cards.destroy', [$fixture, $card]) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <span class="form-text">Löscht die Karte.</span>
        <br>
        @can('delete card')
            <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> Löschen</button>
            <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]) }}"><span class="fa fa-ban"></span> Abbrechen</a>
        @else
            Keine Berechtigung.
        @endcan
    </form>

@endsection