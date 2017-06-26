@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <!-- create a new competition -->
        <h1 class="mt-4 mb-4">Wettbewerb anlegen</h1>
        <form method="POST" action="{{ route('competitions.store') }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="name">Name</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="{{ old('name', 'Hobbyliga-West') }}">
                    <small id="nameHelp" class="form-text text-muted">Bezeichnung des Wettbewerbs</small>
                </div>
            </div>
            <!-- published -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="published">Veröffentlichen?</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="published" name="published" aria-describedby="publishedHelp">
                        <option value="0">Nein</option>
                        <option value="1">Ja</option>
                    </select>
                    <small id="publishedHelp" class="form-text text-muted">Wettbewerb auf Seite veröffentlichen?</small>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Anlegen</button>
            <a class="btn btn-secondary" href="{{ route('competitions.index') }}">Abbrechen</a>
        </form>
    </div>

@endsection
