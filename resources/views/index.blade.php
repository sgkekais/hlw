@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-fluid p-0" style="color: #fff9c4; background: url({{ asset('images/duesseldorf.jpg') }}) left; background-size: cover;">
        <div class="pt-4 pb-4" style="box-shadow: inset 0px 5px 5px 0px rgba(173,173,173,0.5); width: 100%; height: 100%">
            <div class="container pt-4 pb-4">
                <div class="col-12 p-0">
                    <div class="display-4 font-weight-bold">
                        Hobbyliga-West Düsseldorf
                    </div>
                    <h1>
                        Die Fußballliga für Hobby- und Freizeitmannschaften aus Düsseldorf und Umgebung.
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <!-- fixtures of the current week -->
        @if($fixtures->count() > 0)
            <div class="row">
                <div class="col">
                    <h1 class="font-weight-bold font-italic">In dieser Woche</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @foreach ($fixtures->chunk(6) as $chunk)
                        <div class="row">
                            @foreach($chunk as $fixture)
                                <div class="col-6 col-sm-4 col-md-3 col-lg-2 {{ !$loop->last ? "border border-left-0 border-top-0 border-bottom-0" : null }} mt-2 mb-2">
                                    {{-- details --}}
                                    <div class="row">
                                        <div class="col-6 pr-0 text-muted">
                                            <small>{{ $fixture->datetime ? $fixture->datetime->format('d.m.') : "-" }}</small>
                                        </div>
                                        <div class="col-6 pl-0 text-muted text-right">
                                            <small>{{ $fixture->datetime ? $fixture->datetime->format('H:i') : "-" }}</small>
                                        </div>
                                    </div>
                                    {{-- top row --}}
                                    <div class="row">
                                        <div class="col-9 pr-0">
                                            @if($fixture->clubHome)
                                                @if($fixture->clubHome->logo_url)
                                                    <img src="{{ Storage::url($fixture->clubHome->logo_url) }}" width="30">
                                                @else
                                                    <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                                @endif
                                                <span class="pl-1 d-none d-lg-inline align-middle">{{ $fixture->clubHome->name_short }}</span>
                                                <span class="pl-1 d-lg-none align-middle">{{ $fixture->clubHome->name_code }}</span>
                                            @else
                                                -
                                            @endif
                                        </div>
                                        <div class="col-3 pl-0 text-right">
                                            @if($fixture->isPlayed() && !$fixture->isRated())
                                                {{ $fixture->goals_home ?? "-" }}
                                            @elseif($fixture->isRated())
                                                {{ $fixture->goals_home_rated ?? "-" }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    {{-- bottom row --}}
                                    <div class="row pt-1">
                                        <div class="col-9 pr-0">
                                            @if($fixture->clubAway)
                                                @if($fixture->clubAway->logo_url)
                                                    <img src="{{ Storage::url($fixture->clubAway->logo_url) }}" width="30">
                                                @else
                                                    <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                                @endif
                                                <span class="pl-1 d-none d-lg-inline align-middle">{{ $fixture->clubAway->name_short }}</span>
                                                <span class="pl-1 d-lg-none align-middle">{{ $fixture->clubAway->name_code }}</span>
                                            @else
                                                -
                                            @endif
                                        </div>
                                        <div class="col-3 pl-0 text-right">
                                            @if($fixture->isPlayed() && !$fixture->isRated())
                                                {{ $fixture->goals_away ?? "-" }}
                                            @elseif($fixture->isRated())
                                                {{ $fixture->goals_away_rated ?? "-" }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @unless ($loop->last)
                            <hr class="d-none d-lg-block">
                        @endunless
                    @endforeach
                </div>
            </div>
        @endif
        <!-- end fixtures of the current week -->
        <!-- shortened standings for leagues -->
        <hr>
        <div class="row">
            @foreach ($divisions as $division)
                <div class="col-md-4 {{ !$loop->last ? "border border-left-0 border-top-0 border-bottom-0" : null }}">
                    <h3 class="font-weight-bold font-italic">{{ $division->competition->name_short." &ndash; ".$division->name }}</h3>
                    @php
                        // $c_season = $division->seasons()->published()->current()->first();
                        $c_season = $division->currentSeason();
                        if ($c_season) {
                            $c_matchweek = $c_season->currentMatchweek();
                        }
                    @endphp
                    @if ($c_season && $c_matchweek)
                        {{-- TODO: render partial view for this collection ('c_season') --}}
                        <h4 class="text-muted">
                            SW {{ $c_matchweek->number_consecutive ?? null }}
                            <small class="text-muted">
                                {{ $c_matchweek->begin ? $c_matchweek->begin->format('d.m.y') : null }}
                                {{ $c_matchweek->end ? "bis ".$c_matchweek->end->format('d.m.y') : null }}
                            </small>
                        </h4>

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
                                @foreach ($c_season->generateTable($c_matchweek) as $club)
                                    @php
                                        $rank_color = null;
                                        $rank_icon  = null;
                                    @endphp
                                    @if(in_array($club->t_rank, $c_season->ranks_champion) || in_array($club->t_rank, $c_season->ranks_promotion))
                                        @php
                                            $rank_color = "#FFC107";
                                            $rank_icon  = "fa-circle";
                                        @endphp
                                    @elseif(in_array($club->t_rank, $c_season->ranks_relegation))
                                        @php
                                            $rank_color = "#F44336";
                                            $rank_icon  = "fa-circle";
                                        @endphp
                                    @elseif(in_array($club->t_rank, $c_season->playoff_relegation))
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
                                                <img src="{{ asset('storage/'.$club->logo_url) }}" width="25">
                                            @else
                                                <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                            @endif
                                            <a href="{{ route('frontend.clubs.show', $club) }}" class="pl-1 align-middle" title="{{ $club->name }}">
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
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection