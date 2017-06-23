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
        <!-- show season details -->
        <h3 class="mt-4">
            Zugeordnete Spielwochen
            <span class="badge badge-default">{{ $season->matchweeks->count() }}</span>
        </h3>
        <div class="row">
            <div class="col-md-12">
                @if($season->matchweeks->count() == 0)
                    <br>
                    <i>Keine Spielwochen zugeordnet</i>
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
                        @foreach($season->matchweeks as $matchweek)
                            <tr>
                                <td><b>{{ $matchweek->id }}</b></td>
                                <td>{{ $matchweek->name }}</td>
                                <td>{{ $matchweek->hierarchy_level }}</td>
                                <td>{{ $matchweek->published ? "Ja" : "Nein" }}</td>
                                <td>
                                    <a class="btn btn-secondary" href="{{ route('seasons.show', $matchweek) }}" title="Spielwoche anzeigen">
                                        <span class="fa fa-eye"></span>
                                    </a>
                                    <a class="btn btn-primary" href="{{ route('seasons.edit', $matchweek) }}" title="Spielwoche bearbeiten">
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
        </div> <!-- ./assigned seasons -->
    </div>
@endsection