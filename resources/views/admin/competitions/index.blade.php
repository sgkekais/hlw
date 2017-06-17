@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1>Wettbewerbe</h1>
        <!-- controls -->
        <a href="competitions/create" title="Wettbewerb hinzufügen">
            <button type="button" class="btn btn-primary">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Wettbewerb hinzufügen
            </button>
        </a>
        <hr>
        <!-- list all competitions -->
        <h2>Angelegte Wettbewerbe <span class="badge">{{ $competitions->count() }}</span></h2>
        <table class="table table-condensed table-striped table-hover">
            <thead>
            <tr>
                <th class="col-md-1">ID</th>
                <th class="col-md-2">Name</th>
                <th class="col-md-2">Aktionen</th>
                <th class="col-md-2"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($competitions as $competition)
                <tr>
                    <td>{{ $competition->id }}</td>
                    <td>
                        <a href="competitions/{{ $competition->id }}" title="Bearbeiten">{{ $competition->name }}</a>
                        <br>Spielklassen: {{ $competition->divisions()->get()->count() }}
                    </td>
                    <td>
                        <a href="competitions/{{ $competition->id }}">
                            <button type="button" class="btn btn-default">
                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                            </button>
                        </a>
                        <a href="competitions/{{ $competition->id }}/edit">
                            <button type="button" class="btn btn-primary ">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </button>
                        </a>
                    </td>
                    <td>
                        {{ $competition->created_at->format('d.m.Y \\u\\m h:i') }} Uhr
                        <br>
                        {{ $competition->updated_at->format('d.m.Y \\u\\m h:i') }} Uhr
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection