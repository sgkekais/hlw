@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1 class="mt-4">Details zu Mannschaft</h1>
        <h2 class="mt-4 text-primary">&mdash; {{ $club->name }}</h2>

        <div class="row">
            <div class="col-md-6">
                <h3 class="mt-4">Aktionen</h3>
                <a class="btn btn-primary mb-4" href="{{ route('clubs.edit', $club ) }}" title="Wettbewerb bearbeiten">
                    <span class="fa fa-pencil"></span> Bearbeiten
                </a>
                <a class="btn btn-primary mb-4" href="{{ route('players.create', $club ) }}" title="Spieler zuordnen">
                    <span class="fa fa-pencil"></span> Spieler zuordnen
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
                <a class="nav-link active" data-toggle="tab" href="#fixtures" role="tab">Paarungen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#players" role="tab">Kader</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#stadiums" role="tab">Spielort(e)</a>
            </li>
        </ul>
        <!-- show club details -->
        <div class="tab-content">
            <div class="tab-pane active" id="fixtures" role="tabpanel">
                Saisons: {{ $club->seasons->count() }}

                + jeweilige Paarungen
            </div>
            <div class="tab-pane" id="players" role="tabpanel">
                <h4 class="mb-4 mt-4">Aktive
                    <span class="badge badge-default">
                        {{ $club->players()->whereNull('sign_off')->get()->count() }}
                    </span>
                    <small class="text-muted">(davon <b>{{ $club->players()->whereNotNull('registered_at_club')->get()->count() }}</b> Vereinsspieler)</small>
                </h4>
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
                        <th class="">Änderungen</th>
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
                            <td>
                                angelegt am {{ $p_active->pivot->created_at->format('d.m.Y \\u\\m H:i') }} Uhr
                                @if($causer = ModelHelper::causerOfAction($p_active,'created'))
                                    von {{ $causer->name }}
                                @endif
                                <br>
                                @if($p_active->pivot->updated_at != $p_active->pivot->created_at)
                                    geändert am {{ $p_active->pivot->updated_at->format('d.m.Y \\u\\m H:i') }} Uhr
                                    @if($causer = ModelHelper::causerOfAction($p_active,'updated'))
                                        von {{ $causer->name }}
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <hr>
                <h4 class="mb-4 mt-4">Ehemalige
                    <span class="badge badge-default">
                        {{ $club->players()->whereNotNull('sign_off')->get()->count() }}
                    </span>                    
                </h4>

                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th class="">Nachname, Vorname</th>
                        <th class="">Anmeldung</th>
                        <th class="">Abmeldung</th>
                        <th class="">Aktionen</th>
                        <th class="">Änderungen</th>
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
                            <td>
                                angelegt am {{ $p_inactive->pivot->created_at->format('d.m.Y \\u\\m H:i') }} Uhr
                                @if($causer = ModelHelper::causerOfAction($p_inactive,'created'))
                                    von {{ $causer->name }}
                                @endif
                                <br>
                                @if($p_inactive->pivot->updated_at != $p_inactive->pivot->created_at)
                                    geändert am {{ $p_inactive->pivot->updated_at->format('d.m.Y \\u\\m H:i') }} Uhr
                                    @if($causer = ModelHelper::causerOfAction($p_inactive,'updated'))
                                        von {{ $causer->name }}
                                    @endif
                                @endif
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- stadiums -->
            <div class="tab-pane" id="stadiums" role="tabpanel">
                <h4 class="mb-4 mt-4">Spielort(e)  <span class="badge badge-default">{{ $club->stadiums()->count() }}</span></h4>
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th class="">Name</th>

                        <th class="">Aktionen</th>
                        <th class="">Änderungen</th>
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
                            <td>
                                angelegt am {{ $stadium->created_at->format('d.m.Y \\u\\m H:i') }} Uhr
                                @if($causer = ModelHelper::causerOfAction($stadium,'created'))
                                    von {{ $causer->name }}
                                @endif
                                <br>
                                @if($stadium->updated_at != $stadium->created_at)
                                    geändert am {{ $stadium->updated_at->format('d.m.Y \\u\\m H:i') }} Uhr
                                    @if($causer = ModelHelper::causerOfAction($stadium,'updated'))
                                        von {{ $causer->name }}
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection