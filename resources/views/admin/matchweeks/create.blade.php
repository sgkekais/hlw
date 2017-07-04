@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <!-- create a new matchweek -->
        <h1 class="mt-4 mb-4">Spielwoche anlegen</h1>

        <form method="POST" action="{{ route('seasons.matchweeks.store', $season) }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            <!-- season -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="season_id">Saison</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="season_id" id="season_id" value="({{ $season->id }}) {{ $season->year_begin }} / {{ $season->year_end }} | {{ $season->division->name }}" disabled>
                    <small id="season_idHelp" class="form-text text-muted">Zuordnung zu welcher Saison?</small>
                </div>
            </div>
            <!-- number -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="number_consecutive">Nummer</label>
                </div>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="number_consecutive" id="number_consecutive" aria-describedby="number_consecutiveHelp" placeholder="{{ old('number', '1') }}">
                    <small id="number_consecutiveHelp" class="form-text text-muted">Nummer der Spielwoche, bspw. 1 für erste Spielwoche, etc.</small>
                </div>
            </div>
            <!-- name for the matchweek -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="name">Name</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="{{ old('name') }}">
                    <small id="nameHelp" class="form-text text-muted">Bezeichnung der Spielwoche, bspw. "Relegation" (optional)</small>
                </div>
            </div>
            <!-- begin and end -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="begin">Beginn</label>
                </div>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="begin" id="begin" aria-describedby="beginHelp" placeholder="{{ old('begin') }}">
                    <small id="nameHelp" class="form-text text-muted">Beginn der Spielwoche im Format JJJJ-MM-TT</small>
                </div>
                <div class="col-md-2">
                    <label for="end">Ende</label>
                </div>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="end" id="end" aria-describedby="endHelp" placeholder="{{ old('end') }}">
                    <small id="nameHelp" class="form-text text-muted">Ende der Spielwoche im Format JJJJ-MM-TT</small>
                </div>
            </div>
            <!-- published -->
            <div class="form-group row">
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
            <button type="submit" class="btn btn-primary">Anlegen</button>
            <a class="btn btn-secondary" href="{{ route('seasons.show', $season) }}">Abbrechen</a>
        </form>
    </div>

@endsection