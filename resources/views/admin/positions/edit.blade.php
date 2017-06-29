@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <!-- create a new position -->
        <h1 class="mt-4 mb-4">Position bearbeiten</h1>
        <h2 class="mt-4 text-primary">&mdash; {{ $position->name }}</h2>
        <!-- created at -->
        Angelegt: {{ $position->created_at->format('d.m.Y H:i') }} Uhr
        @if($causer = ModelHelper::causerOfAction($position,'created'))
            von {{ $causer->name }}
        @endif
        <br>
        <!-- updated at -->
        @if($position->updated_at != $position->created_at)
            Geändert: {{ $position->updated_at->format('d.m.Y H:i') }} Uhr
            @if($causer = ModelHelper::causerOfAction($position,'updated'))
                von {{ $causer->name }}
            @endif
        @endif
        <hr>
        <h3 class="mt-4 mb-4">Position ändern</h3>
        <form method="POST" action="{{ route('positions.update', $position) }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <!-- name -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="name">Name</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="{{ $position->name }}">
                    <small id="nameHelp" class="form-text text-muted">Bezeichnung der Position</small>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Ändern</button>
                <a class="btn btn-secondary" href="{{ route('positions.index') }}">Abbrechen</a>
            </div>
        </form>
        <hr>
        <h3 class="mt-4 mb-4">Position löschen</h3>
        <form method="POST" action="{{ route('positions.destroy', $position) }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <span class="form-text">Löscht die Position.</span>
            <br>
            <button type="submit" class="btn btn-danger">Löschen</button>
            <a class="btn btn-secondary" href="{{ url()->previous() }}">Abbrechen</a>
        </form>
    </div>

@endsection