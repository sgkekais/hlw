@extends('admin.adminlayout')

@section('content')

    <!-- create a new person -->
    <h1 class="mb-4">Person anlegen</h1>
    <form method="POST" action="{{ route('people.store') }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <!-- names -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="first_name">Vorname</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}">
            </div>
            <div class="col-md-2">
                <label for="last_name">Nachname</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}">
            </div>
        </div>
        <!-- date of birth -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="date_of_birth">Geburtsdatum</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" aria-describedby="date_of_birthHelp" value="{{ old('date_of_birth') }}">
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
                        <option value="{{ $real_club->id }}">{{ $real_club->name }}</option>
                    @endforeach
                </select>
                <small id="registered_at_clubHelp" class="form-text text-muted">Verein des Spielers auswählen</small>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Anlegen</button>
            <a class="btn btn-secondary" href="{{ route('people.index') }}">Abbrechen</a>
        </div>
    </form>

@endsection