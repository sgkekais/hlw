@extends('admin.adminlayout')

@section('content')

    <h1 class="">Details zu Paarung</h1>
    <div class="row justify-content-center mt-4 mb-4">
        <div class="col-md-12 text-center">
            @if($fixture->datetime)
                <span class="fa fa-calendar"></span> {{ $fixture->datetime->format('d.m.Y H:i:s') }}
            @endif
            @if($fixture->stadium)
                <br>
                <span class="fa fa-map-marker"></span>
                    @if($fixture->stadium->gmaps)
                        <a href="{{ $fixture->stadium->gmaps }}" target="_blank">
                    @endif
                        {{ $fixture->stadium->name }}
                    @if($fixture->stadium->gmaps)
                        </a>
                    @endif
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-5 text-right">
            @if($fixture->club_home)
                <a href="{{ route('clubs.show', $fixture->club_home) }}" title="Mannschaft anzeigen">{{ $fixture->club_home->name }}<img src="{{ $fixture->club_home->logo_url ? Storage::url($fixture->club_home->logo_url) : null }}" height="100" class="pl-2"></a>
            @endif
        </div>
        <div class="col-md-1 text-center">
            <h3 class="text-muted text-center">{{ $fixture->goals_home }} : {{ $fixture->goals_away }}</h3>
        </div>
        <div class="col-md-5 text-left">
            @if($fixture->club_away)
                <a href="{{ route('clubs.show', $fixture->club_away) }}" title="Mannschaft anzeigen"><img src="{{ $fixture->club_away->logo_url ? Storage::url($fixture->club_away->logo_url) : null}}" height="100" class="pr-2">{{ $fixture->club_away->name }}</a>
            @endif
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
                    Kein Tor
                @endif

        </div>
        <div class="col-md-4">
            <h3 class="mt-4">Karten</h3>
            <!-- add cards -->
                <a class="btn btn-outline-warning" href="#" title="Karten pflegen">
                    <span class="fa fa-clone" aria-hidden="true"></span> Karten eintragen
                </a>
                Liste der Karten...
        </div>
        <div class="col-md-4">

        </div>
    </div>


@endsection