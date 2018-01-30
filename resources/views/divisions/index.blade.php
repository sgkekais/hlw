@extends('layouts.app')

@section('title')
    | {{ $division->name }}
@endsection

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('jumbotron')

    <div class="jumbotron jumbotron-fluid p-0" style="color: #fff9c4; background: url({{ $jumbo_bg }}) {{ $division->competition->name_short != "P" ? "top left repeat" : "center" }}; {{ $division->competition->name_short == "P" ? "background-size: cover" : null }}">
        <div class="container pt-4 pb-4">
            <div class="col-12 p-0">
                <div class="display-4 font-weight-bold">
                    @if ($division->competition_id == 1)
                        {{ $division->competition->name_short }} &#448; {{ $division->name }}
                    @else
                        {{ $division->name }}
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')

    <div class="container">
        {{-- fixtures in this week--}}
        @if(!$fixtures->isEmpty())
            <div class="row">
                <div class="col">
                    <h2 class="font-weight-bold font-italic text-uppercase">In dieser Woche</h2>
                    <ul class="list-unstyled">
                        @foreach ($fixtures->sortBy('datetime') as $fixture)
                            @if (!$loop->last)
                                <li class="border border-top-0 border-right-0 border-left-0 mb-2 pb-2 {{ $fixture->rescheduledTo ? "text-muted" : null }}">
                            @else
                                <li class="mb-2 pb-2 {{ $fixture->rescheduledTo ? "text-muted" : null }}">
                            @endif
                            @if ($division->competition->type == "knockout")
                                <div class="row">
                                    <div class="col font-weight-bold">
                                        {{ $fixture->matchweek->name }}
                                    </div>
                                </div>
                            @endif
                            <div class="row d-flex align-items-center">
                                <div class="col-2">
                                    {{ $fixture->datetime ? $fixture->datetime->format('d.m. H:i') : null }}
                                </div>
                                <div class="col-8 col-sm-6 text-center d-flex align-items-center justify-content-center">
                                    <div class="d-inline-block text-right" style="width: 40%">
                                        @if($fixture->clubHome)
                                            @if ($division->competition->isKnockout() && $fixture->clubHome->hasWon($fixture))
                                                <b>
                                                    @endif
                                                    {{-- visible only on xs --}}
                                                    <span class="d-inline d-sm-none align-middle">{{ $fixture->clubHome->name_code }}</span>
                                                    {{-- visible only on sm and md --}}
                                                    <span class="d-none d-sm-inline d-lg-none align-middle">{{ $fixture->clubHome->name_short }}</span>
                                                    {{-- hidden on xs, sm, md --}}
                                                    <span class="d-none d-lg-inline align-middle">{{ $fixture->clubHome->name }}</span>
                                                    @if ($division->competition->type == "knockout" && $fixture->clubHome->hasWon($fixture))
                                                </b>
                                            @endif
                                        @else
                                            <span class="align-middle text-muted">{{ $fixture->club_id_home ?? "-" }}</span>
                                        @endif
                                    </div>
                                    <div class="d-inline-block text-center  {{ $fixture->rescheduledTo ? "text-muted bg-light" : "text-white bg-dark" }} rounded p-1 mx-2" style="word-break: keep-all; width: 60px">
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
                                    <div class="d-inline-block text-left" style="width: 40%;">
                                        @if ($fixture->clubAway)
                                            @if ($division->competition->type == "knockout" && $fixture->clubAway->hasWon($fixture))
                                                <b>
                                                    @endif
                                                    {{-- visible only on xs --}}
                                                    <span class="d-inline d-sm-none align-middle">{{ $fixture->clubAway->name_code }}</span>
                                                    {{-- visible only on sm and md --}}
                                                    <span class="d-none d-sm-inline d-lg-none align-middle">{{ $fixture->clubAway->name_short }}</span>
                                                    {{-- hidden on xs, sm, md --}}
                                                    <span class="d-none d-lg-inline align-middle">{{ $fixture->clubAway->name }}</span>
                                                    @if ($division->competition->type == "knockout" && $fixture->clubAway->hasWon($fixture))
                                                </b>
                                            @endif
                                        @else
                                            <span class="align-middle text-muted">{{ $fixture->club_id_away ?? "-" }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-3 d-none d-sm-block text-left">
                                    @if ($fixture->stadium)
                                        @if ($fixture->clubHome && !$fixture->clubHome->regularStadium->isEmpty() && $fixture->clubHome->regularStadium->first()->id != $fixture->stadium->id)
                                            <span class="text-warning">{{ $fixture->stadium->name_short }}</span>
                                        @else
                                            {{ $fixture->stadium->name_short }}
                                        @endif
                                    @endif
                                </div>
                                <div class="col-2 col-sm-1 text-right">
                                    <a href="{{ route('frontend.fixtures.show', $fixture) }}" title="Spieldetails">
                                        <span class="fa fa-fw fa-arrow-right"></span>
                                    </a>
                                </div>
                            </div>
                            @if ($fixture->rescheduledTo)
                                <div class="row">
                                    <div class="col">
                                        <small><span class="text-danger">Paarung wurde {{ "von ".$fixture->rescheduledTo->rescheduledBy->name_short }} verlegt.</span> Siehe <a href="{{ route('frontend.fixtures.show', $fixture) }}" title="Matchdetails">Spiel</a>  für Details.</small>
                                    </div>
                                </div>
                            @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        {{-- quick standings --}}
        <div class="row">
            <div class="col-md-6">
                @if ($division->competition->isLeague())
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
                                <li class="list-inline-item"><span class="fa fa-fw fa-calendar"></span> <a href="{{ route('frontend.divisions.fixtures', $division) }}">Spielplan</a></li>
                                <li class="list-inline-item"><span class="fa fa-fw fa-list-ol"></span> <a href="{{ route('frontend.divisions.tables', $division) }}">Tabelle</a></li>
                            </ul>
                        </div>
                    @endisset
                @endif
            </div>
            {{-- scorers --}}
            @if (!$scorers->isEmpty())
                <div class="col-md-6">
                    <h2 class="font-weight-bold font-italic">TORSCHÜTZEN</h2>
                    @include ('divisions.response_scorers')
                </div>
            @endif
        </div>
    </div>
@endsection