@extends('admin.adminlayout')

@section('content')

    <h1 class="">Details zu Paarung</h1>
    <div class="row mt-4 mb-4">
        <div class="col-md-12">
            <span class="fa fa-calendar fa-fw"></span>
            @if($fixture->datetime)
                {{ $fixture->datetime->format('d.m.Y H:i:s') }}
            @else
                <i>Kein Termin angegeben.</i>
            @endif
            <br>
            <span class="fa fa-map-marker fa-fw"></span>
            @if($fixture->stadium)
                @if($fixture->stadium->gmaps)
                    <a href="{{ $fixture->stadium->gmaps }}" target="_blank">
                @endif
                    {{ $fixture->stadium->name }}
                @if($fixture->stadium->gmaps)
                    </a>
                @endif
            @else
                <i>Kein Spielort angegeben.</i>
            @endif

            @if($fixture->club_home)
                <a href="{{ route('clubs.show', $fixture->club_home) }}" title="Mannschaft anzeigen">{{ $fixture->club_home->name }}</a>
            @endif
             vs.
            @if($fixture->club_away)
                <a href="{{ route('clubs.show', $fixture->club_away) }}" title="Mannschaft anzeigen">{{ $fixture->club_away->name }}</a>
            @endif
            <br>
            Ergebnis: {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary" href="{{ route('matchweeks.fixtures.edit', [$matchweek, $fixture]) }}" title="Paarung bearbeiten">
                <span class="fa fa-pencil-square-o" aria-hidden="true"></span> Paarung bearbeiten
            </a>
        </div>
    </div>
    <hr>
    <!-- show fixture details -->
    <div class="row">
        <div class="col-md-4">
            <h3 class="mt-4">Tore</h3>

                <!-- add goals, if goals_home or goals_away not null -->
                @if($fixture->goals_home || $fixture->goals_away )
                    <a class="btn btn-outline-success" href="#" title="Tore pflegen">
                        <span class="fa fa-soccer-ball-o" aria-hidden="true"></span>
                    </a>
                @else
                <i>Noch kein Ergebnis eingetragen.</i>
                @endif

        </div>
        <div class="col-md-4">
            <h3 class="mt-4">Karten</h3>
            <!-- add cards -->
                <a class="btn btn-outline-warning" href="#" title="Karten pflegen">
                    <span class="fa fa-clone" aria-hidden="true"></span> Karten eintragen
                </a>

        </div>
        <div class="col-md-4">

        </div>
    </div>


@endsection