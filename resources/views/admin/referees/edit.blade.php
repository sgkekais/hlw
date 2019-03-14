@extends('admin.adminlayout')

@section('content')

    <!-- edit the referee -->
    <h1 class="">Schiedsrichter</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $referee->person->last_name }}, {{ $referee->person->first_name }}</h2>
    <!-- created at -->
    Angelegt: {{ $referee->created_at->format('d.m.Y H:i') }} Uhr
    <br>
    <!-- updated at -->
    @if($referee->updated_at != $referee->created_at)
        Geändert: {{ $referee->updated_at->format('d.m.Y H:i') }} Uhr
    @endif
    <hr>
    <h3 class="mb-4">Schiedsrichter bearbeiten</h3>
    <form method="POST" action="{{ route('referees.update', $referee) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <!-- which person is this? -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="person_id">Person</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="person_id" name="person_id" aria-describedby="person_idHelp">
                    @foreach($people as $person)
                        <option value="{{ $person->id }}" {{ $person->id === $referee->person_id ? "selected" : null }}>{{ $person->last_name }}, {{ $person->first_name }}</option>
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
                <input type="email" class="form-control" name="mail" id="mail" aria-describedby="mailHelp" value="{{ $referee->mail }}">
                <small id="mailHelp" class="form-text text-muted">E-Mail-Adresse</small>
            </div>
            <div class="col-md-2">
                <label for="mobile">Mobilnr.</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="mobile" id="mobile" aria-describedby="mobileHelp" value="{{ $referee->mobile }}">
                <small id="mobileHelp" class="form-text text-muted">Mobilfunknummer</small>
            </div>
        </div>
        <!-- note -->
        <div class="form-group row">
            <label for="note" class="col-md-2 col-form-label">Notiz</label>
            <div class="col-md-4">
                <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp">{{ $referee->note }}</textarea>
                <small id="noteHelp" class="form-text text-muted">Interne Notiz</small>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Ändern</button>
            <a class="btn btn-secondary" href="{{ route('referees.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
        </div>
    </form>
    <hr>
    <h3 class="mt-4">Schiedsrichter löschen</h3>
    <form method="POST" action="{{ route('referees.destroy', $referee) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <span class="form-text">Löscht den Schiedsrichter. Person bleibt erhalten.</span>
        <br>
        @can('delete referee_assignment')
            <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> Löschen</button>
            <a class="btn btn-secondary" href="{{ route('referees.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
        @else
            Keine Berechtigung.
        @endcan
    </form>
@endsection