@extends('admin.adminlayout')

@section('content')

    <h1 class="">Details zu Spielwoche</h1>
    <h2 class="mt-4 text-primary">
        &mdash; {{ $matchweek->number_consecutive }} {{ $matchweek->name ? '- '.$matchweek->name : null }}
    </h2>
    <h3 class="mt-2 text-muted">
        {{ $matchweek->begin ? $matchweek->begin->format('d.m.Y') : null }}
        {{ $matchweek->end ? "- ".$matchweek->end->format('d.m.Y') : null }}
    </h3>
    <div class="row">
        <div class="col-md-6">
            <h3 class="mt-4">Aktionen</h3>
            @can('update matchweek')
                <a class="btn btn-primary mb-2" href="{{ route('seasons.matchweeks.edit', [$matchweek->season,$matchweek]) }}" title="Spielwoche bearbeiten">
                    <span class="fa fa-pencil"></span> Bearbeiten
                </a>
            <br>
            @endcan
            @can('create fixture')
                <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.create', $matchweek) }}" title="Paarung hinzufügen">
                    <span class="fa fa-plus-circle"></span> Paarung
                </a>
            @endcan
        </div>
        <!-- dates -->
        <div class="col-md-6">
            <h3 class="mt-4">Änderungen</h3>
            <!-- published -->
            @if($matchweek->published)
                <span class="fa fa-eye"></span> Öffentlich
            @else
                <span class="fa fa-eye-slash"></span> <b>Nicht</b> öffentlich
            @endif
            <br>
            <!-- created at -->
            Angelegt am: {{ $matchweek->created_at->format('d.m.Y H:i') }} Uhr
            @if($causer = ModelHelper::causerOfAction($matchweek,'created'))
                von {{ $causer->name }}
            @endif
            <br>
            <!-- updated at -->
            @if($matchweek->updated_at != $matchweek->created_at)
                Geändert am: {{ $matchweek->updated_at->format('d.m.Y H:i') }} Uhr
                @if($causer = ModelHelper::causerOfAction($matchweek,'updated'))
                    von {{ $causer->name }}
                @endif
            @endif
        </div>
    </div>
    <hr>
    <!-- show matchweek details -->
    <h3 class="mt-4">
        Zugeordnete Paarungen
        <span class="badge badge-secondary">{{ $matchweek->fixtures->count() }}</span>
    </h3>
    <div class="row">
        <div class="col-md-12">
            @if($matchweek->fixtures->count() == 0)
                <i>Keine Paarungen zugeordnet</i>
            @else
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th></th>
                        <th class="">Datum</th>
                        <th class="">Paarung</th>
                        <th class="">Spielort</th>
                        <th class="">Erg.</th>
                        <th class="">11m</th>
                        <th class="">Wert.</th>
                        <th class=""></th>
                        <th class=""></th>
                        <th></th>
                        <th>Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($matchweek->fixtures()->orderBy('datetime')->get() as $fixture)
                        <tr>
                            <td class="align-middle">
                                @if($fixture->rescheduled_from_fixture_id)
                                    {{ $fixture->rescheduledFrom->id }}
                                    <br>
                                    <span class="fa fa-level-up fa-rotate-90"></span>
                                @endif
                                <b>{{ $fixture->id }}</b></td>
                            <td class="align-middle">
                                @if($fixture->published)
                                    <span class="fa fa-eye" title="Öffentlich"></span>
                                @else
                                    <span class="fa fa-eye-slash" title="Nicht öffentlich"></span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($fixture->datetime)
                                    {{ $fixture->datetime->format('d.m.Y H:i') }}
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($fixture->clubHome)
                                    @can('read club')
                                        <a href="{{ route('clubs.show', $fixture->clubHome) }}" title="Mannschaft anzeigen">
                                            {{ $fixture->clubHome->name_short }}
                                        </a>
                                    @else
                                        {{ $fixture->clubHome->name_short }}
                                    @endcan
                                @else
                                    -
                                @endif
                                    vs.
                                @if($fixture->clubAway)
                                    @can('read club')
                                        <a href="{{ route('clubs.show', $fixture->clubAway) }}" title="Mannschaft anzeigen">
                                            {{ $fixture->clubAway->name_short }}
                                        </a>
                                    @else
                                        {{ $fixture->clubAway->name_short }}
                                    @endcan
                                @else
                                    -
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($fixture->stadium)
                                    @can('read stadium')
                                        <a href="{{ route('stadiums.show', $fixture->stadium) }}">
                                            {{ $fixture->stadium->name_short }}
                                        </a>
                                    @else
                                        {{ $fixture->stadium->name_short }}
                                    @endcan
                                @endif
                            </td>
                            <td class="align-middle">
                                <!-- TODO replace with proper methods to test fixture -->
                                {{ $fixture->goals_home ?? "-" }} : {{ $fixture->goals_away ?? "-" }}
                            </td>
                            <td class="align-middle">
                                @if(isset($fixture->goals_home_11m) && isset($fixture->goals_away_11m))
                                    ({{ $fixture->goals_home_11m }} : {{ $fixture->goals_away_11m }})
                                @endif
                            </td>
                            <td class="align-middle">
                                @if(isset($fixture->goals_home_rated) && isset($fixture->goals_away_rated))
                                    {{ $fixture->goals_home_rated }} : {{ $fixture->goals_away_rated }}
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($fixture->goals_home && $fixture->goals_away)
                                    @if($fixture->goals->count() === 0 && $fixture->goals_home + $fixture->goals_away > 0)
                                        <span class="fa fa-soccer-ball-o fa-fw text-danger" title="Torschützen noch nicht gepflegt"></span>
                                    @elseif($fixture->goals->count() < $fixture->goals_home + $fixture->goals_away)
                                        <span class="fa fa-soccer-ball-o fa-fw text-warning" title="Torschützen evtl. nicht vollständig gepflegt"></span>
                                    @elseif($fixture->goals->count() === $fixture->goals_home + $fixture->goals_away)
                                        <span class="fa fa-soccer-ball-o fa-fw text-success" title="Torschützen gepflegt"></span>
                                    @endif
                                @else
                                    <span class="fa fa-fw"></span>
                                @endif
                                @if($fixture->cards->count() > 0)
                                    <span class="fa fa-clone fa-fw" title="Karte(n) gepflegt"></span>
                                @else
                                    <span class="fa fa-fw"></span>
                                @endif
                                @if($fixture->referees->isEmpty())
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
                            <td class="align-middle">{{ $fixture->cancelled ? "Ann." : null }}</td>
                            <td class="align-middle">
                                @if($fixture->note)
                                    <span class="fa fa-file-text" title="Notiz vorhanden"></span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <!-- show -->
                                @can('read fixture')
                                    <a class="btn btn-secondary btn-sm" href="{{ route('matchweeks.fixtures.show', [$matchweek, $fixture]) }}" title="Paarung anzeigen">
                                        <span class="fa fa-search-plus" aria-hidden="true"></span>
                                    </a>
                                @endcan
                                <!-- edit -->
                                @can('update fixture')
                                    <a class="btn btn-primary btn-sm" href="{{ route('matchweeks.fixtures.edit', [$matchweek, $fixture]) }}" title="Paarung bearbeiten">
                                        <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                    </a>
                                @endcan
                                <!-- reschedule, only once -->
                                @can('reschedule fixture')
                                    @if(!$fixture->rescheduledTo)
                                        <a class="btn btn-warning btn-sm" href="{{ route('reschedule.create', [$matchweek, $fixture]) }}" title="Paarung verlegen">
                                            <span class="fa fa-calendar-plus-o" aria-hidden="true"></span>
                                        </a>
                                    @else
                                        <button class="btn btn-outline-danger" type="button" title="Paarung wurde schon einmal verlegt." aria-disabled="true" disabled><span class="fa fa-calendar-times-o"></span> </button>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div> <!-- ./assigned seasons -->

@endsection