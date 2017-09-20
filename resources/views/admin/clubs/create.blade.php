@extends('admin.adminlayout')

@section('content')

    <!-- create a new club -->
    <h1 class="mb-4">Mannschaft anlegen</h1>
    <form method="POST" action="{{ route('clubs.store') }}" enctype="multipart/form-data" >
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <!-- names -->
        <div class="row">
            <div class="form-group col-md-4">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="{{ old('name', 'Schwarz-Weiß Bilk \'79') }}">
                <small id="nameHelp" class="form-text text-muted">Vollständiger Name der Mannschaft</small>
            </div>
            <div class="form-group col-md-4">
                <label for="name_short">Name - verkürzt</label>
                <input type="text" class="form-control" name="name_short" id="name_short" aria-describedby="name_shortHelp" placeholder="{{ old('name_short', 'SW Bilk \'79') }}">
                <small id="name_shortHelp" class="form-text text-muted">Abgekürzter Name der Mannschaft, bspw. SW Bilk</small>
            </div>
            <div class="form-group col-md-4">
                <label for="name_code">Abkürzung</label>
                <input type="text" class="form-control" name="name_code" id="name_code" aria-describedby="name_codeHelp" placeholder="{{ old('name_code', 'SWB') }}">
                <small id="name_shortHelp" class="form-text text-muted">"Code" für Manschaft, bspw. SWB</small>
            </div>
        </div>
        <!-- logo and cover image -->
        <div class="row">
            <div class="form-group col-md-6">
                <label for="logo">Wappen</label>
                <input type="file" class="form-control-file" name="logo" id="logo" aria-describedby="logoHelp" placeholder="{{ old('logo') }}">
                <small id="logoHelp" class="form-text text-muted">Vereinswappen. Muss im .png-Format mit transparentem Hintergrund mit den Abmessungen 200x200px vorliegen.</small>
            </div>
            <div class="form-group col-md-6">
                <label for="cover">Cover</label>
                <input type="file" class="form-control-file" name="cover" id="cover" aria-describedby="coverHelp" placeholder="{{ old('cover') }}">
                <small id="coverHelp" class="form-text text-muted">Cover, das auf der Mannschaftsseite angezeigt werden soll.</small>
            </div>
        </div>

        <!-- founded -->
        <div class="row">
            <div class="form-group col-md-4">
                <label for="founded">Gründungsdatum</label>
                <input type="date" class="form-control" name="founded" id="founded" aria-describedby="foundedHelp" placeholder="{{ old('founded', '2017-01-01') }}">
                <small id="foundedHelp" class="form-text text-muted">Gründungsdatum im Format JJJJ-MM-TT</small>
            </div>
            <!-- league entry and exit -->
            <div class="form-group col-md-4">
                <label for="league_entry">Eintritt in HLW</label>
                <input type="date" class="form-control" name="league_entry" id="league_entry" aria-describedby="league_entryHelp" placeholder="{{ old('league_entry', '2017-01-01') }}">
                <small id="league_entryHelp" class="form-text text-muted">Eintrittsdatum</small>
            </div>
            <div class="form-group col-md-4">
                <label for="league_exit">Austritt aus HLW</label>
                <input type="date" class="form-control" name="league_exit" id="league_exit" aria-describedby="league_exitHelp" placeholder="{{ old('league_exit', '2017-01-01') }}">
                <small id="league_exitHelp" class="form-text text-muted">Austrittsdatum</small>
            </div>
        </div>

        <!-- club colors -->
        <div class="row">
            <div class="form-group col-md-6">
                <label for="colours_club_primary">Vereinsfarbe - Primär</label>
                <input type="color" class="form-control" name="colours_club_primary" id="colours_club_primary" aria-describedby="colours_club_primaryHelp" placeholder="{{ old('colours_club_primary') }}">
                <small id="colours_club_primaryHelp" class="form-text text-muted">Primärfarbe des Vereins</small>
            </div>
            <div class="form-group col-md-6">
                <label for="colours_club_secondary">Vereinsfarbe - Sekundär</label>
                <input type="color" class="form-control" name="colours_club_secondary" id="colours_club_secondary" aria-describedby="colours_club_secondaryHelp" placeholder="{{ old('colours_club_secondary') }}">
                <small id="colours_club_secondaryHelp" class="form-text text-muted">Sekundärfarbe des Vereins</small>
            </div>
        </div>
        <!-- ignore control for kit colors -->
        <div class="row pl-3 mt-3">
            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="ignore_kit_home" name="ignore_kit_home">
                        Heimtrikotfarben ignorieren?
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="ignore_kit_away" name="ignore_kit_away">
                        Auswärtstrikotfarben ignorieren?
                    </label>
                </div>
            </div>

        </div>
        <!-- kit colors -->
        <div class="row">
            <div class="form-group col-md-3">
                <label for="colours_kit_home_primary">Heimtrikotfarbe - Primär</label>
                <input type="color" class="form-control" name="colours_kit_home_primary" id="colours_kit_home_primary" aria-describedby="colours_kit_home_primaryHelp" placeholder="{{ old('colours_kit_home_primary') }}">
            </div>
            <div class="form-group col-md-3">
                <label for="colours_kit_home_secondary">Heimtrikotfarbe - Sekundär</label>
                <input type="color" class="form-control" name="colours_kit_home_secondary" id="colours_kit_home_secondary" aria-describedby="colours_club_secondaryHelp" placeholder="{{ old('colours_kit_home_secondary') }}">
            </div>
            <div class="form-group col-md-3">
                <label for="colours_kit_away_primary">Auswärtstrikotfarbe - Primär</label>
                <input type="color" class="form-control" name="colours_kit_away_primary" id="colours_kit_away_primary" aria-describedby="colours_kit_home_primaryHelp" placeholder="{{ old('colours_kit_away_primary') }}">
            </div>
            <div class="form-group col-md-3">
                <label for="colours_kit_away_secondary">Auswärtstrikotfarbe - Sekundär</label>
                <input type="color" class="form-control" name="colours_kit_away_secondary" id="colours_kit_away_secondary" aria-describedby="colours_club_secondaryHelp" placeholder="{{ old('colours_kit_away_secondary') }}">
            </div>
        </div>

        <!-- websites -->
        <div class="row">
            <div class="form-group col-md-6">
                <label for="website">Homepage</label>
                <input type="url" class="form-control" name="website" id="website" aria-describedby="websiteHelp" placeholder="{{ old('website', 'https://www.verein.de') }}">
                <small id="websiteHelp" class="form-text text-muted">Homepage des Vereins</small>
            </div>
            <div class="form-group col-md-6">
                <label for="facebook">Facebook</label>
                <input type="url" class="form-control" name="facebook" id="facebook" aria-describedby="facebookHelp" placeholder="{{ old('facebook', 'https://www.facebook.com/verein') }}">
                <small id="facebookHelp" class="form-text text-muted">Facebook-Seite des Vereins</small>
            </div>
        </div>
        <!-- note -->
        <div class="row">
            <div class="form-group col-md-6">
                <label for="note">Notiz</label>
                <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp"></textarea>
                <small id="noteHelp" class="form-text text-muted">Interne Notiz</small>
            </div>
        </div>
        <div class="row">
            <!-- real club -->
            <div class="form-group col-md-6">
                <label for="is_real_club">"Echter" Verein?</label>
                <select class="form-control" id="is_real_club" name="is_real_club" aria-describedby="is_real_clubHelp">
                    <option value="0">Nein</option>
                    <option value="1">Ja</option>
                </select>
                <small id="is_real_clubHelp" class="form-text text-muted">Setzen für echte, eingetragene Vereine, wie bspw. DjK TuSA 06 e.V.</small>
            </div>
            <!-- published -->
            <div class="form-group col-md-6">
                <label for="published">Veröffentlichen?</label>
                <select class="form-control" id="published" name="published" aria-describedby="publishedHelp">
                    <option value="0">Nein</option>
                    <option value="1">Ja</option>
                </select>
                <small id="publishedHelp" class="form-text text-muted">Verein auf Seite veröffentlichen?</small>
            </div>
        </div>
        <div class="form-group mt-4">
            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Anlegen</button>
            <a class="btn btn-secondary" href="{{ route('clubs.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
        </div>
    </form>

@endsection