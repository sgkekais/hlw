@extends('admin.adminlayout')

@section('content')

    <div class="row">
        <div class="col-md-2">
            Passfoto
        </div>
        <div class="col-md-10">
            <h1 class="">Details zu Person</h1>
            <h2 class="mt-4 text-primary">&mdash; {{ $person->last_name }}, {{ $person->first_name }}</h2>
            <h3 class="text-muted">{{ $person->registered_at_club ? "Vereinsspieler bei ".$person->realClub->name : null }}</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h3 class="mt-4">Aktionen</h3>
            <a class="btn btn-primary mb-4" href="{{ route('people.edit', $person ) }}" title="Person bearbeiten">
                <span class="fa fa-pencil"></span> Bearbeiten
            </a>
        </div>
        <!-- dates -->
        <div class="col-md-6">
            <h3 class="mt-4">Änderungen</h3>
            <!-- created at -->
            Angelegt am: {{ $person->created_at->format('d.m.Y H:i') }} Uhr
            @if($causer = ModelHelper::causerOfAction($person,'created'))
                von {{ $causer->name }}
            @endif
            <br>
            <!-- updated at -->
            @if($person->updated_at != $person->created_at)
                Geändert am: {{ $person->updated_at->format('d.m.Y H:i') }} Uhr
                @if($causer = ModelHelper::causerOfAction($person,'updated'))
                    von {{ $causer->name }}
                @endif
            @endif
        </div>
    </div>
    <hr>
    <!-- show person details -->
    <h3 class="mt-4">
        Zuordnungen
    </h3>
    <div class="row">
        <div class="col-md-12">
            <h4>Spieler</h4>
            @if($person->players()->count() > 0)
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th>Verein</th>
                        <th class="">Anmeldung</th>
                        <th>Abmeldung</th>
                        <th class="">Nummer</th>
                        <th class="">Position</th>
                        <th class="">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($person->players as $player)
                        <tr>
                            <td>{{ $player->id }}</td>
                            <td>
                                <a href="{{ route('clubs.show', $player->club) }}" title="Mannschaft anzeigen">
                                    {{ $player->club->name }}
                                </a>
                            </td>
                            <td>{{ $player->sign_on->format('d.m.Y') }}</td>
                            <td>{{ $player->sign_off ? $player->sign_off->format('d.m.Y') : null }}</td>
                            <td>{{ $player->number }}</td>
                            <td>
                                @if($player->position_id)
                                    {{ $player->position->name }}
                                @else

                                @endif
                            </td>
                            <td>
                                <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('clubs.players.edit', [$player->club, $player]) }}" title="Spieler bearbeiten">
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <i>Person spielt für keine Mannschaft.</i>
            @endif
        </div>
        <div class="col-md-12">
            <h4>Ansprechpartner</h4>
            @if($person->contacts()->count() > 0)

            @else
                <i>Person ist kein Ansprechpartner.</i>
            @endif
        </div>
        <div class="col-md-12">
            <h4>Schiedsrichter</h4>
            @if($person->referees()->count() > 0)

            @else
                <i>Person ist kein Schiedsrichter.</i>
            @endif
        </div>
    </div> <!-- ./assignments -->

@endsection