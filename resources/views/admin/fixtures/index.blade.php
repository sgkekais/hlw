@extends('admin.adminlayout')

@section('content')

    <h1 class="">Paarungshistorie</h1>
    <p>
        Übersicht und Verwaltung aller Paarungen.
    </p>
    <hr>
    <div class="row">
        <div class="col">
            <!-- list all cards -->
            <h2 class="">Angelegte Paarungen <span class="badge badge-secondary">{{ $fixtures->count() }}</span></h2>
        </div>
    </div>
    <table class="table table-sm table-striped table-hover" id="fixtures">
        <thead class="thead-default">
        <tr>
            <th class="">ID</th>
            <th class="">Spielkl.</th>
            <th class="">Datum</th>
            <th class="">Paarung</th>
            <th class="">Erg.</th>
            <th></th>
            <th class="">Aktionen</th>
        </tr>
        </thead>
        <tbody>
        @foreach($fixtures as $fixture)
            <tr>
                <td class="align-middle">
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
                <td class="align-middle">{{ $fixture->matchweek->season->division->name }}</td>
                <td class="align-middle">
                    {{ $fixture->datetime ? $fixture->datetime->format('Y-m-d H:i') : $fixture->datetime }}
                </td>
                <td class="align-middle">
                    @if($fixture->clubHome)
                        @if($can_read_club)
                            <a href="{{ route('clubs.show', $fixture->clubHome) }}" title="Mannschaft anzeigen">
                                {{ $fixture->clubHome->name_short }}
                            </a>
                        @else
                            {{ $fixture->clubHome->name_short }}
                        @endif
                    @else
                        -
                    @endif
                    vs.
                    @if($fixture->clubAway)
                        @if($can_read_club)
                            <a href="{{ route('clubs.show', $fixture->clubAway) }}" title="Mannschaft anzeigen">
                                {{ $fixture->clubAway->name_short }}
                            </a>
                        @else
                            {{ $fixture->clubAway->name_short }}
                        @endif
                    @else
                        -
                    @endif
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
                    @if ($fixture->cards->count() > 0)
                        <span class="fa fa-clone fa-fw" title="Karte(n) gepflegt"></span>
                    @else
                        <span class="fa fa-fw"></span>
                    @endif
                    @if ($fixture->referees->isEmpty())
                        <span class="fa fa-hand-stop-o fa-fw text-danger" title="Kein Schiedsrichter"></span>
                    @else
                        <span class="fa fa-hand-stop-o fa-fw text-success" title="Schiedsrichter zugewiesen"></span>
                        @php
                            $confirmed = true;
                        @endphp
                        @foreach ($fixture->referees as $referee)
                            @php
                                if (!$referee->pivot->confirmed) {
                                    $confirmed = false;
                                }
                            @endphp
                        @endforeach
                        @if ($confirmed)
                            <span class="fa fa-check-circle text-success" title="Alle Schiedsrichter Bestätigt"></span>
                        @else
                            <span class="fa fa-question-circle text-danger" title="Nicht alle Schiedsrichter bestätigt"></span>
                        @endif
                    @endif
                </td>
                <td class="align-middle">
                    @if($can_read_fixture)
                        <!-- show -->
                        <a class="btn btn-secondary btn-sm" href="{{ route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]) }}" title="Paarung anzeigen">
                            <span class="fa fa-search-plus" aria-hidden="true"></span>
                        </a>
                    @endif
                    @if($can_update_fixture)
                        <!-- edit -->
                        <a class="btn btn-primary btn-sm" href="{{ route('matchweeks.fixtures.edit', [$fixture->matchweek, $fixture]) }}" title="Paarung bearbeiten">
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
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

@section('pagespecificscripts')
    <script type="text/javascript">
        $(document).ready( function () {

            $('#fixtures').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
                },
                "pageLength": 50,
                "order": [[ 2, "desc" ]]
            });

        });
    </script>
@endsection