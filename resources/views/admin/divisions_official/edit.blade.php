@extends('admin.adminlayout')

@section('content')

    <!-- edit the division -->
    <h1 class="">Off. Spielklasse</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $divisionOfficial->name }}</h2>
    <!-- created at -->
    Angelegt: {{ $divisionOfficial->created_at->format('d.m.Y H:i') }} Uhr
    @if($causer = ModelHelper::causerOfAction($divisionOfficial,'created'))
        von {{ $causer->name }}
    @endif
    <br>
    <!-- updated at -->
    @if($divisionOfficial->updated_at != $divisionOfficial->created_at)
        Geändert: {{ $divisionOfficial->updated_at->format('d.m.Y H:i') }} Uhr
        @if($causer = ModelHelper::causerOfAction($divisionOfficial,'updated'))
            von {{ $causer->name }}
        @endif
    @endif
    <hr>
    <h3 class="mt-4 mb-4">Off. Spielklasse ändern</h3>
    <form method="POST" action="{{ route('divisions-official.update', $divisionOfficial) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Name</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="{{ $divisionOfficial->name }}">
                <small id="nameHelp" class="form-text text-muted">Bezeichnung der off. Spielklasse</small>
            </div>
            <div class="col-md-2">
                <label for="name_short">Name kurz</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name_short" id="name_short" aria-describedby="name_shortHelp" value="{{ $divisionOfficial->name_short }}">
                <small id="nameHelp" class="form-text text-muted">Kurzbezeichnung der off. Spielklasse</small>
            </div>
        </div>
        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Anlegen</button>
        <a class="btn btn-secondary" href="{{ route('divisions-official.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>
    <hr>
    <h3 class="mt-4">Spielklasse löschen</h3>
    <form method="POST" action="{{ route('divisions-official.destroy', $divisionOfficial) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <span class="form-text">Löscht die off. Spielklasse</span>
        <br>
        @can('delete division_official')
            <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> Löschen</button>
            <a class="btn btn-secondary" href="{{ route('divisions-official.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
        @else
            Keine Berechtigung.
        @endcan
    </form>

@endsection