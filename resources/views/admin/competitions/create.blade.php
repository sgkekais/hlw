@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <!-- create a new competition -->
        <h1 class="mt-4">Wettbewerb anlegen</h1>

        <form method="POST" action="{{ route('competitions.store') }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="{{ old('name', 'Hobbyliga-West') }}">
                <small id="nameHelp" class="form-text text-muted">Bezeichnung des Wettbewerbs</small>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="published" id="published" aria-describedby="pubishHelp">
                    Veröffentlichen
                    <small id="publishHelp" class="form-text text-muted">Wettbewerb veröffentlichen?</small>
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Anlegen</button>
            <a class="btn btn-secondary" href="{{ route('competitions.index') }}">Abbrechen</a>
        </form>
    </div>

@endsection
