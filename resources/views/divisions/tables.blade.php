@extends('layouts.app')

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

    <div class="container pt-4">
        <div class="row">
            <div class="col-12">
                <h2 style="font-weight: bold">Tabelle</h2>
                <h3 class="text-muted">
                    Spielwoche {{ $c_matchweek->number_consecutive ?: null }}
                    | {{ $c_matchweek->begin ? $c_matchweek->begin->format('d.m.') : null }} - {{ $c_matchweek->end ? $c_matchweek->end->format('d.m.') : null }}
                    {{ $c_matchweek->name ? "| ".$c_matchweek->name : null }}
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="align-middle text-center d-none d-lg-table-cell"></th>
                        <th class="align-middle "><span class="fa fa-fw"></span>#</th>
                        <th class="align-middle text-center">+/-</th>
                        <th class="align-middle text-center"></th>
                        <th class="align-middle text-center">Sp</th>
                        <th class="align-middle text-center d-none d-md-table-cell">S</th>
                        <th class="align-middle text-center d-none d-md-table-cell">U</th>
                        <th class="align-middle text-center d-none d-md-table-cell">N</th>
                        <th class="align-middle text-center d-none d-lg-table-cell">Tore</th>
                        <th class="align-middle text-center">Diff.</th>
                        <th class="align-middle text-center">Pkt.</th>
                        <th class="align-middle text-center d-none d-lg-table-cell">Form</th>
                        <th class="align-middle text-center d-none d-md-table-cell">Next</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($table_current as $club)
                        @php
                            $rank_color = "";
                            $rank_icon  = null;
                        @endphp
                        <!-- ranks_champion OR ranks_promotion -->
                        @if(in_array($club->t_rank, $season->ranks_champion) || in_array($club->t_rank, $season->ranks_promotion))
                            @php
                                $rank_color = "#FFC107";
                                $rank_icon  = "fa-circle";
                            @endphp
                        @endif
                        <!-- ranks_relegation -->
                        @if(in_array($club->t_rank, $season->ranks_relegation))
                            @php
                                $rank_color = "#F44336";
                                $rank_icon  = "fa-circle";
                            @endphp
                        @endif
                        <!-- playoff_champion -->

                        <!-- playoff_cup -->

                        <!-- playoff_relegation -->
                        @if(in_array($club->t_rank, $season->playoff_relegation))
                            @php
                                $rank_color = "#FF9800";
                                $rank_icon  = "fa-circle-o";
                            @endphp
                        @endif
                        <tr>
                            <td class="align-middle text-center d-none d-lg-table-cell ">
                                <a class="table-entry-details" data-toggle="collapse" href="#collapsedetails{{ $loop->iteration }}" aria-expanded="false" title="Expandieren">
                                    <span class="fa fa-angle-down"></span>
                                </a>
                            </td>
                            <td class="align-middle">
                                <span class="fa fa-fw {{ $rank_icon ?? null }}" style="color: {{ $rank_color }};"></span>
                                {{ $club->t_rank }}
                            </td>
                            <td class="align-middle text-center p-2 p-md-2">
                                @if($table_previous->count() > 0)
                                    @if($previous_rank = $table_previous->where('id', $club->id)->first()->t_rank)
                                        @if ($previous_rank < $club->t_rank)
                                            <span class="fa fa-fw fa-arrow-circle-down text-warning"></span>
                                        @elseif ($previous_rank == $club->t_rank)
                                            <span class="fa fa-fw "></span>
                                        @else
                                            <span class="fa fa-fw fa-arrow-circle-up text-success"></span>
                                        @endif
                                        <small>
                                            @if(abs($previous_rank-$club->t_rank) > 0)
                                                {{ abs($previous_rank-$club->t_rank) }}
                                            @endif
                                        </small>
                                    @endif
                                @endif
                            </td>
                            <td class="align-middle d-none d-sm-table-cell">
                                @if($club->logo_url)
                                    <img src="{{ Storage::url($club->logo_url) }}" width="30" class="pr-1">
                                @else
                                    <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                @endif
                                <a href="{{ route('frontend.clubs.show', $club) }}">
                                    {{ $club->name }}
                                </a>
                            </td>
                            <td class="align-middle d-sm-none p-2">
                                @if($club->logo_url)
                                    <img src="{{ Storage::url($club->logo_url) }}" width="30" class="pr-1">
                                @else
                                    <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                @endif
                                <a href="{{ route('frontend.clubs.show', $club) }}">
                                    {{ $club->name_code }}
                                </a>
                            </td>
                            <td class="align-middle text-center p-2 p-md-2">{{ $club->t_played }}</td>
                            <td class="align-middle text-center d-none d-md-table-cell">{{ $club->t_won }}</td>
                            <td class="align-middle text-center d-none d-md-table-cell">{{ $club->t_drawn }}</td>
                            <td class="align-middle text-center d-none d-md-table-cell">{{ $club->t_lost }}</td>
                            <td class="align-middle text-center d-none d-lg-table-cell">{{ $club->t_goals_for }} : {{ $club->t_goals_against }}</td>
                            <td class="align-middle text-center p-2 p-md-2">{{ $club->t_goals_diff }}</td>
                            <td class="align-middle text-center p-2 p-md-2">{{ $club->t_points }}</td>
                            <!-- Form -->
                            <td class="align-middle text-center d-none d-lg-table-cell">
                                @foreach ($club->getLastGames(5) as $lastGame)
                                    @if($lastGame->isPlayed() || $lastGame->isRated())
                                        <span class="fa-stack">
                                    @if ($club->hasWon($lastGame))
                                                <i class="fa fa-circle fa-stack-2x text-success"></i>
                                                <strong class="fa-stack-1x" style="color:#ffffff">S</strong>
                                            @elseif ($club->hasLost($lastGame))
                                                <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                                <strong class="fa-stack-1x" style="color:#ffffff">N</strong>
                                            @elseif ($club->hasDrawn($lastGame))
                                                <i class="fa fa-circle fa-stack-2x text-dark"></i>
                                                <strong class="fa-stack-1x" style="color:#ffffff">U</strong>
                                            @endif
                                </span>
                                    @endif
                                @endforeach
                            </td>
                            <!-- next -->
                            <td class="align-middle text-center d-none d-md-table-cell">
                                @php
                                    $nextgame = $club->getNextGames(1)->first()
                                @endphp
                                @if($nextgame)
                                    @php
                                        $logo = null;
                                        if($nextgame->clubHome && $nextgame->clubHome->id == $club->id )
                                            $logo = $nextgame->clubAway->logo_url;
                                        elseif($nextgame->clubAway && $nextgame->clubAway->id == $club->id)
                                            $logo = $nextgame->clubHome->logo_url;
                                    @endphp
                                    @if($logo)
                                        <img src="{{ Storage::url($logo) }}" width="30" class="pr-1">
                                    @else
                                        <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                    @endif
                                @endif

                            </td>
                        </tr>
                        <tr class="collapse bg-light" id="collapsedetails{{ $loop->iteration }}">
                            <td class="" colspan="14" style="border-top: none">
                                <div class="row">
                                    <div class="col-md-4">
                                        @if($club->logo_url)
                                            <img src="{{ Storage::url($club->logo_url) }}" width="100" class="pr-2">
                                        @else
                                            <span class="fa fa-ban text-muted fa-2x"></span>
                                        @endif
                                        <a href="{{ route('frontend.clubs.show', $club) }}">
                                            {{ $club->name }}
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        @if ($lastgame = $club->getLastGamesPlayedOrRated(1)->first())
                                            <div class="row">
                                                <div class="col-md-12">
                                                    Letztes Spiel am <b>{{ $lastgame->datetime ? $lastgame->datetime->format('d.m.Y') : null }}</b>
                                                </div>
                                            </div>
                                            <div class="row pt-2">
                                                <div class="col-md-5 pr-0">
                                                    <div class="row no-gutters">
                                                        <div class="col-md-8 pt-2 pb-2 pr-1 text-right">
                                                            {{ $lastgame->clubHome->name_short }}
                                                        </div>
                                                        <div class="col-md-4 p-2 text-center" style="background-color: {{ $lastgame->clubHome->colours_club_primary }}">
                                                            @if($lastgame->clubHome->logo_url)
                                                                <img src="{{ Storage::url($lastgame->clubHome->logo_url) }}" width="25" class="">
                                                            @else
                                                                <span class="fa fa-ban text-muted fa-2x"></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 text-center bg-faded pt-2">
                                                    @if($lastgame->isPlayed() && !$lastgame->isRated())
                                                        {{ $lastgame->goals_home }} : {{ $lastgame->goals_away }}
                                                    @elseif($lastgame->isRated())
                                                        {{ $lastgame->goals_home_rated }} : {{ $lastgame->goals_away_rated }}
                                                    @endif
                                                </div>
                                                <div class="col-md-5 pl-0">
                                                    <div class="row no-gutters">
                                                        <div class="col-md-4 p-2 text-center" style="background-color: {{ $lastgame->clubAway->colours_club_primary }}">
                                                            @if($lastgame->clubAway->logo_url)
                                                                <img src="{{ Storage::url($lastgame->clubAway->logo_url) }}" width="25" class="">
                                                            @else
                                                                <span class="fa fa-ban text-muted fa-2x"></span>
                                                            @endif                                                </div>
                                                        <div class="col-md-8 pt-2 pb-2 pl-1 text-left">
                                                            {{ $lastgame->clubAway->name_short }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <i>Kein vorangegangenes Spiel.</i>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        @if ($nextgame)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    Nächstes Spiel am <b>{{ $nextgame->datetime ? $nextgame->datetime->format('d.m.Y') : null }}</b>
                                                </div>
                                            </div>
                                            <div class="row pt-2">
                                                <div class="col-md-5 pr-0">
                                                    <div class="row no-gutters">
                                                        <div class="col-md-8 pt-2 pb-2 pr-1 text-right">
                                                            {{ $nextgame->clubHome->name_short }}
                                                        </div>
                                                        <div class="col-md-4 p-2 text-center" style="background-color: {{ $nextgame->clubHome->colours_club_primary }}">
                                                            @if($nextgame->clubHome->logo_url)
                                                                <img src="{{ Storage::url($nextgame->clubHome->logo_url) }}" width="25" class="">
                                                            @else
                                                                <span class="fa fa-ban text-muted fa-2x"></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 text-center bg-faded pt-2">
                                                    <b>vs.</b>
                                                </div>
                                                <div class="col-md-5 pl-0">
                                                    <div class="row no-gutters">
                                                        <div class="col-md-4 p-2 text-center" style="background-color: {{ $nextgame->clubAway->colours_club_primary }}">
                                                            @if($nextgame->clubAway->logo_url)
                                                                <img src="{{ Storage::url($nextgame->clubAway->logo_url) }}" width="25" class="">
                                                            @else
                                                                <span class="fa fa-ban text-muted fa-2x"></span>
                                                            @endif                                                </div>
                                                        <div class="col-md-8 pt-2 pb-2 pl-1 text-left">
                                                            {{ $nextgame->clubAway->name_short }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <i>Kein anstehendes Spiel.</i>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="text-secondary">
                    {{ $season->rules }}
                </p>
            </div>
        </div>
    </div>

@endsection

@section('js-footer')

    {{-- change the arrow's orientation on click --}}
    <script type="text/javascript">
        $('.table-entry-details').click(function(){
           $(this).find('span').toggleClass('fa-angle-down fa-angle-up');
        });
    </script>

@endsection