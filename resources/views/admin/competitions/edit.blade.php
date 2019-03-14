@extends('admin.adminlayout')

@section('content')

    <!-- edit the competition -->
    <h1 class="">Wettbewerb</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $competition->name }}</h2>
    <!-- created at -->
    Angelegt: {{ $competition->created_at->format('d.m.Y H:i') }} Uhr
    @if($causer = ModelHelper::causerOfAction($competition,'created'))
        von {{ $causer->name }}
    @endif
    <br>
    <!-- updated at -->
    @if($competition->updated_at != $competition->created_at)
        Geändert: {{ $competition->updated_at->format('d.m.Y H:i') }} Uhr
        @if($causer = ModelHelper::causerOfAction($competition,'updated'))
            von {{ $causer->name }}
        @endif
    @endif
    <hr>
    <h3 class="mt-4 mb-4">Wettbewerb ändern</h3>
    <form method="POST" action="{{ route('competitions.update', $competition) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Name</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="{{ $competition->name }}" placeholder="{{ $competition->name }}">
                <small id="nameHelp" class="form-text text-muted">Bezeichnung des Wettbewerbs</small>
            </div>
            <div class="col-md-2">
                <label for="name_short">Name - kurz</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name_short" id="name_short" aria-describedby="name_shortHelp" value="{{ $competition->name_short }}">
                <small id="name_shortHelp" class="form-text text-muted">Abkürzung des Namens (bspw. "HLW")</small>
            </div>
        </div>
        <!-- type of competition / championship -->
        <div class="form-group row">
            <label for="type" class="form-control-label col-md-2">Art des Wettbewerbs</label>
            <div class="col-md-4">
                <select name="type" id="type" class="form-control">
                    <option value="league" {{ $competition->type == "league" ? "selected" : null }}>Liga</option>
                    <option value="knockout" {{ $competition->type == "knockout" ? "selected" : null }}>Turnier - K.O.</option>
                    <option value="tournament" {{ $competition->type == "tournament" ? "selected" : null }}>Turnier - Gruppe+K.O.</option>
                </select>
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
                    <option value="1" {{ $competition->published ? "selected" : null }}>Ja</option>
                </select>
                <small id="publishedHelp" class="form-text text-muted">Verein auf Seite veröffentlichen?</small>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Ändern</button>
        <a class="btn btn-secondary" href="{{ url()->previous() }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>
    <hr>
    <h3 class="mt-4">Wettbewerb löschen</h3>
    <form method="POST" action="{{ route('competitions.destroy', $competition) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <span class="form-text">Löscht den Wettbewerb und <b>alle zugeordneten Objekte <span class="text-danger">unwiderruflich</span></b>.</span>
        <br>
        @can('delete competition')
            <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> Löschen</button>
            <a class="btn btn-secondary" href="{{ url()->previous() }}"><span class="fa fa-ban"></span> Abbrechen</a>
        @else
            Keine Berechtigung.
        @endcan
    </form>

@endsection