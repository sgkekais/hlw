@extends('admin.adminlayout')

@section('content')

    <h1 class="">Details zu Wettbewerb</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $competition->name }}</h2>
    <h3 class="text-muted">
        @if($competition->type == "league")
            <span class="fa fa-star"></span> Liga
        @elseif($competition->type == "knockout")
            <span class="fa fa-trophy"></span> Turnier (K.O.-Modus / Pokal)
        @elseif($competition->type == "tournament")
            <span class="fa fa-trophy"></span> Turnier Gruppe + K.O.
        @endif
    </h3>
    <div class="row">
        <div class="col-md-6">
            <h3 class="mt-4">Aktionen</h3>
            <a class="btn btn-primary mb-4" href="{{ route('competitions.edit', $competition ) }}" title="Wettbewerb bearbeiten">
                <span class="fa fa-pencil"></span> Bearbeiten
            </a>
        </div>
        <!-- dates -->
        <div class="col-md-6">
            <h3 class="mt-4">Änderungen</h3>
            <!-- published -->
            @if($competition->published)
                <span class="fa fa-eye"></span> Öffentlich
            @else
                <span class="fa fa-eye-slash"></span> <b>Nicht</b> öffentlich
            @endif
            <br>
            <!-- created at -->
            Angelegt am: {{ $competition->created_at->format('d.m.Y H:i') }} Uhr
            @if($causer = ModelHelper::causerOfAction($competition,'created'))
                von {{ $causer->name }}
            @endif
            <br>
            <!-- updated at -->
            @if($competition->updated_at != $competition->created_at)
                Geändert am: {{ $competition->updated_at->format('d.m.Y H:i') }} Uhr
                @if($causer = ModelHelper::causerOfAction($competition,'updated'))
                    von {{ $causer->name }}
                @endif
            @endif
        </div>
    </div>
    <hr>
    <!-- show competition details -->
    <h3 class="mt-4">
        Zugeordnete Spielklassen
        <span class="badge badge-default">{{ $competition->divisions->count() }}</span>
    </h3>
    <div class="row">
        <div class="col-md-12">
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
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($competition->divisions as $division)
                        <tr>
                            <td><b>{{ $division->id }}</b></td>
                            <td>
                                <a href="{{ route('divisions.show', $division) }}">
                                    {{ $division->name }}
                                </a>
                            </td>
                            <td>{{ $division->hierarchy_level }}</td>
                            <td>{{ $division->published ? "Ja" : "Nein" }}</td>
                            <td>
                                <a class="btn btn-secondary" href="{{ route('divisions.show', $division) }}" title="Spielklasse anzeigen">
                                    <span class="fa fa-search-plus"></span>
                                </a>
                                <a class="btn btn-primary" href="{{ route('divisions.edit', $division) }}" title="Spielklasse bearbeiten">
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div> <!-- ./assigned divisions -->

@endsection