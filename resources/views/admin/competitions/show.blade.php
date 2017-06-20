@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <!-- show competition details -->
        <h1 class="mt-4">Details zu Wettbewerb:</h1>
        <h2 class="mt-4">{{ $competition->name }}</h2>
        Bla

        <h3 class="mt-4">
            Zugeordnete Spielklassen
            <span class="badge badge-default">{{ $competition->divisions->count() }}</span>
        </h3>
        <a class="btn btn-primary mb-4" href="{{ route('divisions.create') }}" title="Spielklasse anlegen">
            <span class="fa fa-plus-circle"></span> Spielklasse anlegen
        </a>
        @if($competition->divisions->count() == 0)
            <br>
            <i>Keine Spielklassen zugeordnet</i>
        @else
            <table class="table table-sm table-striped table-hover">
                <thead class="thead-default">
                <tr>
                    <th class="">ID</th>
                    <th class="">Name</th>
                    <th class="">Hierarchieebene</th>
                    <th class="">Öffentlich?</th>
                    <th class="">Aktionen</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($competition->divisions as $division)
                        <tr>
                            <td><b>{{ $division->id }}</b></td>
                            <td>{{ $division->name }}</td>
                            <td>{{ $division->hierarchy_level }}</td>
                            <td>{{ $division->published ? "Ja" : "Nein" }}</td>
                            <td>
                                <a class="btn btn-secondary" href="{{ route('divisions.show', $division) }}" title="Spielklasse anzeigen">
                                    <span class="fa fa-eye"></span>
                                </a>
                                <a class="btn btn-primary" href="{{ route('divisions.edit', $division) }}" title="Spielklasse bearbeiten">
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                            </td>
                            <td>

                            </td>
                        </tr>
                    @endforeach
            </table>
        @endif


    </div>
@endsection