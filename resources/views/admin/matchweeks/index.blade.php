@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1 class="mt-4">Spielwochen</h1>
        <p>
            Verwaltung der Spielwochen.
        </p>
        <div class="row">
            <div class="col-md-3">
                <!-- controls -->
                @can('create matchweek')
                    <a class="btn btn-primary" href="{{ route('matchweeks.create') }}" title="Spielwoche anlegen">
                        <span class="fa fa-plus-circle"></span> Spielwoche anlegen
                    </a>
                @endcan
            </div>
        </div>
        <hr>
        <!-- list all matchweeks -->
        <h2 class="mt-4">Angelegte Spielwochen <span class="badge badge-secondary">{{ $matchweeks->count() }}</span></h2>
        <table class="table table-sm table-striped table-hover">
            <thead class="thead-default">
            <tr>
                <th class="">ID</th>
                <th class="">Nummer</th>
                <th class="">Name</th>
                <th class="">Veröffentlicht?</th>
                <th class="">Aktionen</th>
                <th class="">Änderungen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($matchweeks as $matchweek)
                <tr>
                    <td class="align-middle"><b>{{ $matchweek->id }}</b></td>
                    <td class="align-middle">
                        <a href="{{ route('matchweeks.show', $matchweek ) }}" title="Anzeigen">{{ $matchweek->number_consecutive }}</a>
                        <br>
                        <span class="text-muted">
                            {{ $matchweek->season->year_begin }} /
                            {{ $matchweek->season->year_end }}
                            {{ $matchweek->season->division->name }}
                        </span>
                        <br>
                        Paarungen: {{ $matchweek->fixtures()->get()->count() }}
                    </td>
                    <td class="align-middle">{{ $matchweek->name }}</td>
                    <td class="align-middle">{{ $matchweek->published ? "JA" : "NEIN" }}</td>
                    <td class="align-middle">
                        @can('read matchweek')
                            <!-- display details -->
                            <a class="btn btn-secondary btn-sm" href="{{ route('matchweeks.show', $matchweek) }}" title="Spielwoche anzeigen">
                                <span class="fa fa-eye"></span>
                            </a>
                        @endcan
                        @can('update matchweek')
                            <!-- edit -->
                            <a class="btn btn-primary btn-sm" href="{{ route('matchweeks.edit', $matchweek) }}" title="Spielwoche bearbeiten">
                                <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                            </a>
                        @endcan
                    </td>
                    <td class="align-middle">
                        angelegt am {{ $matchweek->created_at->format('d.m.Y \\u\\m H:i') }} Uhr
                        @if($causer = ModelHelper::causerOfAction($matchweek,'created'))
                            von {{ $causer->name }}
                        @endif
                        <br>
                        @if($matchweek->updated_at != $matchweek->created_at)
                            geändert am {{ $matchweek->updated_at->format('d.m.Y \\u\\m H:i') }} Uhr
                            @if($causer = ModelHelper::causerOfAction($matchweek,'updated'))
                                von {{ $causer->name }}
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection