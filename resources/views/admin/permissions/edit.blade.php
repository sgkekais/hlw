@extends('admin.adminlayout')

@section('content')

    <!-- edit a permission -->
    <h1 class="mb-4">Berechtigung ändern</h1>
    <form method="POST" action="{{ route('permissions.update', $permission) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Name</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="{{ $permission->name }}" >
                <small id="nameHelp" class="form-text text-muted">Bezeichnung der Berechtigung</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Beschreibung</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="description" id="description" aria-describedby="descriptionHelp" value="{{ $permission->description }}">
                <small id="descriptionHelp" class="form-text text-muted">Beschreibung der Berechtigung</small>
            </div>
        </div>
        <h4>Rollen zuordnen:</h4>
        <div class="form-group">
            @foreach ($roles as $role)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $role->id }}" id="role{{ $loop->iteration }}" name="roles[]" {{ $permission->roles->contains($role->id) ? "checked" : null }}>
                    <label class="form-check-label" for="role{{ $loop->iteration }}">
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Ändern</button>
        <a class="btn btn-secondary" href="{{ route('users.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection