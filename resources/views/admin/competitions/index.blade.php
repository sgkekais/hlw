@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1 class="mt-4">Wettbewerbe</h1>
        <p>
            Verwaltung der Wettbewerbe.
        </p>
        <div class="row">
            <div class="col-3">
                <!-- controls -->
                <a class="btn btn-primary" href="{{ route('competitions.create') }}" title="Wettbewerb anlegen">
                    <span class="fa fa-plus-circle"></span> Wettbewerb anlegen
                </a>
            </div>
        </div>


        <!-- list all competitions -->
        <h2 class="mt-4">Angelegte Wettbewerbe <span class="badge badge-default">{{ $competitions->count() }}</span></h2>
        <table class="table table-sm table-striped table-hover">
            <thead class="thead-default">
            <tr>
                <th class="">ID</th>
                <th class="">Name</th>
                <th class="">Aktionen</th>
                <th class="">Änderungen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($competitions as $competition)
                <tr>
                    <td><b>{{ $competition->id }}</b></td>
                    <td>
                        <a href="competitions/{{ $competition->id }}" title="Bearbeiten">{{ $competition->name }}</a>
                        <br>Spielklassen: {{ $competition->divisions()->get()->count() }}
                    </td>
                    <td>
                        <a class="btn btn-secondary" href="{{ route('competitions.show', $competition) }}" title="Wettbewerb anzeigen">
                            <span class="fa fa-eye"></span>
                        </a>
                        <a class="btn btn-primary" href="{{ route('competitions.edit', $competition) }}" title="Wettbewerb bearbeiten">
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                    </td>
                    <td>
                        angelegt am {{ $competition->created_at->format('d.m.Y \\u\\m h:i') }} Uhr
                        <br>
                        geändert am {{ $competition->updated_at->format('d.m.Y \\u\\m h:i') }} Uhr
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection