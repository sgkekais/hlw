@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <!-- edit the matchweek -->
        <h1 class="mt-4">Spielwoche</h1>
        <h2 class="mt-4 text-primary">&mdash; {{ $matchweek->number_consecutive }} {{ $matchweek->name ? '- '.$matchweek->name : null }}</h2>
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
        <h3 class="mt-4 mb-4">Spielwoche ändern</h3>
        <form method="POST" action="{{ route('seasons.matchweeks.update', [$season, $matchweek]) }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
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
                    <input type="number" class="form-control" name="number_consecutive" id="number_consecutive" aria-describedby="number_consecutiveHelp" value="{{ $matchweek->number_consecutive }}">
                    <small id="number_consecutiveHelp" class="form-text text-muted">Nummer der Spielwoche, bspw. 1 für erste Spielwoche, etc.</small>
                </div>
            </div>
            <!-- name for the matchweek -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="name">Name</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="{{ $matchweek->name }}">
                    <small id="nameHelp" class="form-text text-muted">Bezeichnung der Spielwoche, bspw. "Relegation" (optional)</small>
                </div>
            </div>
            <!-- begin and end -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="begin">Beginn</label>
                </div>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="begin" id="begin" aria-describedby="beginHelp" value="{{ $matchweek->begin }}">
                    <small id="nameHelp" class="form-text text-muted">Beginn der Spielwoche im Format JJJJ-MM-TT</small>
                </div>
                <div class="col-md-2">
                    <label for="end">Ende</label>
                </div>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="end" id="end" aria-describedby="endHelp" value="{{ $matchweek->end }}">
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
                        <option value="1" {{ $matchweek->published ? "selected" : null }}>Ja</option>
                    </select>
                    <small id="publishedHelp" class="form-text text-muted">Spielklasse auf Seite veröffentlichen?</small>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Ändern</button>
            <a class="btn btn-secondary" href="{{ route('seasons.show', $season) }}">Abbrechen</a>
        </form>
        <hr>
        <h3 class="mt-4">Spielwoche löschen</h3>
        <form method="POST" action="{{ route('seasons.matchweeks.destroy', [$season, $matchweek]) }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <span class="form-text">Löscht die Spielwoche und <b>alle zugeordneten Objekte <span class="text-danger">unwiderruflich</span></b>.</span>
            <br>
            <button type="submit" class="btn btn-danger">Löschen</button>
            <a class="btn btn-secondary" href="{{ route('seasons.show', $season) }}">Abbrechen</a>
        </form>

    </div>

@endsection