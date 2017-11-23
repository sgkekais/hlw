@extends('layouts.app')

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

<!-- cover -->
<div class="container-fluid" style="background-color: {{ $club->colours_club_primary }}">
    <div class="row m-auto pt-4" style="max-width: 1140px">
        <div class="col-3">
            @if($club->logo_url)
                <img src="{{ Storage::url($club->logo_url) }}" class="img-fluid" title="{{ $club->name }}" alt="Vereinswappen">
            @else
                <span class="fa fa-ban text-muted fa-5x"></span>
            @endif
        </div>
        <div class="col {{ $club->colours_club_primary == "#ffffff" ? "text-dark" : "text-white" }}">
            <h1 class="font-weight-bold">{{ $club->name }}</h1>
            <ul class="list-unstyled">
                <li class="pt-2 pb-2">
                    @if($club->championships->count() > 0)
                        @foreach($club->championships->sortByDesc('end') as $championship)
                            <span class="fa fa-fw fa-star" style="color: orange" title="{{ $championship->begin ? $championship->begin->format('Y') : null }}/{{ $championship->end ? $championship->end->format('Y') : null }}"></span>
                        @endforeach
                    @else
                        &nbsp;
                    @endif
                </li>
                <li>{{ $club->regularStadium()->first() ? $club->regularStadium()->first()->name : null }}</li>
                @if($club->website)
                    <li><span class="fa fa-fw fa-home"></span> <a href="{{ $club->website }}" target="_blank">Offizielle Website</a> </li>
                @endif
                @if($club->facebook)
                    <li><span class="fa fa-fw fa-facebook"></span> <a href="{{ $club->facebook }}" target="_blank">Facebook</a> </li>
                @endif
            </ul>
        </div>
        {{-- TODO Cover?
        <div class="col-md-4">
            <img src="{{ $club->cover_url ? Storage::url($club->cover_url) : Storage::url('public/clubcovers/_default.jpg') }}" height="200">
        </div>
        --}}
    </div>
    <div class="row m-auto pt-4" style="max-width: 1140px">
        <div class="col">
            <!-- tabs -->
            <nav class="nav nav-tabs" id="tab" role="tablist">
                <a class="nav-item nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-expanded="true">
                    Übersicht
                </a>
                <a class="nav-item nav-link " id="results-tab" data-toggle="tab" href="#results" role="tab" aria-controls="results" >
                    Resultate
                </a>
                <a class="nav-item nav-link" id="players-tab" data-toggle="tab" href="#players" role="tab" aria-controls="players" >
                    Kader
                </a>
            </nav>
        </div>
    </div>
