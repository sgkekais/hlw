@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1 class="mt-4">Details zu Spielwoche</h1>
        <h2 class="mt-4 text-primary">&mdash; {{ $matchweek->number_consecutive }} {{ $matchweek->name ? '- '.$matchweek->name : null }}</h2>

        <div class="row">
            <div class="col-md-6">
                <h3 class="mt-4">Aktionen</h3>
                <a class="btn btn-primary mb-4" href="{{ route('seasons.matchweeks.edit', [$matchweek->season,$matchweek]) }}" title="Spielwoche bearbeiten">
                    <span class="fa fa-pencil"></span> Bearbeiten
                </a>
                <a class="btn btn-primary mb-4" href="{{ route('fixtures.create') }}" title="Paarung hinzufügen">
                    <span class="fa fa-pencil"></span> Paarung hinzufügen
                </a>
            </div>
            <!-- dates -->
            <div class="col-md-6">
                <h3 class="mt-4">Änderungen</h3>
                <!-- published -->
                @if($matchweek->published)
                    <span class="fa fa-eye"></span> Öffentlich
                @else
                    <span class="fa fa-eye-slash"></span> <b>Nicht</b> öffentlich
                @endif
                <br>
                <!-- created at -->
                Angelegt am: {{ $matchweek->created_at->format('d.m.Y H:i') }} Uhr
                @if($causer = ModelHelper::causerOfAction($matchweek,'created'))
                    von {{ $causer->name }}
                @endif
                <br>
                <!-- updated at -->
                @if($matchweek->updated_at != $matchweek->created_at)
                    Geändert am: {{ $matchweek->updated_at->format('d.m.Y H:i') }} Uhr
                    @if($causer = ModelHelper::causerOfAction($matchweek,'updated'))
                        von {{ $causer->name }}
                    @endif
                @endif
            </div>
        </div>
        <hr>
        <!-- show matchweek details -->
        <h3 class="mt-4">
            Zugeordnete Paarungen
            <span class="badge badge-default">{{ $matchweek->fixtures->count() }}</span>
        </h3>
        <div class="row">
            <div class="col-md-12">
                @if($matchweek->fixtures->count() == 0)
                    <br>
                    <i>Keine Paarungen zugeordnet</i>
                @else
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th class="">ID</th>
                            <th class="">Jahr</th>
                            <th class="">Veröffentlicht?</th>
                            <th class="">Aktionen</th>
                            <th class="">Änderungen</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($matchweek->fixtures as $fixture)
                            <tr>
                                <td><b>{{ $fixture->id }}</b></td>
                                <td>
                                    <a href="{{ route('fixtures.show', $fixture ) }}" title="Anzeigen">
                                        @if($fixture->year_begin == $fixture->year_end)
                                            {{ $fixture->year_begin }}
                                        @else
                                            {{ $fixture->year_begin }} / {{ $fixture->year_end }}
                                        @endif
                                    </a>
                                    <br>
                                    <span class="text-muted">{{ $fixture->matchweek->name }}</span>
                                    <br>
                                    Spielwochen: {{ $fixture->matchweeks()->get()->count() }}
                                </td>
                                <td>{{ $fixture->published ? "JA" : "NEIN" }}</td>
                                <td>
                                    <!-- display details -->
                                    <a class="btn btn-secondary" href="{{ route('fixtures.show', $fixture) }}" title="Saison anzeigen">
                                        <span class="fa fa-eye"></span>
                                    </a>
                                    <!-- edit -->
                                    <a class="btn btn-primary" href="{{ route('fixtures.edit', $fixture) }}" title="Saison bearbeiten">
                                        <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                    </a>
                                </td>
                                <td>
                                    angelegt am {{ $fixture->created_at->format('d.m.Y \\u\\m H:i') }} Uhr
                                    @if($causer = ModelHelper::causerOfAction($fixture,'created'))
                                        von {{ $causer->name }}
                                    @endif
                                    <br>
                                    @if($fixture->updated_at != $fixture->created_at)
                                        geändert am {{ $fixture->updated_at->format('d.m.Y \\u\\m H:i') }} Uhr
                                        @if($causer = ModelHelper::causerOfAction($fixture,'updated'))
                                            von {{ $causer->name }}
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div> <!-- ./assigned seasons -->
    </div>
@endsection