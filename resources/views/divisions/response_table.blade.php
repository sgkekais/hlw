{{--
@php
    $p_season = $season->previousSeason();
    if ($p_season) {
        $p_champion = $p_season->champion;
    } else {
        $p_champion = null;
    }
@endphp
--}}
<h4 class="text-muted">
    <b>{{ $season->season_nr ? $season->season_nr."." : null }}</b> Saison |
    Spielwoche
    @if ($c_matchweek->number_consecutive)
        <b>{{ $c_matchweek->number_consecutive }}</b>
    @endif
    | {{ $c_matchweek->begin ? $c_matchweek->begin->format('d.m.y') : null }} - {{ $c_matchweek->end ? $c_matchweek->end->format('d.m.y') : null }}
    {{ $c_matchweek->name ? "| ".$c_matchweek->name : null }}
</h4>
<table class="table table-hover standings">
    <thead>
    <tr>
        <th class="align-middle text-center d-none d-lg-table-cell"></th>
        <th class="align-middle "><span class="fa fa-fw"></span>#</th>
        <th class="align-middle text-center">+/-</th>
        <th class="align-middle text-center"></th>
        <th class="align-middle text-center"><abbr title="Spiele">Sp</abbr></th>
        <th class="align-middle text-center d-none d-md-table-cell"><abbr title="Siege">S</abbr></th>
        <th class="align-middle text-center d-none d-md-table-cell"><abbr title="Unentschieden">U</abbr></th>
        <th class="align-middle text-center d-none d-md-table-cell"><abbr title="Niederlagen">N</abbr></th>
        <th class="align-middle text-center d-none d-lg-table-cell">Tore</th>
        <th class="align-middle text-center"><abbr title="Differenz">Diff</abbr></th>
        <th class="align-middle text-center"><abbr title="Punkte">Pkt</abbr></th>
        <th class="align-middle text-center d-none d-lg-table-cell">Form</th>
        <th class="align-middle text-center d-none d-md-table-cell">Next</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($table_current as $club)
        @php
            $rank_color = "";
            $rank_icon  = null;
            $previous_season_of_club = $club->seasons()->orderBy('end','desc')->where('end','>=',Carbon::now()->subYear()->format('Y-m-d'))->where('begin','<=',Carbon::now()->subYear()->format('Y-m-d'))->get()->where('division.id', $season->division->id)->first();
            $previous_titles_of_club =  $club->championships()->where('end','<=',Carbon::now()->subYear()->endOfYear()->format('Y-m-d'))->where('begin','>=',Carbon::now()->subYear()->startOfYear()->format('Y-m-d'))->get();

        @endphp
        {{-- ranks_champion OR ranks_promotion --}}
        @if (in_array($club->t_rank, $season->ranks_champion) || in_array($club->t_rank, $season->ranks_promotion))
            @php
                $rank_color = "#FFC107";
                $rank_icon  = "fa-circle";
            @endphp
        @endif
        {{-- ranks_relegation --}}
        @if (in_array($club->t_rank, $season->ranks_relegation))
            @php
                $rank_color = "#F44336";
                $rank_icon  = "fa-circle";
            @endphp
        @endif
        {{-- playoff_champion --}}
        @if (in_array($club->t_rank, $season->playoff_champion))
            @php
                $rank_color = "#FFC107";
                $rank_icon  = "fa-circle-o";
            @endphp
        @endif
        {{-- playoff_cup --}}
        @if (in_array($club->t_rank, $season->playoff_cup))
            @php
                $rank_color = "#03a9f4";
                $rank_icon  = "fa-circle-o";
            @endphp
        @endif
        {{-- playoff_relegation --}}
        @if (in_array($club->t_rank, $season->playoff_relegation))
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
                <b>{{ $club->t_rank }}</b>
            </td>
            <td class="align-middle text-center p-2 p-md-2">
                @if (!$table_previous->isEmpty())
                    @if ($previous_rank = $table_previous->where('id', $club->id)->first()->t_rank)
                        @if ($previous_rank < $club->t_rank)
                            <span class="fa fa-arrow-circle-down text-danger"></span>
                        @elseif ($previous_rank == $club->t_rank)
                            <span class="fa "></span>
                        @else
                            <span class="fa fa-arrow-circle-up text-success"></span>
                        @endif
                        <small>
                            @if(abs($previous_rank-$club->t_rank) > 0)
                                {{ abs($previous_rank-$club->t_rank) }}
                            @endif
                        </small>
                    @endif
                @endif
            </td>
            <td class="align-middle">
                @if($club->logo_url)
                    <img src="{{ asset('storage/'.$club->logo_url) }}" width="30" class="pr-1">
                @else
                    <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                @endif
                <a href="{{ route('frontend.clubs.show', $club) }}">
                    <span class="d-none d-sm-inline">{{ $club->name }}</span>
                    <span class="d-sm-none">{{ $club->name_code }}</span>
                </a>
                {{--
                    @if ($p_champion)
                        @if ($p_champion->id == $club->id)
                            <span class="pull-right" data-toggle="tooltip" title="Meister {{ $p_season->name }}"><small class="text-secondary"><i class="fa fa-star" style="color: orange"></i> </small></span>
                        @endif
                    @endif
                --}}
                @isset($previous_titles_of_club)
                    @foreach($previous_titles_of_club as $title)
                        <span class="pull-right"><small class="text-secondary"><i class="fa {{ $title->champion_icon }}" style="color: {{ $title->champion_icon_color }}"></i> </small></span>
                    @endforeach
                @endisset
                @if ($previous_season_of_club)
                    @if ($previous_season_of_club->division->hierarchy_level < $season->division->hierarchy_level)
                        <span class="pull-right" data-toggle="tooltip" title="Absteiger"><small class="text-secondary">A</small></span>
                    @elseif ($previous_season_of_club->division->hierarchy_level > $season->division->hierarchy_level)
                        <span class="pull-right" data-toggle="tooltip" title="Aufsteiger"><small class="text-secondary">N</small></span>
                    @endif
                @endif
            </td>
            <td class="align-middle text-center p-2 p-md-2">{{ $club->t_played }}</td>
            <td class="align-middle text-center d-none d-md-table-cell">{{ $club->t_won }}</td>
            <td class="align-middle text-center d-none d-md-table-cell">{{ $club->t_drawn }}</td>
            <td class="align-middle text-center d-none d-md-table-cell">{{ $club->t_lost }}</td>
            <td class="align-middle text-center d-none d-lg-table-cell">{{ $club->t_goals_for }} : {{ $club->t_goals_against }}</td>
            <td class="align-middle text-center p-2 p-md-2">{{ $club->t_goals_diff }}</td>
            <td class="align-middle text-center p-2 p-md-2"><b>{{ $club->t_points }}</b></td>
            <!-- Form -->
            <td class="align-middle text-center d-none d-lg-table-cell">
                @foreach ($club->getLastGamesPlayedOrRated(5, $season->isFinished() ? $season->end : null, $season->begin) as $lastGame)
                    <span class="fa-stack" data-toggle="tooltip" data-html="true" title="{{ $lastGame->matchweek->season->division->name }} | {{ $lastGame->datetime ?  $lastGame->datetime->format('d.m.') : null }} - {{ $lastGame->clubHome ? $lastGame->clubHome->name_code : null }} {{ $lastGame->goals_home ?? $lastGame->goals_home_rated }} : {{ $lastGame->goals_away ?? $lastGame->goals_away_rated }} {{ $lastGame->clubAway ? $lastGame->clubAway->name_code : null }}">
                        @if ($lastGame->isPlayed() && !$lastGame->isRated())
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
                        @elseif ($lastGame->isRated())
                            <i class="fa fa-circle fa-stack-2x text-warning"></i>
                            <strong class="fa-stack-1x" style="color:#ffffff">W</strong>
                        @endif
                    </span>
                @endforeach
            </td>
            <!-- next -->
            <td class="align-middle text-center d-none d-md-table-cell">
                @if (!$season->isFinished())
                    @php
                        $nextgame = $club->getNextGames(1)->load('clubHome', 'clubAway')->first();
                    @endphp
                    @if ($nextgame && $nextgame->clubHome && $nextgame->clubAway)
                        @php
                            $logo = null;
                            if ($nextgame->clubHome->id == $club->id) {
                                 $logo = $nextgame->clubAway->logo_url;
                            } if ($nextgame->clubAway->id == $club->id) {
                                $logo = $nextgame->clubHome->logo_url;
                            }
                        @endphp
                        @if($logo)
                            <img src="{{ asset('storage/'.$logo) }}" width="30" class="">
                        @else
                            <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                        @endif
                    @endif
                @endif
            </td>
        </tr>
        <tr class="collapse bg-light" id="collapsedetails{{ $loop->iteration }}">
            <td class="" colspan="14" style="border-top: none">
                <div class="row">
                    <div class="col-md-4">
                        @if ($club->logo_url)
                            <img src="{{ asset('storage/'.$club->logo_url) }}" width="100" class="pr-2">
                        @else
                            <span class="fa fa-ban text-muted fa-2x"></span>
                        @endif
                        <a href="{{ route('frontend.clubs.show', $club) }}">
                            {{ $club->name }}
                        </a>
                    </div>
                    <div class="col-md-4">
                        @if ($lastgame = $club->getLastGamesPlayedOrRated(1, $season->isFinished() ? $season->end : null)->load('clubHome', 'clubAway')->first())
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
                                <div class="col-md-2 text-center bg-faded pt-2 px-1">
                                    @if ($lastgame->isPlayed() && !$lastgame->isRated())
                                        {{ $lastgame->goals_home }} : {{ $lastgame->goals_away }}
                                    @elseif ($lastgame->isRated())
                                        {{ $lastgame->goals_home_rated }} : {{ $lastgame->goals_away_rated }}
                                    @endif
                                </div>
                                <div class="col-md-5 pl-0">
                                    <div class="row no-gutters">
                                        <div class="col-md-4 p-2 text-center" style="background-color: {{ $lastgame->clubAway->colours_club_primary }}">
                                            @if ($lastgame->clubAway->logo_url)
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
                        @if (!$season->isFinished())
                            @if ($nextgame && $nextgame->clubHome && $nextgame->clubAway)
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
                                                @if ($nextgame->clubHome->logo_url)
                                                    <img src="{{ asset('storage/'.$nextgame->clubHome->logo_url) }}" width="25" class="">
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
                                                @if ($nextgame->clubAway->logo_url)
                                                    <img src="{{ asset('storage/'.$nextgame->clubAway->logo_url) }}" width="25" class="">
                                                @else
                                                    <span class="fa fa-ban text-muted fa-2x"></span>
                                                @endif
                                            </div>
                                            <div class="col-md-8 pt-2 pb-2 pl-1 text-left">
                                                {{ $nextgame->clubAway->name_short }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <i>Kein anstehendes Spiel.</i>
                            @endif
                        @endif
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-md-6">
        @if ($season->rules)
            <h5 class="text-secondary">Saison-Infos</h5>
            <p class="text-secondary">
                {{ $season->rules }}
            </p>
        @endif
    </div>
    <div class="col-md-6">
        @if ($season->clubs()->wherePivot('note', '!=', null)->count() > 0)
            <h5 class="text-secondary">Team-Infos</h5>
            <ul class="text-secondary">
                @foreach ($season->clubs()->wherePivot('note', '!=', null)->get() as $notes)
                    <li>{{ $notes->pivot->note }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>