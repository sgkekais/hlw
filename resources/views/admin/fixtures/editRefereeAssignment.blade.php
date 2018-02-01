@extends('admin.adminlayout')

@section('content')

    <!-- edit the referee assignment -->
    <h1 class="">Schiedsrichterzuordnung</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $referee->person->last_name }}, {{ $referee->person->first_name }} </h2>
    <!-- created at -->
    Angelegt: {{ $referee->pivot->created_at->format('d.m.Y H:i') }} Uhr
    <br>
    <!-- updated at -->
    @if($referee->pivot->updated_at != $referee->pivot->created_at)
        Geändert: {{ $referee->pivot->updated_at->format('d.m.Y H:i') }} Uhr
    @endif
    <hr>
    <h3 class="mb-4">Schiedsrichterzuordnung bearbeiten</h3>
    <form method="POST" action="{{ route('updateRefereeAssignment', [$fixture, $referee]) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <!-- which referee? -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="referee_id">Schiedsrichter</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="referee_id" value="{{ $referee->person->last_name }}, {{ $referee->person->first_name }}" aria-describedby="referee_idHelp" disabled>
                <small id="referee_idHelp" class="form-text text-muted">Welcher Schiedsrichter soll der Paarung zugeordnet werden?</small>
            </div>
        </div>
        <!-- confirmation -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="confirmed">Bestätigt?</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="confirmed" name="confirmed" aria-describedby="confirmedHelp">
                    <option value="0">Nein</option>
                    <option value="1" {{ $referee->pivot->confirmed ? "selected" : null }}>Ja</option>
                </select>
                <small id="confirmedHelp" class="form-text text-muted">Hat der Schiedsrichter die Zuordnung bestätigt?</small>
            </div>
        </div>
        <!-- note -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="note">Notiz</label>
            </div>
            <div class="col-md-4">
                <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp">{{ $referee->pivot->note }}</textarea>
                <small id="noteHelp" class="form-text text-muted">Interne Notiz</small>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Ändern</button>
            <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]) }}"><span class="fa fa-ban"></span> Abbrechen</a>
        </div>
    </form>
    <hr>
    <h3 class="mt-4">Zuordnung löschen</h3>
    <form method="POST" action="{{ route('destroyRefereeAssignment', [$fixture, $referee]) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <span class="form-text">Löscht die Zuordnung des Schiedsrichters zur Paarung</span></b>.</span>
        <br>
        <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> Löschen</button>
        <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]) }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection