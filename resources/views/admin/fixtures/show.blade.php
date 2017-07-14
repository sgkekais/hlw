@extends('admin.adminlayout')

@section('content')

    <h1 class="">Details zu Paarung</h1>
    <div class="row justify-content-center mt-4 mb-4">
        <div class="col-md-12 text-center">
            @if($fixture->date)
                <span class="fa fa-calendar"></span> {{ $fixture->date->format('d.m.Y') }}
            @endif
            @if($fixture->time)
                <br>
                <span class="fa fa-clock-o"></span> {{ $fixture->time }}
            @endif
            @if($fixture->stadium)
                <br>
                <span class="fa fa-map-marker"></span> {{ $fixture->stadium->name }}
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
    <h3 class="mt-4">
        Karten, Tore, Verlegungen
    </h3>
    <div class="row">
        <div class="col-md-12">

        </div>
    </div> <!-- ./details -->

@endsection