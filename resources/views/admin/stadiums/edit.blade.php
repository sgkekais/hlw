@extends('admin.adminlayout')

@section('content')

    <!-- edit the stadium -->
    <h1 class="">Spielort</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $stadium->name }}</h2>
    <!-- created at -->
    Angelegt: {{ $stadium->created_at->format('d.m.Y H:i') }} Uhr
    @if($causer = ModelHelper::causerOfAction($stadium,'created'))
        von {{ $causer->name }}
    @endif
    <br>
    <!-- updated at -->
    @if($stadium->updated_at != $stadium->created_at)
        Geändert: {{ $stadium->updated_at->format('d.m.Y H:i') }} Uhr
        @if($causer = ModelHelper::causerOfAction($stadium,'updated'))
            von {{ $causer->name }}
        @endif
    @endif
    <hr>
    <h3 class="mt-4 mb-4">Spielort ändern</h3>
    <form method="POST" action="{{ route('stadiums.update', $stadium) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Name</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="{{ $stadium->name }}">
                <small id="nameHelp" class="form-text text-muted">Name des Spielorts (oder Vereinsname)</small>
            </div>
            <div class="col-md-2">
                <label for="name_short">Kurzname</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name_short" id="name_short" aria-describedby="name_shortHelp" value="{{ $stadium->name_short }}">
                <small id="name_shortHelp" class="form-text text-muted">Kurzversion des Namens</small>
            </div>
        </div>
        <!-- gmaps -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="gmaps">Google Maps URL</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="gmaps" id="gmaps" aria-describedby="gmapsHelp" value="{{ $stadium->gmaps }}">
                <small id="nameHelp" class="form-text text-muted">Über das Teilen-Menü auf Google Maps ermittelte Kurz-URL hier eintragen.</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="lat">Breitengrad</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="lat" id="lat" aria-describedby="latHelp" value="{{ $stadium->lat }}">
                <small id="latHelp" class="form-text text-muted">Breitengrad der Adresse</small>
            </div>
            <div class="col-md-2">
                <label for="long">Längengrad</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="long" id="long" aria-describedby="longHelp" value="{{ $stadium->long }}">
                <small id="longHelp" class="form-text text-muted">Längengrad der Adresse</small>
            </div>
        </div>
        <!-- note -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="note">Notiz</label>
            </div>
            <div class="col-md-4">
                <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp">{{ $stadium->note }}</textarea>
                <small id="noteHelp" class="form-text text-muted">Interne Notiz</small>
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
                    <option value="1" {{ $stadium->published ? "selected" : null }}>Ja</option>
                </select>
                <small id="publishedHelp" class="form-text text-muted">Spielort auf Seite veröffentlichen?</small>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ändern</button>
        <a class="btn btn-secondary" href="{{ route('stadiums.index') }}">Abbrechen</a>
    </form>

@endsection
