@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <!-- create a new club -->
        <h1 class="mt-4 mb-4">Mannschaft anlegen</h1>

        <form method="POST" action="{{ route('clubs.store') }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            <!-- names -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="name">Name</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="{{ old('name', 'Schwarz-Weiß Bilk \'79') }}">
                    <small id="nameHelp" class="form-text text-muted">Vollständiger Name der Mannschaft</small>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="name_short">Name</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="name_short" id="name_short" aria-describedby="name_shortHelp" placeholder="{{ old('name_short', 'SW Bilk \'79') }}">
                    <small id="name_shortHelp" class="form-text text-muted">Abgekürzter Name der Mannschaft, bspw. SW Bilk</small>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="name_code">Abkürzung</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="name_code" id="name_code" aria-describedby="name_codeHelp" placeholder="{{ old('name_code', 'SWB') }}">
                    <small id="name_shortHelp" class="form-text text-muted">"Code" für Manschaft, bspw. SWB</small>
                </div>
            </div>
            <!-- logo -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="logo_url">Wappen</label>
                </div>
                <div class="col-md-4">
                    <input type="file" class="form-control-file" name="logo_url" id="logo_url" aria-describedby="logo_urlHelp" placeholder="{{ old('logo_url') }}">
                    <small id="logo_urlHelp" class="form-text text-muted">Vereinswappen</small>
                </div>
            </div>
            <!-- founded -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="founded">Gründungsdatum</label>
                </div>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="founded" id="founded" aria-describedby="foundedHelp" placeholder="{{ old('founded', '2017-01-01') }}">
                    <small id="foundedHelp" class="form-text text-muted">Gründungsdatum im Format JJJJ-MM-TT</small>
                </div>
            </div>
            <!-- league entry and exit -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="league_entry">Eintritt in HLW</label>
                </div>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="league_entry" id="league_entry" aria-describedby="league_entryHelp" placeholder="{{ old('league_entry', '2017-01-01') }}">
                    <small id="league_entryHelp" class="form-text text-muted">Eintrittsdatum</small>
                </div>
                <div class="col-md-2">
                    <label for="league_exit">Austritt aus HLW</label>
                </div>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="league_exit" id="league_exit" aria-describedby="league_exitHelp" placeholder="{{ old('league_exit', '2017-01-01') }}">
                    <small id="league_exitHelp" class="form-text text-muted">Austrittsdatum</small>
                </div>
            </div>
            <!-- colors -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="colours_club">Vereinsfarbe</label>
                </div>
                <div class="col-md-4">
                    <input type="color" class="form-control" name="colours_club" id="colours_club" aria-describedby="colours_clubHelp" placeholder="{{ old('colours_club', '#000') }}">
                    <small id="colours_clubHelp" class="form-text text-muted">Primärfarbe des Vereins</small>
                </div>
                <div class="col-md-2">
                    <label for="colours_kit">Trikotfarbe</label>
                </div>
                <div class="col-md-4">
                    <input type="color" class="form-control" name="colours_kit" id="colours_kit" aria-describedby="colours_kitHelp" placeholder="{{ old('colours_kit', '#FFF') }}">
                    <small id="colours_kitHelp" class="form-text text-muted">Trikotfarbe</small>
                </div>
            </div>
            <!-- websites -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="website">Homepage</label>
                </div>
                <div class="col-md-4">
                    <input type="url" class="form-control" name="website" id="website" aria-describedby="websiteHelp" placeholder="{{ old('website', 'https://www.verein.de') }}">
                    <small id="websiteHelp" class="form-text text-muted">Homepage des Vereins</small>
                </div>
                <div class="col-md-2">
                    <label for="facebook">Facebook</label>
                </div>
                <div class="col-md-4">
                    <input type="url" class="form-control" name="facebook" id="facebook" aria-describedby="facebookHelp" placeholder="{{ old('facebook', 'https://www.facebook.com/verein') }}">
                    <small id="facebookHelp" class="form-text text-muted">Facebook-Seite des Vereins</small>
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
            <div class="form-group row">
                <!-- real club -->
                <div class="col-md-2">
                    <label for="is_real_club">"Echter" Verein?</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="is_real_club" name="is_real_club" aria-describedby="is_real_clubHelp">
                        <option value="0">Nein</option>
                        <option value="1">Ja</option>
                    </select>
                    <small id="is_real_clubHelp" class="form-text text-muted">Setzen für echte, eingetragene Vereine, wie bspw. DjK TuSA 06 e.V.</small>
                </div>
                <!-- published -->
                <div class="col-md-2">
                    <label for="published">Veröffentlichen?</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="published" name="published" aria-describedby="publishedHelp">
                        <option value="0">Nein</option>
                        <option value="1">Ja</option>
                    </select>
                    <small id="publishedHelp" class="form-text text-muted">Verein auf Seite veröffentlichen?</small>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Anlegen</button>
                <a class="btn btn-secondary" href="{{ route('clubs.index') }}">Abbrechen</a>
            </div>
        </form>
    </div>

@endsection