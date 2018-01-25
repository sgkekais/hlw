@extends('admin.adminlayout')

@section('content')

    <!-- create a new role -->
    <h1 class="mb-4">Rolle ändern</h1>
    <form method="POST" action="{{ route('roles.update', $role) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Name</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="{{ $role->name }}" >
                <small id="nameHelp" class="form-text text-muted">Bezeichnung der Rolle</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Anzeigename</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="display_name" id="display_name" aria-describedby="display_nameHelp" value="{{ $role->display_name }}">
                <small id="nameHelp" class="form-text text-muted">Welche Bezeichnung soll Besuchern angezeigt werden?</small>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Ändern</button>
        <a class="btn btn-secondary" href="{{ route('users.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection