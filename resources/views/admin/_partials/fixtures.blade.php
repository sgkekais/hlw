<table class="table table-sm table-striped table-hover" id="{{ $id }}">
    <thead class="thead-default">
    <tr>
        <th class="">ID</th>
        <th class=""><span class="fa fa-fw fa-calendar" title="Datum"></span></th>
        <th class=""><span class="fa fa-fw fa-handshake-o" title="Paarung"></span></th>
        <th class=""><span class="fa fa-fw fa-map-marker"></span></th>
        <th class="">Erg.</th>
        <th class="">T</th>
        <th class="">K</th>
        <th class="">S</th>
        <th class=""></th>
        <th class=""></th>
        <th>Aktionen</th>
    </tr>
    </thead>
    <tbody>
    @foreach($fixtures as $fixture)
        <tr>
            <td class="align-middle">
                <small>
                    @switch ($fixture->matchweek->season->division->competition->id)
                        @case (1)
                            <span class="badge badge-success">HLW</span>
                            @break
                        @case (2)
                            <span class="badge badge-warning">Pok</span>
                            @break
                        @case (3)
                            <span class="badge badge-secondary">AH</span>
                            @break
                        @case (4)
                            <span class="badge badge-success">PlOff</span>
                    @endswitch
                </small>
                @if ($fixture->rescheduled_from_fixture_id)
                    (von: {{ $fixture->rescheduled_from_fixture_id }})
                    <br>
                    <span class="fa fa-level-up fa-rotate-90"></span>
                @endif
                <b>{{ $fixture->id }}</b>
                @if ($fixture->rescheduledTo)
                    <br>
                    (nach: {{ $fixture->rescheduledTo->id }})
                @endif
            </td>
            <td class="align-middle">
                @if($fixture->datetime)
                    <div class="{{ $today->format('d.m.') == $fixture->datetime->format('d.m.') ? "font-weight-bold" : null }} ">
                        {{ $fixture->datetime->format('d.m.y H:i') }}
                    </div>
                @endif
            </td>
            <td class="align-middle">
                @if($fixture->clubHome)
                    @if($can_read_club)
                        <a href="{{ route('clubs.show', $fixture->clubHome) }}" title="Mannschaft anzeigen">
                    @endif
                        <span class="d-inline d-lg-none">{{ $fixture->clubHome->name_code }}</span>
                        <span class="d-none d-lg-inline">{{ $fixture->clubHome->name_short }}</span>
                    @if($can_read_club)
                    @endif
                @else
                    -
                @endif
                :
                @if($fixture->clubAway)
                    @if($can_read_club)
                        <a href="{{ route('clubs.show', $fixture->clubAway) }}" title="Mannschaft anzeigen">
                    @endif
                        <span class="d-inline d-lg-none">{{ $fixture->clubAway->name_code }}</span>
                        <span class="d-none d-lg-inline">{{ $fixture->clubAway->name_short }}</span>
                    @if($can_read_club)
                        </a>
                    @endif
                @else
                    -
                @endif
            </td>
            <td class="align-middle">
                {{ $fixture->stadium ? $fixture->stadium->name_short : null }}
            </td>
            <td class="align-middle">
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
            </td>
            <td class="align-middle">
                @if ($fixture->goals_home && $fixture->goals_away)
                    @if ($fixture->goals->count() === 0 && $fixture->goals_home + $fixture->goals_away > 0)
                        <span class="fa fa-soccer-ball-o fa-fw text-danger" title="Torschützen noch nicht gepflegt"></span>
                    @elseif ($fixture->goals->count() < $fixture->goals_home + $fixture->goals_away)
                        <span class="fa fa-soccer-ball-o fa-fw text-warning" title="Torschützen evtl. nicht vollständig gepflegt"></span>
                    @elseif ($fixture->goals->count() === $fixture->goals_home + $fixture->goals_away)
                        <span class="fa fa-soccer-ball-o fa-fw text-success" title="Torschützen gepflegt"></span>
                    @endif
                @else
                    <span class="fa fa-fw"></span>
                @endif
            </td>
            <td class="align-middle">
                @if ($fixture->cards->count() > 0)
                    <span class="fa fa-clone fa-fw" title="Karte(n) gepflegt"></span>
                @else
                    <span class="fa fa-fw"></span>
                @endif
            </td>
            <td class="align-middle">
                @if ($fixture->referees->isEmpty())
                    <span class="fa fa-hand-stop-o fa-fw text-danger" title="Kein Schiedsrichter"></span>
                @else
                    @foreach ($fixture->referees as $referee)
                        <small>
                            @if ($referee->pivot->confirmed)
                                <span class="fa fa-check-circle text-success" title="Alle Schiedsrichter Bestätigt"></span>
                            @else
                                <span class="fa fa-question-circle text-danger" title="Nicht alle Schiedsrichter bestätigt"></span>
                            @endif
                            {{ substr($referee->person->first_name, 0, 1)."., ".$referee->person->last_name }}
                        </small>
                            @unless( $loop->last )
                                <br>
                            @endunless
                    @endforeach

                @endif
            </td>
            <td class="align-middle">{{ $fixture->cancelled ? "Ann." : null }}</td>
            <td class="align-middle">
                @if($fixture->note)
                    <span class="fa fa-file-text" title="Notiz vorhanden"></span>
                @endif
            </td>
            <td class="align-middle">
                <div class="d-flex flex-column flex-md-row justify-content-between justify-content-md-start">
                    <!-- show -->
                    @if($can_read_fixture)
                        <a class="btn btn-secondary btn-sm mb-2 mb-md-0 mr-md-2" href="{{ route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]) }}" title="Paarung anzeigen">
                            <span class="fa fa-search-plus" aria-hidden="true"></span>
                        </a>
                    @endif
                <!-- edit -->
                    @if($can_update_fixture)
                        <a class="btn btn-primary btn-sm mb-2 mb-md-0 mr-md-2" href="{{ route('matchweeks.fixtures.edit', [$fixture->matchweek, $fixture]) }}" title="Paarung bearbeiten">
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                    @endif
                <!-- reschedule -->
                    @if($can_reschedule_fixture)
                        @if(!$fixture->rescheduledTo)
                            <a class="btn btn-warning btn-sm" href="{{ route('reschedule.create', [$fixture->matchweek, $fixture]) }}" title="Paarung verlegen">
                                <span class="fa fa-calendar-plus-o" aria-hidden="true"></span>
                            </a>
                        @else
                            <button class="btn btn-outline-danger btn-sm" type="button" title="Paarung wurde schon einmal verlegt." aria-disabled="true" disabled><span class="fa fa-calendar-times-o"></span> </button>
                        @endif
                    @endif
                </div>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>