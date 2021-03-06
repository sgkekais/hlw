@extends('admin.adminlayout')

@section('sidebar')
    <a href="{{ Route('seasons.matchweeks.show', [$matchweek->season, $matchweek]) }}">Spielwoche</a>
@endsection

@section('content')

    <!-- match report upload form -->
    <div class="modal" tabindex="-1" role="dialog" id="uploadMatchReport">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Spielbericht hochladen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm" class="" method="POST" action="{{ route('fixtures.matchreport.store', $fixture) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="match_report">Datei auswählen:</label>
                            <input type="file" class="form-control-file" id="match_report" name="match_report">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-fw fa-ban"></span> Abbrechen</button>
                    <button type="button" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('uploadForm').submit();"><span class="fa fa-fw fa-upload"></span> Speichern</button>
                </div>
            </div>
        </div>
    </div>

    <h1 class="">Details zu Paarung</h1>
    <div class="row mt-4 mb-4">
        <div class="col-md-12">
            <p class="h3">
               @if($fixture->clubHome)
                    @can('read club')
                        <a href="{{ route('clubs.show', $fixture->clubHome) }}" title="Mannschaft anzeigen">{{ $fixture->clubHome->name }}</a>
                    @else
                        {{ $fixture->clubHome->name }}
                    @endcan
                @endif
                <span class="text-muted">vs.</span>
                @if($fixture->clubAway)
                    @can('read club')
                        <a href="{{ route('clubs.show', $fixture->clubAway) }}" title="Mannschaft anzeigen">{{ $fixture->clubAway->name }}</a>
                    @else
                       {{ $fixture->clubAway->name }}
                    @endcan
                @endif
            </p>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4">
            <span class="fa fa-calendar fa-fw"></span>
            @if($fixture->datetime)
                {{ $fixture->datetime->format('d.m.Y H:i:s') }}
            @else
                <i>Kein Termin angegeben.</i>
            @endif
            <br>
            <span class="fa fa-map-marker fa-fw"></span>
            @if($fixture->stadium)
                @if($fixture->stadium->gmaps)
                    <a href="{{ $fixture->stadium->gmaps }}" target="_blank">
                @endif
                    {{ $fixture->stadium->name }}
                @if($fixture->stadium->gmaps)
                    </a>
                @endif
            @else
                <i>Kein Spielort angegeben.</i>
            @endif
            <br>
            @can('update fixture')
                <a class="btn btn-primary mt-4" href="{{ route('matchweeks.fixtures.edit', [$matchweek, $fixture]) }}" title="Paarung bearbeiten">
                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span> Paarung bearbeiten
                </a>
            @endcan
            <br>
            <!-- reschedule, only once -->
            @if(!$fixture->rescheduledTo)
                @can('reschedule fixture')
                    <a class="btn btn-warning mt-2" href="{{ route('reschedule.create', [$matchweek, $fixture]) }}" title="Paarung verlegen">
                        <span class="fa fa-calendar-plus-o" aria-hidden="true"></span> Paarung verlegen
                    </a>
                @endcan
            @else
                <button class="btn btn-outline-danger mt-2" type="button" title="Paarung wurde schon einmal verlegt." aria-disabled="true" disabled><span class="fa fa-calendar-times-o"></span> Paarung wurde schon verlegt.</button>
            @endif
        </div>
        <div class="col-md-4">
            <span class="display-4">{{ $fixture->goals_home ?? "-" }} : {{ $fixture->goals_away ?? "-" }}</span>
        </div>
        <div class="col-md-4">
            <span class="text-muted display-4">{{ $fixture->goals->count() }}</span><span class="h4"> Torschütze(n)</span>
            <br>
            <span class="text-muted display-4">{{ $fixture->cards->count() }}</span><span class="h4"> Karte(n)</span>
            <br>
            <span class="text-muted display-4">{{ $fixture->referees->count() }}</span><span class="h4"> Schiedsrichter</span>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-6">
            @if ($fixture->note)
                <h3>Notiz</h3>
                <div class="alert alert-secondary">
                    {{ $fixture->note }}
                </div>
            @endif
        </div>
        <div class="col-sm-6">
            <h3>Spielbericht</h3>
            <div class="row">
                @if ($fixture->match_report_url)
                    <div class="col-6">
                        <img src="{{ asset('storage/'.$fixture->match_report_url) }}" class="img-fluid " title="Spielbericht" alt="Spielbericht">
                    </div>
                    <div class="col-6">
                        @can('delete matchreport')
                            <button type="button" class="btn btn-outline-danger" onclick="event.preventDefault(); document.getElementById('deleteMatchReport').submit();"><span class="fa fa-fw fa-upload"></span> Löschen</button>
                            <form id="deleteMatchReport" class="d-none" method="POST" action="{{ route('fixtures.matchreport.delete', $fixture) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                        @endcan
                    </div>
                @else
                    <div class="col-6">
                        Kein Spielbericht vorhanden.
                    </div>
                    <div class="col-6">
                        @can('create matchreport')
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#uploadMatchReport" ><span class="fa fa-fw fa-upload"></span> Hochladen</button>
                        @endcan
                    </div>
                @endif
            </div>
        </div>
    </div>
    <hr>

    @if($fixture->rescheduledFrom)
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <span class="fa fa-warning"></span> Paarung ist eine verlegte Paarung!
                </div>
                <h3>Verlegt von:</h3>
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
                    @if($oldfixture = $fixture->rescheduledFrom)
                        <tr>
                            <td>
                                @if($oldfixture->rescheduled_from_fixture_id)
                                    <b>{{ $oldfixture->rescheduledFrom->id }}</b>
                                    <br>
                                    <span class="fa fa-level-up fa-rotate-90"></span>
                                @endif
                                <b>{{ $oldfixture->id }}</b></td>
                            <td class="align-middle">
                                @if($oldfixture->published)
                                    <span class="fa fa-eye" title="Öffentlich"></span>
                                @else
                                    <span class="fa fa-eye-slash" title="Nicht öffentlich"></span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($oldfixture->datetime)
                                    {{ $oldfixture->datetime->format('d.m.Y H:i') }}
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($oldfixture->clubHome)
                                    @can('read club')
                                        <a href="{{ route('clubs.show', $oldfixture->clubHome) }}" title="Mannschaft anzeigen">
                                            {{ $oldfixture->clubHome->name_short }}
                                        </a>
                                    @else
                                        {{ $oldfixture->clubHome->name_short }}
                                    @endcan
                                @else
                                    -
                                @endif
                                vs.
                                @if($oldfixture->clubAway)
                                    @can('read club')
                                        <a href="{{ route('clubs.show', $oldfixture->clubAway) }}" title="Mannschaft anzeigen">
                                            {{ $oldfixture->clubAway->name_short }}
                                        </a>
                                    @else
                                        {{ $oldfixture->clubAway->name_short }}
                                    @endcan
                                @else
                                    -
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($oldfixture->stadium)
                                    @can('read stadium')
                                        <a href="{{ route('stadiums.show', $oldfixture->stadium) }}">
                                            {{ $oldfixture->stadium->name_short }}
                                        </a>
                                    @else
                                        {{ $oldfixture->stadium->name_short }}
                                    @endcan
                                @endif
                            </td>
                            <td class="align-middle">
                                {{ $oldfixture->goals_home }}:{{ $oldfixture->goals_away }}
                                ({{ $oldfixture->goals_home_11m }} : {{ $oldfixture->goals_away_11m }})
                                - {{ $oldfixture->goals_home_rated }}:{{ $oldfixture->goals_away_rated }}
                            </td>
                            <td class="align-middle">{{ $oldfixture->cancelled ? "Ann." : null }}</td>
                            <td class="align-middle">
                                <!-- show -->
                                @can('read fixture')
                                    <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.show', [$oldfixture->matchweek, $oldfixture]) }}" title="Paarung anzeigen">
                                        <span class="fa fa-search-plus" aria-hidden="true"></span>
                                    </a>
                                @endcan
                                <!-- edit -->
                                @can('update fixture')
                                    <a class="btn btn-primary" href="{{ route('matchweeks.fixtures.edit', [$oldfixture->matchweek, $oldfixture]) }}" title="Paarung bearbeiten">
                                        <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                    </a>
                                @endcan
                                <!-- reschedule, only once -->
                                @if(!$oldfixture->rescheduledTo)
                                    @can('reschedule fixture')
                                        <a class="btn btn-warning" href="{{ route('reschedule.create', [$oldfixture->matchweek, $oldfixture]) }}" title="Paarung verlegen">
                                            <span class="fa fa-calendar-plus-o" aria-hidden="true"></span>
                                        </a>
                                    @endcan
                                @else
                                    <button class="btn btn-outline-danger" type="button" title="Paarung wurde schon einmal verlegt." aria-disabled="true" disabled><span class="fa fa-calendar-times-o"></span> </button>
                                @endif
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    @if(!$fixture->rescheduledTo)
        <!-- show fixture details -->
        <div class="row">
            <div class="col-md-12">
                <h3 class="">Tore</h3>
                <!-- add goals, if goals_home or goals_away not null -->
                @if($fixture->goals_home || $fixture->goals_away )
                    @if($fixture->goals->count() < $fixture->goals_home + $fixture->goals_away)
                        @can('create goal')
                            <a class="btn btn-success mb-4" href="{{ route('fixtures.goals.create', $fixture) }}" title="Tore pflegen">
                                <span class="fa fa-soccer-ball-o" aria-hidden="true"></span> Torschützen eintragen
                            </a>
                        @endcan
                    @elseif($fixture->goals->count() === $fixture->goals_home + $fixture->goals_away)
                        <div class="alert alert-success" role="alert">
                            <span class="fa fa-check"></span> Alle Torschützen eingetragen.
                        </div>
                    @endif
                @else
                    <div class="alert alert-info" role="alert">
                        <span class="fa fa-info"></span> Kein Ergebnis eingetragen.
                    </div>
                @endif
                @if($fixture->goals->count() > 0)
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th class="">ID</th>
                            <th class="">Spieler</th>
                            <th class="">Mannschaft</th>
                            <th class="">Stand</th>
                            <th class="">Aktionen</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($fixture->goals as $goal)
                            <tr>
                                <td>{{ $goal->id }}</td>
                                <td>{{ $goal->player->person->last_name }}, {{ $goal->player->person->first_name }}</td>
                                <td>{{ $goal->player->club->name_short }}</td>
                                <td>{{ $goal->score }}</td>
                                <td>
                                <!-- edit -->
                                @can('update goal')
                                    <a class="btn btn-primary" href="{{ route('fixtures.goals.edit', [$fixture, $goal]) }}" title="Torschützen bearbeiten">
                                        <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                    </a>
                                @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info" role="alert">
                        <span class="fa fa-info"></span> Keine Torschützen gepflegt.
                    </div>
                @endif

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="mt-4">Karten</h3>
                @can('create card')
                    <!-- add cards -->
                    <a class="btn btn-success mb-4" href="{{ route('fixtures.cards.create', $fixture ) }}" title="Karte eintragen">
                        <span class="fa fa-clone" aria-hidden="true"></span> Karte eintragen
                    </a>
                @endcan
                <!-- list cards -->
                @if($fixture->cards->count() > 0)
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th class="">ID</th>
                            <th class="">Spieler</th>
                            <th class="">Mannschaft</th>
                            <th class="">Karte</th>
                            <th class="">Sperre</th>
                            <th class="">Grund</th>
                            <th class="">Gilt für</th>
                            <th class="">Aktionen</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($fixture->cards as $card)
                            <tr>
                                <td>{{ $card->id }}</td>
                                <td>{{ $card->player->person->last_name }}, {{ $card->player->person->first_name }}</td>
                                <td>{{ $card->player->club->name_short }}</td>
                                <td>{{ $card->color }}</td>
                                <td>{{ $card->ban_matches }}</td>
                                <td>{{ $card->ban_reason }}</td>
                                <td>
                                    @foreach ($card->divisions as $division)
                                        {{ $division->name }}
                                        @unless ($loop->last)
                                            <br>
                                        @endunless
                                    @endforeach
                                </td>
                                <td>
                                    <!-- edit -->
                                    @can('update card')
                                        <a class="btn btn-primary" href="{{ route('fixtures.cards.edit', [ $fixture, $card ]) }}" title="Karte bearbeiten">
                                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info" role="alert">
                        <span class="fa fa-info"></span> Keine Karten gepflegt.
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="mt-4">Schiedsrichter</h3>
                @can('create referee_assignment')
                    <!-- add referee -->
                    <a class="btn btn-success mb-4" href="{{ route('createRefereeAssignment', $fixture ) }}" title="Schiedsrichter zuordnen">
                        <span class="fa fa-clone" aria-hidden="true"></span> Schiedsrichter zuordnen
                    </a>
                @endcan
                @if($fixture->referees->count() > 0)
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th class="">ID</th>
                            <th class="">Schiedsrichter</th>
                            <th></th>
                            <th class="text-center">Bestätigt</th>
                            <th class="">Notiz</th>
                            <th class="">Aktionen</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($fixture->referees as $referee)
                            <tr>
                                <td class="align-middle">{{ $referee->id }}</td>
                                <td class="align-middle">
                                    @can('read referee')
                                        <a href="{{ route('referees.show', $referee) }}" title="Schiedsricher anzeigen">
                                            {{ $referee->person->full_name }}
                                        </a>
                                    @else
                                        {{ $referee->person->full_name }}
                                    @endcan
                                </td>
                                <td class="align-middle">
                                    Angelegt: {{ $referee->pivot->created_at->format('d.m.y h:i') }} <br>
                                    Geändert: {{ $referee->pivot->updated_at->format('d.m.y h:i') }} <br>
                                </td>
                                <td class="align-middle text-center">
                                    @if ($referee->pivot->confirmed)
                                        <span class="fa fa-check-circle text-success" title="Bestätigt"></span>
                                    @else
                                        <span class="fa fa-times-circle text-danger" title="Bestätigt"></span>
                                    @endif
                                </td>
                                <td class="align-middle"><i>{{ $referee->pivot->note }}</i></td>
                                <td class="align-middle">
                                    <!-- edit -->
                                    @can('update referee_assignment')
                                        <a class="btn btn-primary" href="{{ route('editRefereeAssignment', [ $fixture, $referee ]) }}" title="Schiedsrichterzuordnung bearbeiten">
                                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info" role="alert">
                        <span class="fa fa-info"></span> Keine Schiedsrichter zugeordnet.
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <span class="fa fa-warning"></span> Paarung wurde verlegt! Keine Eintragungen mehr möglich.
                </div>
                <h3>Verlegt nach:</h3>
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
                    @if($newfixture = $fixture->rescheduledTo)
                        <tr>
                            <td>
                                @if($newfixture->rescheduled_from_fixture_id)
                                    <b>{{ $newfixture->rescheduledFrom->id }}</b>
                                    <br>
                                    <span class="fa fa-level-up fa-rotate-90"></span>
                                @endif
                                <b>{{ $newfixture->id }}</b></td>
                            <td class="align-middle">
                                @if($newfixture->published)
                                    <span class="fa fa-eye" title="Öffentlich"></span>
                                @else
                                    <span class="fa fa-eye-slash" title="Nicht öffentlich"></span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($newfixture->datetime)
                                    {{ $newfixture->datetime->format('d.m.Y H:i') }}
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($newfixture->clubHome)
                                    @can('read club')
                                        <a href="{{ route('clubs.show', $newfixture->clubHome) }}" title="Mannschaft anzeigen">
                                            {{ $newfixture->clubHome->name_short }}
                                        </a>
                                    @else
                                        {{ $newfixture->clubHome->name_short }}
                                    @endcan
                                @else
                                    -
                                @endif
                                vs.
                                @if($newfixture->clubAway)
                                    @can('read club')
                                        <a href="{{ route('clubs.show', $newfixture->clubAway) }}" title="Mannschaft anzeigen">
                                            {{ $newfixture->clubAway->name_short }}
                                        </a>
                                    @else
                                        {{ $newfixture->clubAway->name_short }}
                                    @endcan
                                @else
                                    -
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($newfixture->stadium)
                                    <a href="{{ route('stadiums.show', $newfixture->stadium) }}">
                                        {{ $newfixture->stadium->name_short }}
                                    </a>
                                @endif
                            </td>
                            <td class="align-middle">
                                {{ $newfixture->goals_home }}:{{ $newfixture->goals_away }}
                                ({{ $newfixture->goals_home_11m }} : {{ $newfixture->goals_away_11m }})
                                - {{ $newfixture->goals_home_rated }}:{{ $newfixture->goals_away_rated }}
                            </td>
                            <td class="align-middle">{{ $newfixture->cancelled ? "Ann." : null }}</td>
                            <td class="align-middle">
                                <!-- show -->
                                @can('read fixture')
                                    <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.show', [$newfixture->matchweek, $newfixture]) }}" title="Paarung anzeigen">
                                        <span class="fa fa-search-plus" aria-hidden="true"></span>
                                    </a>
                                @endcan
                                <!-- edit -->
                                @can('update fixture')
                                    <a class="btn btn-primary" href="{{ route('matchweeks.fixtures.edit', [$newfixture->matchweek, $newfixture]) }}" title="Paarung bearbeiten">
                                        <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                    </a>
                                @endcan
                                <!-- reschedule, only once -->
                                @if(!$newfixture->rescheduledTo)
                                    @can('reschedule fixture')
                                        <a class="btn btn-warning" href="{{ route('reschedule.create', [$newfixture->matchweek, $newfixture]) }}" title="Paarung verlegen">
                                            <span class="fa fa-calendar-plus-o" aria-hidden="true"></span>
                                        </a>
                                    @endcan
                                @else
                                    <button class="btn btn-outline-danger" type="button" title="Paarung wurde schon einmal verlegt." aria-disabled="true" disabled><span class="fa fa-calendar-times-o"></span> </button>
                                @endif
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif


@endsection