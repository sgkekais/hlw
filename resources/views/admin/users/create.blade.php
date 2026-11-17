@extends('admin.adminlayout')

@section('content')

    <h1 class="">User</h1>
    <hr>
    <h3 class="mt-4 mb-4">User anlegen</h3>
    <form method="POST" action="{{ route('users.store') }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Name</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="{{ old('name') }}">
                <small id="nameHelp" class="form-text text-muted">Name</small>
            </div>
        </div>
        <!-- email -->
        <div class="form-group row">
            <label for="email" class="form-control-label col-md-2">E-Mail</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="email" id="email" aria-describedby="emailHelp" value="{{ old('email') }}" >
            </div>
        </div>
        <!-- password -->
        @include('admin.users._password', ['required' => true])
        <!-- roles -->
        <div class="form-group">
            <span class="col-form-label">Rollen</span>
            @foreach ($roles as $role)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $role->id }}" id="role{{ $loop->iteration }}" name="roles[]" {{ in_array($role->id, old('roles', [])) ? "checked" : null }}>
                    <label class="form-check-label" for="role{{ $loop->iteration }}">
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Anlegen</button>
        <a class="btn btn-secondary" href="{{ url()->previous() }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection
