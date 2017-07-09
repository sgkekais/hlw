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
            <a class="btn btn-primary mb-2" href="{{ route('seasons.matchweeks.edit', [$matchweek->season,$matchweek]) }}" title="Spielwoche bearbeiten">
                <span class="fa fa-pencil"></span> Bearbeiten
            </a>
            <br>
            <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.create', $matchweek) }}" title="Paarung hinzufügen">
                <span class="fa fa-plus-circle"></span> Paarung
            </a>
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
        <span class="badge badge-default">{{ $matchweek->fixtures->count() }}</span>
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
                        <th>Spielort</th>
                        <th class="">Ergebnis</th>
                        <th class=""></th>
                        <th>Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($matchweek->fixtures as $fixture)
                        <tr>
                            <td><b>{{ $fixture->id }}</b></td>
                            <td>
                                @if($fixture->published)
                                    <span class="fa fa-eye" title="Öffentlich"></span>
                                @else
                                    <span class="fa fa-eye-slash" title="Nicht öffentlich"></span>
                                @endif
                            </td>
                            <td>
                                @if($fixture->date)
                                    {{ $fixture->date->format('d.m.Y') }}
                                @endif
                                @if($fixture->time)
                                    - {{ $fixture->time }}
                                @endif
                            </td>
                            <td>
                                @if($fixture->club_home)
                                    <a href="{{ route('clubs.show', $fixture->club_home) }}" title="Mannschaft anzeigen">
                                        {{ $fixture->club_home->name_short }}
                                    </a>
                                @else
                                    -
                                @endif
                                    :
                                @if($fixture->club_away)
                                    <a href="{{ route('clubs.show', $fixture->club_home) }}" title="Mannschaft anzeigen">
                                        {{ $fixture->club_away->name_short }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($fixture->stadium)
                                    <a href="{{ route('stadiums.show', $fixture->stadium) }}">
                                        {{ $fixture->stadium->name_short }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $fixture->goals_home }}:{{ $fixture->goals_away }}
                                ({{ $fixture->goals_home_11m }}:{{ $fixture->goals_away_11m }})
                                - {{ $fixture->goals_home_rated }}:{{ $fixture->goals_away_rated }}
                            </td>
                            <td>{{ $fixture->cancelled ? "Ann." : null }}</td>
                            <td>
                                <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('matchweeks.fixtures.edit', [$matchweek, $fixture]) }}" title="Paarung bearbeiten">
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                                <!-- reschedule, only once -->
                                @unless($fixture->rescheduled_to)
                                    <a class="btn btn-warning" href="{{ route('reschedule.create', [$matchweek, $fixture]) }}" title="Paarung verlegen">
                                        <span class="fa fa-calendar-plus-o" aria-hidden="true"></span>
                                    </a>
                                @endunless
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div> <!-- ./assigned seasons -->

@endsection