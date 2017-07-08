@extends('admin.adminlayout')

@section('content')

    <h1 class="">Wettbewerbe</h1>
    <p>
        Verwaltung der Wettbewerbe.
    </p>
    <div class="row">
        <div class="col-md-3">
            <!-- controls -->
            <a class="btn btn-primary" href="{{ route('competitions.create') }}" title="Wettbewerb anlegen">
                <span class="fa fa-plus-circle"></span> Wettbewerb anlegen
            </a>
        </div>
    </div>
    <hr>
    <!-- list all competitions -->
    <h2 class="mt-4">Angelegte Wettbewerbe <span class="badge badge-default">{{ $competitions->count() }}</span></h2>
        <table class="table table-sm table-striped table-hover">
            <thead class="thead-default">
            <tr>
                <th class="">ID</th>
                <th class="">Name</th>
                <th class="">Veröffentlicht?</th>
                <th class="">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($competitions as $competition)
                <tr>
                    <td><b>{{ $competition->id }}</b></td>
                    <td>
                        <a href="{{ route('competitions.show', $competition ) }}" title="Anzeigen">{{ $competition->name }}</a>
                        <br>Spielklassen: {{ $competition->divisions()->get()->count() }}
                    </td>
                    <td>{{ $competition->published ? "JA" : "NEIN" }}</td>
                    <td>
                        <!-- display details -->
                        <a class="btn btn-secondary" href="{{ route('competitions.show', $competition) }}" title="Wettbewerb anzeigen">
                            <span class="fa fa-eye"></span>
                        </a>
                        <!-- edit -->
                        <a class="btn btn-primary" href="{{ route('competitions.edit', $competition) }}" title="Wettbewerb bearbeiten">
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

@endsection