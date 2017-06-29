@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <!-- create a new stadium -->
        <h1 class="mt-4 mb-4">Spielort anlegen</h1>
        <form method="POST" action="{{ route('stadiums.store') }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="name">Name</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="{{ old('name') }}">
                    <small id="nameHelp" class="form-text text-muted">Name des Spielorts (oder Vereinsname)</small>
                </div>
                <div class="col-md-2">
                    <label for="name_short">Kurzname</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="name_short" id="name_short" aria-describedby="name_shortHelp" placeholder="{{ old('name_short') }}">
                    <small id="name_shortHelp" class="form-text text-muted">Kurzversion des Namens</small>
                </div>
            </div>
            <!-- gmaps -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="gmaps">Google Maps URL</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="gmaps" id="gmaps" aria-describedby="gmapsHelp" placeholder="{{ old('gmaps') }}">
                    <small id="nameHelp" class="form-text text-muted">Über das Teilen-Menü auf Google Maps ermittelte Kurz-URL hier eintragen.</small>
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
                    <small id="publishedHelp" class="form-text text-muted">Spielort auf Seite veröffentlichen?</small>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Anlegen</button>
            <a class="btn btn-secondary" href="{{ route('stadiums.index') }}">Abbrechen</a>
        </form>
    </div>

@endsection
