@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1 class="mt-4">Spielklassen</h1>
        <p>
            Verwaltung der Spielklassen.
        </p>
        <div class="row">
            <div class="col-md-3">
                <!-- controls -->
                <a class="btn btn-primary" href="{{ route('divisions.create') }}" title="Spielklasse anlegen">
                    <span class="fa fa-plus-circle"></span> Spielklasse anlegen
                </a>
            </div>
        </div>
        <hr>
        <!-- list all divisions -->
        <h2 class="mt-4">Angelegte Spielklassen <span class="badge badge-default">{{ $divisions->count() }}</span></h2>
        <table class="table table-sm table-striped table-hover">
            <thead class="thead-default">
            <tr>
                <th class="">ID</th>
                <th class="">Name</th>
                <th class="">Hierarchieebene</th>
                <th class="">Veröffentlicht?</th>
                <th class="">Aktionen</th>
                <th class="">Änderungen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($divisions as $division)
                <tr>
                    <td><b>{{ $division->id }}</b></td>
                    <td>
                        <a href="{{ route('divisions.show', $division ) }}" title="Anzeigen">{{ $division->name }}</a>
                        <br>
                        <span class="text-muted">{{ $division->competition->name }}</span>
                        <br>
                        Saisons: {{ $division->seasons()->get()->count() }}
                    </td>
                    <td>{{ $division->hierarchy_level }}</td>
                    <td>{{ $division->published ? "JA" : "NEIN" }}</td>
                    <td>
                        <!-- display details -->
                        <a class="btn btn-secondary" href="{{ route('divisions.show', $division) }}" title="Spielklasse anzeigen">
                            <span class="fa fa-eye"></span>
                        </a>
                        <!-- edit -->
                        <a class="btn btn-primary" href="{{ route('divisions.edit', $division) }}" title="Spielklasse bearbeiten">
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                        <!-- delete -->
                        <a class="btn btn-danger" href="{{ route('divisions.destroy', $division->id) }}" title="Spielklasse löschen" onclick="event.preventDefault(); document.getElementById('delete-form{{ $division->id }}').submit();">
                            <span class="fa fa-trash"></span>
                        </a>
                        <form id="delete-form{{ $division->id }}" action="{{ route('divisions.destroy', $division->id) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                    </td>
                    <td>
                        angelegt am {{ $division->created_at->format('d.m.Y \\u\\m H:i') }} Uhr
                        @if($causer = ModelHelper::causerOfAction($division,'created'))
                            von {{ $causer->name }}
                        @endif
                        <br>
                        @if($division->updated_at != $division->created_at)
                            geändert am {{ $division->updated_at->format('d.m.Y \\u\\m H:i') }} Uhr
                            @if($causer = ModelHelper::causerOfAction($division,'updated'))
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