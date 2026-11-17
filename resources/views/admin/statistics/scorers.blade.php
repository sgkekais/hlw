@extends('admin.adminlayout')

@section('content')

    <h1 class="">Torschützen</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $division->competition->name }} {{ $division->name }}</h2>
    <p class="text-muted">
        Es zählen nur die Tore gespielter Spiele. Tore in nachträglich gewerteten oder annullierten Spielen werden nicht berücksichtigt.
    </p>

    @include('admin.statistics._tabs')

    @include('admin.statistics._season_select')

    @if ($scorers->isEmpty())
        <div class="alert alert-info">Keine Torschützen in dieser Saison.</div>
    @else
        @include('divisions.response_scorers')
    @endif

@endsection
