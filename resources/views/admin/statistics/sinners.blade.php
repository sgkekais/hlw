@extends('admin.adminlayout')

@section('content')

    <h1 class="">Sünderkartei</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $division->competition->name }} {{ $division->name }}</h2>
    <p class="text-muted">
        Die Zahl in Klammern gibt die Anzahl der Spiele wieder, die der Spieler noch gesperrt ist.
    </p>

    @include('admin.statistics._tabs')

    @include('admin.statistics._season_select')

    @include('divisions.response_sinners')

    @include('divisions._lifetime_bans')

@endsection
