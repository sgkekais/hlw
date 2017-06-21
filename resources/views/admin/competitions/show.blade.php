@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1 class="mt-4">Details zu Wettbewerb</h1>
        <h2 class="mt-4 text-primary">&mdash; {{ $competition->name }}</h2>
        {{ Route::is('competitions.*') ? 'JA' : 'NEIN' }}
        <div class="row">
            <div class="col-md-4">
                <h3 class="mt-4">Aktionen</h3>
                <a class="btn btn-primary mb-4" href="{{ route('competitions.edit', $competition ) }}" title="Wettbewerb bearbeiten">
                    <span class="fa fa-pencil"></span> Bearbeiten
                </a>
                <a class="btn btn-danger mb-4" href="{{ route('competitions.destroy', $competition) }}" title="Wettbewerb löschen" onclick="event.preventDefault(); document.getElementById('delete-form').submit();">
                    <span class="fa fa-trash"></span> Löschen
                </a>
                <form id="delete-form" action="{{ route('competitions.destroy', $competition) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                </form>
            </div>
            <!-- dates -->
            <div class="col-md-4">
                <h3 class="mt-4">Änderungen</h3>
                Angelegt am: {{ $competition->created_at->format('d.m.Y H:i') }} Uhr
                @if($causer = ModelHelper::causerOfAction($competition,'created'))
                    von {{ $causer->name }}
                @endif
                <br>
                @if($competition->updated_at != $competition->created_at)
                    Geändert am: {{ $competition->updated_at->format('d.m.Y H:i') }} Uhr
                    @if($causer = ModelHelper::causerOfAction($competition,'updated'))
                        von {{ $causer->name }}
                    @endif
                @endif
            </div>
        </div>
        <!-- show competition details -->
        <h3 class="mt-4">
            Zugeordnete Spielklassen
            <span class="badge badge-default">{{ $competition->divisions->count() }}</span>
        </h3>
        <div class="row">
            <div class="col-md-4">
                <a class="btn btn-primary mb-4" href="{{ route('divisions.create') }}" title="Spielklasse anlegen">
                    <span class="fa fa-plus-circle"></span> Spielklasse anlegen
                </a>
            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-4">

            </div>
        </div>
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
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($competition->divisions as $division)
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
        </div> <!-- ./assigned divisions -->
    </div>
@endsection