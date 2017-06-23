@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <!-- create a new season -->
        <h1 class="mt-4 mb-4">Saison anlegen</h1>

        <form method="POST" action="{{ route('seasons.store') }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            <!-- competition -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="division_id">Wettbewerb</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="competition_id" name="competition_id" aria-describedby="competition_idHelp">
                        @foreach($competitions = \App\Competition::all() as $competition)
                            <option value="{{ $competition->id }}">{{ $competition->name }}</option>
                        @endforeach
                    </select>
                    <small id="competition_idHelp" class="form-text text-muted">Zuordnung zu welchem Wettbewerb?</small>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="name">Name</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="{{ old('name', 'Hobbyliga-West') }}">
                    <small id="nameHelp" class="form-text text-muted">Bezeichnung der Spielklasse</small>
                </div>
            </div>
            <!-- hierarchy level -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="hierarchy_level">Hierarchiebene</label>
                </div>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="hierarchy_level" id="hierarchy_level" aria-describedby="hierarchy_levelHelp" placeholder="{{ old('hierarchy_level', '1') }}">
                    <small id="hierarchy_levelHelp" class="form-text text-muted">Hierarchiebene der Spielklasse, bspw. 2 für 2. Liga</small>
                </div>
            </div>

            <!-- published -->
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="published" id="published" aria-describedby="pubishHelp">
                    Veröffentlichen
                    <small id="publishHelp" class="form-text text-muted">Spielklasse veröffentlichen?</small>
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Anlegen</button>
            <a class="btn btn-secondary" href="{{ route('seasons.index') }}">Abbrechen</a>
        </form>
    </div>

@endsection