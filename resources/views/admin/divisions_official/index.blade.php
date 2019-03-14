@extends('admin.adminlayout')

@section('content')

    <h1 class="">Offizielle Spielklassen</h1>
    <p>
        Verwaltung der offiziellen Spielklassen.
    </p>
    <div class="row">
        <div class="col-md-3">
            @can('create division_official')
                <!-- controls -->
                <a class="btn btn-success" href="{{ route('divisions-official.create') }}" title="Spielklasse anlegen">
                    <span class="fa fa-plus-square"></span> Off. Spielklasse anlegen
                </a>
            @endcan
        </div>
    </div>
    <hr>
    <!-- list all divisions -->
    <h2 class="mt-4">Angelegte off. Spielklassen <span class="badge badge-secondary">{{ $official_divisions->count() }}</span></h2>
    <table class="table table-sm table-striped table-hover">
        <thead class="thead-default">
        <tr>
            <th class="">ID</th>
            <th class="">Name</th>
            <th class="">Name kurz</th>
            <th class="">Aktionen</th>
        </tr>
        </thead>
        <tbody>
        @foreach($official_divisions as $division)
            <tr>
                <td class="align-middle"><b>{{ $division->id }}</b></td>
                <td class="align-middle">
                    {{ $division->name }}
                </td>
                <td class="align-middle">{{ $division->name_short }}</td>
                <td class="align-middle">
                    @can('read division_official')
                        <!-- display details -->
                        <a class="btn btn-secondary btn-sm" href="{{ route('divisions-official.show', $division) }}" title="Spielklasse anzeigen">
                            <span class="fa fa-search-plus"></span>
                        </a>
                    @endcan
                    @can('update division_official')
                        <!-- edit -->
                        <a class="btn btn-primary btn-sm" href="{{ route('divisions-official.edit', $division) }}" title="Spielklasse bearbeiten">
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection