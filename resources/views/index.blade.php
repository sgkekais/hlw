@extends('layouts.app')

@section('title')

@endsection

@section('content')
    @include('cookieConsent::index')
    <div class="container">
        <!-- fixtures of the current week -->
        @if($fixtures_grouped_by_divisions->count() > 0)
            <div class="row">
                <div class="col">
                    <h2 class="font-weight-bold font-italic text-uppercase">
                        In dieser Woche
                        <small class="pull-right text-muted">
                            {{ Carbon::now()->startOfWeek()->format('d.m.y') }} - {{ Carbon::now()->endOfWeek()->format('d.m.y') }}
                        </small>
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul class="list-unstyled">
                        @foreach ($fixtures_grouped_by_divisions as $division => $fixtures)
                            <div class="row mb-2">
                                <div class="col-12">
                                    <h4 class="p-1 text-center bg-light rounded">
                                        @php
                                            $d = \HLW\Division::findOrFail($division);
                                        @endphp
                                        <a href="{{ route('frontend.divisions.show', $d) }}">{{ $d->name }}</a>
                                    </h4>
                                </div>
                            </div>
                            @foreach ($fixtures->sortBy('datetime') as $fixture)
                                @if (!$loop->last)
                                    <li class="border border-top-0 border-right-0 border-left-0 mb-2 pb-2 {{ $fixture->rescheduledTo ? "text-muted" : null }}">
                                @else
                                    <li class="mb-2 pb-2 {{ $fixture->rescheduledTo ? "text-muted" : null }}">
                                @endif
                                    @if ($d->competition->type == "knockout" && $loop->first)
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
                                                    @if ($d->competition->type == "knockout" && $fixture->clubHome->hasWon($fixture))
                                                        <b>
                                                    @endif
                                                    {{-- visible only on xs --}}
                                                    <span class="d-inline d-sm-none align-middle">{{ $fixture->clubHome->name_code }}</span>
                                                    {{-- visible only on sm and md --}}
                                                    <span class="d-none d-sm-inline d-lg-none align-middle">{{ $fixture->clubHome->name_short }}</span>
                                                    {{-- hidden on xs, sm, md --}}
                                                    <span class="d-none d-lg-inline align-middle">{{ $fixture->clubHome->name }}</span>
                                                    @if ($d->competition->type == "knockout" && $fixture->clubHome->hasWon($fixture))
                                                        </b>
                                                    @endif
                                                @else
                                                    <span class="align-middle">{{ $fixture->club_home }}</span>
                                                @endif
                                            </div>
                                            <div class="d-inline-block text-center {{ $fixture->rescheduledTo || $fixture->isCancelled() ? "text-muted bg-light" : "text-white bg-dark" }} rounded p-1 mx-2" style="word-break: keep-all; width: 60px">
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
                                                    @if ($d->competition->type == "knockout" && $fixture->clubAway->hasWon($fixture))
                                                        <b>
                                                    @endif
                                                    {{-- visible only on xs --}}
                                                    <span class="d-inline d-sm-none align-middle">{{ $fixture->clubAway->name_code }}</span>
                                                    {{-- visible only on sm and md --}}
                                                    <span class="d-none d-sm-inline d-lg-none align-middle">{{ $fixture->clubAway->name_short }}</span>
                                                    {{-- hidden on xs, sm, md --}}
                                                    <span class="d-none d-lg-inline align-middle">{{ $fixture->clubAway->name }}</span>
                                                    @if ($d->competition->type == "knockout" && $fixture->clubAway->hasWon($fixture))
                                                        </b>
                                                    @endif
                                                @else
                                                    <span class="align-middle">{{ $fixture->club_away }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-3 d-none d-sm-block text-left">
                                            @if ($fixture->stadium)
                                                @if ($fixture->clubHome && !$fixture->clubHome->regularStadium->isEmpty() && $fixture->clubHome->regularStadium->first()->id != $fixture->stadium->id)
                                                    <span class="text-warning"><abbr title="abweichender Spielort">{{ $fixture->stadium->name_short }}</abbr></span>
                                                @else
                                                    {{ $fixture->stadium->name_short }}
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-2 col-sm-1 d-flex flex-row flex-sm-column flex-md-row justify-content-end align-items-center">
                                            <a href="{{ route('frontend.fixtures.show', $fixture) }}" class="order-1 pl-1 pl-sm-0 pl-md-1" title="Spieldetails">
                                                <span class="fa fa-fw fa-arrow-right"></span>
                                            </a>
                                            @if (!$fixture->goals->isEmpty())
                                                <span class="fa fa-fw fa-soccer-ball-o text-secondary" style="font-size: .8rem" data-toggle="tooltip" title="Torschützen vorhanden"></span>
                                            @endif
                                            @if (!$fixture->cards->isEmpty())
                                                <span class="fa fa-fw fa-clone pl-1 pt-0 pl-sm-0 pt-sm-1 pl-md-1 pt-md-0 text-secondary" style="font-size: .8rem" data-toggle="tooltip" title="Karten vorhanden"></span>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($fixture->rescheduledTo)
                                        <div class="row">
                                            <div class="col">
                                                <small><span class="text-warning">Paarung wurde {{ $fixture->rescheduledTo->rescheduledBy ? "von ".$fixture->rescheduledTo->rescheduledBy->name_short : null }} verlegt.</span> Siehe <a href="{{ route('frontend.fixtures.show', $fixture) }}" title="Matchdetails">Spiel</a>  für Details.</small>
                                            </div>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <!-- end fixtures of the current week -->
        <!-- shortened standings for leagues -->
        <div class="row mt-2">
            @foreach ($divisions as $division)
                <div class="{{ $division_count >= 3 ? "col-md-4" : "col-md-6" }}">
                    @php
                        // $c_season = $division->seasons()->published()->current()->first();
                        $c_season = $division->currentSeason();
                        if ($c_season) {
                            $c_matchweek = $c_season->currentMatchweek();
                        } else {
                            $c_season = $division->seasons()->orderBy('season_nr','desc')->first();
                            $c_matchweek = $c_season->currentMatchweek();
                        }
                        /* not necessary anymore due to new champion_icon and champion_icon_color columns, also not working if divisions change between year
                            $p_season = $c_season->previousSeason();
                            if ($p_season) {
                                $p_champion = $p_season->champion;
                            }
                        */
                    @endphp
                    @if ($c_season && $c_matchweek)
                        <h3 class="font-weight-bold font-italic text-uppercase">
                            @if ($division->competition_id == 1)
                                {{ $division->competition->name_short." &ndash; ".$division->name }}
                            @else
                                {{ $division->name }}
                            @endif
                        </h3>
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
                                @foreach ($c_season->generateTable() as $club)
                                    @php
                                        $rank_color = null;
                                        $rank_icon  = null;
                                        $previous_season_of_club = $club->seasons()->orderBy('end','desc')->where('end','>=',Carbon::now()->subYear()->format('Y-m-d'))->where('begin','<=',Carbon::now()->subYear()->format('Y-m-d'))->get()->where('division.id', $c_season->division->id)->first();
                                        $previous_titles_of_club =  $club->championships()->where('end','<=',Carbon::now()->subYear()->endOfYear()->format('Y-m-d'))->where('begin','>=',Carbon::now()->subYear()->startOfYear()->format('Y-m-d'))->get();

                                    @endphp
                                    @if(in_array($club->t_rank, $c_season->ranks_champion) || in_array($club->t_rank, $c_season->ranks_promotion))
                                        @php
                                            $rank_color = "#FFC107";
                                            $rank_icon  = "fa-circle";
                                        @endphp
                                    @elseif(in_array($club->t_rank, $c_season->playoff_champion))
                                        @php
                                            $rank_color = "#FFC107";
                                            $rank_icon  = "fa-circle-o";
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
                                                @if ($division_count < 3 )
                                                    {{-- visible only on xs --}}
                                                    <span class="d-inline d-sm-none">{{ $club->name_code }}</span>
                                                    {{-- visible only on sm and md --}}
                                                    <span class="d-none d-sm-inline d-lg-none">{{ $club->name_short }}</span>
                                                    {{-- hidden on xs, sm, md --}}
                                                    <span class="d-none d-lg-inline">{{ $club->name }}</span>
                                                @else
                                                   {{ $club->name_code }}
                                                @endif
                                            </a>
                                            {{-- not working when divisions change
                                                @if ($p_champion)
                                                    @if ($p_champion->id == $club->id)
                                                        <span class="pull-right" data-toggle="tooltip" title="Meister {{ $p_season->name }}"><small class="text-secondary"><i class="fa fa-star" style="color: orange"></i> </small></span>
                                                    @endif
                                                @endif
                                            --}}
                                            @isset($previous_titles_of_club)
                                                @foreach($previous_titles_of_club)
                                                        <span class="pull-right" data-toggle="tooltip" title=" {{ $previous_titles_of_club->name }}"><small class="text-secondary"><i class="fa {{ $previous_titles_of_club->champion_icon }}" style="color: {{ $previous_titles_of_club->champion_icon_color }}"></i> </small></span>
                                                @endforeach
                                            @endisset
                                            @if ($previous_season_of_club)
                                                @if ($previous_season_of_club->division->hierarchy_level < $c_season->division->hierarchy_level)
                                                    <span class="pull-right" data-toggle="tooltip" title="Absteiger"><small class="text-secondary">A</small></span>
                                                @elseif ($previous_season_of_club->division->hierarchy_level > $c_season->division->hierarchy_level)
                                                    <span class="pull-right" data-toggle="tooltip" title="Aufsteiger"><small class="text-secondary">N</small></span>
                                                @endif
                                            @endif
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
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('js-footer')

    <script type="text/javascript">
        $(function() {

            // activate tooltips for this page
            $("body").tooltip({
                selector: '[data-toggle="tooltip"]'
            });

        });
    </script>

@endsection