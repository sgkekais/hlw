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
            <div class="table-responsive">
                <table class="table table-sm table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">SW</th>
                            <th class="d-none d-sm-table-cell"></th>
                            <th class="align-middle text-left"><span class="fa fa-calendar" title="Datum"></span></th>
                            <th colspan="3" class="align-middle text-center"><span class="fa fa-handshake-o" title="Paarung"></span></th>
                            <th class="d-none d-md-table-cell">@svg('arena', ['class' => 'align-middle pr-1', 'style' => 'fill: #343a40', 'width' => '30', 'height' => '30'])</th>
                            <th class="align-middle text-right"><span class="fa fa-fw fa-search-plus" title="Spieldetails"></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fixtures as $fixture)
                            <tr class="{{ $fixture->rescheduledTo || $fixture->isCancelled() ? "text-muted" : null }}">
                                <td class="align-middle text-center">
                                    {{ $fixture->matchweek->number_consecutive }}
                                </td>
                                {{-- win, loss, remis --}}
                                <td class="d-none d-sm-table-cell align-middle text-center">
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
                                        <span class="d-none d-md-inline-block text-uppercase" style="width: 24px">{{ $fixture->datetime->formatLocalized('%a') }}</span>
                                        {{-- date --}}
                                        <span class="d-inline d-md-none pr-1">{{ $fixture->datetime->format('d.m.') }}</span>
                                        <span class="d-none d-md-inline px-1">{{ $fixture->datetime->format('d.m.y') }}</span>
                                        <span class="">{{ $fixture->datetime->format('H:i') != "00:00" ? $fixture->datetime->format('H:i') : "--:--" }}</span>
                                    </td>
                                @else
                                    <td class="align-middle text-left text-muted">
                                        o.D.
                                    </td>
                                @endif
                                {{-- club home --}}
                                <td class="align-middle text-right">
                                    @if ($fixture->clubHome)
                                        {{-- visible only on xs --}}
                                        <span class="d-inline d-sm-none pr-1 align-middle">{{ $fixture->clubHome->name_code }}</span>
                                        {{-- visible only on sm and md --}}
                                        <span class="d-none d-sm-inline d-lg-none pr-1 align-middle">{{ $fixture->clubHome->name_short }}</span>
                                        {{-- hidden on xs, sm, md --}}
                                        <span class="d-none d-lg-inline pr-1 align-middle">{{ $fixture->clubHome->name }}</span>
                                        @if ($fixture->clubHome->logo_url)
                                            <img src="{{ asset('storage/'.$fixture->clubHome->logo_url) }}" class="d-none d-md-inline" height="25">
                                        @endif
                                    @endif
                                </td>
                                {{-- result --}}
                                <td class="align-middle text-center">
                                    <div class="rounded {{ $fixture->rescheduledTo || $fixture->isCancelled() ? "bg-light text-muted" : "bg-dark text-white" }} d-inline-block p-1" style="word-break: keep-all; width: 60px">
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
                                {{-- club away --}}
                                <td class="align-middle text-left">
                                    @if ($fixture->clubAway)
                                        @if ($fixture->clubAway->logo_url)
                                            <img src="{{ asset('storage/'.$fixture->clubAway->logo_url) }}" class="d-none d-md-inline" height="25">
                                        @endif
                                        {{-- visible only on xs --}}
                                        <span class="d-inline d-sm-none pl-1 align-middle">{{ $fixture->clubAway->name_code }}</span>
                                        {{-- visible only on sm and md --}}
                                        <span class="d-none d-sm-inline d-lg-none pl-1 align-middle">{{ $fixture->clubAway->name_short }}</span>
                                        {{-- hidden on xs, sm, md --}}
                                        <span class="d-none d-lg-inline pl-1 align-middle">{{ $fixture->clubAway->name }}</span>
                                    @endif
                                </td>
                                <td class="d-none d-md-table-cell align-middle text-left">
                                    @if ($fixture->stadium)
                                        @if (!$club->regularStadium->isEmpty())
                                            @if ($fixture->club_id_home == $club->id && ($club->regularStadium()->first()->id != $fixture->stadium->id))
                                                <span class="text-warning"><abbr title="abweichender Spielort">{{ $fixture->stadium->name_short}}</abbr></span>
                                            @else
                                                {{ $fixture->stadium->name_short }}
                                            @endif
                                        @endif
                                    @else
                                        &nbsp;{{ $fixture->stadium_id }}
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex flex-row flex-sm-column flex-md-row justify-content-end align-items-center">
                                        <a href="{{ route('frontend.fixtures.show', $fixture) }}" class="order-1 pl-1 pl-sm-0 pl-md-1" title="Spieldetails">
                                            <span class="fa fa-fw fa-arrow-right"></span>
                                        </a>
                                        @if (!$fixture->goals->isEmpty())
                                            <span class="fa fa-fw fa-soccer-ball-o text-secondary" style="font-size: .8rem" data-toggle="tooltip" title="Torschützen vorhanden"></span>
                                        @endif
                                        @if (!$fixture->cards->isEmpty())
                                            <span class="fa fa-fw fa-clone pl-1 pt-0 pl-sm-0 pt-sm-1 pl-md-1 pt-md-0 text-secondary" style="font-size: .8rem" data-toggle="tooltip" title="Karten vorhanden"></span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="mt-4 alert alert-warning" role="alert">
        Es wurden keine Resultate gefunden. Mehr als die oben angegebenen Daten sind entweder nicht vorhanden oder wurden noch nicht gepflegt.
    </div>
@endif

