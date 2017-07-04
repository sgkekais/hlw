@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1 class="mt-4">Details zu Saison</h1>
        <h2 class="mt-4 text-primary">&mdash;
            @if($season->year_begin == $season->year_end)
                {{ $season->year_begin }}
            @else
                {{ $season->year_begin }} / {{ $season->year_end }}
            @endif
            <span class="text-muted">({{ $season->division->name }})</span>
        </h2>

        <div class="row">
            <div class="col-md-6">
                <h3 class="mt-4">Aktionen</h3>
                <a class="btn btn-primary mb-4" href="{{ route('seasons.edit', $season ) }}" title="Saison bearbeiten">
                    <span class="fa fa-pencil"></span> Bearbeiten
                </a>
                <a class="btn btn-primary mb-4" href="{{ route('seasons.matchweeks.create', $season ) }}" title="Spielwoche hinzufügen">
                    <span class="fa fa-pencil"></span> Spielwoche hinzufügen
                </a>
                <a class="btn btn-primary mb-4" href="{{ route('createClubAssignment', $season ) }}" title="Mannschaft zuordnen">
                    <span class="fa fa-pencil"></span> Mannschaft zuordnen
                </a>
            </div>
            <!-- dates -->
            <div class="col-md-6">
                <h3 class="mt-4">Änderungen</h3>
                <!-- published -->
                @if($season->published)
                    <span class="fa fa-eye"></span> Öffentlich
                @else
                    <span class="fa fa-eye-slash"></span> <b>Nicht</b> öffentlich
                @endif
                <br>
                <!-- created at -->
                Angelegt am: {{ $season->created_at->format('d.m.Y H:i') }} Uhr
                @if($causer = ModelHelper::causerOfAction($season,'created'))
                    von {{ $causer->name }}
                @endif
                <br>
                <!-- updated at -->
                @if($season->updated_at != $season->created_at)
                    Geändert am: {{ $season->updated_at->format('d.m.Y H:i') }} Uhr
                    @if($causer = ModelHelper::causerOfAction($season,'updated'))
                        von {{ $causer->name }}
                    @endif
                @endif
            </div>
        </div>
        <hr>
        <h3 class="mt-4 mb-4">Zuordnungen</h3>
        <!-- show season tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#matchweeks" role="tab">Spielwochen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#clubs" role="tab">Mannschaften</a>
            </li>
        </ul>
        <!-- show club details -->
        <div class="tab-content">
            <div class="tab-pane active" id="matchweeks" role="tabpanel">
                <!-- show season details -->
                <h4 class="mt-4">
                    Zugeordnete Spielwochen
                    <span class="badge badge-default">{{ $season->matchweeks->count() }}</span>
                </h4>
                @if($season->matchweeks->count() == 0)
                    <br>
                    <i>Keine Spielwochen zugeordnet</i>
                @else
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
                        @foreach($season->matchweeks as $matchweek)
                            <tr>
                                <td><b>{{ $matchweek->id }}</b></td>
                                <td>
                                    <a href="{{ route('seasons.matchweeks.show', [$season, $matchweek]) }}" title="Anzeigen">{{ $matchweek->number_consecutive }}</a>
                                    <br>
                                    Paarungen: {{ $matchweek->fixtures()->get()->count() }}
                                </td>
                                <td>{{ $matchweek->name }}</td>
                                <td>{{ $matchweek->published ? "JA" : "NEIN" }}</td>
                                <td>
                                    <!-- display details -->
                                    <a class="btn btn-secondary" href="{{ route('seasons.matchweeks.show', [$season, $matchweek]) }}" title="Spielwoche anzeigen">
                                        <span class="fa fa-eye"></span>
                                    </a>
                                    <!-- edit -->
                                    <a class="btn btn-primary" href="{{ route('seasons.matchweeks.edit', [$season, $matchweek]) }}" title="Spielwoche bearbeiten">
                                        <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                    </a>
                                </td>
                                <td>
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
                @endif
            </div>
            <!-- assigned clubs -->
            <div class="tab-pane" id="clubs" role="tabpanel">
                <h4 class="mt-4">
                    Zugeordnete Mannschaften
                    <span class="badge badge-default">{{ $season->clubs->count() }}</span>
                </h4>
                @if($season->clubs->count() == 0)
                    <br>
                    <i>Bisher sind keine Mannschaften zugeordnet</i>
                @else
                    <table class="table table-sm table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th class="">ID</th>
                            <th class="">Name</th>
                            <th class="">Rang</th>
                            <th class="">Punktabzug</th>
                            <th class="">Torabzug</th>
                            <th class="">Ausgeschieden?</th>
                            <th>Aktionen</th>
                            <th>Änderungen</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($season->clubs as $clubs)
                            <tr>
                                <td><b>{{ $matchweek->id }}</b></td>
                                <td>
                                    <a href="{{ route('seasons.matchweeks.show', [$season, $matchweek]) }}" title="Anzeigen">{{ $matchweek->number_consecutive }}</a>
                                    <br>
                                    Paarungen: {{ $matchweek->fixtures()->get()->count() }}
                                </td>
                                <td>{{ $matchweek->name }}</td>
                                <td>{{ $matchweek->published ? "JA" : "NEIN" }}</td>
                                <td>
                                    <!-- display details -->
                                    <a class="btn btn-secondary" href="{{ route('seasons.matchweeks.show', [$season, $matchweek]) }}" title="Spielwoche anzeigen">
                                        <span class="fa fa-eye"></span>
                                    </a>
                                    <!-- edit -->
                                    <a class="btn btn-primary" href="{{ route('seasons.matchweeks.edit', [$season, $matchweek]) }}" title="Spielwoche bearbeiten">
                                        <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                    </a>
                                </td>
                                <td>
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
                @endif
            </div>
    </div>
@endsection