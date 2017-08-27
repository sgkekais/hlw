@extends('layouts.app')

@section('subnav')
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="#">Tabelle & Paarungen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('frontend.seasons.clubs', HLW\Season::find(1)) }}">Mannschaften</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Spieler</a>
        </li>
    </ul>
@endsection

@section('content')
<div class="container">
    <table class="table table-hover">
        <thead>
            <tr>
                <td></td>
                <th class="align-middle text-center hidden-xs-down">#</th>
                <th class="align-middle text-center">+/-</th>
                <th></th>
                <th class="align-middle text-center">Sp</th>
                <th class="align-middle text-center hidden-sm-down">S</th>
                <th class="align-middle text-center hidden-sm-down">U</th>
                <th class="align-middle text-center hidden-sm-down">N</th>
                <th class="align-middle text-center hidden-sm-down">Tore</th>
                <th class="align-middle text-center">Diff.</th>
                <th class="align-middle text-center">Pkt.</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($table_current as $club)
                <tr>
                    <td class="align-middle text-center hidden-xs-down ">
                        <a data-toggle="collapse" href="#collapsedetails{{ $loop->iteration }}" aria-expanded="false" title="Expandieren">
                            <span class="fa fa-angle-down"></span>
                        </a>
                    </td>
                    <td class="align-middle text-center p-2 p-md-2" >{{ $club->t_rank }}</td>
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
                    <td class="align-middle hidden-xs-down">
                        @if($club->logo_url)
                            <img src="{{ Storage::url($club->logo_url) }}" width="30" class="pr-1">
                        @else
                            <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                        @endif
                            <a href="{{ route('frontend.clubs.show', $club) }}">
                                {{ $club->name }}
                            </a>
                    </td>
                    <td class="align-middle hidden-sm-up p-2">
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
                    <td class="align-middle text-center hidden-sm-down">{{ $club->t_won }}</td>
                    <td class="align-middle text-center hidden-sm-down">{{ $club->t_drawn }}</td>
                    <td class="align-middle text-center hidden-sm-down">{{ $club->t_lost }}</td>
                    <td class="align-middle text-center hidden-sm-down">{{ $club->t_goals_for }} : {{ $club->t_goals_against }}</td>
                    <td class="align-middle text-center p-2 p-md-2">{{ $club->t_goals_diff }}</td>
                    <td class="align-middle text-center p-2 p-md-2">{{ $club->t_points }}</td>
                </tr>
                <tr class="collapse bg-faded hidden-xs-down" id="collapsedetails{{ $loop->iteration }}">
                    <td class="" colspan="11" style="border-top: none">
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
                                <div class="d-flex align-items-center">
                                    @foreach ($club->getLastGames(5) as $lastGame)
                                        <span class="fa-stack fa-lg">
                                        @if ($club->hasWon($lastGame))
                                            <i class="fa fa-circle fa-stack-2x text-success"></i>
                                            <strong class="fa-stack-1x" style="color:#ffffff">S</strong>
                                        @elseif ($club->hasLost($lastGame))
                                            <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                            <strong class="fa-stack-1x" style="color:#ffffff">N</strong>
                                        @elseif ($club->hasDrawn($lastGame))
                                            <i class="fa fa-circle fa-stack-2x text-gray-dark"></i>
                                            <strong class="fa-stack-1x" style="color:#ffffff">U</strong>
                                        @endif
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-4">
                                @php
                                    $nextgame = $club->getNextGames(1)->first()
                                @endphp
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
@endsection