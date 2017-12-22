@extends('layouts.app')

@section('jumbotron')

    <div class="jumbotron jumbotron-fluid p-0" style="color: #fff9c4; background: url({{ asset('images/duesseldorf.jpg') }}) left; background-size: cover;">
        <div class="pt-4 pb-4" style="box-shadow: inset 0px 5px 5px 0px rgba(173,173,173,0.5); width: 100%; height: 100%">
            <div class="container pt-4 pb-4">
                <div class="col-12 p-0">
                    <div class="display-4 font-weight-bold">
                        <span class="px-1 bg-black-transparent">Hobbyliga-West Düsseldorf</span>
                    </div>
                    <h1>
                        <span class="px-1 bg-black-transparent">Die Fußballliga für Hobby- und Freizeitmannschaften aus Düsseldorf und Umgebung.</span>
                    </h1>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
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
                    <ul class="list-unstyled">
                        @foreach ($fixtures as $fixture)
                            @if (!$loop->last)
                                <li class="border border-top-0 border-right-0 border-left-0">
                            @else
                                <li>
                            @endif
                                <div class="row">
                                    <div class="col-2">
                                        {{ $fixture->datetime ? $fixture->datetime->format('d.m. H:i') : null }}
                                    </div>
                                    <div class="col-3 text-right">
                                        {{ $fixture->clubHome ? $fixture->clubHome->name : null }}
                                    </div>
                                    <div class="col-2 text-center">
                                        {{-- cancelled? --}}
                                        @if ($fixture->isCancelled())
                                            <span class="text-danger">Ann.</span>
                                            {{-- rated? --}}
                                        @elseif ($fixture->isRated())
                                            <span class="text-warning">{{ $fixture->goals_home_rated }} : {{ $fixture->goals_away_rated }}</span>
                                            {{-- played and *not* rated? --}}
                                        @elseif ($fixture->isPlayed() && !$fixture->isRated())
                                            {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
                                            @if ($fixture->isPenalty())
                                                <br><small>({{ $fixture->goals_home_11m }} : {{ $fixture->goals_away_11m }})</small>
                                            @endif
                                        @else
                                            -&nbsp;:&nbsp;-
                                        @endif
                                    </div>
                                    <div class="col-3">
                                        {{ $fixture->clubAway ? $fixture->clubAway->name : null }}
                                    </div>
                                    <div class="col-2 text-right">
                                        <a href="{{ route('frontend.fixtures.show', $fixture) }}" title="Match betrachten">
                                            <span class="fa fa-fw fa-arrow-right"></span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <!-- end fixtures of the current week -->
        <!-- shortened standings for leagues -->
        <hr>
        <div class="row">
            @foreach ($divisions as $division)
                <div class="col-md-4">
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
                            @if (Carbon::now() > $c_matchweek->end)
                                Abschluss
                            @else
                                SW {{ $c_matchweek->number_consecutive ?? null }}
                                <small class="text-muted">
                                    {{ $c_matchweek->begin ? $c_matchweek->begin->format('d.m.y') : null }}
                                    {{ $c_matchweek->end ? "bis ".$c_matchweek->end->format('d.m.y') : null }}
                                </small>
                            @endif
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