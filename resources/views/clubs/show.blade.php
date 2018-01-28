@extends('layouts.app')

@section('subnav')

    {{--@include('_partials.subnav_divisions')--}}

@endsection

@section('content')

{{-- primrary color when club color is white --}}
@php
    if ($club->colours_club_primary == "#FFFFFF" || $club->colours_club_primary == "#ffffff") {
        $primary_color = "#111";
    } else {
        $primary_color = $club->colours_club_primary;
    }
@endphp
<!-- cover -->
<div class="position-relative border border-top-0 border-left-0 border-right-0" style="background-color: {{ $club->colours_club_primary }}">
    <div class="container">
        {{-- TODO: cover! {{ $club->cover_url ? "background-image: url('".asset('storage/'.$club->cover_url)."'); background-size: cover; background-position: center right" :  --}}
        <div class="position-absolute h-100" style="width: 100%; right: 0; background: url(' {{ asset('storage/club_bg.jpg') }} ') no-repeat top center; background-size: cover">
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
        <div class="row pt-3">
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
        <div class="row pt-3">
            <div class="col">
                <!-- tabs -->
                <nav class="nav nav-tabs border-0" id="tab" role="tablist">
                    <a class="nav-item nav-link px-2 active border border-white" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-expanded="true" style="background-color: rgba(0, 0, 0, 0.5);">
                        Übersicht
                    </a>
                    <a class="ml-1 nav-item nav-link px-2 border-white" id="results-tab" data-toggle="tab" href="#results" role="tab" aria-controls="results" style="background-color: rgba(0, 0, 0, 0.5);" >
                        Resultate
                    </a>
                    <a class="ml-1 nav-item nav-link px-2 border-white" id="players-tab" data-toggle="tab" href="#players" role="tab" aria-controls="players" style="background-color: rgba(0, 0, 0, 0.5);">
                        Kader
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- content -->
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="tab-content col-12" id="tabcontent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <h1 class="font-weight-bold font-italic text-uppercase" style="color: {{ $primary_color }}">Übersicht</h1>
                <div class="row">
                    <div class="col">
                        <div class="p-4 bg-light rounded text-muted">
                            <ul class="list-inline d-flex justify-content-around mb-0">
                                @if ($club->founded)
                                    <li class="list-inline-item" title="Gegründet">
                                        <span class="fa fa-birthday-cake fa-3x pr-1 align-middle"></span>
                                        <span class="h3 align-middle">{{ $club->founded->format('d.m.Y') }}</span>
                                    </li>
                                @endif
                                @if ($club->league_entry)
                                    <li class="list-inline-item" title="Eingetreten">
                                        <span class="fa fa-sign-in fa-3x pr-1 align-middle"></span>
                                        <span class="h3 align-middle">{{ $club->league_entry->format('d.m.Y') }}</span>
                                    </li>
                                @endif
                                @if ($club->league_exit)
                                    <li class="list-inline-item" title="Ausgetreten">
                                        <span class="fa fa-sign-out fa-3x pr-1 align-middle"></span>
                                        <span class="h3 align-middle">{{ $club->league_exit->format('d.m.Y') }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        @if ($reschedulings && !$reschedulings->isEmpty())
                            @php
                                $total_reschedulings      = $reschedulings->count();
                                $counting_reschedulings   = $reschedulings->where('reschedule_count', true)->count();
                            @endphp
                                <h2 class="font-weight-bold font-italic text-uppercase" style="color: {{ $primary_color }}">Spielverlegungen</h2>
                                <div class="row">
                                    <div class="col-2 d-flex justify-content-center align-items-center">
                                        <div class="h1 font-weight-bold font-italic align-middle text-center {{ $counting_reschedulings >= $season->max_rescheduling ? "text-danger" : null }}" title="Anzahl Verlegungen">
                                            <span class="fa fa-fw fa-calendar-plus-o"></span>
                                            {{ $counting_reschedulings }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <ul class="list-group">
                                            @if ($total_reschedulings > 0)
                                                @foreach ($reschedulings as $rescheduled_fixture)
                                                    <li class="list-group-item">
                                                        {{ $rescheduled_fixture->clubHome ? $rescheduled_fixture->clubHome->name_short : "-" }}
                                                        :
                                                        {{ $rescheduled_fixture->clubAway ? $rescheduled_fixture->clubAway->name_short : "-" }}
                                                        aus SW {{ $rescheduled_fixture->matchweek->number_consecutive }}
                                                        verlegt vom {{ $rescheduled_fixture->rescheduledFrom && $rescheduled_fixture->rescheduledFrom->datetime ? $rescheduled_fixture->rescheduledFrom->datetime->format('d.m.Y H:i') : "o.D." }}
                                                        auf den {{ $rescheduled_fixture->datetime ? $rescheduled_fixture->datetime->format('d.m.Y H:i') : "o.D." }}
                                                        <span class="pull-right">
                                                            <a href="{{ route('frontend.fixtures.show', $rescheduled_fixture) }}" title="Match betrachten">
                                                                <i class="fa fa-fw fa-arrow-right"></i>
                                                            </a>
                                                        </span>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li class="list-group-item">
                                                    <span class="fa fa-fw fa-thumbs-o-up"></span> Team hat bisher kein Spiel verlegt.
                                                </li>
                                            @endif
                                        </ul>
                                        @if ($total_reschedulings > $counting_reschedulings)
                                            <small class="text-muted">
                                                {{ $total_reschedulings - $counting_reschedulings }} Verlegung wird nicht gezählt.
                                            </small>
                                        @endif
                                    </div>
                                </div>
                        @endif
                    </div>
                    {{-- club colors --}}
                    <div class="col-md-6">

                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <h2 class="font-weight-bold font-italic text-uppercase" style="color: {{ $primary_color }}">Zuletzt</h2>
                        @php
                            $lastGames = $club->getLastGamesPlayedOrRated(5)->load('clubHome', 'clubAway');
                        @endphp
                        @if (!$lastGames->isEmpty())
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="align-middle"><span class="fa fa-calendar" title="Datum"></span></th>
                                        <th colspan="3" class="text-center"><span class="fa fa-handshake-o" title="Paarung"></span></th>
                                        <th class="align-middle text-center"><span class="fa fa-search-plus" title="Spieldetails"></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lastGames as $fixture)
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
                                                    <span class="pr-1">{{ $fixture->clubHome->name_short }}</span>
                                                    @if($fixture->clubHome->logo_url)
                                                        <img src="{{ asset('storage/'.$fixture->clubHome->logo_url) }}" width="30" class="">
                                                    @else
                                                        <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                                    @endif
                                                @else
                                                    <span class="pr-1">{{ $fixture->club_home }}</span>
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
                                                        <img src="{{ asset('storage/'.$fixture->clubAway->logo_url) }}" width="30" class="">
                                                    @else
                                                        <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                                    @endif
                                                    <span class="pl-1">{{ $fixture->clubAway->name_short }}</span>
                                                    @else
                                                    <span class="pl-1">{{ $fixture->club_away }}</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('frontend.fixtures.show', $fixture) }}" title="Spieldetails">
                                                    <span class="fa fa-fw fa-arrow-right"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            Keine zurückliegenden Spiele.
                        @endif
                    </div>
                    <div class="col-md-6">
                        @php
                            $nextGames = $club->getNextGames(5)->load('clubHome','clubAway');
                        @endphp
                        <h2 class="font-weight-bold font-italic text-uppercase" style="color: {{ $primary_color }}">Demnächst</h2>
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
                                                    <img src="{{ asset('storage/'.$fixture->clubHome->logo_url) }}" width="30" class="pr-1">
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
                                                    <img src="{{ asset('storage/'.$fixture->clubAway->logo_url) }}" width="30" class="pr-1">
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
                        @else
                            Keine anstehenden Spiele.
                        @endif
                    </div>
                </div>
                @if ($club->note)
                    <div class="row mt-4">
                        <div class="col">
                            <h2 class="font-weight-bold font-italic text-uppercase" style="color: {{ $primary_color }}">Notizen zum Club</h2>
                            <p>{{ $club->note }}</p>
                            {{-- TODO: stadiums --}}
                        </div>
                    </div>
                @endif
                @php
                    $players = $club->players()->active()->public()->get();
                @endphp
                @if (!$players->isEmpty())
                    <div class="row mt-2">
                        <div class="col">
                            <h2 class="font-weight-bold font-italic text-uppercase">Gesperrte Spieler</h2>
                            <ul class="list-group border-danger">
                            @php
                                $suspended_players = false;
                            @endphp
                                @foreach ($players as $player)
                                    @if ($card = $player->isSuspended())
                                        <div class="alert alert-danger">
                                            {{ $player->person->first_name }} {{ $player->person->last_name }}
                                            wurde am <b>{{ $card->fixture->datetime ? $card->fixture->datetime->format('d.m.Y') : null }}</b>
                                            im Spiel <a href="{{ route('frontend.fixtures.show', $card->fixture) }}" class="text-danger" title="Spieldetails">{{ $card->fixture->clubHome ? $card->fixture->clubHome->name : null }} : {{ $card->fixture->clubAway ? $card->fixture->clubAway->name : null }}</a>
                                            für <b>{{ $card->ban_matches - $card->ban_reduced_by }}</b> Spiele gesperrt. Die Sperre gilt noch für <b>{{ $card->ban_remaining }}</b> weitere Spiele.
                                            @if ($card->ban_reason)
                                                Grund der Sperre: {{ $card->ban_reason }}
                                            @endif
                                        </div>
                                        @php
                                            $suspended_players = true;
                                        @endphp
                                    @endif
                                @endforeach
                                @unless ($suspended_players)
                                    <div class="alert alert-success">
                                        <span class="fa fa-check-circle-o"></span> Alle Spieler sind spielberechtigt.
                                    </div>
                                @endunless
                            </ul>
                        </div>
                    </div>
                @endif
                @auth
                    @php
                        $contacts = $club->contacts;
                    @endphp
                    <div class="row mt-2">
                        <div class="col">
                            <h2 class="font-weight-bold font-italic text-uppercase">Ansprechpartner</h2>
                            @if (!$contacts->isEmpty())
                                <ul class="list-group">
                                    @foreach ($club->contacts()->orderBy('hierarchy_level')->with('person')->get() as $contact)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span class="font-weight-bold">
                                                {{ $contact->hierarchy_level }}
                                            </span>
                                            <span class="">
                                                {{ $contact->person->first_name }} {{ $contact->person->last_name }}
                                            </span>
                                            <span class="">
                                                {{ $contact->mail }}
                                            </span>
                                            <span class="">
                                                {{ $contact->mobile }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="alert alert-info">
                                    <span class="fa fa-info-circle"></span> Es wurden keine Ansprechpartner angegeben.
                                </div>
                            @endif
                        </div>
                    </div>
                @endauth
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
                        <h2 class="font-weight-bold font-italic text-uppercase" style="color: {{ $primary_color }}">Resultate</h2>
                        <form class="form-inline pb-2">
                            <label class="pr-4" for="season-selection"><b>Saison</b></label>
                            <select id="season-selection" name="season-selection" class="form-control" aria-labelledby="">
                                @foreach($club->seasons()->published()->orderBy('end','desc')->get() as $club_season)
                                    <option {{ $club_season->id == $season->id ? "selected" : null }} value="{{ $club_season->id }}">{{ $club_season->name }} {{ $club_season->division ? "- ".$club_season->division->name : null }}</option>
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
                        <div class="row my-1">
                            <div class="col text-muted">
                                Es sind nur Spieler mit einem gültigen Spielerpass der HLW spielberechtigt.
                            </div>
                        </div>
                        @foreach($active_players->chunk(4) as $player_chunk)
                            <div class="row">
                                @foreach($player_chunk as $player)
                                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                                        <div class="card {{ $player->isSuspended() ? "border-danger text-danger" : null }}">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <h4 class="card-title font-weight-bold">
                                                        {{ $player->person->full_name_shortened }}
                                                        <span class="pull-right" style="color: {{ $club->colours_club_primary }}">{{ $player->number ? "#".$player->number : null }}</span>
                                                    </h4>
                                                    @if ($player->isSuspended())
                                                        <h6 class="card-subtitle mb-2">
                                                            Spieler ist gesperrt
                                                        </h6>
                                                    @endif
                                                </li>
                                                <li class="list-group-item">
                                                    <p class="card-text">
                                                        <span class="fa fa-pencil-square-o"></span>
                                                        @if($player->sign_on)
                                                            {{ $player->sign_on->format('d.m.Y') }}
                                                            @if( Carbon::now()->diffInYears($player->sign_on) > 0 )
                                                                <br><small class="text-muted">{{ Carbon::now()->diffInYears($player->sign_on) == 1 ? Carbon::now()->diffInYears($player->sign_on)." Jahr" : Carbon::now()->diffInYears($player->sign_on)." Jahre" }} dabei</small>
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
                                                            $cards_yr = $player->cards()->yellowReds()->with('fixture.matchweek.season')->get()->where('fixture.matchweek.season.id', $season->id)->count();
                                                            $cards_r = $player->cards()->reds()->with('fixture.matchweek.season')->get()->where('fixture.matchweek.season.id', $season->id)->count();
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
