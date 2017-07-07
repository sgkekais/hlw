@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <!-- edit a match -->
        <h1 class="mt-4">Paarung</h1>
        <h2 class="mt-4 text-primary">&mdash; {{ $fixture->club_home ? $fixture->club_home->name : $fixture->club_id_home }} : {{ $fixture->club_away ? $fixture->club_away->name : $fixture->club_id_away }}</h2>
        <!-- created at -->
        Angelegt: {{ $matchweek->created_at->format('d.m.Y H:i') }} Uhr
        @if($causer = ModelHelper::causerOfAction($matchweek,'created'))
            von {{ $causer->name }}
        @endif
        <br>
        <!-- updated at -->
        @if($matchweek->updated_at != $matchweek->created_at)
            Geändert: {{ $matchweek->updated_at->format('d.m.Y H:i') }} Uhr
            @if($causer = ModelHelper::causerOfAction($matchweek,'updated'))
                von {{ $causer->name }}
            @endif
        @endif
        <hr>
        <h3 class="mt-4 mb-4">Paarung ändern</h3>
        <form method="POST" action="{{ route('matchweeks.fixtures.update', [$matchweek, $fixture]) }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <!-- matchweek -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="matchweek_id">Spielwoche</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="matchweek_id" aria-describedby="matchweek_idHelp" value="({{ $matchweek->id }}) Nr. {{ $matchweek->number_consecutive }} | {{ $matchweek->begin }} - {{ $matchweek->end }}" disabled>
                    <small id="matchweek_idHelp" class="form-text text-muted">Zuordnung zu welcher Spielwoche?</small>
                </div>
            </div>
            <!-- date and time -->
            <div class="form-group row">
                <label for="date" class="col-md-2 col-form-label">Datum</label>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="date" id="date" aria-describedby="dateHelp" value="{{ $fixture->date ? $fixture->date->format('Y-m-d') : "" }}">
                    <small id="dateHelp" class="form-text text-muted">im Format JJJJ-MM-TT</small>
                </div>
                <div class="col-md-2">
                    <label for="time">Uhrzeit</label>
                </div>
                <div class="col-md-4">
                    <input type="time" class="form-control" name="time" id="time" aria-describedby="timeHelp" value="{{ $fixture->time }}">
                    <small id="timeHelp" class="form-text text-muted">im Format HH:MM:SS</small>
                </div>
            </div>
            <!-- stadium -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="stadium_id">Spielort</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control" aria-describedby="stadium_idHelp" name="stadium_id" id="stadium_id">
                        <option></option>
                        @foreach($stadiums as $stadium)
                            <option value="{{ $stadium->id }}"
                                    @if($fixture->stadium)
                                        {{ $fixture->stadium->id == $stadium->id ? "selected" : null }}
                                    @endif
                            >
                                {{ $stadium->name }}
                            </option>
                        @endforeach
                    </select>
                    <small id="stadium_idHelp" class="form-text text-muted">Platz, auf dem das Spiel ausgetragen wird</small>
                </div>
            </div>
            <!-- home and away clubs -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="club_id_home">Heim</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control" name="club_id_home" id="club_id_home">
                        <option></option>
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}" {{ $fixture->club_id_home == $club->id ? "selected" : null }}>
                                {{ $club->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="club_id_away">Gast</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control" name="club_id_away" id="club_id_away">
                        <option></option>
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}" {{ $fixture->club_id_away == $club->id ? "selected" : null }}>
                                {{ $club->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- goals -->
            <div class="form-group row">
                <label for="goals_home" class="col-md-2 col-form-label">Tore - Heim</label>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="goals_home" id="goals_home" aria-describedby="goals_homeHelp" value="{{ $fixture->goals_home }}">
                    <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der Heimmannschaft</small>
                </div>
                <label for="goals_away" class="col-md-2 col-form-label">Tore - Gast</label>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="goals_away" id="goals_away" aria-describedby="goals_awayHelp" value="{{ $fixture->goals_away }}">
                    <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der Gastmannschaft</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="goals_home_11m" class="col-md-2 col-form-label">Tore - 11m - Heim</label>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="goals_home_11m" id="goals_home_11m" aria-describedby="goals_home_11mHelp" value="{{ $fixture->goals_home_11m }}">
                    <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der Heimmannschaft <b>im</b> Elfmeterschießen</small>
                </div>
                <label for="goals_away_11m" class="col-md-2 col-form-label">Tore - 11m - Gast</label>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="goals_away_11m" id="goals_away_11m" aria-describedby="goals_away_11mHelp" value="{{ $fixture->goals_away_11m }}">
                    <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der Gastmannschaft <b>im</b> Elfmeterschießen</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="goals_home_rated" class="col-md-2 col-form-label">Wertung - Heim</label>
                <div class="col-md-1">
                    <input type="number" class="form-control" name="goals_home_rated" id="goals_home_rated" aria-describedby="goals_home_ratedHelp" value="{{ $fixture->goals_home_rated }}">
                    <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der <b>Wertung</b> - Heim</small>
                </div>
                <label for="goals_away_rated" class="col-md-2 col-form-label">Wertung - Gast</label>
                <div class="col-md-1">
                    <input type="number" class="form-control" name="goals_away_rated" id="goals_away_rated" aria-describedby="goals_away_ratedHelp" value="{{ $fixture->goals_away_rated }}">
                    <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der <b>Wertung</b> - Heim</small>
                </div>
                <label for="rated_note" class="col-md-2 col-form-label">Begründung</label>
                <div class="col-md-4">
                    <textarea class="form-control" id="rated_note" name="rated_note" rows="3" aria-describedby="rated_noteHelp">{{ $fixture->rated_note }}</textarea>
                    <small id="rated_noteHelp" class="form-text text-muted">Warum wurde gewertet?</small>
                </div>
            </div>
            <!-- note -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="note">Notiz</label>
                </div>
                <div class="col-md-4">
                    <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp">{{ $fixture->note }}</textarea>
                    <small id="noteHelp" class="form-text text-muted">Interne Notiz</small>
                </div>
            </div>
            <!-- cancelled and published -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="cancelled">Annullierung?</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="cancelled" name="cancelled" aria-describedby="cancelledHelp">
                        <option value="0">Nein</option>
                        <option value="1">Ja</option>
                    </select>
                    <small id="publishedHelp" class="form-text text-muted">Wurde das Spiel annulliert?</small>
                </div>
                <div class="col-md-2">
                    <label for="published">Veröffentlichen?</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="published" name="published" aria-describedby="publishedHelp">
                        <option value="0">Nein</option>
                        <option value="1">Ja</option>
                    </select>
                    <small id="publishedHelp" class="form-text text-muted">Spielklasse auf Seite veröffentlichen?</small>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Ändern</button>
            <a class="btn btn-secondary" href="{{ route('seasons.matchweeks.show', [$matchweek->season, $matchweek]) }}">Abbrechen</a>
        </form>
        <hr>
        <h3 class="mt-4">Paarung löschen</h3>
        <form method="POST" action="{{ route('matchweeks.fixtures.destroy', [$matchweek, $fixture]) }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <span class="form-text">Löscht die Paarung.</span>
            <br>
            <button type="submit" class="btn btn-danger">Löschen</button>
            <a class="btn btn-secondary" href="{{ route('seasons.matchweeks.show', [$matchweek->season, $matchweek]) }}">Abbrechen</a>
        </form>
    </div>

@endsection