@extends('admin.adminlayout')

@section('content')

    <!-- edit the club assignment -->
    <h1 class="">Mannschaftszuordnung</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $season->year_begin }}/{{ $season->year_end }} | {{ $club->name }}</h2>
    <!-- created at -->
    Angelegt: {{ $club->pivot->created_at->format('d.m.Y H:i') }} Uhr
    <br>
    <!-- updated at -->
    @if($club->pivot->updated_at != $club->pivot->created_at)
        Geändert: {{ $club->pivot->updated_at->format('d.m.Y H:i') }} Uhr
    @endif
    <hr>
    <h3 class="mb-4">Mannschaftszuordnung bearbeiten</h3>
    <form method="POST" action="{{ route('updateClubAssignment', [$season, $club]) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <!-- which club? -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="club_id">Mannschaft</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="club_id" value="{{ $club->name }} ({{ $club->id }})" aria-describedby="club_idHelp" disabled>
                <small id="club_idHelp" class="form-text text-muted">Welche Mannschaft soll der Saison zugeordnet werden?</small>
            </div>
        </div>
        <!-- rank -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="rank">Endplatzierung</label>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" id="rank" name="rank" aria-describedby="rankHelp" value="{{ $club->pivot->rank }}">
                <small id="rankHelp" class="form-text text-muted">Welchen Platz hat die Mannschaft am Ende der Saison erreicht?</small>
            </div>
        </div>
        <!-- start points -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="rank">Startpunkte</label>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" id="start_points" name="start_points" aria-describedby="rankHelp" value="{{ $club->pivot->start_points }}">
                <small id="rankHelp" class="form-text text-muted">Punkte, mit denen die Mannschaft starten soll</small>
            </div>
        </div>
        <!-- deductions -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="deduction_points">Punktabzug</label>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" name="deduction_points" id="deduction_points" aria-describedby="deduction_pointsHelp" value="{{  $club->pivot->deduction_points }}">
                <small id="deduction_pointsHelp" class="form-text text-muted">Punktabzug (als positive Zahl) für Saisonstart oder während der Saison?</small>
            </div>
            <div class="col-md-2">
                <label for="deduction_goals">Torabzug</label>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" name="deduction_goals" id="deduction_goals" aria-describedby="deduction_goalsHelp" value="{{ $club->pivot->deduction_points }}">
                <small id="deduction_goalsHelp" class="form-text text-muted">Torabzug (als positive Zahl) für Saisonstart oder während der Saison?</small>
            </div>
        </div>
        <!-- withdrawal -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="withdrawal">Ausgeschieden</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="withdrawal" id="withdrawal" aria-describedby="withdrawalHelp" value="{{ $club->pivot->withdrawal }}">
                <small id="withdrawalHelp" class="form-text text-muted">Datum, zu dem die Mannschaft aus dem Spielbetrieb ausgeschieden ist</small>
            </div>
        </div>
        <!-- note -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="note">Notiz</label>
            </div>
            <div class="col-md-4">
                <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp">{{ $club->pivot->note }}</textarea>
                <small id="noteHelp" class="form-text text-muted">Interne Notiz</small>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Ändern</button>
            <a class="btn btn-secondary" href="{{ route('seasons.show', $season) }}">Abbrechen</a>
        </div>
    </form>
    <hr>
    <h3 class="mt-4">Zuordnung löschen</h3>
    <form method="POST" action="{{ route('destroyClubAssignment', [$season, $club]) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <span class="form-text">Löscht die Zuordnung der Mannschaft zur Saison.</span>
        <br>
        @can('delete club_season_assignment')
            <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> Löschen</button>
            <a class="btn btn-secondary" href="{{ route('seasons.show', $season) }}"><span class="fa fa-ban"></span> Abbrechen</a>
        @else
            Keine Berechtigung.
        @endcan
    </form>

@endsection