@extends('admin.adminlayout')

@section('content')

    <h1 class="">Spielklassen</h1>
    <p>
        Verwaltung der Spielklassen.
    </p>
    <div class="row">
        <div class="col-md-3">
            <!-- controls -->
            <a class="btn btn-success" href="{{ route('divisions.create') }}" title="Spielklasse anlegen">
                <span class="fa fa-plus-square"></span> Spielklasse anlegen
            </a>
        </div>
    </div>
    <hr>
    <!-- list all divisions -->
    <h2 class="mt-4">Angelegte Spielklassen <span class="badge badge-secondary">{{ $divisions->count() }}</span></h2>
    <table class="table table-sm table-striped table-hover">
        <thead class="thead-default">
        <tr>
            <th class="">ID</th>
            <th></th>
            <th class="">Name</th>
            <th class="">Hierarchieebene</th>
            <th class="">Aktionen</th>
        </tr>
        </thead>
        <tbody>
        @foreach($divisions as $division)
            <tr>
                <td class="align-middle"><b>{{ $division->id }}</b></td>
                <td class="align-middle">
                    @if($division->published)
                        <span class="fa fa-eye" title="Öffentlich"></span>
                    @else
                        <span class="fa fa-eye-slash" title="Nicht öffentlich"></span>
                    @endif
                </td>
                <td class="align-middle">
                    <a href="{{ route('divisions.show', $division ) }}" title="Anzeigen">{{ $division->name }}</a>
                    <br>
                    <span class="text-muted">{{ $division->competition->name }}</span>
                    <br>
                    Saisons: {{ $division->seasons()->get()->count() }}
                </td>
                <td class="align-middle">{{ $division->hierarchy_level }}</td>
                <td class="align-middle">
                    <!-- display details -->
                    <a class="btn btn-secondary" href="{{ route('divisions.show', $division) }}" title="Spielklasse anzeigen">
                        <span class="fa fa-search-plus"></span>
                    </a>
                    <!-- edit -->
                    <a class="btn btn-primary" href="{{ route('divisions.edit', $division) }}" title="Spielklasse bearbeiten">
                        <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection