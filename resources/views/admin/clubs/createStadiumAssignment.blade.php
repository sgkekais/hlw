@extends('admin.adminlayout')

@section('content')

    <!-- assign a stadium to a club -->
    <h1 class="mb-4">Spielort zuordnen</h1>
    <p>
        Spielort einer Mannschaft zuordnen.
    </p>
    <form method="POST" action="{{ route('storeStadiumAssignment', $club) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <!-- which stadium? -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="stadium_id">Spielort</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="stadium_id" name="stadium_id" aria-describedby="stadium_idHelp">
                    @foreach($unassigned_stadiums as $unassigned_stadium)
                        <option value="{{ $unassigned_stadium->id }}">{{ $unassigned_stadium->name }}</option>
                    @endforeach
                </select>
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
                    <option value="Montags">Montags</option>
                    <option value="Dienstags">Dienstags</option>
                    <option value="Mittwochs">Mittwochs</option>
                    <option value="Donnerstags">Donnerstags</option>
                    <option value="Freitags">Freitags</option>
                    <option value="Samstags">Samstags</option>
                    <option value="Sonntags">Sonntags</option>
                </select>
                <small id="regular_home_dayHelp" class="form-text text-muted">Wann wird hier normalerweise angestoßen?</small>
            </div>
            <div class="col-md-2">
                <label for="regular_home_time">Uhrzeit</label>
            </div>
            <div class="col-md-4">
                <input type="time" class="form-control" name="regular_home_time" id="regular_home_time" aria-describedby="regular_home_timeHelp">
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
                    <option value="0">Nein</option>
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
                <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp"></textarea>
                <small id="noteHelp" class="form-text text-muted">Interne Notiz</small>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Zuordnen</button>
            <a class="btn btn-secondary" href="{{ route('clubs.show', $club) }}"><span class="fa fa-ban"></span> Abbrechen</a>
        </div>
    </form>

@endsection