@extends('layouts.app')

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

<div class="jumbotron jumbotron-fluid p-0" style="background-color: {{ $club->colours_club_primary }}">
    <!-- cover -->
    <div class="container">
        <div class="row">
            <div class="col-md-auto pt-4" style="min-width: 200px">
                @if($club->logo_url)
                    <img src="{{ Storage::url($club->logo_url) }}" title="{{ $club->name }}" alt="Vereinswappen">
                @else
                    <span class="fa fa-ban text-muted fa-5x"></span>
                @endif
            </div>
            <div class="col-md-6 pt-4 {{ $club->colours_club_primary == "#ffffff" ? "text-dark" : "text-white" }}">
                <h1 style="font-weight: bold">{{ $club->name }}</h1>
                <ul class="list-unstyled">
                    <li class="pt-2 pb-2">
                        @foreach ($club->getLastGames(5) as $lastGame)
                            <span class="fa-stack fa-lg">
                            @if ($club->hasWon($lastGame))
                                    <i class="fa fa-circle fa-stack-2x text-success"></i>
                                    <strong class="fa-stack-1x text-white">S</strong>
                                @elseif ($club->hasLost($lastGame))
                                    <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                    <strong class="fa-stack-1x text-white">N</strong>
                                @elseif ($club->hasDrawn($lastGame))
                                    <i class="fa fa-circle fa-stack-2x text-dark"></i>
                                    <strong class="fa-stack-1x text-white">U</strong>
                                @endif
                            </span>
                        @endforeach
                    </li>
                    <li>{{ $club->regularStadium()->first() ? $club->regularStadium()->first()->name : null }}</li>
                    @if($club->website)
                        <li><span class="fa fa-home"></span> <a href="{{ $club->website }}" target="_blank">Offizielle Website</a> </li>
                    @endif
                    <li><span class="fa fa-facebook"></span> </li>

                </ul>

            </div>
            <div class="col-md-4">
                <!--<img src="{{ $club->cover_url ? Storage::url($club->cover_url) : Storage::url('public/clubcovers/_default.jpg') }}" height="200">-->
            </div>
        </div>
        <div class="row pt-4">
            <div class="col-md-6">
                <!-- tabs -->
                <nav class="nav nav-tabs" id="tab" role="tablist"> <!--style="background-color: #f5f5f5; border-top-left-radius: 5px; border-top-right-radius: 5px"-->
                    <a class="nav-item nav-link active text-dark" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-expanded="true">
                        Übersicht
                    </a>
                    <a class="nav-item nav-link text-dark" id="results-tab" data-toggle="tab" role="tab" aria-controls="results" href="#results">
                        Resultate
                    </a>
                    <a class="nav-item nav-link text-dark" id="players-tab" data-toggle="tab" role="tab" aria-controls="players" href="#players">
                        Kader
                    </a>
                    <a class="nav-item nav-link text-dark" href="#">
                        Erfolge
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- content -->
<div class="container">
    <div class="row">
        <div class="tab-content col-12" id="tabcontent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                Home
            </div>
            <div class="tab-pane fade" id="results" role="tabpanel" aria-labelledby="">
                <h2 style="color: {{ $club->colours_club_primary }}"><b>Resultate</b></h2>
                <form class="form-inline pb-2">
                    <label class="pr-4" for=""><b>Saison</b></label>
                    <select id="" name="" class="form-control" aria-labelledby="">
                        <option>{{ $season->begin->format('Y') }} - {{ $season->end->format('Y') }}</option>
                        <option></option>
                    </select>
                </form>
                <!-- results -->
                <div class="col-12">
                    <table class="table table-sm table-hover">
                        <thead>
                        <tr>
                            <th class="text-right">SW</th>
                            <th class=""></th>
                            <th colspan="2" class="">Datum</th>
                            <th colspan="3" class="text-center">Paarung</th>
                            <th class=""></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($season->fixtures()->ofClub($club->id)->orderBy('datetime')->get() as $fixture)
                            <tr>
                                <td class="align-middle text-right">
                                    {{ $fixture->matchweek->number_consecutive }}
                                </td>
                                <td class="align-middle text-center">
                                    <span class="fa-stack">
                                        @if ($fixture->isPlayed())
                                            @if ($club->hasWon($fixture))
                                                <i class="fa fa-circle fa-stack-2x text-success"></i>
                                                <strong class="fa-stack-1x text-white">S</strong>
                                            @elseif ($club->hasLost($fixture))
                                                <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                                <strong class="fa-stack-1x text-white">N</strong>
                                            @elseif ($club->hasDrawn($fixture))
                                                <i class="fa fa-circle fa-stack-2x text-dark"></i>
                                                <strong class="fa-stack-1x text-white">U</strong>
                                            @endif
                                        @endif
                                    </span>
                                </td>
                                <td class="align-middle">
                                    @if ( $fixture->datetime )
                                        <span class="fa fa-calendar"></span>
                                        {{ $fixture->datetime->formatLocalized('%a') }},
                                        {{ $fixture->datetime->format('d.m.y') }}
                                    @else
                                        TBD
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if ( $fixture->datetime )
                                        <span class="fa fa-clock-o"></span>
                                        {{ $fixture->datetime->format('H:i') }} Uhr
                                    @endif
                                </td>
                                <td class="align-middle text-right">
                                    @if ($fixture->clubHome)
                                        {{ $fixture->clubHome->name }}
                                        @if ($fixture->clubHome->logo_url)
                                            <img src="{{ Storage::url($fixture->clubHome->logo_url) }}" height="25">
                                        @endif
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    {{ $fixture->goals_home ?? "-" }} : {{ $fixture->goals_away ?? "-" }}
                                </td>
                                <td class="align-middle text-left">
                                    @if ($fixture->clubAway)
                                        @if ($fixture->clubHome->logo_url)
                                            <img src="{{ Storage::url($fixture->clubAway->logo_url) }}" height="25">
                                        @endif
                                        {{ $fixture->clubAway->name }}
                                    @endif
                                </td>
                                <td class="align-middle text-left">
                                    @if($fixture->stadium)
                                        <img src="{{ url('images/stadium.png') }}" height="20">&nbsp;
                                        {{ $fixture->stadium->name_short}}
                                        @else
                                        &nbsp;
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- players -->
            <div class="tab-pane fade" id="players" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-12">
                        <h2 style="color: {{ $club->colours_club_primary }}"><b>Aktive</b></h2>
                        <div class="card-deck">
                            @foreach($club->players()->active()->public()->with('person')->get()->sortBy('person.last_name') as $player)
                                <div class="card">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <h4 class="card-title">
                                                {{ $player->person->full_name_shortened }}
                                                <span class="pull-right" style="color: {{ $club->colours_club_primary }}">{{ $player->number ? "#".$player->number : null }}</span>
                                            </h4>
                                            <h6 class="card-subtitle mb-2" style="color: red">
                                                TODO: Gesperrt
                                            </h6>
                                            <p class="card-text">
                                                <span class="fa fa-calendar-o fa-fw"></span>
                                                @if($player->sign_on)
                                                    {{ $player->sign_on->format('d.m.Y') }}
                                                    @if( Carbon::now()->diffInYears($player->sign_on) > 0 )
                                                        <span class="text-muted"><i>{{ Carbon::now()->diffInYears($player->sign_on) }} Jahre dabei</i></span>
                                                    @else
                                                        <span class="text-muted"><i>{{ Carbon::now()->diffInDays($player->sign_on)}} Tage dabei</i></span>
                                                    @endif
                                                @endif
                                            </p>
                                        </li>
                                        <li class="list-group-item">
                                            <ul class="list-unstyled">
                                                <li>
                                                    Saison
                                                    @if($season->begin)
                                                        <b>{{ $season->begin->format('y') }}</b>
                                                    @endif
                                                    @if($season->end)
                                                        / <b>{{ $season->end->format('y') }}</b>
                                                    @endif
                                                </li>
                                                <li>
                                                    <span class="fa fa-soccer-ball-o fa-fw"></span>
                                                    @php
                                                        $goals_season = $player->goals()->get()->where('fixture.matchweek.season.id', $season->id )->count();
                                                    @endphp
                                                    <b>{{ $goals_season }}</b>
                                                    <i>
                                                        @if($goals_season != 1)
                                                            Tore
                                                        @else
                                                            Tor
                                                        @endif
                                                    </i>
                                                </li>
                                                <li>
                                                    <span class="fa fa-clone fa-fw" style="color: orange"></span>
                                                    @php
                                                        $cards_yr = $player->cards()->yellowReds()->get()->where('fixture.matchweek.season.id', $season->id)->count();
                                                    @endphp
                                                    <b>{{ $cards_yr }}</b>
                                                    <i>{{ $cards_yr != 1 ? "Gelb-rote Karten" : "Gelb-rote Karte" }}</i>
                                                </li>
                                                <li>
                                                    <span class="fa fa-clone fa-fw" style="color: red"></span>
                                                    @php
                                                        $cards_r = $player->cards()->reds()->get()->where('fixture.matchweek.season.id', $season->id)->count();
                                                    @endphp
                                                    <b>{{ $cards_r }}</b>
                                                    <i>{{ $cards_r != 1 ? "Rote Karten" : "Rote Karte" }}</i>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="list-group-item">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">Insgesamt</li>
                                                <li class="list-inline-item"><span class="fa fa-soccer-ball-o fa-fw"></span> <b>{{ $player->goals->count() }}</b></li>
                                                <li class="list-inline-item"><span class="fa fa-clone fa-fw" style="color: orange;"></span> <b>{{ $player->cards()->yellowReds()->count() }}</b></li>
                                                <li class="list-inline-item"><span class="fa fa-clone fa-fw" style="color: red"></span> <b>{{ $player->cards()->reds()->count() }}</b></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if($club->players()->inactive()->count() > 0)
                    <div class="row pt-4">
                        <div class="col-12">
                            <h2 style="color: {{ $club->colours_club_primary }}"><b>Ehemalige</b></h2>
                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th class=""></th>
                                    <th class="">Eintritt</th>
                                    <th class="">Austritt</th>
                                    <th class="text-center"><span class="fa fa-soccer-ball-o fa-fw"></span></th>
                                    <th class="text-center"><span class="fa fa-clone fa-fw" style="color: orange"></span></th>
                                    <th class="text-center"><span class="fa fa-clone fa-fw" style="color: red"></span></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($club->players()->inactive()->get() as $player_inactive)
                                    <tr>
                                        <td class="align-middle">{{ $player_inactive->person->full_name_shortened }}</td>
                                        <td class="align-middle">{{ $player_inactive->sign_on ? $player_inactive->sign_on->format('d.m.Y') : null }}</td>
                                        <td class="align-middle">{{ $player_inactive->sign_off ? $player_inactive->sign_off->format('d.m.Y') : null}}</td>
                                        <td class="align-middle text-center">{{ $player_inactive->goals->count() }}</td>
                                        <td class="align-middle text-center">{{ $player_inactive->cards()->yellowReds()->count() }}</td>
                                        <td class="align-middle text-center">{{ $player_inactive->cards()->reds()->count() }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection