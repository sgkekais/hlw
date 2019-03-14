@extends('admin.adminlayout')

@section('content')

    <h1 class="">Details zu Schiedsrichter</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $referee->person->last_name }}, {{ $referee->person->first_name }}</h2>
    <div class="row">
        <div class="col-md-6">
            <h3 class="mt-4">Aktionen</h3>
            @can('update referee')
                <a class="btn btn-primary mb-4" href="{{ route('referees.edit', $referee ) }}" title="Schiedsrichter bearbeiten">
                    <span class="fa fa-pencil"></span> Bearbeiten
                </a>
            @endcan
        </div>
        <!-- dates -->
        <div class="col-md-6">
            <h3 class="mt-4">Änderungen</h3>
            <!-- created at -->
            Angelegt am: {{ $referee->created_at->format('d.m.Y H:i') }} Uhr
            @if($causer = ModelHelper::causerOfAction($referee,'created'))
                von {{ $causer->name }}
            @endif
            <br>
            <!-- updated at -->
            @if($referee->updated_at != $referee->created_at)
                Geändert am: {{ $referee->updated_at->format('d.m.Y H:i') }} Uhr
                @if($causer = ModelHelper::causerOfAction($referee,'updated'))
                    von {{ $causer->name }}
                @endif
            @endif
        </div>
    </div>
    <hr>
    <!-- show referee details -->
    <h3 class="mt-4">
        Zugeordnete Paarungen
        <span class="badge badge-secondary">{{ $referee->fixtures->count() }}</span>
    </h3>
    <div class="row">
        <div class="col-md-12">
            @if($referee->fixtures->count() == 0)
                <br>
                <i>Keine Paarungen zugeordnet</i>
            @else
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th></th>
                        <th class="">Datum</th>
                        <th class="">Paarung</th>
                        <th>Spielort</th>
                        <th class="">Ergebnis</th>
                        <th class=""></th>
                        <th class=""></th>
                        <th></th>
                        <th>Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($referee->fixtures()->orderBy('datetime','desc')->get() as $fixture)
                        <tr>
                            <td>
                                @if($fixture->rescheduled_from_fixture_id)
                                    <b>{{ $fixture->rescheduledFrom->id }}</b>
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
                                @if($fixture->goals_home && $fixture->goals_away)
                                    {{ $fixture->goals_home }}:{{ $fixture->goals_away }}
                                @else
                                    <i>-:-</i>
                                @endif
                                @if($fixture->goals_home_11m && $fixture->goals_away_11m)
                                    ({{ $fixture->goals_home_11m }} : {{ $fixture->goals_away_11m }})
                                @endif
                                @if($fixture->goals_home_rated && $fixture->goals_away_rated)
                                    {{ $fixture->goals_home_rated }}:{{ $fixture->goals_away_rated }}
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
                                @can('read fixture')
                                    <!-- show -->
                                    <a class="btn btn-secondary btn-sm" href="{{ route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]) }}" title="Paarung anzeigen">
                                        <span class="fa fa-search-plus" aria-hidden="true"></span>
                                    </a>
                                @endcan
                                @can('update referee_assignment')
                                    <!-- edit -->
                                    <a class="btn btn-primary btn-sm" href="{{ route('editRefereeAssignment', [ $fixture, $referee ]) }}" title="Schiedsrichterzuordnung bearbeiten">
                                        <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div> <!-- ./assigned fixtures -->

@endsection