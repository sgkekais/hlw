@extends('admin.adminlayout')

@section('content')

    <h1 class="">Schiedsrichter</h1>
    <p>
        Verwaltung der Schiedsrichter.
    </p>
    <div class="row">
        <div class="col-md-3">
            <!-- controls -->
            <a class="btn btn-success" href="{{ route('referees.create') }}" title="Schiedsrichter anlegen">
                <span class="fa fa-plus-square"></span> Schiedsrichter anlegen
            </a>
        </div>
    </div>
    <hr>
    <!-- list all referees -->
    <h2 class="mt-4">Angelegte Schiedsrichter <span class="badge badge-secondary">{{ $referees->count() }}</span></h2>
        <table class="table table-sm table-striped table-hover">
            <thead class="thead-default">
            <tr>
                <th class="">ID</th>
                <th class="">Nachname, Vorname</th>
                <th class=""></th>
                <th class="">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($referees as $referee)
                <tr>
                    <td class="align-middle"><b>{{ $referee->id }}</b></td>
                    <td class="align-middle">
                        <a href="{{ route('referees.show', $referee ) }}" title="Anzeigen">
                            {{ $referee->person->last_name }}, {{ $referee->person->first_name }}
                        </a>
                    </td>
                    <td class="align-middle">
                        @if($referee->note)
                            <span class="fa fa-file-text" title="Notiz vorhanden"></span>
                        @endif
                    </td>
                    <td class="align-middle">
                        <!-- display details -->
                        <a class="btn btn-secondary" href="{{ route('referees.show', $referee) }}" title="Schiedsrichter anzeigen">
                            <span class="fa fa-search-plus"></span>
                        </a>
                        <!-- edit -->
                        <a class="btn btn-primary" href="{{ route('referees.edit', $referee) }}" title="Schiedsrichter bearbeiten">
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

@endsection