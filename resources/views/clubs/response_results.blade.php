@if ($season->isFinished() && $season->type != "knockout")
    @if ($season->clubs->find($club->id)->pivot->withdrawal)
        <div class="row bg-danger text-white m-0 rounded">
            <div class="col p-2 text-center">
                {{ $season->clubs->find($club->id)->pivot->note }}
            </div>
        </div>
    @else
        <div class="row bg-secondary text-white m-0 rounded">
            <div class="col text-center">
                <span class="display-4 font-italic">
                    {{ $season->clubs->find($club->id)->pivot->rank ?? "-" }}.
                </span>
                <span class="font-weight-light font-italic">Platz</span>
            </div>
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
    @endif
@endif
@if (!$fixtures->isEmpty())
    <div class="row">
        <div class="col-12">
            <table class="table table-sm table-hover table-striped">
                <thead>
                <tr>
                    <th class="text-right">SW</th>
                    <th class=""></th>
                    <th class="align-middle text-left"><span class="fa fa-calendar" title="Datum"></span></th>
                    <th colspan="3" class="align-middle text-center"><span class="fa fa-handshake-o" title="Paarung"></span></th>
                    <th class="">@svg('arena', ['class' => 'align-middle pr-1', 'style' => 'fill: #343a40', 'width' => '30', 'height' => '30'])</th>
                    <th class="align-middle text-center"><span class="fa fa-search-plus" title="Spieldetails"></span></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($fixtures as $fixture)
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
                            <strong class="fa-stack-1x text-white" title="Gewertet">W</strong>
                        @endif
                    </span>
                        </td>
                        @if ($fixture->datetime)
                            <td class="align-middle text-left">
                                <span class="">{{ $fixture->datetime->formatLocalized('%a') }}</span>
                                <span class="px-1">{{ $fixture->datetime->format('d.m.y') }}</span>
                                <span class="">{{ $fixture->datetime->format('H:i') }}</span>
                            </td>
                        @else
                            <td class="align-middle text-left text-muted">
                                o.D.
                            </td>
                        @endif
                        <td class="align-middle text-right">
                            @if ($fixture->clubHome)
                                {{ $fixture->clubHome->name }}
                                @if ($fixture->clubHome->logo_url)
                                    <img src="{{ asset('storage/'.$fixture->clubHome->logo_url) }}" height="25">
                                @endif
                            @endif
                        </td>
                        <td class="align-middle text-center">
                            <div class="text-white rounded bg-dark d-inline-block p-1" style="word-break: keep-all">
                                {{-- cancelled? --}}
                                @if($fixture->isCancelled())
                                    <span class="text-danger">
                                        @if ($fixture->isPlayed() && !$fixture->isRated())
                                            {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
                                        @elseif ($fixture->isRated())
                                            {{ $fixture->goals_home_rated }} : {{ $fixture->goals_away_rated }}
                                        @else
                                            Ann.
                                        @endif
                                    </span>
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
                            @if ($fixture->clubAway)
                                @if ($fixture->clubAway->logo_url)
                                    <img src="{{ asset('storage/'.$fixture->clubAway->logo_url) }}" height="25">
                                @endif
                                {{ $fixture->clubAway->name }}
                            @endif
                        </td>
                        <td class="align-middle text-left">
                            @if($fixture->stadium)
                                {{ $fixture->stadium->name_short}}
                            @else                                        &nbsp;
                            @endif
                        </td>
                        <td class="align-middle text-center">
                            <a href="{{ route('frontend.fixtures.show', $fixture) }}" title="Match betrachten">
                                <span class="fa fa-fw fa-arrow-right"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="mt-4 alert alert-warning" role="alert">
        Es wurden keine Resultate gefunden. Mehr als die oben angegebenen Daten sind entweder nicht vorhanden oder wurden noch nicht gepflegt.
    </div>
@endif

