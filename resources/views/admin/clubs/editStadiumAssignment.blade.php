@extends('admin.adminlayout')

@section('content')

    <!-- edit the stadium assignment -->
    <h1 class="">Spielortzuordnung</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $stadium->name }} | {{ $club->name }}</h2>
    <!-- created at -->
    Angelegt: {{ $stadium->pivot->created_at->format('d.m.Y H:i') }} Uhr
    <br>
    <!-- updated at -->
    @if($stadium->pivot->updated_at != $stadium->pivot->created_at)
        Geändert: {{ $stadium->pivot->updated_at->format('d.m.Y H:i') }} Uhr
    @endif
    <hr>
    <h3 class="mb-4">Spielortzuordnung bearbeiten</h3>
    <form method="POST" action="{{ route('updateStadiumAssignment', [$club, $stadium]) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <!-- which stadium? -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="stadium_id">Spielort</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="stadium_id" value="{{ $stadium->name }}" aria-describedby="stadium_idHelp" disabled>
                <small id="stadium_idHelp" class="form-text text-muted">Welcher Spielort soll der Mannschaft zugeordnet werden?</small>
            </div>
        </div>
        <!-- day and time -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="regular_home_day">Tag</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="regular_home_day" name="regular_home_day" aria-describedby="regular_home_dayHelp">
                    <option value=""></option>
                    @foreach($days = collect(['Montags', 'Dienstags', 'Mittwochs', 'Donnerstags', 'Freitags', 'Samstags', 'Sonntags']) as $day)
                        <option value="{{ $day }}" {{ $day === $stadium->pivot->regular_home_day ? "selected" : null }}>{{ $day }}</option>
                    @endforeach
                </select>
                <small id="regular_home_dayHelp" class="form-text text-muted">Wann wird hier normalerweise angestoßen?</small>
            </div>
            <div class="col-md-2">
                <label for="regular_home_time">Uhrzeit</label>
            </div>
            <div class="col-md-4">
                <input type="time" class="form-control" name="regular_home_time" id="regular_home_time" aria-describedby="regular_home_timeHelp" value="{{ $stadium->pivot->regular_home_time }}">
                <small id="regular_home_timeHelp" class="form-text text-muted"></small>
            </div>
        </div>
        <!-- regular stadium -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="is_regular_stadium">Hauptspielstätte?</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="is_regular_stadium" name="is_regular_stadium" aria-describedby="is_regular_stadiumHelp">
                    <option value="1">Ja</option>
                    <option value="0" {{ !$stadium->pivot->is_regular_stadium ? "selected" : null }}>Nein</option>
                </select>
                <small id="deduction_pointsHelp" class="form-text text-muted">Ist der Spielort das reguläre zu Hause?</small>
            </div>
        </div>
        <!-- note -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="note">Notiz</label>
            </div>
            <div class="col-md-4">
                <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp">{{ $stadium->pivot->note }}</textarea>
                <small id="noteHelp" class="form-text text-muted">Interne Notiz</small>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Zuordnen</button>
            <a class="btn btn-secondary" href="{{ route('clubs.show', $club) }}"><span class="fa fa-ban"></span> Abbrechen</a>
        </div>
    </form>
    <hr>
    <h3 class="mt-4">Zuordnung löschen</h3>
    <form method="POST" action="{{ route('destroyStadiumAssignment', [$club, $stadium]) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <span class="form-text">Löscht die Zuordnung des Spielorts zur Mannschaft.</span>
        <br>
        @can('delete club_stadium_assignment')
            <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> Löschen</button>
            <a class="btn btn-secondary" href="{{ route('clubs.show', $club) }}"><span class="fa fa-ban"></span> Abbrechen</a>
        @else
            Keine Berechtigung.
        @endcan
    </form>

@endsection