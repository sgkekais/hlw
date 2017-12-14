@extends('layouts.app')

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

<!-- cover -->
<div class="position-relative border border-top-0 border-left-0 border-right-0" style="background-color: {{ $club->colours_club_primary }}">
    <div class="container">
        {{-- TODO: cover! {{ $club->cover_url ? "background-image: url('".asset('storage/'.$club->cover_url)."'); background-size: cover; background-position: center right" :  --}}
        <div class="position-absolute h-100" style="width: 100%; right: 0; background-image: url(' {{ asset('storage/clubcovers/default.jpg') }} '); background-size: cover; background-position: bottom right">
            {{-- inner --}}
            <div class="position-relative h-100" style="width: 40%; background: repeating-linear-gradient(
                    135deg,
                    transparent,
                    transparent 20px,
                    {{ $club->colours_club_primary }} 20px,
                    {{ $club->colours_club_primary }} 40px
                );">

            </div>
        </div>
        <div class="row pt-4">
            <div class="col-3 text-center">
                @if($club->logo_url)
                    <img src="{{ asset('storage/'.$club->logo_url) }}" class="img-fluid" title="{{ $club->name }}" alt="Vereinswappen">
                @else
                    <span class="fa fa-ban text-muted fa-5x"></span>
                @endif
            </div>
            <div class="col-9 text-white">
                <h1 class="font-weight-bold"><span class="p-1 bg-black-transparent">{{ $club->name }}</span></h1>
                <ul class="list-unstyled">
                    {{-- league championships --}}
                    @php
                        $league_championships = $club->championships->where('division.competition.type', 'league')->sortByDesc('end');
                    @endphp
                    @if (!$league_championships->isEmpty())
                        <li class="my-1">
                        <span class="p-1 bg-black-transparent">
                            @foreach ($league_championships as $league_championship)
                                <i class="fa fa-fw fa-star" style="color: orange" title="{{ $league_championship->name }}"></i>
                            @endforeach
                        </span>
                        </li>
                    @endif
                    {{-- cup trophys --}}
                    @php
                        $cup_championships = $club->championships->where('division.competition.type', 'knockout')->sortByDesc('end');
                    @endphp
                    @if (!$cup_championships->isEmpty())
                        <li class="my-1">
                        <span class="p-1 bg-black-transparent">
                            @foreach ($cup_championships as $cup_championship)
                                <i class="fa fa-fw fa-trophy" style="color: orange" title="{{ $cup_championship->name }}"></i>
                            @endforeach
                        </span>
                        </li>
                    @endif
                    {{-- stadium --}}
                    @php
                        $regular_stadium = $club->regularStadium->first();
                    @endphp
                    @isset ($regular_stadium)
                        <li class="my-1">
                        <span class="p-1 bg-black-transparent">
                            @svg('arena', ['class' => 'align-middle pr-1', 'style' => 'fill: #FFF', 'width' => '30', 'height' => '30'])
                            {{ $regular_stadium->name }}
                        </span>
                        </li>
                        <li class="my-1">
                        <span class="p-1 bg-black-transparent">
                            <i class="fa fa-fw fa-calendar"></i> {{ $regular_stadium->pivot->regular_home_day }}
                            <i class="fa fa-fw fa-clock-o"></i> {{ $regular_stadium->pivot->regular_home_time }}
                        </span>
                        </li>
                    @endif
                    {{-- website --}}
                    @if($club->website)
                        <li class="my-1">
                        <span class="p-1 bg-black-transparent">
                            <i class="fa fa-fw fa-home"></i> <a href="{{ $club->website }}" target="_blank">Offizielle Website</a>
                        </span>
                        </li>
                    @endif
                    {{-- facebook --}}
                    @if($club->facebook)
                        <li class="my-1">
                        <span class="p-1 bg-black-transparent">
                            <i class="fa fa-fw fa-facebook"></i> <a href="{{ $club->facebook }}" target="_blank">Facebook</a>
                        </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col">
                <!-- tabs -->
                <nav class="nav nav-tabs border-0" id="tab" role="tablist">
                    <a class="nav-item nav-link active border border-white" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-expanded="true" style="background-color: rgba(0, 0, 0, 0.5);">
                        Übersicht
                    </a>
                    <a class="ml-1 nav-item nav-link border-white" id="results-tab" data-toggle="tab" href="#results" role="tab" aria-controls="results" style="background-color: rgba(0, 0, 0, 0.5);" >
                        Resultate
                    </a>
                    <a class="ml-1 nav-item nav-link border-white" id="players-tab" data-toggle="tab" href="#players" role="tab" aria-controls="players" style="background-color: rgba(0, 0, 0, 0.5);">
                        Kader
                    </a>
                </nav>
            </div>
        </div>
    </div>

</div>
<!-- content -->
<div class="container mt-4">
    <div class="row">
        <div class="tab-content col-12" id="tabcontent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <h2 class="font-weight-bold font-italic text-uppercase" style="color: {{ $club->colours_club_primary }}">Übersicht</h2>
                {{--<div class="row my-2">
                    <div class="col text-center">
                        <span class="h1 font-weight-bold font-italic">
                            {{ $club->getGamesPlayedWon($season)->count() + $club->getGamesRatedWon($season)->count() }}
                        </span>
                        <span class="h1 font-italic">
                            S
                        </span>
                    </div>
                    <div class="col text-center">
                        <span class="h1 font-weight-bold font-italic">
                            {{ $club->getGamesPlayedDrawn($season)->count() + $club->getGamesRatedDrawn($season)->count() }}
                        </span>
                        <span class="h1 font-italic">
                            U
                        </span>
                    </div>
                    <div class="col text-center">
                        <span class="h1 font-weight-bold font-italic">
                            {{ $club->getGamesPlayedLost($season)->count() + $club->getGamesRatedLost($season)->count() }}
                        </span>
                        <span class="h1 font-italic">
                            N
                        </span>
                    </div>
                    <div class="col text-center">
                        <span class="h1 font-weight-bold font-italic">
                            {{ $club->getGoalsFor($season).":".$club->getGoalsAgainst($season) }}
                        </span>
                        <span class="h1 font-italic">
                            Tore
                        </span>
                    </div>--}}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="font-weight-bold font-italic text-uppercase" style="color: {{ $club->colours_club_primary }}">Zuletzt</h3>
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Datum</th>
                                    <th colspan="3" class="text-center">Paarung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($club->getLastGamesPlayedOrRated(5)->load('clubHome', 'clubAway') as $fixture)
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
                                                    <img src="{{ asset('storage/'.$fixture->clubHome->logo_url) }}" width="30" class="pr-1">
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
                                                    <img src="{{ asset('storage/'.$fixture->clubAway->logo_url) }}" width="30" class="pr-1">
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
                        @php
                            $nextGames = $club->getNextGames(5)->load('clubHome','clubAway');
                        @endphp
                        <h3 class="font-weight-bold font-italic text-uppercase" style="color: {{ $club->colours_club_primary }}">Demnächst</h3>
                        @if (!$nextGames->isEmpty())
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Datum</th>
                                        <th colspan="3" class="text-center">Paarung</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($nextGames as $fixture)
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
                        @endif
                        <em>Keine anstehenden Spiele.</em>
                    </div>
                </div>
                <div class="row mt-4 mb-4 no-gutters">
                    <div class="col-12 bg-secondary">
                        Test
                    </div>
                </div>
                {{--
                TODO: Stadion anzeigen?
                @if($club->regularStadium()->first())
                    <div class="row">
                        <div class="col-12">
                            <h4 class="font-weight-bold font-italic text-uppercase" style="color: {{ $club->colours_club_primary }}">Spielstätte</h4>
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
                @endif--}}
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
                                @foreach($club->seasons->sortByDesc('end') as $club_season)
                                    <option {{ $club_season->id == $season->id ? "selected" : null }} value="{{ $club_season->id }}">{{ $club_season->name }}</option>
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
                        @php
                            $active_players = $club->players()->active()->public()->with('person', 'goals.fixture.matchweek.season', 'cards.fixture.matchweek.season')->get()->sortBy('person.last_name');
                        @endphp
                        <h2 class="font-weight-bold" style="color: {{ $club->colours_club_primary }}">Aktive <span class="badge badge-secondary">{{ $active_players->count() }}</span></h2>
                        @foreach($active_players->chunk(4) as $player_chunk)
                            <div class="row">
                                @foreach($player_chunk as $player)
                                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                                        <div class="card">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <h4 class="card-title font-weight-bold">
                                                        {{ $player->person->full_name_shortened }}
                                                        <span class="pull-right" style="color: {{ $club->colours_club_primary }}">{{ $player->number ? "#".$player->number : null }}</span>
                                                    </h4>
                                                    <h6 class="card-subtitle mb-2" style="color: red">
                                                        TODO: Gesperrt
                                                    </h6>
                                                </li>
                                                <li class="list-group-item">
                                                    <p class="card-text">
                                                        <span class="fa fa-pencil-square-o"></span>
                                                        @if($player->sign_on)
                                                            {{ $player->sign_on->format('d.m.Y') }}
                                                            @if( Carbon::now()->diffInYears($player->sign_on) > 0 )
                                                                <br><small class="text-muted">{{ Carbon::now()->diffInYears($player->sign_on) }} Jahre dabei</small>
                                                            @else
                                                                <br><small class="text-muted">{{ Carbon::now()->diffInDays($player->sign_on)}} Tage dabei</small>
                                                            @endif
                                                        @endif
                                                    </p>
                                                </li>
                                                <li class="list-group-item">
                                                    <ul class="list-unstyled">
                                                        @php
                                                            $goals_season = $player->goals->where('fixture.matchweek.season.id', $season->id )->count();
                                                            $cards_yr = $player->cards()->yellowReds()->get()->where('fixture.matchweek.season.id', $season->id)->count();
                                                            $cards_r = $player->cards()->reds()->get()->where('fixture.matchweek.season.id', $season->id)->count();
                                                        @endphp
                                                        <li>
                                                            Saison <b>{{ $season->name }}</b>
                                                            <ul class="list-inline">
                                                                <li class="list-inline-item"><span class="fa fa-soccer-ball-o fa-fw"></span> {{ $goals_season }}</li>
                                                                <li class="list-inline-item"><span class="fa fa-clone fa-fw" style="color: orange;"></span> <b> {{ $cards_yr }}</b></li>
                                                                <li class="list-inline-item"><span class="fa fa-clone fa-fw" style="color: red"></span> <b> {{ $cards_r }}</b></li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="list-group-item">
                                                    Insgesamt
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item"><span class="fa fa-soccer-ball-o fa-fw"></span> <b>{{ $player->goals->count() }}</b></li>
                                                        <li class="list-inline-item"><span class="fa fa-clone fa-fw" style="color: orange;"></span> <b>{{ $player->cards()->yellowReds()->count() }}</b></li>
                                                        <li class="list-inline-item"><span class="fa fa-clone fa-fw" style="color: red"></span> <b>{{ $player->cards()->reds()->count() }}</b></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                @php
                    $inactive_players = $club->players()->inactive()->with('person', 'goals', 'cards')->get()->sortBy('person.last_name');
                @endphp
                @if(!$inactive_players->isEmpty())
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
                                @foreach($inactive_players as $inactive_player)
                                    <tr>
                                        <td class="align-middle">{{ $inactive_player->person->full_name_shortened }}</td>
                                        <td class="align-middle">{{ $inactive_player->sign_on ? $inactive_player->sign_on->format('d.m.Y') : null }}</td>
                                        <td class="align-middle">{{ $inactive_player->sign_off ? $inactive_player->sign_off->format('d.m.Y') : null}}</td>
                                        <td class="align-middle text-center">{{ $inactive_player->goals->count() }}</td>
                                        <td class="align-middle text-center">{{ $inactive_player->cards()->yellowReds()->count() }}</td>
                                        <td class="align-middle text-center">{{ $inactive_player->cards()->reds()->count() }}</td>
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
