@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1 class="mt-4">Positionen</h1>
        <p>
            Verwaltung der Positionen.
        </p>
        <div class="row">
            <div class="col-md-3">
                <!-- controls -->
                <a class="btn btn-primary" href="{{ route('positions.create') }}" title="Position anlegen">
                    <span class="fa fa-plus-circle"></span> Position anlegen
                </a>
            </div>
        </div>
        <hr>
        <!-- list all positions -->
        <h2 class="mt-4">Angelegte Positionen <span class="badge badge-default">{{ $positions->count() }}</span></h2>
            <table class="table table-sm table-striped table-hover">
                <thead class="thead-default">
                <tr>
                    <th class="">ID</th>
                    <th class="">Name</th>
                    <th class="">Typ</th>
                    <th class="">Aktionen</th>
                    <th class="">Änderungen</th>
                </tr>
                </thead>
                <tbody>
                @foreach($positions as $position)
                    <tr>
                        <td><b>{{ $position->id }}</b></td>
                        <td>
                            <a href="{{ route('positions.show', $position ) }}" title="Anzeigen">{{ $position->name }}</a>

                        </td>
                        <td>
                            @if($position->type == "player")
                                Spieler
                            @elseif($position->type == "staff")
                                Stab
                            @endif
                        </td>
                        <td>
                            <!-- display details -->
                            <a class="btn btn-secondary" href="{{ route('positions.show', $position) }}" title="Position anzeigen">
                                <span class="fa fa-eye"></span>
                            </a>
                            <!-- edit -->
                            <a class="btn btn-primary" href="{{ route('positions.edit', $position) }}" title="Position bearbeiten">
                                <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                            </a>
                        </td>
                        <td>
                            angelegt am {{ $position->created_at->format('d.m.Y \\u\\m H:i') }} Uhr
                            @if($causer = ModelHelper::causerOfAction($position,'created'))
                                von {{ $causer->name }}
                            @endif
                            <br>
                            @if($position->updated_at != $position->created_at)
                                geändert am {{ $position->updated_at->format('d.m.Y \\u\\m H:i') }} Uhr
                                @if($causer = ModelHelper::causerOfAction($position,'updated'))
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