@extends('admin.adminlayout')

@section('content')

    <!-- create a new contact and assign to club and person -->
    <h1 class="mb-4">Kontakt anlegen</h1>
    <p>
        Ein Kontakt ist eine Person, die als Ansprechpartner einer Mannschaft dien. Die Person muss zuvor angelegt werden.
    </p>
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
            <button type="submit" class="btn btn-primary">Anlegen</button>
            <a class="btn btn-secondary" href="{{ route('clubs.show', $club) }}">Abbrechen</a>
        </div>
    </form>

@endsection