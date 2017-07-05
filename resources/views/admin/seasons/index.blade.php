@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1 class="mt-4">Saisons</h1>
        <p>
            Verwaltung der Saisons.
        </p>
        <div class="row">
            <div class="col-md-3">
                <!-- controls -->
                <a class="btn btn-primary" href="{{ route('seasons.create') }}" title="Saison anlegen">
                    <span class="fa fa-plus-circle"></span> Saison anlegen
                </a>
            </div>
        </div>
        <hr>
        <!-- list all seasons -->
        <h2 class="mt-4">Angelegte Saisons <span class="badge badge-default">{{ $seasons->count() }}</span></h2>
        <table class="table table-sm table-striped table-hover">
            <thead class="thead-default">
            <tr>
                <th class="">ID</th>
                <th class="">Jahr</th>
                <th class="">Veröffentlicht?</th>
                <th class="">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($seasons as $season)
                <tr>
                    <td><b>{{ $season->id }}</b></td>
                    <td>
                        <a href="{{ route('seasons.show', $season ) }}" title="Anzeigen">
                            @if($season->year_begin == $season->year_end)
                                {{ $season->year_begin }}
                            @else
                                {{ $season->year_begin }} / {{ $season->year_end }}
                            @endif
                        </a>
                        <br>
                        <span class="text-muted">{{ $season->division->name }}</span>
                        <br>
                        Spielwochen: {{ $season->matchweeks()->get()->count() }}
                    </td>
                    <td>{{ $season->published ? "JA" : "NEIN" }}</td>
                    <td>
                        <!-- display details -->
                        <a class="btn btn-secondary" href="{{ route('seasons.show', $season) }}" title="Saison anzeigen">
                            <span class="fa fa-eye"></span>
                        </a>
                        <!-- edit -->
                        <a class="btn btn-primary" href="{{ route('seasons.edit', $season) }}" title="Saison bearbeiten">
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection