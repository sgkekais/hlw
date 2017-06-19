@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <!-- create a new competition -->
        <h1>Wettbewerb anlegen</h1>

        <form method="POST" action="{{ route('competitions.store') }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="{{ old('name') }}">
                <small id="nameHelp" class="form-text text-muted">Bezeichnung des Wettbewerbs</small>
            </div>
            <button type="submit" class="btn btn-primary">Anlegen</button>
        </form>
    </div>

@endsection
