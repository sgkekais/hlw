@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1 class="mt-4">Details zu Position</h1>
        <h2 class="mt-4 text-primary">&mdash; {{ $position->name }}</h2>

        <div class="row">
            <div class="col-md-6">
                <h3 class="mt-4">Aktionen</h3>
                <a class="btn btn-primary mb-4" href="{{ route('positions.edit', $position ) }}" title="Position bearbeiten">
                    <span class="fa fa-pencil"></span> Bearbeiten
                </a>
            </div>
            <!-- dates -->
            <div class="col-md-6">
                <h3 class="mt-4">Änderungen</h3>
                <!-- published -->
                @if($position->published)
                    <span class="fa fa-eye"></span> Öffentlich
                @else
                    <span class="fa fa-eye-slash"></span> <b>Nicht</b> öffentlich
                @endif
                <br>
                <!-- created at -->
                Angelegt am: {{ $position->created_at->format('d.m.Y H:i') }} Uhr
                @if($causer = ModelHelper::causerOfAction($position,'created'))
                    von {{ $causer->name }}
                @endif
                <br>
                <!-- updated at -->
                @if($position->updated_at != $position->created_at)
                    Geändert am: {{ $position->updated_at->format('d.m.Y H:i') }} Uhr
                    @if($causer = ModelHelper::causerOfAction($position,'updated'))
                        von {{ $causer->name }}
                    @endif
                @endif
            </div>
        </div>
        <hr>
        <h3 class="mt-4 mb-4">Zugeordnete Spieler <span class="badge badge-default">{{ $position->players->count() }}</span></h3>
            <table class="table table-sm table-striped table-hover">
                <thead class="thead-default">
                <tr>
                    <th class="">ID</th>
                    <th class="">Nachname, Vorname</th>
                    <th class="">Mannschaft</th>
                    <th class="">Aktionen</th>
                    <th class="">Änderungen</th>
                </tr>
                </thead>
                <tbody>
                @foreach($position->players as $player)
                    <tr>
                        <td>{{ $player->id }}</td>
                        <td>{{ $player->person->last_name }}, {{ $player->person->first_name }}</td>
                        <td>{{ $player->club->name }}</td>
                        <td>
                            <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('players.edit', $player) }}" title="Spieler bearbeiten">
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                            </td>
                            <td>
                                angelegt am {{ $player->created_at->format('d.m.Y \\u\\m H:i') }} Uhr
                                @if($causer = ModelHelper::causerOfAction($player,'created'))
                                    von {{ $causer->name }}
                                @endif
                                <br>
                                @if($player->updated_at != $player->created_at)
                                    geändert am {{ $player->updated_at->format('d.m.Y \\u\\m H:i') }} Uhr
                                    @if($causer = ModelHelper::causerOfAction($player,'updated'))
                                        von {{ $causer->name }}
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
    </div>
@endsection