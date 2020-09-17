@extends('admin.adminlayout')

@section('content')

    <h1 class="">Schiedsrichter</h1>
    <p>
        Verwaltung der Schiedsrichter.
    </p>
    <div class="row">
        <div class="col-md-3">
            @can('create referee')
                <!-- controls -->
                <a class="btn btn-success" href="{{ route('referees.create') }}" title="Schiedsrichter anlegen">
                    <span class="fa fa-plus-square"></span> Schiedsrichter anlegen
                </a>
            @endcan
        </div>
    </div>
    <hr>
    <div class="row mt-2">
        <div class="col">
            <h4 class="font-weight-bold">Springe zu:</h4>
            <a class="btn btn-outline-secondary" href="#activerefs" role="button">Aktive Schiedsrichter <span class="badge badge-primary">{{ $active_referees->count() }}</span></a>
            <a class="btn btn-outline-secondary" href="#inactiverefs" role="button">Inaktive Schiedsrichter <span class="badge badge-primary">{{ $inactive_referees->count() }}</span></a>
        </div>
    </div>
    <hr>
    <!-- list all active referees -->
    <h2 class="mt-4" id="activerefs">Aktive Schiedsrichter <span class="badge badge-secondary">{{ $active_referees->count() }}</span></h2>
        <table class="table table-sm table-striped table-hover">
            <thead class="thead-default">
            <tr>
                <th class="">ID</th>
                <th class="">Nachname, Vorname</th>
                <th class="">Mail</th>
                <th class="">Mobil</th>
                <th class="">Notiz</th>
                <th class="">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($active_referees as $referee)
                <tr>
                    <td class="align-middle"><b>{{ $referee->id }}</b></td>
                    <td class="align-middle">
                        {{ $referee->person->last_name }}, {{ $referee->person->first_name }}
                    </td>
                    <td class="align-middle">
                        {{ $referee->mail }}
                    </td>
                    <td class="align-middle">
                        {{ $referee->mobile }}
                    </td>
                    <td class="align-middle">
                        {{ $referee->note }}
                    </td>
                    <td class="align-middle">
                        @can('read referee')
                            <!-- display details -->
                            <a class="btn btn-secondary btn-sm" href="{{ route('referees.show', $referee) }}" title="Schiedsrichter anzeigen">
                                <span class="fa fa-search-plus"></span>
                            </a>
                        @endcan
                        @can('update referee')
                            <!-- edit -->
                            <a class="btn btn-primary btn-sm" href="{{ route('referees.edit', $referee) }}" title="Schiedsrichter bearbeiten">
                                <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    <hr>
    <!-- list all inactive referees -->
    <h2 class="mt-4" id="inactiverefs">Inaktive Schiedsrichter <span class="badge badge-secondary">{{ $inactive_referees->count() }}</span></h2>
    <table class="table table-sm table-striped table-hover">
        <thead class="thead-default">
        <tr>
            <th class="">ID</th>
            <th class="">Nachname, Vorname</th>
            <th class="">Mail</th>
            <th class="">Mobil</th>
            <th class="">Notiz</th>
            <th class="">Aktionen</th>
        </tr>
        </thead>
        <tbody>
        @foreach($inactive_referees as $referee)
            <tr>
                <td class="align-middle"><b>{{ $referee->id }}</b></td>
                <td class="align-middle">
                    {{ $referee->person->last_name }}, {{ $referee->person->first_name }}
                </td>
                <td class="align-middle">
                    {{ $referee->mail }}
                </td>
                <td class="align-middle">
                    {{ $referee->mobile }}
                </td>
                <td class="align-middle">
                    {{ $referee->note }}
                </td>
                <td class="align-middle">
                @can('read referee')
                    <!-- display details -->
                        <a class="btn btn-secondary btn-sm" href="{{ route('referees.show', $referee) }}" title="Schiedsrichter anzeigen">
                            <span class="fa fa-search-plus"></span>
                        </a>
                @endcan
                @can('update referee')
                    <!-- edit -->
                        <a class="btn btn-primary btn-sm" href="{{ route('referees.edit', $referee) }}" title="Schiedsrichter bearbeiten">
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection