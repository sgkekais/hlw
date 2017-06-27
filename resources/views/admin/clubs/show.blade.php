@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1 class="mt-4">Details zu Mannschaft</h1>
        <h2 class="mt-4 text-primary">&mdash; {{ $club->name }}</h2>

        <div class="row">
            <div class="col-md-6">
                <h3 class="mt-4">Aktionen</h3>
                <a class="btn btn-primary mb-4" href="{{ route('clubs.edit', $club ) }}" title="Wettbewerb bearbeiten">
                    <span class="fa fa-pencil"></span> Bearbeiten
                </a>
            </div>
            <!-- dates -->
            <div class="col-md-6">
                <h3 class="mt-4">Änderungen</h3>
                <!-- published -->
                @if($club->published)
                    <span class="fa fa-eye"></span> Öffentlich
                @else
                    <span class="fa fa-eye-slash"></span> <b>Nicht</b> öffentlich
                @endif
                <br>
                <!-- created at -->
                Angelegt am: {{ $club->created_at->format('d.m.Y H:i') }} Uhr
                @if($causer = ModelHelper::causerOfAction($club,'created'))
                    von {{ $causer->name }}
                @endif
                <br>
                <!-- updated at -->
                @if($club->updated_at != $club->created_at)
                    Geändert am: {{ $club->updated_at->format('d.m.Y H:i') }} Uhr
                    @if($causer = ModelHelper::causerOfAction($club,'updated'))
                        von {{ $causer->name }}
                    @endif
                @endif
            </div>
        </div>
        <hr>
        <h3 class="mt-4 mb-4">Zuordnungen</h3>
        <!-- show club tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#fixtures" role="tab">Paarungen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#players" role="tab">Kader</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#stadiums" role="tab">Spielort(e)</a>
            </li>
        </ul>
        <!-- show club details -->
        <div class="tab-content">
            <div class="tab-pane active" id="fixtures" role="tabpanel">
                Saisons: {{ $club->seasons->count() }}

                + jeweilige Paarungen
            </div>
            <div class="tab-pane" id="players" role="tabpanel">
                <a class="btn btn-primary mb-4" href="{{ route('players.create', $club ) }}" title="Spieler zuordnen">
                    <span class="fa fa-pencil"></span> Spieler zuordnen
                </a>
                Kader (aktiv + ehemalige)
                <br>
                Aktiv: {{ $club->players()->whereNull('sign_off')->count() }}
                Ehemalige: {{ $club->players()->whereNotNull('sign_off')->count() }}
            </div>
            <div class="tab-pane" id="stadiums" role="tabpanel">
                Spielort(e): {{ $club->stadiums->count() }}

            </div>
        </div>
    </div>
@endsection