</div>
<!-- content -->
<div class="container mt-4">
    <div class="row">
        <div class="tab-content col-12" id="tabcontent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <h2 class="font-weight-bold" style="color: {{ $club->colours_club_primary }}">Übersicht</h2>
                <div class="row bg-secondary text-white ml-0 mr-0 mb-4">
                    <div class="col text-center">
                        <span class="display-4 font-italic">
                            {{ $club->getGamesPlayedWon($season)->count() + $club->getGamesRatedWon($season)->count() }}
                        </span>
                        <span class="font-weight-light font-italic">Siege</span>
                    </div>
                    <div class="col text-center">
                        <span class="display-4 font-italic">
                            {{ $club->getGamesPlayedDrawn($season)->count() + $club->getGamesRatedDrawn($season)->count() }}
                        </span>
                        <span class="font-weight-light font-italic">Unentschieden</span>
                    </div>
                    <div class="col text-center">
                        <span class="display-4 font-italic">
                            {{ $club->getGamesPlayedLost($season)->count() + $club->getGamesRatedLost($season)->count() }}
                        </span>
                        <span class="font-weight-light font-italic">Niederlagen</span>
                    </div>
                    <div class="col text-center">
                        <span class="display-4 font-italic">
                            {{ $club->getGoalsFor($season).":".$club->getGoalsAgainst($season) }}
                        </span>
                        <span class="font-weight-light font-italic">Tore</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="font-weight-bold" style="color: {{ $club->colours_club_primary }}">Zuletzt</h4>
                        <table class="table table-striped table-sm">
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
                                        @if ($fixture->isPlayed() && !$fixture->isRated())
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
                                        @elseif ($fixture->isRated())
                                            <i class="fa fa-circle fa-stack-2x text-warning"></i>
                                            <strong class="fa-stack-1x text-white">R</strong>
                                        @endif
                                    </span>
                                        </td>
                                        <td class="align-middle">{{ $fixture->datetime ? $fixture->datetime->format('d.m.y') : null }}</td>
                                        <td class="align-middle text-right">
                                            @if($fixture->clubHome)
                                                {{ $fixture->clubHome->name_short }}
                                                @if($fixture->clubHome->logo_url)
                                                    <img src="{{ Storage::url($fixture->clubHome->logo_url) }}" width="30" class="pr-1">
                                                @else
                                                    <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                                @endif
                                            @else
                                                {{ $fixture->club_home }}
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="text-white rounded bg-dark d-inline-block p-1" style="word-break: keep-all">
                                                {{-- cancelled? --}}
                                                @if($fixture->isCancelled())
                                                    <span class="text-danger">Ann.</span>
                                                    {{-- played and *not* rated? --}}
                                                @elseif($fixture->isPlayed() && !$fixture->isRated())
                                                    {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
                                                    {{-- rated? --}}
                                                @elseif($fixture->isRated())
                                                    <span class="text-warning">{{ $fixture->goals_home_rated }} : {{ $fixture->goals_away_rated }}</span>
                                                @else
                                                    -&nbsp;:&nbsp;-
                                                @endif
                                            </div>
                                        </td>
                                        <td class="align-middle text-left">
                                            @if($fixture->clubAway)
                                                @if($fixture->clubAway->logo_url)
                                                    <img src="{{ Storage::url($fixture->clubAway->logo_url) }}" width="30" class="pr-1">
                                                @else
                                                    <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                                @endif
                                                {{ $fixture->clubAway->name_short }}
                                            @else
                                                {{ $fixture->club_away }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4 class="font-weight-bold" style="color: {{ $club->colours_club_primary }}">Demnächst</h4>
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Datum</th>
                                    <th colspan="3" class="text-center">Paarung</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($club->getNextGames(5) as $fixture)
                                <tr>
                                    <td class="align-middle">{{ $fixture->datetime ? $fixture->datetime->format('d.m.y') : null }}</td>
                                    <td class="align-middle text-right">
                                        @if($fixture->clubHome)
                                            {{ $fixture->clubHome->name_short }}
                                            @if($fixture->clubHome->logo_url)
                                                <img src="{{ Storage::url($fixture->clubHome->logo_url) }}" width="30" class="pr-1">
                                            @else
                                                <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                            @endif
                                        @else
                                            {{ $fixture->club_home }}
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($fixture->isPlayed())
                                            {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
                                        @elseif($fixture->isRated())
                                            {{ $fixture->goals_home_rated }} : {{ $fixture->goals_away_rated }}
                                        @else
                                            - : -
                                        @endif
                                    </td>
                                    <td class="align-middle text-left">
                                        @if($fixture->clubAway)
                                            @if($fixture->clubAway->logo_url)
                                                <img src="{{ Storage::url($fixture->clubAway->logo_url) }}" width="30" class="pr-1">
                                            @else
                                                <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                            @endif
                                            {{ $fixture->clubAway->name_short }}
                                        @else
                                            {{ $fixture->club_away }}
                                        @endif
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4 mb-4 no-gutters">
                    <div class="col-12 bg-secondary">
                        Test
                    </div>
                </div>
                @if($club->regularStadium()->first())
                    <div class="row">
                        <div class="col-12">
                            <h4 class="font-weight-bold" style="color: {{ $club->colours_club_primary }}">Spielstätte</h4>
                                @if($club->regularStadium()->first()->lat && $club->regularStadium()->first()->long)
                                    <div id="map" style="width: 100%; height: 450px;"></div>
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
                                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBKAZ6Ay4GdEqmP3gG6Zpp3kOyBSSa-Lc&callback=initMap">
                                    </script>
                                @endif
                        </div>
                    </div>
                @endif
            </div>
            <!-- end home tab -->
            <!-- results tab -->
            <div class="tab-pane fade" id="results" role="tabpanel" aria-labelledby="">
                <div class="row">
                    <div class="col-12">
                        <h2 class="font-weight-bold" style="color: {{ $club->colours_club_primary }}">Resultate</h2>
                        <form class="form-inline pb-2">
                            <label class="pr-4" for="season-selection"><b>Saison</b></label>
                            <select id="season-selection" name="season-selection" class="form-control" aria-labelledby="">
                                @foreach($club->seasons()->orderBy('end', 'desc')->get() as $club_season)
                                    <option {{ $club_season->id == $season->id ? "selected" : null }} value="{{ $club_season->id }}">{{ $club_season->begin->format('Y') }} / {{ $club_season->end->format('Y') }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12" id="response">
                        @include('loader')
                    </div>
                </div>
            </div>
            <!-- end results tab -->
            <!-- players tab -->
            <div class="tab-pane fade" id="players" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-12">
                        <h2 class="font-weight-bold" style="color: {{ $club->colours_club_primary }}">Aktive <span class="badge badge-secondary">{{ $club->players()->active()->count() }}</span></h2>
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

@section('js-footer')

    <script>

        // get the results of a club for the specified season
        function getResults(season){
            $.ajax({
                method:     'GET',
                url:        '/clubs/{{ $club->id }}/ajax-club-results',
                data:       {'season_id' : season},

                success: function(response){
                    $('#response').html(response);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        }

        //
        $(function() {
            // get the results for the current season
            getResults();

            $('#season-selection').change(function () {
                // add loading indicator back
                $('#response').html(@include('loader'));
                // get results of selected season
                getResults($(this).val());

            });
        });

    </script>

@endsection
