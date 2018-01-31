@extends('admin.adminlayout')

@section('content')

    <!-- edit the user -->
    <h1 class="">User</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $user->name }}</h2>
    <!-- created at -->
    Angelegt: {{ $user->created_at->format('d.m.Y H:i') }} Uhr
    <br>
    <!-- updated at -->
    @if($user->updated_at != $user->created_at)
        Geändert: {{ $user->updated_at->format('d.m.Y H:i') }} Uhr
    @endif
    <hr>
    <h3 class="mt-4 mb-4">User ändern</h3>
    <form method="POST" action="{{ route('users.update', $user) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Name</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="{{ $user->name }}">
                <small id="nameHelp" class="form-text text-muted">Name</small>
            </div>
        </div>
        <!-- email -->
        <div class="form-group row">
            <label for="email" class="form-control-label col-md-2">E-Mail</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="email" id="email" aria-describedby="emailHelp" value="{{ $user->email }}" >
            </div>
        </div>
        <!-- roles -->
        <div class="form-group">
            <span class="col-form-label">Rollen</span>
            @foreach ($roles as $role)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $role->id }}" id="role{{ $loop->iteration }}" name="roles[]" {{ $user->roles->contains($role->id) ? "checked" : null }}>
                    <label class="form-check-label" for="role{{ $loop->iteration }}">
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Ändern</button>
        <a class="btn btn-secondary" href="{{ url()->previous() }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>
    <hr>
    <h3 class="mt-4">User löschen</h3>
    <form method="POST" action="{{ route('users.destroy', $user) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <span class="form-text">Löscht den User und <b>alle zugeordneten Objekte <span class="text-danger">unwiderruflich</span></b>.</span>
        <br>
        <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> Löschen</button>
        <a class="btn btn-secondary" href="{{ url()->previous() }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection