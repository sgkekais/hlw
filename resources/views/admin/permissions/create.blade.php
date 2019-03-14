@extends('admin.adminlayout')

@section('content')

    <!-- create a new permission -->
    <h1 class="mb-4">Berechtigung anlegen</h1>
    <form method="POST" action="{{ route('permissions.store') }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Name</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="{{ old('name') }}">
                <small id="nameHelp" class="form-text text-muted">Bezeichnung der Berechtigung</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Beschreibung</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="description" id="description" aria-describedby="descriptionHelp" placeholder="{{ old('description') }}">
                <small id="descriptionHelp" class="form-text text-muted">Beschreibung der Berechtigung</small>
            </div>
        </div>
        <h4>Rollen zuordnen:</h4>
        <div class="form-group ">
            @if (!$roles->isEmpty())
                @foreach ($roles as $role)
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" name="roles[]" type="checkbox" value="{{ $role->id }}">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            @endif
        </div>

        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Anlegen</button>
        <a class="btn btn-secondary" href="{{ route('users.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection
