@extends('admin.adminlayout')

@section('content')

    <!-- create a new player and assign to season and person -->
    <h1 class="mb-4">Mannschaft zuordnen</h1>
    <p>
        Mannschaft einer Saison zuordnen, damit diese den Paarungen dieser Saison als Heim- oder Gastmannschaft zugeordnet werden kann.
    </p>
    <form method="POST" action="{{ route('storeClubAssignment', $season) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <!-- which club? -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="club_id">Mannschaft</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="club_id" name="club_id" aria-describedby="club_idHelp">
                    @foreach($unassigned_clubs as $club)
                        <option value="{{ $club->id }}">{{ $club->name }} ({{ $club->id }})</option>
                    @endforeach
                </select>
                <small id="club_idHelp" class="form-text text-muted">Welche Mannschaft soll der Saison zugeordnet werden?</small>
            </div>
        </div>
        <!-- rank -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="rank">Endplatzierung</label>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" id="rank" name="rank" aria-describedby="rankHelp" placeholder="{{ old('rank') }}">
                <small id="rankHelp" class="form-text text-muted">Welchen Platz hat die Mannschaft am Ende der Saison erreicht?</small>
            </div>
        </div>
        <!-- deductions -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="deduction_points">Punktabzug</label>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" name="deduction_points" id="deduction_points" aria-describedby="deduction_pointsHelp" placeholder="{{ old('deduction_points') }}">
                <small id="deduction_pointsHelp" class="form-text text-muted">Punktabzug (als positive Zahl) für Saisonstart oder während der Saison?</small>
            </div>
            <div class="col-md-2">
                <label for="deduction_goals">Torabzug</label>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" name="deduction_goals" id="deduction_goals" aria-describedby="deduction_goalsHelp" placeholder="{{ old('deduction_goals') }}">
                <small id="deduction_goalsHelp" class="form-text text-muted">Torabzug (als positive Zahl) für Saisonstart oder während der Saison?</small>
            </div>
        </div>
        <!-- withdrawal -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="withdrawal">Ausgeschieden</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="withdrawal" id="withdrawal" aria-describedby="withdrawalHelp" placeholder="{{ old('withdrawal') }}">
                <small id="withdrawalHelp" class="form-text text-muted">Datum, zu dem die Mannschaft aus dem Spielbetrieb ausgeschieden ist</small>
            </div>
        </div>
        <!-- note -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="note">Notiz</label>
            </div>
            <div class="col-md-4">
                <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp"></textarea>
                <small id="noteHelp" class="form-text text-muted">Interne Notiz</small>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Zuordnen</button>
            <a class="btn btn-secondary" href="{{ route('seasons.show', $season) }}"><span class="fa fa-ban"></span> Abbrechen</a>
        </div>
    </form>

@endsection