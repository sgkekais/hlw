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
                        Irgendwas
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
                <h2 style="color: {{ $club->colours_club_primary }}"><b>Übersicht</b></h2>
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-muted">
                            <span class="font-weight-bold">Saison {{ $season->begin ? $season->begin->format('Y') : '-' }} / {{ $season->end ? $season->end->format('Y') : '-' }}</span>:
                            {{ $club->getGamesPlayedWon($season)->count() + $club->getGamesRatedWon($season)->count() }}
                            S -
                            {{ $club->getGamesPlayedDrawn($season)->count() + $club->getGamesRatedDrawn($season)->count() }}
                            U -
                            {{ $club->getGamesPlayedLost($season)->count() + $club->getGamesRatedLost($season)->count() }}
                            N
                        </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h4 style="color: {{ $club->colours_club_primary }}">Die letzten Spiele</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Datum</th>
                                    <th colspan="3" class="text-center">Paarung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($club->getLastGamesPlayedOrRated(5) as $fixture)
                                    <tr>
                                        <td class="align-middle">
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
                                        <td class="align-middle">{{ $fixture->datetime ? $fixture->datetime->format('d.m.y') : null }}</td>
                                        <td class="align-middle text-right">{{ $fixture->clubHome ? $fixture->clubHome->name_short : null }}</td>
                                        <td class="align-middle text-center">
                                            @if($fixture->isPlayed())
                                                {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
                                            @elseif($fixture->isRated())
                                                {{ $fixture->goals_home_rated }} : {{ $fixture->goals_away_rated }}
                                            @endif
                                        </td>
                                        <td class="align-middle text-left">{{ $fixture->clubAway ? $fixture->clubAway->name_short : null }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4 style="color: {{ $club->colours_club_primary }}">Die nächsten Spiele</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Datum</th>
                                    <th colspan="3" class="text-center">Paarung</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($club->getNextGames(5) as $fixture)
                                <tr>
                                    <td class="align-middle">{{ $fixture->datetime ? $fixture->datetime->format('d.m.y') : null }}</td>
                                    <td class="align-middle text-right">{{ $fixture->clubHome ? $fixture->clubHome->name_short : null }}</td>
                                    <td class="align-middle text-center">
                                        @if($fixture->isPlayed())
                                            {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
                                        @elseif($fixture->isRated())
                                            {{ $fixture->goals_home_rated }} : {{ $fixture->goals_away_rated }}
                                        @else
                                            - : -
                                        @endif
                                    </td>
                                    <td class="align-middle text-left">{{ $fixture->clubAway ? $fixture->clubAway->name_short : null }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4 mb-4 ">
                    <div class="col-12 bg-secondary">
                        Test
                    </div>
                </div>
                @if($club->regularStadium()->first())
                    @if($club->regularStadium()->first()->lat && $club->regularStadium()->first()->long)
                        <div class="row">
                            <div class="col-12">
                                <h4 style="color: {{ $club->colours_club_primary }}">Spielstätte</h4>
                                <div id="map" style="width: 100%; height: 450px "></div>
                                <script>
                                    function initMap() {
                                        var uluru = {lat: {{ $club->regularStadium()->first()->lat }}, lng: {{ $club->regularStadium()->first()->long }}};
                                        var map = new google.maps.Map(document.getElementById('map'), {
                                            zoom: 18,
                                            center: uluru
                                        });
                                        var marker = new google.maps.Marker({
                                            position: uluru,
                                            map: map
                                        });
                                    }
                                </script>
                                <script async defer
                                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBKAZ6Ay4GdEqmP3gG6Zpp3kOyBSSa-Lc&callback=initMap">
                                </script>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            <!-- end home tab -->
            <!-- results tab -->
            <div class="tab-pane fade" id="results" role="tabpanel" aria-labelledby="">
                <div class="row">
                    <div class="col-12">
                        <h2 style="color: {{ $club->colours_club_primary }}"><b>Resultate</b></h2>
                        <form class="form-inline pb-2">
                            <label class="pr-4" for=""><b>Saison</b></label>
                            <select id="" name="" class="form-control" aria-labelledby="">
                                <option>{{ $season->begin->format('Y') }} - {{ $season->end->format('Y') }}</option>
                                <option></option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-sm table-hover table-striped">
                            <thead>
                            <tr>
                                <th class="text-right">SW</th>
                                <th class=""></th>
                                <th colspan="3" class="">Datum</th>
                                <th colspan="3" class="text-center">Paarung</th>
                                <th colspan="2" class=""></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($season->fixtures()->ofClub($club->id)->where('fixtures.published',1)->orderBy('datetime')->get() as $fixture)
                                <tr>
                                    <td class="align-middle text-right">
                                        {{ $fixture->matchweek->number_consecutive }}
                                    </td>
                                    <td class="align-middle text-center">
                                    <span class="fa-stack">
                                        @if ($fixture->isPlayed() && !$fixture->isRated())
                                            @if ($club->hasWon($fixture))
                                                <i class="fa fa-circle fa-stack-2x text-success"></i>
                                                <strong class="fa-stack-1x text-white" title="Sieg">S</strong>
                                            @elseif ($club->hasLost($fixture))
                                                <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                                <strong class="fa-stack-1x text-white" title="Niederlage">N</strong>
                                            @elseif ($club->hasDrawn($fixture))
                                                <i class="fa fa-circle fa-stack-2x text-dark"></i>
                                                <strong class="fa-stack-1x text-white" title="Unentschieden">U</strong>
                                            @endif
                                        @elseif ($fixture->isRated())
                                            <i class="fa fa-circle fa-stack-2x text-warning"></i>
                                            <strong class="fa-stack-1x text-white" title="Gewertet">R</strong>
                                        @endif
                                    </span>
                                    </td>
                                    @if ( $fixture->datetime )
                                        <td class="align-middle text-left">
                                            <span class="fa fa-calendar"></span>
                                            {{ $fixture->datetime->formatLocalized('%a') }}
                                        </td>
                                        <td class="align-middle text-left">
                                            {{ $fixture->datetime->format('d.m.y') }}
                                        </td>
                                        <td class="align-middle text-left">
                                            <span class="fa fa-clock-o"></span>
                                            {{ $fixture->datetime->format('H:i') }} Uhr
                                        </td>
                                    @else
                                        <td colspan="3" class="align-middle text-left">
                                            <span class="fa fa-calendar-times-o"></span> TBD
                                        </td>
                                    @endif
                                    <td class="align-middle text-right">
                                        @if ($fixture->clubHome)
                                            {{ $fixture->clubHome->name }}
                                            @if ($fixture->clubHome->logo_url)
                                                <img src="{{ Storage::url($fixture->clubHome->logo_url) }}" height="25">
                                            @endif
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($fixture->isPlayed() && !$fixture->isRated())
                                            {{ $fixture->goals_home ?? "-" }} : {{ $fixture->goals_away ?? "-" }}
                                        @elseif($fixture->isRated())
                                            {{ $fixture->goals_home_rated ?? "-" }} : {{ $fixture->goals_away_rated }}
                                        @endif
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
                                        @else                                        &nbsp;
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if ($fixture->cards()->count() > 0)
                                            <span class="fa fa-fw fa-clone"></span>
                                            x {{ $fixture->cards()->count() }}
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if ($fixture->goals()->count() > 0)
                                            <span class="fa fa-fw fa-soccer-ball-o"></span>
                                            x {{ $fixture->goals()->count() }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end results tab -->
            <!-- players tab -->
            <div class="tab-pane fade" id="players" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-12">
                        <h2 style="color: {{ $club->colours_club_primary }}"><b>Aktive</b> <span class="badge badge-secondary">{{ $club->players()->active()->count() }}</span></h2>
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