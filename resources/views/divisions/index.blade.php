@extends('layouts.app')

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('jumbotron')

    <div class="jumbotron jumbotron-fluid p-0" style="color: #fff9c4; background: url({{ $jumbo_bg }}) {{ $division->competition->name_short != "P" ? "top left repeat" : "center" }}; {{ $division->competition->name_short == "P" ? "background-size: cover" : null }}">
        <div class="pt-4 pb-4" style="box-shadow: inset 0px 5px 5px 0px rgba(173,173,173,0.5); width: 100%; height: 100%">
            <div class="container pt-4 pb-4">
                <div class="col-12 p-0">
                    <div class="display-4 font-weight-bold">
                        {{ $division->name }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')

    <div class="container pt-4">
        <div class="row">
            <div class="col">
                <h1 class="font-weight-bold font-italic text-uppercase">
                    @if($division->competition->isLeague())
                        {{ $division->competition->name_short }} -  {{ $division->name }}
                    @elseif($division->competition->isKnockout())
                        {{ $division->competition->name }}
                    @endif
                </h1>
                <span class="">
                    x Teams, y Spieler, ... ?
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h2 class="font-weight-bold font-italic text-uppercase">In dieser Woche</h2>
            </div>
        </div>
        <div class="row">
            {{-- quick standings --}}
            <div class="col-md-6">
                @if($division->competition->isLeague())
                    <h2 class="font-weight-bold font-italic">TABELLE</h2>
                    @isset($season)
                        <table class="table table-hover table-striped table-sm">
                            <thead>
                            <tr>
                                <th class="">Pos</th>
                                <th class="">Club</th>
                                <th class=" text-center">Sp</th>
                                <th class=" text-center">TD</th>
                                <th class=" text-center">Pkt</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($season->generateTable($matchweek) as $club)
                                @php
                                    $rank_color = null;
                                    $rank_icon  = null;
                                @endphp
                                @if(in_array($club->t_rank, $season->ranks_champion) || in_array($club->t_rank, $season->ranks_promotion))
                                    @php
                                        $rank_color = "#FFC107";
                                        $rank_icon  = "fa-circle";
                                    @endphp
                                @elseif(in_array($club->t_rank, $season->ranks_relegation))
                                    @php
                                        $rank_color = "#F44336";
                                        $rank_icon  = "fa-circle";
                                    @endphp
                                @elseif(in_array($club->t_rank, $season->playoff_relegation))
                                    @php
                                        $rank_color = "#FF9800";
                                        $rank_icon  = "fa-circle-o";
                                    @endphp
                                @endif
                                <tr>
                                    <td class="align-middle">
                                        @if($rank_icon)
                                            <span class="fa fa-fw {{ $rank_icon }}" style="color: {{ $rank_color }};"></span>
                                        @else
                                            <span class="fa fa-fw"></span>
                                        @endif
                                        {{ $club->t_rank }}
                                    </td>
                                    <td class="align-middle">
                                        @if($club->logo_url)
                                            <img src="{{ asset('storage/'.$club->logo_url) }}" width="30" class="pr-1">
                                        @else
                                            <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                        @endif
                                        <a href="{{ route('frontend.clubs.show', $club) }}" title="{{ $club->name }}">
                                            {{ $club->name_code }}
                                        </a>
                                    </td>
                                    <td class="align-middle text-center">{{ $club->t_played }}</td>
                                    <td class="align-middle text-center">{{ $club->t_goals_diff }}</td>
                                    <td class="align-middle text-center">{{ $club->t_points }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-right">
                            <ul class="list-inline">
                                <li class="list-inline-item"><span class="fa fa-fw fa-calendar-o"></span> <a href="{{ route('frontend.divisions.fixtures', $division) }}">Spielplan</a></li>
                                <li class="list-inline-item"><span class="fa fa-fw fa-table"></span> <a href="{{ route('frontend.divisions.tables', $division) }}">Tabelle</a></li>
                            </ul>
                        </div>
                    @endisset
                @endif
            </div>
            {{-- scorers --}}
            <div class="col-md-6">
                <h2 class="font-weight-bold font-italic">TORSCHÜTZEN</h2>
            </div>
        </div>
    </div>
@endsection