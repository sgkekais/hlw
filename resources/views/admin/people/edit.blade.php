@extends('admin.adminlayout')

@section('content')

    <!-- edit a person -->
    <h1 class="mb-4">Person</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $person->first_name }} {{ $person->last_name }}</h2>
    <!-- created at -->
    Angelegt: {{ $person->created_at->format('d.m.Y H:i') }} Uhr
    @if($causer = ModelHelper::causerOfAction($person,'created'))
        von {{ $causer->name }}
    @endif
    <br>
    <!-- updated at -->
    @if($person->updated_at != $person->created_at)
        Geändert: {{ $person->updated_at->format('d.m.Y H:i') }} Uhr
        @if($causer = ModelHelper::causerOfAction($person,'updated'))
            von {{ $causer->name }}
        @endif
    @endif
    <hr>
    <h3 class="mt-4 mb-4">Person ändern</h3>
    <form method="POST" action="{{ route('people.update', $person) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <!-- names -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="first_name">Vorname</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $person->first_name }}">
            </div>
            <div class="col-md-2">
                <label for="last_name">Nachname</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $person->last_name }}">
            </div>
        </div>
        <!-- date of birth -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="date_of_birth">Geburtsdatum</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="date_of_birth" id="singledatepicker" aria-describedby="date_of_birthHelp" value="{{ $person->date_of_birth->format('Y-m-d') }}">
                <small id="date_of_birthHelp" class="form-text text-muted">JJJJ-MM-TT</small>
            </div>
        </div>
        <!-- photo TODO -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="photo">Passbild</label>
            </div>
            <div class="col-md-4">
                <input type="file" name="photo" id="photo" aria-describedby="photoHelp">
                <small id="photoHelp" class="form-text text-muted">zu erledigen</small>
            </div>
        </div>
        <!-- registered at club -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="registered_at_club">Vereinsspieler?</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="registered_at_club" name="registered_at_club" aria-describedby="competition_idHelp">
                    <option></option>
                    @foreach($real_clubs as $real_club)
                        <option value="{{ $real_club->id }}" {{ $person->registered_at_club == $real_club->id ? "selected" : null }}>{{ $real_club->name }}</option>
                    @endforeach
                </select>
                <small id="registered_at_clubHelp" class="form-text text-muted">Verein des Spielers auswählen. Leeren Eintrag auswählen, wenn Person kein Vereinsspieler ist.</small>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Ändern</button>
            <a class="btn btn-secondary" href="{{ route('people.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
        </div>
    </form>
    <hr>
    <h3 class="mt-4 mb-4">Person löschen</h3>
    <form method="POST" action="{{ route('people.destroy', $person) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <span class="form-text">Löscht die Person und <b>alle zugeordneten Objekte <span class="text-danger">unwiderruflich</span></b>.</span>
        <br>
        <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> Löschen</button>
        <a class="btn btn-secondary" href="{{ url()->previous() }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection