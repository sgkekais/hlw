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
            <h2 class="mt-4 text-primary">&mdash; {{ $club->name }}</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h3 class="mt-4">Aktionen</h3>
            <a class="btn btn-primary mb-2" href="{{ route('clubs.edit', $club ) }}" title="Wettbewerb bearbeiten">
                <span class="fa fa-pencil"></span> Bearbeiten
            </a>
            <br>
            <a class="btn btn-secondary" href="{{ route('players.create', $club ) }}" title="Spieler zuordnen">
                <span class="fa fa-plus-circle"></span> Spieler
            </a>
            <a class="btn btn-secondary" href="{{ route('clubs.contacts.create', $club) }}" title="Ansprechpartner zuordnen">
                <span class="fa fa-plus-circle"></span> Kontakt
            </a>
            <a class="btn btn-secondary" href="#" title="Spielort zuordnen">
                <span class="fa fa-plus-circle"></span> Spielort
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
                <span class="badge badge-pill badge-default">
                    {{ $club->seasons->count() }}
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#fixtures" role="tab">
                Paarungen
                <span class="badge badge-pill badge-default">
                    {{ $club->fixtures_home->count() + $club->fixtures_away->count() }}
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#players" role="tab">
                Kader
                <span class="badge badge-pill badge-default">
                    {{ $club->players()->whereNull('sign_off')->get()->count() }}
                </span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#contacts" role="tab">
                Kontakte
                <span class="badge badge-pill badge-default">{{ $club->contacts->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#stadiums" role="tab">
                Spielort(e)
                <span class="badge badge-pill badge-default">{{ $club->stadiums->count() }}</span>
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
                                    @if($season->year_begin == $season->year_end)
                                        {{ $season->year_begin }}
                                    @else
                                        {{ $season->year_begin }} / {{ $season->year_end }}
                                    @endif
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
            @if($club->getFixtures()->count() != 0)
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th class="">Datum</th>
                        <th class="">Paarung</th>
                        <th class="">Ergebnis</th>
                        <th class="">Ann.?</th>
                        <th class="">Veröffentlicht?</th>
                        <th class="">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($club->getFixtures() as $fixture)
                        <tr>
                            <td><b>{{ $fixture->id }}</b></td>
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
                                {{ $fixture->goals_home }}:{{ $fixture->goals_away }}
                                ({{ $fixture->goals_home_11m }}:{{ $fixture->goals_away_11m }})
                                - {{ $fixture->goals_home_rated }}:{{ $fixture->goals_away_rated }}
                            </td>
                            <td>{{ $fixture->cancelled ? "X" : null }}</td>
                            <td>{{ $fixture->published ? "JA" : "NEIN" }}</td>
                            <td>
                                <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('matchweeks.fixtures.edit', [$fixture->matchweek, $fixture]) }}" title="Paarung bearbeiten">
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                                <!-- reschedule -->
                                <a class="btn btn-primary" href="{{ route('matchweeks.fixtures.edit', [$fixture->matchweek, $fixture]) }}" title="Paarung verlegen">
                                    <span class="fa fa-clock-o" aria-hidden="true"></span>
                                    <span class="fa fa-caret-right" aria-hidden="true"></span>
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
                <small class="text-muted">(davon <b>{{ $club->players()->whereNotNull('registered_at_club')->get()->count() }}</b> Vereinsspieler)</small>
            </h4>
            @if($club->players()->whereNull('sign_off')->get()->count() > 0)
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th class="">Nachname, Vorname</th>
                        <th class="">Anmeldung</th>
                        <th class="">Vereinsspieler?</th>
                        <th class="">Nummer</th>
                        <th class="">Position</th>
                        <th class="">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($club->players()->whereNull('sign_off')->get() as $p_active)
                        <tr>
                            <td>{{ $p_active->id }}</td>
                            <td>
                                <a href="{{ route('people.edit', $p_active) }}" title="Person bearbeiten (nicht Spieler)">
                                    {{ $p_active->last_name }}, {{ $p_active->first_name }}
                                </a>
                            </td>
                            <td>{{ $p_active->pivot->sign_on->format('d.m.Y') }}</td>
                            <td>
                                @if($p_active->registered_at_club)
                                    <span class='text-danger'>JA</span>
                                @else
                                    <span class='text-success'>NEIN</span>
                                @endif
                            </td>
                            <td>{{ $p_active->pivot->number }}</td>
                            <td>
                                @if($p_active->pivot->position_id)
                                    {{ $p_active->pivot->position->name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('players.edit', [$club, $p_active]) }}" title="Spieler bearbeiten">
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
                                    {{ $p_inactive->last_name }}, {{ $p_inactive->first_name }}
                                </a>
                            </td>
                            <td>{{ $p_inactive->pivot->sign_on->format('d.m.Y') }}</td>
                            <td>{{ $p_inactive->pivot->sign_off->format('d.m.Y') }}</td>
                            <td>
                                <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('players.edit', [$club, $p_inactive]) }}" title="Spieler bearbeiten">
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
                            <td>{{ $contact->person->last_name }}, {{ $contact->person->first_name }}</td>
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
                        <th class="">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($club->stadiums as $stadium)
                        <tr>
                            <td>{{ $stadium->id }}</td>
                            <td>{{ $stadium->name }}</td>

                            <td>
                                <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('players.edit', $stadium) }}" title="Spieler bearbeiten">
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