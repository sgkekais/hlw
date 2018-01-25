@extends('admin.adminlayout')

@section('content')

    <!-- create a new role -->
    <h1 class="mb-4">Rolle anlegen</h1>
    <form method="POST" action="{{ route('roles.store') }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Name</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="{{ old('name') }}">
                <small id="nameHelp" class="form-text text-muted">Name der Rolle</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Anzeigename</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="display_name" id="display_name" aria-describedby="display_nameHelp" placeholder="{{ old('display_name') }}">
                <small id="nameHelp" class="form-text text-muted">Welche Bezeichnung soll Besuchern angezeigt werden?</small>
            </div>
        </div>
        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Anlegen</button>
        <a class="btn btn-secondary" href="{{ route('users.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection
