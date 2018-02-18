@if ($season)
    @if ($season->type == "knockout" && $season->note)
        <div class="row">
            <div class="col">
                <div class="alert alert-secondary bg-light">
                    <span class="fa fa-fw fa-info-circle"></span> {{ $season->note }}
                </div>
            </div>
        </div>
    @endif
    @foreach ($season->matchweeks as $matchweek)
        <div class="row">
            <a name="matchweek{{ $matchweek->number_consecutive }}"></a>
            <div class="col-12">
                @if ($season->division->competition->isLeague())
                    <h3 class=""><span class="font-weight-bold font-italic text-uppercase">SPIELWOCHE {{ $matchweek->number_consecutive }}</span>
                        <small class="d-inline-block">
                            {{ $matchweek->name ? $matchweek->name." | " : null }}
                            {{ $matchweek->begin ? $matchweek->begin->format('d.m.Y') : null }}
                            {{ $matchweek->end ? " bis ".$matchweek->end->format('d.m.Y') : null }}
                        </small>
                    </h3>
                @elseif ($season->division->competition->isKnockout())
                    <h3>
                        <span class="font-weight-bold font-italic text-uppercase">{{ $matchweek->name }}</span>
                        <small class="d-inline-block">
                            {{ $matchweek->begin ? $matchweek->begin->format('d.m.Y') : null }}
                            {{ $matchweek->end ? " bis ".$matchweek->end->format('d.m.Y') : null }}
                        </small>
                    </h3>
                @endif
                <table class="table table-hover table-striped table-sm">
                    <thead>
                        <tr>
                            <th class="align-middle" style="width: 20%">
                                <span class="fa fa-calendar"></span>
                            </th>
                            <th class="align-middle text-center" style="width: 55%">
                                <span class="fa fa-fw fa-handshake-o"></span>
                            </th>
                            <th class="align-middle text-left">
                                @svg('arena', ['class' => 'align-middle pr-1', 'style' => 'fill: #343a40', 'width' => '30', 'height' => '30'])
                            </th>
                            <th class="align-middle text-right">
                                <span class="fa fa-fw fa-search-plus"></span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($matchweek->fixtures->where('published',1)->sortBy('datetime') as $fixture)
                        <tr class="{{ $fixture->rescheduledTo || $fixture->isCancelled() ? "text-muted" : null }}">
                            {{-- date - day of week, date, time --}}
                            <td class="align-middle">
                                @if ($fixture->datetime)
                                    <span class="d-none d-md-inline-block text-uppercase" style="width: 24px">{{ $fixture->datetime->formatLocalized('%a') }}</span>
                                    <span class="d-inline d-md-none pr-1">{{ $fixture->datetime->format('d.m.') }}</span>
                                    <span class="d-none d-md-inline px-1">{{ $fixture->datetime->format('d.m.y') }}</span>
                                    @if ($fixture->datetime->format('H:i') != "00:00")
                                        <span class="">{{ $fixture->datetime->format('H:i') }}</span>
                                    @else
                                        <span class="">--:--</span>
                                    @endif
                                @else
                                    <span class="text-muted">o.D.</span>
                                @endif
                            </td>
                            <td class="d-flex justify-content-center align-items-center">
                                {{-- home team --}}
                                <div class="d-flex-inline text-right" style="width: 40%">
                                    @if($fixture->clubHome)
                                        @if ($fixture->type == "knockout" && $fixture->clubHome->hasWon($fixture))
                                            <b>
                                        @endif
                                        {{-- visible only on xs --}}
                                        <span class="d-inline d-sm-none align-middle pr-1">{{ $fixture->clubHome->name_code }}</span>
                                        {{-- visible only on sm and md --}}
                                        <span class="d-none d-sm-inline d-lg-none align-middle pr-1">{{ $fixture->clubHome->name_short }}</span>
                                        {{-- hidden on xs, sm, md --}}
                                        <span class="d-none d-lg-inline align-middle pr-1">{{ $fixture->clubHome->name }}</span>
                                        @if ($fixture->type == "knockout" && $fixture->clubHome->hasWon($fixture))
                                            </b>
                                        @endif
                                        @if($fixture->clubHome->logo_url)
                                            <img src="{{ asset('storage/'.$fixture->clubHome->logo_url) }}" height="25" class="d-none d-md-inline align-middle">
                                        @else
                                            <span class="fa fa-ban text-muted d-none d-md-inline align-middle" title="Kein Vereinswappen vorhanden"></span>
                                        @endif
                                    @else
                                        <span class="align-middle pr-1">{{ $fixture->club_id_home ?? "-" }}</span>
                                    @endif
                                </div>
                                {{-- result --}}
                                <div class="d-flex-inline text-center text-white rounded bg-dark d-inline-block ml-2 mr-2 p-1" style="word-break: keep-all; width: 60px">
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
                                {{-- away team --}}
                                <div class="d-flex-inline text-left" style="width: 40%">
                                    @if($fixture->clubAway)
                                        @if($fixture->clubAway->logo_url)
                                            <img src="{{ asset('storage/'.$fixture->clubAway->logo_url) }}" height="25" class="d-none d-md-inline">
                                        @else
                                            <span class="fa fa-ban text-muted d-none d-md-inline" title="Kein Vereinswappen vorhanden"></span>
                                        @endif
                                        @if ($fixture->type == "knockout" && $fixture->clubAway->hasWon($fixture))
                                            <b>
                                        @endif
                                        {{-- visible only on xs --}}
                                        <span class="d-inline d-sm-none pl-1">{{ $fixture->clubAway->name_code }}</span>
                                        {{-- visible only on sm and md --}}
                                        <span class="d-none d-sm-inline d-lg-none pl-1">{{ $fixture->clubAway->name_short }}</span>
                                        {{-- hidden on xs, sm, md --}}
                                        <span class="d-none d-lg-inline pl-1">{{ $fixture->clubAway->name }}</span>
                                        @if ($fixture->type == "knockout" && $fixture->clubAway->hasWon($fixture))
                                            </b>
                                        @endif
                                    @else
                                        <span class="pl-1">{{ $fixture->club_id_away ?? "-" }}</span>
                                    @endif
                                </div>
                            </td>
                            {{-- stadium --}}
                            <td class="align-middle">
                                @if ($fixture->stadium)
                                    @if ($fixture->clubHome)
                                        @if (!$fixture->clubHome->regularStadium->isEmpty())
                                            @if ($fixture->clubHome->regularStadium->first()->id != $fixture->stadium->id)
                                                <span class="text-warning"><abbr title="abweichender Spielort">{{ $fixture->stadium->name_short }}</abbr></span>
                                            @else
                                                {{ $fixture->stadium->name_short }}
                                            @endif
                                        @else
                                            {{ $fixture->stadium->name_short }}
                                        @endif
                                    @else
                                        {{ $fixture->stadium->name_short }}
                                    @endif
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
                <span class="pull-right"><a href="#top"><span class="fa fa-arrow-up"></span> nach oben</a></span>
            </div>
        </div>
    @endforeach
@endif