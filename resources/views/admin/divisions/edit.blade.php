@extends('admin.adminlayout')

@section('content')

    <!-- edit the division -->
    <h1 class="">Spielklasse</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $division->name }}</h2>
    <!-- created at -->
    Angelegt: {{ $division->created_at->format('d.m.Y H:i') }} Uhr
    @if($causer = ModelHelper::causerOfAction($division,'created'))
        von {{ $causer->name }}
    @endif
    <br>
    <!-- updated at -->
    @if($division->updated_at != $division->created_at)
        Geändert: {{ $division->updated_at->format('d.m.Y H:i') }} Uhr
        @if($causer = ModelHelper::causerOfAction($division,'updated'))
            von {{ $causer->name }}
        @endif
    @endif
    <hr>
    <h3 class="mt-4 mb-4">Spielklasse ändern</h3>
    <form method="POST" action="{{ route('divisions.update', $division) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Name</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="{{ $division->name }}" placeholder="{{ $division->name }}">
                <small id="nameHelp" class="form-text text-muted">Bezeichnung der Spielklasse</small>
            </div>
        </div>
        <!-- hierarchy level -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="hierarchy_level">Hierarchiebene</label>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" name="hierarchy_level" id="hierarchy_level" aria-describedby="hierarchy_levelHelp" value="{{ $division->hierarchy_level }}" placeholder="{{ old('hierarchy_level', '1') }}">
                <small id="hierarchy_levelHelp" class="form-text text-muted">Hierarchiebene der Spielklasse, bspw. 2 für 2. Liga</small>
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
                        <option value="{{ $competition->id }}" {{ $division->competition_id == $competition->id ? "selected" : "" }}>{{ $competition->name }}</option>
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
                    <option value="1" {{ $division->published ? "selected" : null }}>Ja</option>
                </select>
                <small id="publishedHelp" class="form-text text-muted">Spielklasse auf Seite veröffentlichen?</small>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Ändern</button>
        <a class="btn btn-secondary" href="{{ url()->previous() }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>
    <hr>
    <h3 class="mt-4">Spielklasse löschen</h3>
    <form method="POST" action="{{ route('divisions.destroy', $division) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <span class="form-text">Löscht die Spielklasse und <b>alle zugeordneten Objekte <span class="text-danger">unwiderruflich</span></b>.</span>
        <br>
        <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> Löschen</button>
        <a class="btn btn-secondary" href="{{ url()->previous() }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection