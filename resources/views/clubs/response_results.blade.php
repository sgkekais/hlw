@if ($season->isFinished())
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success" role="alert">
                <span class="fa fa-check-circle-o" style="color: darkgreen"></span> Saison ist abgeschlossen.
            </div>
        </div>
    </div>
    <div class="row bg-secondary text-white m-0">
        <div class="col-2 text-center">
            <span class="display-4 font-italic">
                {{ $season->clubs->find($club->id)->pivot->rank }}.
            </span>
            <span class="font-weight-light font-italic">Platz</span>
        </div>
        <div class="col-2 text-center">
            <span class="display-4 font-italic">
                {{ $club->getGamesPlayedWon($season)->count() + $club->getGamesRatedWon($season)->count() }}
            </span>
            <span class="font-weight-light font-italic">Siege</span>
        </div>
        <div class="col-2 text-center">
            <span class="display-4 font-italic">
                {{ $club->getGamesPlayedDrawn($season)->count() + $club->getGamesRatedDrawn($season)->count() }}
            </span>
            <span class="font-weight-light font-italic">Unentschieden</span>
        </div>
        <div class="col-2 text-center">
            <span class="display-4 font-italic">
                {{ $club->getGamesPlayedLost($season)->count() + $club->getGamesRatedLost($season)->count() }}
            </span>
            <span class="font-weight-light font-italic">Niederlagen</span>
        </div>
        <div class="col-2 text-center">
            Tore
        </div>
        <div class="col-2 text-center">
            Karten
        </div>
    </div>
@endif
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
                        @else
                            - : -
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
