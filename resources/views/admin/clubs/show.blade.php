@extends('admin.adminlayout')

@section('content')

    <div class="row">
        <div class="col-2">
            @if($club->logo_url)
                <img src="{{ Storage::url($club->logo_url) }}" class="img-fluid " title="Vereinswappen" alt="Vereinswappen">
            @else
            @endif
        </div>
        <div class="col-10 justify-content-end">
            <h1 class="">Details zu Mannschaft</h1>
            <h2 class="mt-4 text-info">&mdash; {{ $club->name }}</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h3 class="mt-4">Aktionen</h3>
            <a class="btn btn-primary mb-2" href="{{ route('clubs.edit', $club ) }}" title="Wettbewerb bearbeiten">
                <span class="fa fa-pencil"></span> Bearbeiten
            </a>
            <br>
            <a class="btn btn-secondary" href="{{ route('clubs.players.create', $club ) }}" title="Spieler zuordnen">
                <span class="fa fa-plus-square"></span> Spieler
            </a>
            <a class="btn btn-secondary" href="{{ route('clubs.contacts.create', $club) }}" title="Ansprechpartner zuordnen">
                <span class="fa fa-plus-square"></span> Kontakt
            </a>
            <a class="btn btn-secondary" href="{{ route('createStadiumAssignment', $club) }}" title="Spielort zuordnen">
                <span class="fa fa-plus-square"></span> Spielort
            </a>
        </div>
        <!-- dates -->
        <div class="col-md-6">
            <h3 class="mt-4">Änderungen</h3>
            <!-- published -->
            @if($club->published)
                <span class="fa fa-eye"></span> Öffentlich
            @else
                <span class="fa fa-eye-slash"></span> <b>Nicht</b> öffentlich
            @endif
            <br>
            <!-- created at -->
            Angelegt am: {{ $club->created_at->format('d.m.Y H:i') }} Uhr
            @if($causer = ModelHelper::causerOfAction($club,'created'))
                von {{ $causer->name }}
            @endif
            <br>
            <!-- updated at -->
            @if($club->updated_at != $club->created_at)
                Geändert am: {{ $club->updated_at->format('d.m.Y H:i') }} Uhr
                @if($causer = ModelHelper::causerOfAction($club,'updated'))
                    von {{ $causer->name }}
                @endif
            @endif
        </div>
    </div>
    <hr>
    <h3 class="mt-4 mb-4">Zuordnungen</h3>
    <!-- show club tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#seasons" role="tab">
                Saisons
                <span class="badge badge-pill badge-secondary">
                    {{ $club->seasons->count() }}
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#fixtures" role="tab">
                Paarungen
                <span class="badge badge-pill badge-secondary">
                    {{ $club->fixtures()->count() }}
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#players" role="tab">
                Kader
                <span class="badge badge-pill badge-secondary">
                    {{ $club->players()->whereNull('sign_off')->get()->count() }}
                </span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#contacts" role="tab">
                Kontakte
                <span class="badge badge-pill badge-secondary">{{ $club->contacts->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#stadiums" role="tab">
                Spielort(e)
                <span class="badge badge-pill badge-secondary">{{ $club->stadiums->count() }}</span>
            </a>
        </li>
    </ul>
    <!-- show club details -->
    <div class="tab-content">
        <!-- seasons -->
        <div class="tab-pane active" id="seasons" role="tabpanel">
            <h4 class="mb-4 mt-4">Saisons</h4>
            @if($club->seasons->count() != 0)
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th class="">Jahr</th>
                        <th class="">Rang</th>
                        <th class="">Punktabzug</th>
                        <th class="">Torabzug</th>
                        <th class="">Ausgeschieden</th>
                        <th class="">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($club->seasons as $season)
                        <tr>
                            <td>{{ $season->id }}</td>
                            <td>
                                <a href="{{ route('seasons.show', $season) }}" title="Saison anzeigen">
                                    {{ $season->begin->format('d.m.Y') }} bis {{ $season->end->format('d.m.Y') }}
                                </a>
                                <br>
                                <span class="text-muted">({{ $season->division->name }})</span>
                            </td>
                            <td>{{ $season->pivot->rank }}</td>
                            <td>{{ $season->pivot->deduction_points }}</td>
                            <td>{{ $season->pivot->deduction_goals }}</td>
                            <td>{{ $season->pivot->withdrawal }}</td>
                            <td>
                                <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('editClubAssignment', [$season, $club]) }}" title="Zuordnung bearbeiten">
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <i>Die Mannschaft ist keiner Saison zugeordnet.</i>
            @endif
        </div>
        <!-- fixtures -->
        <div class="tab-pane" id="fixtures" role="tabpanel">
            <h4 class="mb-4 mt-4">Paarungen</h4>
            @if($club->fixtures()->count() != 0)
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
                    @foreach($club->fixtures()->sortByDesc('datetime') as $fixture)
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
                                    <a href="{{ route('clubs.show', $fixture->clubHome) }}" title="Mannschaft anzeigen">
                                        {{ $fixture->clubHome->name_short }}
                                    </a>
                                @else
                                    -
                                @endif
                                vs.
                                @if($fixture->clubAway)
                                    <a href="{{ route('clubs.show', $fixture->clubAway) }}" title="Mannschaft anzeigen">
                                        {{ $fixture->clubAway->name_short }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($fixture->stadium)
                                    <a href="{{ route('stadiums.show', $fixture->stadium) }}">
                                        {{ $fixture->stadium->name_short }}
                                    </a>
                                @endif
                            </td>
                            <td class="align-middle">
                                <!-- TODO replace with proper methods to test fixture -->
                                {{ $fixture->goals_home ?? "-" }} : {{ $fixture->goals_away ?? "-" }}
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
                                @if($fixture->referees->count() === 0)
                                    <span class="fa fa-hand-stop-o fa-fw text-danger" title="Kein Schiedsrichter"></span>
                                @else
                                    <span class="fa fa-hand-stop-o fa-fw text-success" title="Schiedsrichter zugewiesen"></span>
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
                                <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]) }}" title="Paarung anzeigen">
                                    <span class="fa fa-search-plus" aria-hidden="true"></span>
                                </a>
                                <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('matchweeks.fixtures.edit', [$fixture->matchweek, $fixture]) }}" title="Paarung bearbeiten">
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <i>Der Mannschaft ist keiner Paarung zugeordnet.</i>
            @endif
        </div>
        <!-- players -->
        <div class="tab-pane" id="players" role="tabpanel">
            <h4 class="mb-4 mt-4">Aktive
                <small class="text-muted">(davon <b>{{ $club->players()->whereHas('person', function ($query) { $query->whereNotNull('registered_at_club'); })->get()->count() }}</b> Vereinsspieler)</small>
            </h4>
            @if($club->players()->whereNull('sign_off')->get()->count() > 0)
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th class=""></th>
                        <th class=""></th>
                        <th class=""></th>
                        <th class="">Nachname, Vorname</th>
                        <th class="">Anmeldung</th>
                        <th class="">Nummer</th>
                        <th class="">Position</th>
                        <th class=""></th>
                        <th class="">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($club->players()->whereNull('sign_off')->get() as $p_active)
                        <tr>
                            <td class="align-middle">{{ $p_active->id }}</td>
                            <td class="align-middle">
                                @if($p_active->public)
                                    <span class="fa fa-eye" title="Öffentlich"></span>
                                @else
                                    <span class="fa fa-eye-slash" title="Nicht öffentlich"></span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                @if($p_active->person->photo)
                                    <img src="{{ Storage::url($p_active->person->photo) }}" class="rounded" title="Passbild" alt="Passbild" width="25">
                                @else
                                    <span class="fa fa-ban fa-fw text-muted" title="Kein Passbild"></span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($p_active->person->registered_at_club)
                                    <span class="fa fa-shield text-warning fa-fw" title="Vereinsspieler"></span>
                                    @if($p_active->person->realDivision)
                                        {{ $p_active->person->realDivision->name_short }}
                                    @endif
                                @else
                                    <span class="fa fa-fw"></span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <a href="{{ route('people.show', $p_active->person->id) }}" title="Person bearbeiten (nicht Spieler)">
                                    {{ $p_active->person->full_name ?? "-" }}
                                </a>
                            </td>
                            <td class="align-middle">{{ $p_active->sign_on->format('d.m.Y') }}</td>
                            <td class="align-middle">{{ $p_active->number ?? "-" }}</td>
                            <td class="align-middle">
                                @if($p_active->position_id)
                                    {{ $p_active->position->name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($p_active->registered_at_club)
                                    <span class="fa fa-shield text-warning fa-fw" title="Vereinsspieler"></span>
                                @else
                                    <span class="fa fa-fw"></span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('clubs.players.edit', [$club, $p_active]) }}" title="Spieler bearbeiten">
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <i>Der Mannschaft sind keine Spieler zugeordnet.</i>
            @endif
            @if($club->players()->whereNotNull('sign_off')->get()->count() > 0)
                <hr>
                <h4 class="mb-4 mt-4">Ehemalige</h4>
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th class="">Nachname, Vorname</th>
                        <th class="">Anmeldung</th>
                        <th class="">Abmeldung</th>
                        <th class="">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($club->players()->whereNotNull('sign_off')->get() as $p_inactive)
                        <tr>
                            <td>{{ $p_inactive->id }}</td>
                            <td>
                                <a href="" title="Person bearbeiten">
                                    {{ $p_inactive->person->last_name }}, {{ $p_inactive->person->first_name }}
                                </a>
                            </td>
                            <td>{{ $p_inactive->sign_on->format('d.m.Y') }}</td>
                            <td>{{ $p_inactive->sign_off->format('d.m.Y') }}</td>
                            <td>
                                <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('clubs.players.edit', [$club, $p_inactive]) }}" title="Spieler bearbeiten">
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <!-- contacts -->
        <div class="tab-pane" id="contacts" role="tabpanel">
            <h4 class="mb-4 mt-4">
                Ansprechpartner
            </h4>
            @if( $club->contacts->count() > 0 )
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th class="">Name</th>
                        <th>#</th>
                        <th>E-Mail</th>
                        <th>Mobil</th>
                        <th class="">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($club->contacts()->orderBy('hierarchy_level')->get() as $contact)
                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>
                                <a href="{{ route('people.show', $contact->person ) }}">
                                    {{ $contact->person->last_name }}, {{ $contact->person->first_name }}
                                </a>
                            </td>
                            <td>{{ $contact->hierarchy_level }}.</td>
                            <td>{{ $contact->mail }}</td>
                            <td>{{ $contact->mobile }}</td>
                            <td>
                                <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('clubs.contacts.edit', [ $club, $contact ]) }}" title="Kontakt bearbeiten">
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <i>Der Mannschaft sind keine Ansprechpartner zugeordnet.</i>
            @endif
        </div>
        <!-- stadiums -->
        <div class="tab-pane" id="stadiums" role="tabpanel">
            <h4 class="mb-4 mt-4">
                Spielort(e)
            </h4>
            @if( $club->stadiums->count() > 0 )
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th class="">Name</th>
                        <th class="">Anstoß</th>
                        <th class=""></th>
                        <th class="">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($club->stadiums as $stadium)
                        <tr>
                            <td class="align-middle">{{ $stadium->id }}</td>
                            <td class="align-middle">
                                <a href="{{ route('stadiums.show', $stadium) }}" title="Spielort anzeigen">
                                    {{ $stadium->name }}
                                </a>
                            </td>
                            <td class="align-middle">{{ $stadium->pivot->regular_home_day }} {{ $stadium->pivot->regular_home_time }}</td>
                            <td class="align-middle">
                                @if($stadium->pivot->is_regular_stadium)
                                    <span class="fa fa-star fa-fw" title="Hauptspielort"></span>
                                @endif
                                @if($stadium->pivot->note)
                                    <span class="fa fa-file-text fa-fw" title="Notiz vorhanden"></span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('editStadiumAssignment', [$club,$stadium]) }}" title="Spielort-Zuordnung bearbeiten">
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <i>Der Mannschaft sind keine Spielorte zugeordnet.</i>
            @endif
        </div>
    </div>

@endsection