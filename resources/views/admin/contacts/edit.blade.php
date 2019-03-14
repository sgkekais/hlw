@extends('admin.adminlayout')

@section('content')

    <!-- edit the contact -->
    <h1 class="">Kontakt</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $contact->person->last_name }}, {{ $contact->person->first_name }}</h2>
    <!-- created at -->
    Angelegt: {{ $contact->created_at->format('d.m.Y H:i') }} Uhr
    @if($causer = ModelHelper::causerOfAction($contact,'created'))
        von {{ $causer->name }}
    @endif
    <br>
    <!-- updated at -->
    @if($contact->updated_at != $contact->created_at)
        Geändert: {{ $contact->updated_at->format('d.m.Y H:i') }} Uhr
        @if($causer = ModelHelper::causerOfAction($contact,'updated'))
            von {{ $causer->name }}
        @endif
    @endif
    <hr>
    <h3 class="mt-4 mb-4">Kontakt ändern</h3>
    <form method="POST" action="{{ route('clubs.contacts.update', [ $club, $contact ]) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <!-- contact -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="contact_id">Mannschaft</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="contact_id" aria-describedby="contact_idHelp" value="{{ $club->name }}" disabled>
                <small id="contact_idHelp" class="form-text text-muted">Welcher Mannschaft soll der Kontakt zugeordnet werden?</small>
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
                        <option value="{{ $person->id }}" {{ $contact->person->id == $person->id ? "selected" : null }}>
                            {{ $person->last_name }}, {{ $person->first_name }}
                        </option>
                    @endforeach
                </select>
                <small id="person_idHelp" class="form-text text-muted">Um welche Person handelt es sich?</small>
            </div>
            <!-- hierarchy level -->
            <label for="hierarchy_level" class="col-md-2 form-control-label">Nummer</label>
            <div class="col-md-4">
                <input type="number" class="form-control" id="hierarchy_level" name="hierarchy_level" aria-describedby="hierarchy_levelHelp" value="{{ $contact->hierarchy_level }}">
                <small id="hierarchy_levelHelp" class="form-text text-muted">Bspw. "1" für 1. Ansprechpartner</small>
            </div>
        </div>
        <!-- mail and mobile -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="mail">E-Mail</label>
            </div>
            <div class="col-md-4">
                <input type="email" class="form-control" name="mail" id="mail" aria-describedby="mailHelp" value="{{ $contact->mail }}">
                <small id="mailHelp" class="form-text text-muted">E-Mail-Adresse</small>
            </div>
            <div class="col-md-2">
                <label for="mobile">Mobilnr.</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="mobile" id="mobile" aria-describedby="mobileHelp" value="{{ $contact->mobile }}">
                <small id="mobileHelp" class="form-text text-muted">Mobilfunknummer</small>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Ändern</button>
            <a class="btn btn-secondary" href="{{ route('clubs.show', $club) }}">Abbrechen</a>
        </div>
    </form>
    <hr>
    <h3 class="mt-4">Kontakt löschen</h3>
    <form method="POST" action="{{ route('clubs.contacts.destroy', [ $club, $contact ]) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <span class="form-text">Löscht den Ansprechpartner.</span>
        <br>
        @can('delete contact')
            <button type="submit" class="btn btn-danger">Löschen</button>
            <a class="btn btn-secondary" href="{{ route('clubs.show', $club) }}">Abbrechen</a>
        @else
            Keine Berechtigung.
        @endcan
    </form>

@endsection