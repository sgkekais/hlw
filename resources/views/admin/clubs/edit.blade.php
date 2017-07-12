@extends('admin.adminlayout')

@section('content')

    <!-- edit the club -->
    <h1 class="">Mannschaft</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $club->name }}</h2>
    <!-- created at -->
    Angelegt: {{ $club->created_at->format('d.m.Y H:i') }} Uhr
    @if($causer = ModelHelper::causerOfAction($club,'created'))
        von {{ $causer->name }}
    @endif
    <br>
    <!-- updated at -->
    @if($club->updated_at != $club->created_at)
        Geändert: {{ $club->updated_at->format('d.m.Y H:i') }} Uhr
        @if($causer = ModelHelper::causerOfAction($club,'updated'))
            von {{ $causer->name }}
        @endif
    @endif
    <hr>
    <h3 class="mt-4 mb-4">Mannschaft ändern</h3>
    <form method="POST" action="{{ route('clubs.update', $club) }}" enctype="multipart/form-data">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
    <!-- names -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Name</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="{{ $club->name }}" >
                <small id="nameHelp" class="form-text text-muted">Vollständiger Name der Mannschaft</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name_short">Name</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name_short" id="name_short" aria-describedby="name_shortHelp" value="{{ $club->name_short }}">
                <small id="name_shortHelp" class="form-text text-muted">Abgekürzter Name der Mannschaft, bspw. SW Bilk</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name_code">Abkürzung</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name_code" id="name_code" aria-describedby="name_codeHelp" value="{{ $club->name_code }}">
                <small id="name_shortHelp" class="form-text text-muted">"Code" für Manschaft, bspw. SWB</small>
            </div>
        </div>
        <!-- logo -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="logo">Wappen</label>
            </div>
            <div class="col-md-2">
                @if($club->logo_url)
                    <img src="{{ Storage::url($club->logo_url) }}" class="img-fluid " title="Vereinswappen" alt="Vereinswappen">
                @else
                    <i>Kein Vereinswappen vorhanden</i>
                @endif
            </div>
            <div class="col-md-4">
                <input type="file" class="form-control-file" name="logo" id="logo" aria-describedby="logoHelp">
                <small id="logoHelp" class="form-text text-muted">Vereinswappen hochladen oder ersetzen. Muss im .png-Format mit transparentem Hintergrund mit den Abmessungen 200x200px vorliegen.</small>
            </div>
        </div>
        <!-- founded -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="founded">Gründungsdatum</label>
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control" name="founded" id="founded" aria-describedby="foundedHelp" value="{{ $club->founded }}" placeholder="{{ old('founded', '2017-01-01') }}">
                <small id="foundedHelp" class="form-text text-muted">Gründungsdatum im Format JJJJ-MM-TT</small>
            </div>
        </div>
        <!-- league entry and exit -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="league_entry">Eintritt in HLW</label>
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control" name="league_entry" id="league_entry" aria-describedby="league_entryHelp" value="{{ $club->league_entry }}" placeholder="{{ old('league_entry', '2017-01-01') }}">
                <small id="league_entryHelp" class="form-text text-muted">Eintrittsdatum</small>
            </div>
            <div class="col-md-2">
                <label for="league_exit">Austritt aus HLW</label>
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control" name="league_exit" id="league_exit" aria-describedby="league_exitHelp" value="{{ $club->league_exit }}" placeholder="{{ old('league_exit', '2017-01-01') }}">
                <small id="league_exitHelp" class="form-text text-muted">Austrittsdatum</small>
            </div>
        </div>
        <!-- club colors -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="colours_club_primary">Vereinsfarbe - Primär</label>
            </div>
            <div class="col-md-4">
                <input type="color" class="form-control" name="colours_club_primary" id="colours_club_primary" aria-describedby="colours_club_primaryHelp" value="{{ $club->colours_club_primary }}">
                <small id="colours_club_primaryHelp" class="form-text text-muted">Primärfarbe des Vereins</small>
            </div>
            <div class="col-md-2">
                <label for="colours_club_secondary">Vereinsfarbe - Sekundär</label>
            </div>
            <div class="col-md-4">
                <input type="color" class="form-control" name="colours_club_secondary" id="colours_club_secondary" aria-describedby="colours_club_secondaryHelp" value="{{ $club->colours_club_secondary }}">
                <small id="colours_club_secondaryHelp" class="form-text text-muted">Sekundärfarbe des Vereins</small>
            </div>
        </div>
        <!-- kit colors -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="colours_kit_home_primary">Heimtrikotfarbe - Primär</label>
            </div>
            <div class="col-md-1">
                <input type="color" class="form-control" name="colours_kit_home_primary" id="colours_kit_home_primary" aria-describedby="colours_kit_home_primaryHelp" value="{{ $club->colours_kit_home_primary }}">
            </div>
            <div class="col-md-2">
                <label for="colours_kit_home_secondary">Heimtrikotfarbe - Sekundär</label>
            </div>
            <div class="col-md-1">
                <input type="color" class="form-control" name="colours_kit_home_secondary" id="colours_kit_home_secondary" aria-describedby="colours_club_secondaryHelp" value="{{ $club->colours_kit_home_secondary }}">
            </div>
            <div class="col-md-2">
                <label for="colours_kit_away_primary">Auswärtstrikotfarbe - Primär</label>
            </div>
            <div class="col-md-1">
                <input type="color" class="form-control" name="colours_kit_away_primary" id="colours_kit_away_primary" aria-describedby="colours_kit_home_primaryHelp" value="{{ $club->colours_kit_away_primary }}">
            </div>
            <div class="col-md-2">
                <label for="colours_kit_away_secondary">Auswärtstrikotfarbe - Sekundär</label>
            </div>
            <div class="col-md-1">
                <input type="color" class="form-control" name="colours_kit_away_secondary" id="colours_kit_away_secondary" aria-describedby="colours_club_secondaryHelp" value="{{ $club->colours_kit_home_secondary }}">
            </div>
        </div>
        <!-- websites -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="website">Homepage</label>
            </div>
            <div class="col-md-4">
                <input type="url" class="form-control" name="website" id="website" aria-describedby="websiteHelp" value="{{ $club->website }}">
                <small id="websiteHelp" class="form-text text-muted">Homepage des Vereins</small>
            </div>
            <div class="col-md-2">
                <label for="facebook">Facebook</label>
            </div>
            <div class="col-md-4">
                <input type="url" class="form-control" name="facebook" id="facebook" aria-describedby="facebookHelp" value="{{ $club->facebook }}">
                <small id="facebookHelp" class="form-text text-muted">Facebook-Seite des Vereins</small>
            </div>
        </div>
        <!-- note -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="note">Notiz</label>
            </div>
            <div class="col-md-4">
                <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp">{{ $club->note }}</textarea>
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
                    <option value="1" {{ $club->is_real_club ? "selected" : null }}>Ja</option>
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
                <option value="1" {{ $club->published ? "selected" : null }}>Ja</option>
                </select>
                <small id="publishedHelp" class="form-text text-muted">Verein auf Seite veröffentlichen?</small>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Ändern</button>
            <a class="btn btn-secondary" href="{{ url()->previous() }}"><span class="fa fa-ban"></span> Abbrechen</a>
        </div>
    </form>
    <hr>
    <h3 class="mt-4">Verein löschen</h3>
    <form method="POST" action="{{ route('clubs.destroy', $club) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <span class="form-text">Löscht den Verein und <b>alle zugeordneten Objekte <span class="text-danger">unwiderruflich</span></b>.</span>
        <br>
        <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> Löschen</button>
        <a class="btn btn-secondary" href="{{ url()->previous() }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection