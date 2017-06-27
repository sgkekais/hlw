@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1 class="mt-4">Personen</h1>
        <p>
            Verwaltung der Personen.
        </p>
        <div class="row">
            <div class="col-md-3">
                <!-- controls -->
                <a class="btn btn-primary" href="{{ route('people.create') }}" title="Person anlegen">
                    <span class="fa fa-plus-circle"></span> Person anlegen
                </a>
            </div>
        </div>
        <hr>
        <!-- list all people -->
        <h2 class="mt-4">Angelegte Personen<span class="badge badge-default">{{ $people->count() }}</span></h2>
            <table class="table table-sm table-striped table-hover">
                <thead class="thead-default">
                <tr>
                    <th class="">ID</th>
                    <th class="">Nachname</th>
                    <th class="">Vorname</th>
                    <th class="">Veröffentlicht?</th>
                    <th class="">Aktionen</th>
                    <th class="">Änderungen</th>
                </tr>
                </thead>
                <tbody>
                @foreach($people as $person)
                    <tr>
                        <td><b>{{ $person->id }}</b></td>
                        <td>
                            <a href="{{ route('people.show', $person ) }}" title="Anzeigen">{{ $person->name }}</a>
                            <br>Ist Spieler: {{ $person->players()->get()->count() }}
                        </td>
                        <td>{{ $person->published ? "JA" : "NEIN" }}</td>
                        <td>
                            <!-- display details -->
                            <a class="btn btn-secondary" href="{{ route('people.show', $person) }}" title="Mannschaft anzeigen">
                                <span class="fa fa-eye"></span>
                            </a>
                            <!-- edit -->
                            <a class="btn btn-primary" href="{{ route('people.edit', $person) }}" title="Mannschaft bearbeiten">
                                <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                            </a>
                        </td>
                        <td>
                            angelegt am {{ $person->created_at->format('d.m.Y \\u\\m H:i') }} Uhr
                            @if($causer = ModelHelper::causerOfAction($person,'created'))
                                von {{ $causer->name }}
                            @endif
                            <br>
                            @if($person->updated_at != $person->created_at)
                                geändert am {{ $person->updated_at->format('d.m.Y \\u\\m H:i') }} Uhr
                                @if($causer = ModelHelper::causerOfAction($person,'updated'))
                                    von {{ $causer->name }}
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
@endsection