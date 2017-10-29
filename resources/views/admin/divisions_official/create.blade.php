@extends('admin.adminlayout')

@section('content')

    <!-- create a new division -->
    <h1 class="mb-4">Offizielle Spielklasse anlegen</h1>
    <form method="POST" action="{{ route('divisions-official.store') }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <div class="form-group row">
            <div class="col-md-2">
                <label for="name">Name</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="{{ old('name', 'Kreisliga A') }}">
                <small id="nameHelp" class="form-text text-muted">Bezeichnung der off. Spielklasse</small>
            </div>
            <div class="col-md-2">
                <label for="name_short">Name kurz</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="name_short" id="name_short" aria-describedby="name_shortHelp" placeholder="{{ old('name_short', 'Kl. A') }}">
                <small id="nameHelp" class="form-text text-muted">Kurzbezeichnung der off. Spielklasse</small>
            </div>
        </div>
        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Anlegen</button>
        <a class="btn btn-secondary" href="{{ route('divisions-official.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection