@extends('admin.adminlayout')

@section('content')

    <!-- assign a referee to a fixture -->
    <h1 class="mb-4">Schiedsrichter zuordnen</h1>
    <p>
        Schiedsrichter einer Paarung zuordnen.
    </p>
    <form method="POST" action="{{ route('storeRefereeAssignment', $fixture) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <!-- which referee? -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="referee_id">Schiedsrichter</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="referee_id" name="referee_id" aria-describedby="referee_idHelp">
                    @foreach($unassigned_referees->sortBy('person.last_name') as $unassigned_referee)
                        <option value="{{ $unassigned_referee->id }}">{{ $unassigned_referee->person->last_name }}, {{ $unassigned_referee->person->first_name }}</option>
                    @endforeach
                </select>
                <small id="referee_idHelp" class="form-text text-muted">Welcher Schiedsrichter soll der Paarung zugeordnet werden?</small>
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
            <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]) }}"><span class="fa fa-ban"></span> Abbrechen</a>
        </div>
    </form>

@endsection