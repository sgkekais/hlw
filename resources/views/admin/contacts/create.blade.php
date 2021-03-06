@extends('admin.adminlayout')

@section('content')

    <!-- create a new contact and assign to club and person -->
    <h1 class="mb-4">Kontakt anlegen</h1>
    <div class="alert alert-info">
        <ul class="p-0 m-0 pl-2">
            <li>Ein Kontakt ist eine Person, die als Ansprechpartner einer Mannschaft dient.</li>
            <li>Die Person muss zuvor angelegt werden und auf <b>aktiv</b> stehen. Vorher bitte mit der Suche prüfen, ob diese nicht schon angelegt ist!</li>
            <li>Sollte eine Person den Verein wechseln, so ist hier das Austrittsdatum zu vermerken und anschließend ein neuer Spieler in der neuen Mannschaft anzulegen.</li>
            <li>Nummer und Position sind optional</li>
        </ul>
    </div>
    <form method="POST" action="{{ route('clubs.contacts.store', $club) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <!-- club -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="club_id">Mannschaft</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="club_id" aria-describedby="club_idHelp" value="{{ $club->name }}" disabled>
                <small id="club_idHelp" class="form-text text-muted">Welcher Mannschaft soll der Kontakt zugeordnet werden?</small>
            </div>
        </div>
        <!-- which person is this? -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="person_id">Person</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="person_id" name="person_id" aria-describedby="person_idHelp">
                    @foreach($people as $person)
                        <option value="{{ $person->id }}">{{ $person->last_name }}, {{ $person->first_name }}</option>
                    @endforeach
                </select>
                <small id="person_idHelp" class="form-text text-muted">Um welche Person handelt es sich?</small>
            </div>
            <!-- hierarchy level -->
            <label for="hierarchy_level" class="col-md-2 form-control-label">Nummer</label>
            <div class="col-md-4">
                <input type="number" class="form-control" id="hierarchy_level" name="hierarchy_level" aria-describedby="hierarchy_levelHelp">
                <small id="hierarchy_levelHelp" class="form-text text-muted">Bspw. "1" für 1. Ansprechpartner</small>
            </div>
        </div>
        <!-- mail and mobile -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="mail">E-Mail</label>
            </div>
            <div class="col-md-4">
                <input type="email" class="form-control" name="mail" id="mail" aria-describedby="mailHelp">
                <small id="mailHelp" class="form-text text-muted">E-Mail-Adresse</small>
            </div>
            <div class="col-md-2">
                <label for="mobile">Mobilnr.</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="mobile" id="mobile" aria-describedby="mobileHelp">
                <small id="mobileHelp" class="form-text text-muted">Mobilfunknummer</small>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Anlegen</button>
            <a class="btn btn-secondary" href="{{ route('clubs.show', $club) }}"><span class="fa fa-ban"></span> Abbrechen</a>
        </div>
    </form>

@endsection