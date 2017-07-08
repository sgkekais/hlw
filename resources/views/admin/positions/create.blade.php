@extends('admin.adminlayout')

@section('content')

    <!-- create a new position -->
    <h1 class="mb-4">Position anlegen</h1>
    <form method="POST" action="{{ route('positions.store') }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <!-- names -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Name</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="{{ old('name', 'Tor') }}">
                <small id="nameHelp" class="form-text text-muted">Bezeichnung der Position</small>
            </div>
        </div>
        <!-- type -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="type">Typ</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" name="type" id="type">
                    <option></option>
                    <option value="player">Spieler</option>
                    <option value="staff">Stab</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Anlegen</button>
            <a class="btn btn-secondary" href="{{ route('positions.index') }}">Abbrechen</a>
        </div>
    </form>

@endsection