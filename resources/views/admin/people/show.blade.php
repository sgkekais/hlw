@extends('admin.adminlayout')

@section('content')

    <div class="row">
        <div class="col-md-2">
            @if($person->photo)
                <img src="{{ Storage::url($person->photo) }}" class="w-75">
            @else
                <span class="fa fa-ban fa-4x text-muted" title="kein Passbild vorhanden"></span>
            @endif
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
            <h4>Ist Spieler</h4>
            @if($person->players()->count() > 0)
                @foreach($person->players as $player)
                <div class="row">
                    <div class="col-md-12">
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
                            <tr>
                                <td class="align-middle">{{ $player->id }}</td>
                                <td class="align-middle">
                                    <a href="{{ route('clubs.show', $player->club) }}" title="Mannschaft anzeigen">
                                        {{ $player->club->name }}
                                    </a>
                                </td>
                                <td class="align-middle">{{ $player->sign_on->format('d.m.Y') }}</td>
                                <td class="align-middle">{{ $player->sign_off ? $player->sign_off->format('d.m.Y') : null }}</td>
                                <td class="align-middle">{{ $player->number }}</td>
                                <td class="align-middle">
                                    @if($player->position_id)
                                        {{ $player->position->name }}
                                    @else

                                    @endif
                                </td>
                                <td class="align-middle">
                                    <!-- edit -->
                                    <a class="btn btn-primary" href="{{ route('clubs.players.edit', [$player->club, $player]) }}" title="Spieler bearbeiten">
                                        <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Erhaltene Karten</h5>
                        @if($player->cards->count() > 0)
                            <table class="table table-sm table-striped table-hover">
                                <thead class="thead-default">
                                <tr>
                                    <th class="">ID</th>
                                    <th class="">Datum</th>
                                    <th class=""></th>
                                    <th class="">Farbe</th>
                                    <th class="">Sperre</th>
                                    <th class=""></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($player->cards as $card)
                                        <tr>
                                            <td class="align-middle">{{ $card->id }}</td>
                                            <td class="align-middle">{{ $card->fixture->datetime ? $card->fixture->datetime->format('d.m.Y') : null }}</td>
                                            <td class="align-middle">
                                                {{ $card->fixture->clubHome ? $card->fixture->clubHome->name_code : null }}
                                                {{ $card->fixture->clubAway ? " vs. ".$card->fixture->clubAway->name_code : null }}
                                            </td>
                                            <td class="align-middle">{{ $card->color }}</td>
                                            <td class="align-middle">{{ $card->ban_matches }}</td>
                                            <td class="align-middle">
                                                <!-- show match -->
                                                <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.show', [$card->fixture->matchweek, $card->fixture]) }}" title="Paarung anzeigen">
                                                    <span class="fa fa-search-plus"></span>
                                                </a>
                                                <!-- edit -->
                                                <a class="btn btn-primary" href="{{ route('fixtures.cards.edit', [ $card->fixture, $card ]) }}" title="Karte bearbeiten">
                                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h5>Geschossene Tore</h5>
                        @if($player->goals->count() > 0)
                            <table class="table table-sm table-striped table-hover">
                                <thead class="thead-default">
                                <tr>
                                    <th class="">ID</th>
                                    <th>Datum</th>
                                    <th></th>
                                    <th>Stand</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($player->goals as $goal)
                                        <tr>
                                            <td class="align-middle">{{ $goal->id }}</td>
                                            <td class="align-middle">{{ $goal->fixture->datetime ? $goal->fixture->datetime->format('d.m.Y') : null }}</td>
                                            <td class="align-middle">
                                                {{ $goal->fixture->clubHome ? $goal->fixture->clubHome->name_code : null }}
                                                {{ $goal->fixture->clubAway ? " vs. ".$goal->fixture->clubAway->name_code : null }}
                                            </td>
                                            <td class="align-middle">{{ $goal->score }}</td>
                                            <td class="align-middle">
                                                <!-- show match -->
                                                <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.show', [$goal->fixture->matchweek, $card->fixture]) }}" title="Paarung anzeigen">
                                                    <span class="fa fa-search-plus"></span>
                                                </a>
                                                <!-- edit -->
                                                <a class="btn btn-primary" href="{{ route('fixtures.goals.edit', [$goal->fixture, $goal]) }}" title="Torschützen bearbeiten">
                                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
                <i>Person spielt für keine Mannschaft.</i>
            @endif
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <h4>Ist Ansprechpartner</h4>
            @if($person->contacts()->count() > 0)
                @foreach($person->contacts as $contact)
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-default">
                            <tr>
                                <th class="">ID</th>
                                <th>Club</th>
                                <th>#</th>
                                <th>E-Mail</th>
                                <th>Mobil</th>
                                <th class="">Aktionen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="align-middle">{{ $contact->id }}</td>
                                <td class="align-middle">{{ $contact->club->name_short }}</td>
                                <td class="align-middle">{{ $contact->hierarchy_level }}.</td>
                                <td class="align-middle">{{ $contact->mail }}</td>
                                <td class="align-middle">{{ $contact->mobile }}</td>
                                <td class="align-middle">
                                    <!-- edit -->
                                    <a class="btn btn-primary" href="{{ route('clubs.contacts.edit', [ $contact->club, $contact ]) }}" title="Kontakt bearbeiten">
                                        <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach
            @else
                <i>Person ist kein Ansprechpartner.</i>
            @endif
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <h4>Schiedsrichter</h4>
            @if($person->referees()->count() > 0)
                <i>Person ist Schiedsrichter.</i>
            @else
                <i>Person ist kein Schiedsrichter.</i>
            @endif
        </div>
    </div>

@endsection