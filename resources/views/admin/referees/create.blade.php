@extends('admin.adminlayout')

@section('content')

    <!-- create a new player and assign to club and person -->
    <h1 class="mb-4">Schiedsrichter anlegen</h1>
    <p>
        Ein Schiedsrichter ist einer bestimmten Person "zugeordnet". Die Person muss zuvor angelegt werden.
    </p>
    <form method="POST" action="{{ route('referees.store') }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
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
        <!-- note -->
        <div class="form-group row">
            <label for="note" class="col-md-2 col-form-label">Notiz</label>
            <div class="col-md-4">
                <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp">{{ old('note') }}</textarea>
                <small id="noteHelp" class="form-text text-muted">Interne Notiz</small>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Anlegen</button>
            <a class="btn btn-secondary" href="{{ route('referees.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
        </div>
    </form>

@endsection