@extends('admin.adminlayout')

@section('content')

    <!-- create a new division -->
    <h1 class="mb-4">Spielklasse anlegen</h1>
    <form method="POST" action="{{ route('divisions.store') }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Name</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="{{ old('name', 'Hobbyliga-West') }}">
                <small id="nameHelp" class="form-text text-muted">Bezeichnung der Spielklasse</small>
            </div>
        </div>
        <!-- hierarchy level -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="hierarchy_level">Hierarchieebene</label>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" name="hierarchy_level" id="hierarchy_level" aria-describedby="hierarchy_levelHelp" placeholder="{{ old('hierarchy_level', '1') }}">
                <small id="hierarchy_levelHelp" class="form-text text-muted">Hierarchieebene der Spielklasse, bspw. 2 für 2. Liga</small>
            </div>
        </div>
        <!-- nav text and order -->
        <!-- published -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="nav_show">Anzeige in Navigation?</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="nav_show" name="nav_show" aria-describedby="navshowHelp">
                    <option value="0">Nein</option>
                    <option value="1">Ja</option>
                </select>
                <small id="navshowHelp" class="form-text text-muted">In Navigation anzeigen?</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="nav_text">Navigationstext</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="nav_text" id="nav_text" aria-describedby="navtextHelp" placeholder="{{ old('nav_text', 'Gr. A') }}">
                <small id="navtextHelp" class="form-text text-muted">Text in Navigationsleiste</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="nav_order">Navigationsreihenfolge</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="nav_order" id="nav_order" aria-describedby="navorderHelp" placeholder="{{ old('nav_order', '2') }}">
                <small id="navorderHelp" class="form-text text-muted">Für Sotierung in Navigationsleiste</small>
            </div>
        </div>
        <!-- competition -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="competition_id">Wettbewerb</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="competition_id" name="competition_id" aria-describedby="competition_idHelp">
                    @foreach($competitions as $competition)
                        <option value="{{ $competition->id }}">{{ $competition->name }}</option>
                    @endforeach
                </select>
                <small id="competition_idHelp" class="form-text text-muted">Zuordnung zu welchem Wettbewerb?</small>
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
        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Anlegen</button>
        <a class="btn btn-secondary" href="{{ route('divisions.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection