@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1 class="mt-4">Details zu Spielklasse</h1>
        <h2 class="mt-4 text-primary">&mdash; {{ $division->name }}</h2>

        <div class="row">
            <div class="col-md-6">
                <h3 class="mt-4">Aktionen</h3>
                <a class="btn btn-primary mb-4" href="{{ route('divisions.edit', $division ) }}" title="Spielklasse bearbeiten">
                    <span class="fa fa-pencil"></span> Bearbeiten
                </a>
            </div>
            <!-- dates -->
            <div class="col-md-6">
                <h3 class="mt-4">Änderungen</h3>
                <!-- published -->
                @if($division->published)
                    <span class="fa fa-eye"></span> Öffentlich
                @else
                    <span class="fa fa-eye-slash"></span> <b>Nicht</b> öffentlich
                @endif
                <br>
                <!-- created at -->
                Angelegt am: {{ $division->created_at->format('d.m.Y H:i') }} Uhr
                @if($causer = ModelHelper::causerOfAction($division,'created'))
                    von {{ $causer->name }}
                @endif
                <br>
                <!-- updated at -->
                @if($division->updated_at != $division->created_at)
                    Geändert am: {{ $division->updated_at->format('d.m.Y H:i') }} Uhr
                    @if($causer = ModelHelper::causerOfAction($division,'updated'))
                        von {{ $causer->name }}
                    @endif
                @endif
            </div>
        </div>
        <!-- show division details -->
        <h3 class="mt-4">
            Zugeordnete Saisons
            <span class="badge badge-default">{{ $division->seasons->count() }}</span>
        </h3>
        <div class="row">
            <div class="col-md-12">
                @if($division->seasons->count() == 0)
                    <br>
                    <i>Keine Saisons zugeordnet</i>
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
                        @foreach($division->divisions as $division)
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
        </div> <!-- ./assigned seasons -->
    </div>
@endsection