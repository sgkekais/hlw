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
    <div class="row">
        <div class="col">
            <!-- list all people -->
            <h2 class="">Angelegte Personen <span class="badge badge-secondary">{{ $people->count() }}</span></h2>
        </div>
    </div>
    <table class="table table-sm table-striped" id="people">
        <thead class="thead-default">
        <tr>
            <th class="">ID</th>
            <th class="text-center">Aktiv</th>
            <th class="text-center"></th>
            <th class="">Nachname, Vorname</th>
            <th class="">Geb.datum</th>
            <th class="">Daten</th>
            <th class="">Aktionen</th>
        </tr>
        </thead>
        <tbody>
        @foreach($people as $person)
            <tr>
                <td class="align-middle"><b>{{ $person->id }}</b></td>
                <td class="align-middle text-center">
                    @if($person->active)
                        <span class="fa fa-eye" title="Öffentlich"></span>
                    @else
                        <span class="fa fa-eye-slash" title="Nicht öffentlich"></span>
                    @endif
                </td>
                <td class="align-middle text-center">
                    @if($person->photo)
                        <img src="{{ Storage::url($person->photo) }}" class="rounded" title="Passbild" alt="Passbild" width="25">
                        @if($person->photo_public)
                            <span class="fa fa-eye fa-fw" title="Passbild öffentlich"></span>
                        @else
                            <span class="fa fa-eye-slash fa-fw" title="Passbild nicht öffentlich"></span>
                        @endif
                    @else
                        <span class="fa fa-ban fa-fw text-muted" title="Kein Passbild"></span>
                    @endif
                </td>
                <td class="align-middle">
                    <a href="{{ route('people.show', $person ) }}" title="Anzeigen">
                        {{ $person->last_name }}, {{ $person->first_name }}
                    </a>
                </td>
                <td class="align-middle">{{ $person->date_of_birth ? $person->date_of_birth->format('d.m.Y') : "-" }}</td>
                <td class="align-middle">
                    @if($person->photo)
                        <span class="fa fa-photo fa-fw" title="Passbild vorhanden"></span>
                    @else
                        <span class="fa fa-fw"></span>
                    @endif
                    @if($person->players->count() > 0)
                        <img src="/images/hlwlogo.png" class="d-inline-block align-middle" height="15" alt="HLW-Spieler" title="HLW-Spieler">
                    @else
                        <span class="fa fa-fw"></span>
                    @endif
                    @if($person->registered_at_club)
                        <span class="fa fa-shield text-warning fa-fw" title="Vereinsspieler"></span>
                        @if($person->realDivision)
                            {{ $person->realDivision->name_short }}
                        @endif
                    @else
                        <span class="fa fa-fw"></span>
                    @endif
                    @if($person->contacts->count() > 0)
                        <span class="fa fa-phone fa-fw" title="Ansprechpartner"></span>
                    @else
                        <span class="fa fa-fw"></span>
                    @endif
                    @if($person->referees->count() > 0)
                        <span class="fa fa-hand-stop-o fa-fw" title="Schiedsrichter"></span>
                    @else
                        <span class="fa fa-fw"></span>
                    @endif
                    @if($person->note)
                        <span class="fa fa-file-text" title="Notiz vorhanden"></span>
                    @else
                        <span class="fa fa-fw"></span>
                @endif
                <td class="align-middle">
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

@section('pagespecificscripts')
    <script type="text/javascript">
        $(document).ready( function () {

            $('#people').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
                },
                "order": [[ 3, "asc" ]]
            });

        });
    </script>
@endsection