@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <!-- edit the competition -->
        <h1 class="mt-4">Wettbewerb</h1>
        <h2 class="mt-4 text-primary">&mdash; {{ $competition->name }}</h2>
        <!-- created at -->
        Angelegt: {{ $competition->created_at->format('d.m.Y H:i') }} Uhr
        @if($causer = ModelHelper::causerOfAction($competition,'created'))
            von {{ $causer->name }}
        @endif
        <br>
        <!-- updated at -->
        @if($competition->updated_at != $competition->created_at)
            Geändert: {{ $competition->updated_at->format('d.m.Y H:i') }} Uhr
            @if($causer = ModelHelper::causerOfAction($competition,'updated'))
                von {{ $causer->name }}
            @endif
        @endif
        <hr>
        <h3 class="mt-4 mb-4">Wettbewerb ändern</h3>
        <form method="POST" action="{{ route('competitions.update', $competition) }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="name">Name</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="{{ $competition->name }}" placeholder="{{ $competition->name }}">
                    <small id="nameHelp" class="form-text text-muted">Bezeichnung des Wettbewerbs</small>
                </div>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="published" id="published" aria-describedby="publishHelp" {{ $competition->published ? "checked" : "" }}>
                    Veröffentlichen
                    <small id="publishHelp" class="form-text text-muted">Wettbewerb veröffentlichen?</small>
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Ändern</button>
            <a class="btn btn-secondary" href="{{ url()->previous() }}">Abbrechen</a>
        </form>
        <hr>
        <h3 class="mt-4">Wettbewerb löschen</h3>
        <form method="POST" action="{{ route('competitions.destroy', $competition) }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <span class="form-text">Löscht den Wettbewerb und <b>alle zugeordneten Objekte <span class="text-danger">unwiderruflich</span></b>.</span>
            <br>
            <button type="submit" class="btn btn-danger">Löschen</button>
            <a class="btn btn-secondary" href="{{ url()->previous() }}">Abbrechen</a>
        </form>

    </div>

@endsection