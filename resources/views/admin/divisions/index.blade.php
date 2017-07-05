@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1 class="mt-4">Spielklassen</h1>
        <p>
            Verwaltung der Spielklassen.
        </p>
        <div class="row">
            <div class="col-md-3">
                <!-- controls -->
                <a class="btn btn-primary" href="{{ route('divisions.create') }}" title="Spielklasse anlegen">
                    <span class="fa fa-plus-circle"></span> Spielklasse anlegen
                </a>
            </div>
        </div>
        <hr>
        <!-- list all divisions -->
        <h2 class="mt-4">Angelegte Spielklassen <span class="badge badge-default">{{ $divisions->count() }}</span></h2>
        <table class="table table-sm table-striped table-hover">
            <thead class="thead-default">
            <tr>
                <th class="">ID</th>
                <th class="">Name</th>
                <th class="">Hierarchieebene</th>
                <th class="">Veröffentlicht?</th>
                <th class="">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($divisions as $division)
                <tr>
                    <td><b>{{ $division->id }}</b></td>
                    <td>
                        <a href="{{ route('divisions.show', $division ) }}" title="Anzeigen">{{ $division->name }}</a>
                        <br>
                        <span class="text-muted">{{ $division->competition->name }}</span>
                        <br>
                        Saisons: {{ $division->seasons()->get()->count() }}
                    </td>
                    <td>{{ $division->hierarchy_level }}</td>
                    <td>{{ $division->published ? "JA" : "NEIN" }}</td>
                    <td>
                        <!-- display details -->
                        <a class="btn btn-secondary" href="{{ route('divisions.show', $division) }}" title="Spielklasse anzeigen">
                            <span class="fa fa-eye"></span>
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
    </div>
@endsection