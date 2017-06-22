@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <!-- create a new competition -->
        <h1 class="mt-4">Wettbewerb anlegen</h1>

        <form method="POST" action="{{ route('competitions.update', $competition) }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" value="{{ $competition->name }}" placeholder="{{ $competition->name }}">
                <small id="nameHelp" class="form-text text-muted">Bezeichnung des Wettbewerbs</small>
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
    </div>

@endsection