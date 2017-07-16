@extends('admin.adminlayout')

@section('content')

    <!-- create a new fixture -->
    <h1 class="mb-4">Paarung anlegen</h1>
    <form method="POST" action="{{ route('matchweeks.fixtures.store', $matchweek) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <!-- only show if rescheduling -->
        @if($fixture->id)
            <h2 class="mb-4">Spiel wird verlegt</h2>
            <div class="form-group row">
                <label for="rescheduled_fixture" class="form-control-label col-md-2">Verlegt von Paarung</label>
                <div class="col-md-10">
                    <input type="hidden" name="rescheduled_from_fixture_id" id="rescheduled_from_fixture_id" value="{{ $fixture->id }}">
                    <input type="text" class="form-control" name="rescheduled_fixture" id="rescheduled_fixture" value="{{ $fixture->datetime  }} | {{ $fixture->club_home->name_short }} : {{ $fixture->club_away->name_short }} (ID: {{ $fixture->id }})" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="rescheduled_by_club" class="form-control-label col-md-2">Verlegt von Mannschaft</label>
                <div class="col-md-4">
                    <select class="form-control" name="rescheduled_by_club" id="rescheduled_by_club">
                        <option></option>
                        @if($fixture->club_id_home)
                            <option value="{{ $fixture->club_id_home }}">{{ $fixture->club_home->name }}</option>
                        @endif
                        @if($fixture->club_id_away)
                            <option value="{{ $fixture->club_id_away }}">{{ $fixture->club_away->name }}</option>
                        @endif
                    </select>
                </div>
                <label for="reschedule_reason" class="form-control-label col-md-2">Grund für Verlegung</label>
                <div class="col-md-4">
                    <textarea class="form-control" id="reschedule_reason" name="reschedule_reason" rows="3">{{ old('reschedule_reason') }}</textarea>
                </div>
            </div>
            <mark>Zählt als Spielverlegung implementieren</mark>
            <hr>
            <h2 class="mb-4">Neue Paarung</h2>
        @endif
        <!-- matchweek -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="matchweek_id">Spielwoche</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="matchweek_id" aria-describedby="matchweek_idHelp" value="({{ $matchweek->id }}) Nr. {{ $matchweek->number_consecutive }} | {{ $matchweek->begin->toDateString() }} - {{ $matchweek->end->toDateString() }}" disabled>
                <small id="matchweek_idHelp" class="form-text text-muted">Zuordnung zu welcher Spielwoche?</small>
            </div>
        </div>
        <!-- date and time -->
        <div class="form-group row">
            <label for="datetime" class="col-md-2 col-form-label">Datum und Uhrzeit</label>
            <div class="col-md-4">
                <input type="datetime-local" class="form-control" name="datetime" id="singledatetimepicker" aria-describedby="datetimeHelp" placeholder="{{ old('date') }}">
                <small id="datetimeHelp" class="form-text text-muted">Datum und Uhrzeit der Paarung</small>
            </div>
            <div class="form-check col-md-2">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" id="datetimenull">
                    Leer lassen
                </label>
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
                        <option value="{{ $stadium->id }}">{{ $stadium->name }}</option>
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
                        <option value="{{ $club->id }}">{{ $club->name }}</option>
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
                        <option value="{{ $club->id }}">{{ $club->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- goals -->
        <div class="form-group row">
            <label for="goals_home" class="col-md-2 col-form-label">Tore - Heim</label>
            <div class="col-md-4">
                <input type="number" class="form-control" name="goals_home" id="goals_home" aria-describedby="goals_homeHelp" placeholder="{{ old('goals_home') }}">
                <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der Heimmannschaft</small>
            </div>
            <label for="goals_away" class="col-md-2 col-form-label">Tore - Gast</label>
            <div class="col-md-4">
                <input type="number" class="form-control" name="goals_away" id="goals_away" aria-describedby="goals_awayHelp" placeholder="{{ old('goals_away') }}">
                <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der Gastmannschaft</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="goals_home_11m" class="col-md-2 col-form-label">Tore - 11m - Heim</label>
            <div class="col-md-4">
                <input type="number" class="form-control" name="goals_home_11m" id="goals_home_11m" aria-describedby="goals_home_11mHelp" placeholder="{{ old('goals_home_11m') }}">
                <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der Heimmannschaft <b>im</b> Elfmeterschießen</small>
            </div>
            <label for="goals_away_11m" class="col-md-2 col-form-label">Tore - 11m - Gast</label>
            <div class="col-md-4">
                <input type="number" class="form-control" name="goals_away_11m" id="goals_away_11m" aria-describedby="goals_away_11mHelp" placeholder="{{ old('goals_away_11m') }}">
                <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der Gastmannschaft <b>im</b> Elfmeterschießen</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="goals_home_rated" class="col-md-2 col-form-label">Wertung - Heim</label>
            <div class="col-md-1">
                <input type="number" class="form-control" name="goals_home_rated" id="goals_home_rated" aria-describedby="goals_home_ratedHelp" placeholder="{{ old('goals_home_rated') }}">
                <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der <b>Wertung</b> - Heim</small>
            </div>
            <label for="goals_away_rated" class="col-md-2 col-form-label">Wertung - Gast</label>
            <div class="col-md-1">
                <input type="number" class="form-control" name="goals_away_rated" id="goals_away_rated" aria-describedby="goals_away_ratedHelp" placeholder="{{ old('goals_away_rated') }}">
                <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der <b>Wertung</b> - Heim</small>
            </div>
            <label for="rated_note" class="col-md-2 col-form-label">Begründung</label>
            <div class="col-md-4">
                <textarea class="form-control" id="rated_note" name="rated_note" rows="3" aria-describedby="rated_noteHelp">{{ old('rated_note') }}</textarea>
                <small id="rated_noteHelp" class="form-text text-muted">Warum wurde gewertet?</small>
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
        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Anlegen</button>
        <a class="btn btn-secondary" href="{{ route('seasons.matchweeks.show', [$matchweek->season, $matchweek]) }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection