@extends('admin.adminlayout')

@section('content')

    <h1 class="">Personen</h1>
    <p>
        Verwaltung der Personen.
    </p>
    <div class="row">
        <div class="col-md-3">
            <!-- controls -->
            <a class="btn btn-success" href="{{ route('people.create') }}" title="Person anlegen">
                <span class="fa fa-plus-square"></span> Person anlegen
            </a>
        </div>
    </div>
    <hr>
    <!-- list all people -->
    <h2 class="mt-4">Angelegte Personen <span class="badge badge-default">{{ $people->count() }}</span></h2>
        <table class="table table-sm table-striped table-hover">
            <thead class="thead-default">
            <tr>
                <th class="">ID</th>
                <th class="">Nachname, Vorname</th>
                <th class="">Geb.datum</th>
                <th class="">Foto</th>
                <th class="">Vereinsspieler</th>
                <th class="">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($people as $person)
                <tr>
                    <td><b>{{ $person->id }}</b></td>
                    <td>
                        <a href="{{ route('people.show', $person ) }}" title="Anzeigen">
                            {{ $person->last_name }}, {{ $person->first_name }}
                        </a>
                    </td>
                    <td>{{ $person->date_of_birth->format('d.m.Y') }}</td>
                    <td>{{ $person->photo ? "X" : null }}</td>
                    <td>{{ $person->registered_at_club ? "X" : null }}</td>
                    <td>
                        <!-- display details -->
                        <a class="btn btn-secondary" href="{{ route('people.show', $person) }}" title="Person anzeigen">
                            <span class="fa fa-search-plus"></span>
                        </a>
                        <!-- edit -->
                        <a class="btn btn-primary" href="{{ route('people.edit', $person) }}" title="Person bearbeiten">
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

@endsection