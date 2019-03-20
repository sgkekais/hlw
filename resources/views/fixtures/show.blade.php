@extends ('layouts.app')

@section('title')

@endsection

@section ('content')

    <div class="w-100 bg-dark" style="background: url({{ asset('storage/matchbg.jpg') }}) bottom; background-size: cover">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="text-center text-white font-weight-bold bg-black-transparent">
                        {{ $fixture->matchweek->season->division->name }}&nbsp;&ndash;
                        @if ($fixture->type == "league")
                            {{ $fixture->matchweek->number_consecutive }}. Spielwoche {{ $fixture->matchweek->name ? "|".$fixture->matchweek->name : null }}
                        @elseif ($fixture->type == "knockout")
                            {{ $fixture->matchweek->name }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- home logo --}}
                <div class="col-4 d-flex">
                    @if ($fixture->clubHome)
                        @if ($fixture->clubHome->logo_url)
                            <img src="{{ asset('storage/'.$fixture->clubHome->logo_url) }}" class="img-fluid align-self-end py-2 pull-left bg-black-transparent">
                        @endif
                    @endif
                </div>
                {{-- match details --}}
                <div class="col-4 pl-0 pr-0 d-flex flex-column text-center text-white ">
                    <div class="mt-auto bg-black-transparent">
                        @if ($fixture->datetime)
                            <span class="fa fa-fw fa-calendar"></span>
                            {{ $fixture->datetime->format('d.m.y') }}
                            <br>
                            <span class="fa fa-fw fa-clock-o"></span>
                            @if ($fixture->datetime->format('H:i') != "00:00")
                                {{ $fixture->datetime->format('H:i') }}
                            @else
                                --:--
                            @endif
                        @else
                            <span class="fa fa-fw fa-calendar"></span>
                            <span class="" title="ohne Datum">o.D.</span>
                        @endif
                    </div>
                    <div class="bg-black-transparent">
                        @svg('arena', ['class' => 'align-middle pr-1', 'style' => 'fill: #fff', 'width' => '30', 'height' => '30'])
                        @php
                            $color = null;
                            $title = null;
                        @endphp
                        @if ($fixture->stadium && $fixture->clubHome)
                            @if (!$fixture->clubHome->regularStadium->isEmpty())
                                @if ($fixture->clubHome->regularStadium->first()->id != $fixture->stadium->id)
                                    @php
                                        $color = "text-warning";
                                        $title = "Abweichender Spielort";
                                    @endphp
                                @endif
                            @endif
                        @endif
                        @if ($fixture->stadium)
                            <span class="d-inline d-lg-none {{ $color }}" title="{{ $title }}">{{ $fixture->stadium->name_short }}</span>
                            <span class="d-none d-lg-inline {{ $color }}" title="{{ $title }}">{{ $fixture->stadium->name }}</span>
                        @else
                            -
                        @endif
                    </div>
                    <div class="mb-0 bg-black-transparent">
                        @auth
                            @php
                                $referees = $fixture->referees;
                            @endphp
                            @if (!$referees->isEmpty())
                                @foreach ($referees as $referee)
                                    @svg('whistle', ['class' => 'align-middle pr-1', 'style' => 'fill: #fff', 'width' => '35', 'height' => '35'])
                                    {{ $referee->person->full_name_shortened }}
                                @endforeach
                            @endif
                        @endauth
                    </div>
                </div>
                {{-- away details --}}
                <div class="col-4 d-flex justify-content-end">
                    @if ($fixture->clubAway)
                        @if ($fixture->clubAway->logo_url)
                            <img src="{{ asset('storage/'.$fixture->clubAway->logo_url) }}" class="img-fluid align-self-end py-2 bg-black-transparent">
                        @endif
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-4 col-sm-5 pr-0">
                    <h1 class="p-2 text-white font-weight-bold font-italic bg-black-transparent">
                        @if ($fixture->clubHome)
                            <a href="{{ route('frontend.clubs.show', $fixture->clubHome) }}" title="Mannschaft anzeigen" class="text-white">
                                {{-- visible only on xs --}}
                                <span class="d-inline d-sm-none">{{ $fixture->clubHome->name_code }}</span>
                                {{-- visible only on sm and md --}}
                                <span class="d-none d-sm-inline d-lg-none">{{ $fixture->clubHome->name_short }}</span>
                                {{-- hidden on xs, sm, md --}}
                                <span class="d-none d-lg-inline">{{ $fixture->clubHome->name }}</span>
                            </a>
                        @else
                            {{ $fixture->club_id_home ?? "-" }}
                        @endif
                    </h1>
                </div>
                <div class="col-4 col-sm-2 px-0 text-center">
                    <div class="h1 p-2 text-white bg-dark">
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
                </div>
                <div class="col-4 col-sm-5 pl-0 text-right">
                    <h1 class="p-2 text-white font-weight-bold font-italic bg-black-transparent">
                        @if ($fixture->clubAway)
                            <a href="{{ route('frontend.clubs.show', $fixture->clubAway) }}" title="Mannschaft anzeigen" class="text-white">
                                {{-- visible only on xs --}}
                                <span class="d-inline d-sm-none">{{ $fixture->clubAway->name_code }}</span>
                                {{-- visible only on sm and md --}}
                                <span class="d-none d-sm-inline d-lg-none">{{ $fixture->clubAway->name_short }}</span>
                                {{-- hidden on xs, sm, md --}}
                                <span class="d-none d-lg-inline">{{ $fixture->clubAway->name }}</span>
                            </a>
                        @else
                            {{ $fixture->club_id_away ?? "-" }}
                        @endif
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        {{-- form --}}
        <div class="row mt-2">
            <div class="col-6 d-flex flex-column flex-sm-row justify-content-start align-items-start">
                @if ($fixture->clubHome)
                    @foreach ($fixture->clubHome->getLastGamesPlayedOrRated(5, $fixture->matchweek->season->isFinished() ? $fixture->matchweek->season->end : null, $fixture->matchweek->season->begin) as $lastGame)
                        <span class="fa-stack fa-lg" data-toggle="tooltip" data-html="true" title="{{ $lastGame->matchweek->season->division->name }} | {{ $lastGame->datetime ?  $lastGame->datetime->format('d.m.') : null }} - {{ $lastGame->clubHome ? $lastGame->clubHome->name_code : null }} {{ $lastGame->goals_home ?? $lastGame->goals_home_rated }} : {{ $lastGame->goals_away ?? $lastGame->goals_away_rated }} {{ $lastGame->clubAway ? $lastGame->clubAway->name_code : null }}">
                            @if ($lastGame->isPlayed() && !$lastGame->isRated())
                                @if ($fixture->clubHome->hasWon($lastGame))
                                    <i class="fa fa-circle fa-stack-2x text-success"></i>
                                    <strong class="fa-stack-1x" style="color:#ffffff">S</strong>
                                @elseif ($fixture->clubHome->hasLost($lastGame))
                                    <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                    <strong class="fa-stack-1x" style="color:#ffffff">N</strong>
                                @elseif ($fixture->clubHome->hasDrawn($lastGame))
                                    <i class="fa fa-circle fa-stack-2x text-dark"></i>
                                    <strong class="fa-stack-1x" style="color:#ffffff">U</strong>
                                @endif
                            @elseif ($lastGame->isRated())
                                <i class="fa fa-circle fa-stack-2x text-warning"></i>
                                <strong class="fa-stack-1x" style="color:#ffffff">W</strong>
                            @endif
                        </span>
                    @endforeach
                @endif
            </div>
            <div class="col-6 d-flex flex-column flex-sm-row justify-content-start justify-content-sm-end align-items-end">
                @if ($fixture->clubAway)
                    @foreach ($fixture->clubAway->getLastGamesPlayedOrRated(5, $fixture->matchweek->season->isFinished() ? $fixture->matchweek->season->end : null, $fixture->matchweek->season->begin) as $lastGame)
                        <span class="fa-stack fa-lg" data-toggle="tooltip" data-html="true" title="{{ $lastGame->matchweek->season->division->name }} | {{ $lastGame->datetime ?  $lastGame->datetime->format('d.m.') : null }} - {{ $lastGame->clubHome ? $lastGame->clubHome->name_code : null }} {{ $lastGame->goals_home ?? $lastGame->goals_home_rated }} : {{ $lastGame->goals_away ?? $lastGame->goals_away_rated }} {{ $lastGame->clubAway ? $lastGame->clubAway->name_code : null }}">
                            @if ($lastGame->isPlayed() && !$lastGame->isRated())
                                @if ($fixture->clubAway->hasWon($lastGame))
                                    <i class="fa fa-circle fa-stack-2x text-success"></i>
                                    <strong class="fa-stack-1x" style="color:#ffffff">S</strong>
                                @elseif ($fixture->clubAway->hasLost($lastGame))
                                    <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                    <strong class="fa-stack-1x" style="color:#ffffff">N</strong>
                                @elseif ($fixture->clubAway->hasDrawn($lastGame))
                                    <i class="fa fa-circle fa-stack-2x text-dark"></i>
                                    <strong class="fa-stack-1x" style="color:#ffffff">U</strong>
                                @endif
                            @elseif ($lastGame->isRated())
                                <i class="fa fa-circle fa-stack-2x text-warning"></i>
                                <strong class="fa-stack-1x" style="color:#ffffff">W</strong>
                            @endif
                        </span>
                    @endforeach
                @endif
            </div>
        </div>
        {{-- critical info --}}
        @if ($fixture->isCancelled())
            <div class="row mt-4">
                <div class="col">
                    <div class="alert alert-danger text-center">
                        <h4>
                            <i class="fa fa-fw fa-warning"></i> Dieses Spiel wurde annulliert!
                        </h4>
                        <p class="mt-2">
                            Alle hier aufgeführten Daten werden nicht mehr berücksichtigt.
                            @if ($fixture->isPlayed() && !$fixture->isRated())
                                <br><b>Ursprüngliches Ergebnis:</b> {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
                            @elseif ($fixture->isRated())
                                <br><b>Ursprünglich gewertet:</b> {{ $fixture->goals_home_rated }} : {{ $fixture->goals_away_rated }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @elseif ($fixture->isRated())
            <div class="row mt-4">
                <div class="col">
                    <div class="alert alert-warning text-center">
                        <h4>
                            <i class="fa fa-fw fa-warning"></i> Dieses Spiel wurde
                            @if ($fixture->isPlayed())
                                <b>nachträglich</b>
                            @endif
                            gewertet!
                        </h4>
                        <p class="mt-2 mb-0">
                            {{ $fixture->rated_note ? "Grund für die Wertung: ".$fixture->rated_note : "(Kein Grund für die Wertung angegeben.)"}}
                            <br>
                            @if ($fixture->isPlayed())
                                Ursprüngliches Ergebnis: {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @elseif ($fixture->rescheduledFrom)
            <div class="row mt-4">
                <div class="col">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert"">
                        <h4>
                            <i class="fa fa-fw fa-info-circle"></i> Dies ist ein verlegtes Spiel!
                        </h4>
                        <p class="mt-2 mb-0">
                            @if ($fixture->rescheduledFrom->datetime)
                                Dieses Spiel sollte ursprünglich am {{ $fixture->rescheduledFrom->datetime->format('d.m.Y') }} stattfinden {{ $fixture->rescheduledBy ? "und wurde von ".$fixture->rescheduledBy->name." verlegt" : null }}.
                                <br>
                                Klicke <a href="{{ route('frontend.fixtures.show', $fixture->rescheduledFrom) }}" title="zum ursprünglichen Termin">hier</a>, um den ursprünglichen Termin zu betrachten.
                            @endif
                        </p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        @elseif ($fixture->rescheduledTo)
            <div class="row mt-4">
                <div class="col">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h4>
                            <i class="fa fa-fw fa-info-circle"></i> Dieses Spiel wurde auf einen <a href="{{ route('frontend.fixtures.show', $fixture->rescheduledTo) }}" title="zum neuen Termin springen">neuen Termin</a> verlegt!
                        </h4>
                        <p class="mt-2 mb-0">
                            <b>Verlegt von:</b> {{ $fixture->rescheduledTo->rescheduledBy ? $fixture->rescheduledTo->rescheduledBy->name : "-"  }}
                            <br>
                            <b>Grund für die Verlegung:</b>
                            @if ($fixture->rescheduledTo->reschedule_reason)
                                {{ $fixture->rescheduledTo->reschedule_reason }}
                            @else
                                Kein Grund für die Verlegung angegeben.
                            @endif
                            <br>
                            <b>Zählt als Verlegung:</b> {{ $fixture->rescheduledTo->reschedule_count ? "Ja" : "Nein" }}
                        </p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        {{-- goals --}}
        @php
            $goals = $fixture->goals;
        @endphp
        @if (!$goals->isEmpty())
            <div class="row mt-2 ">
                <div class="col text-center">
                    <h2 class="font-weight-bold font-italic">
                        Gemeldete Torschützen
                    </h2>
                </div>
            </div>
            <div class="row">
                {{-- home goals --}}
                @php
                    $home_goals = $goals->where('player.club.id', $fixture->clubHome->id);
                @endphp
                <div class="col-6">
                    @if (!$home_goals->isEmpty())
                        <ul class="list-unstyled text-right">
                            @foreach ($home_goals as $home_goal)
                                <li>
                                    <span class="align-middle">
                                        {{ $home_goal->player->person->full_name_shortened }}&nbsp;
                                        @if ($home_goal->score)
                                            <span class="font-weight-bold">
                                                ({{ $home_goal->score }})
                                            </span>
                                        @endif
                                    </span>
                                    <span class="fa fa-fw fa-soccer-ball-o align-middle"></span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                {{-- away goals --}}
                @php
                    $away_goals = $goals->where('player.club.id', $fixture->clubAway->id);
                @endphp
                <div class="col-6">
                    @if (!$away_goals->isEmpty())
                        <ul class="list-unstyled">
                            @foreach ($away_goals as $away_goal)
                                <li>
                                    <span class="fa fa-fw fa-soccer-ball-o align-middle"></span>
                                    <span class="align-middle">
                                        @if ($away_goal->score)
                                            <span class="font-weight-bold">
                                                ({{ $away_goal->score }})
                                            </span>
                                        @endif
                                        &nbsp;{{ $away_goal->player->person->full_name_shortened }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endif
        {{-- cards --}}
        @php
            $cards = $fixture->cards;
        @endphp
        @if (!$cards->isEmpty())
            <hr>
            <div class="row mt-2">
                <div class="col text-center">
                    <h2 class="font-weight-bold font-italic">Karten</h2>
                </div>
            </div>
            <div class="row">
                {{-- home cards --}}
                @php
                    $home_cards = $cards->where('player.club.id', $fixture->clubHome->id);
                @endphp
                <div class="col-6">
                    @if (!$home_cards->isEmpty())
                        <ul class="list-unstyled text-right">
                            @foreach ($home_cards as $home_card)
                                <li>
                                    <div class="">
                                        {{ $home_card->player->person->full_name_shortened }}
                                        @if ($home_card->color == "gelb")
                                            <span class="fa fa-square text-warning"></span>
                                        @elseif ($home_card->color == "gelb-rot")
                                            <span class="fa fa-square text-warning"></span> <span class="fa fa-fw fa-square text-danger"></span>
                                        @elseif ($home_card->color == "rot")
                                            <span class="fa fa-square text-danger"></span>
                                        @endif
                                    </div>
                                    <small class="text-muted">
                                        @if ($home_card->ban_lifetime)
                                            <span class="text-danger">Sperre auf Lebenszeit</span>
                                        @elseif ($home_card->ban_season)
                                            <span class="text-danger">Saisonsperre</span>
                                        @else
                                            {{ $home_card->ban_matches }} Spiel{{ $home_card->ban_matches - $home_card->ban_reduced_by > 1 ? "e" : null }} Sperre
                                            <br>
                                            {{ $home_card->ban_reduced_by ? "(um ".$home_card->ban_reduced_by." reduziert)" : null }}
                                        @endif
                                    </small>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                {{-- away cards --}}
                @php
                    $away_cards = $cards->where('player.club.id', $fixture->clubAway->id);
                @endphp
                <div class="col-6">
                    @if (!$away_cards->isEmpty())
                        <ul class="list-unstyled text-left">
                            @foreach ($away_cards as $away_card)
                                <li>
                                    <div class="">
                                        @if ($away_card->color == "gelb")
                                            <span class="fa fa-square text-warning"></span>
                                        @elseif ($away_card->color == "gelb-rot")
                                            <span class="fa fa-square text-warning"></span> <span class="fa fa-fw fa-square text-danger"></span>
                                        @elseif ($away_card->color == "rot")
                                            <span class="fa fa-square text-danger"></span>
                                        @endif
                                        {{ $away_card->player->person->full_name_shortened }}
                                    </div>
                                    <small class="text-muted">
                                        @if ($away_card->ban_lifetime)
                                            <span class="text-danger">Sperre auf Lebenszeit</span>
                                        @elseif ($away_card->ban_season)
                                            <span class="text-danger">Saisonsperre</span>
                                        @else
                                            {{ $away_card->ban_matches }} Spiel{{ $away_card->ban_matches - $away_card->ban_reduced_by > 1 ? "e" : null }} Sperre
                                            <br>
                                            {{ $away_card->ban_reduced_by ? "(um ".$away_card->ban_reduced_by." reduziert)" : null }}
                                        @endif
                                    </small>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endif
        <hr>
        {{-- TODO: stats
        <div class="row mt-2">
            <div class="col-12 text-center">
                <h2 class="font-weight-bold font-italic">Stats</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-4">6</div>
                            <div class="col-4">Siege</div>
                            <div class="col-4">34</div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-4">Unentschieden</div>
                            <div class="col-4"></div>
                        </div>
                    </li><li class="list-group-item">
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-4">Niederlagen</div>
                            <div class="col-4"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>--}}
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