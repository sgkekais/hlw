@extends('admin.adminlayout')

@section('content')

    <h1 class="">Positionen</h1>
    <p>
        Verwaltung der Positionen.
    </p>
    <div class="row">
        <div class="col-md-3">
            <!-- controls -->
            @can('create position')
                <a class="btn btn-success" href="{{ route('positions.create') }}" title="Position anlegen">
                    <span class="fa fa-plus-square"></span> Position anlegen
                </a>
            @endcan
        </div>
    </div>
    <hr>
    <!-- list all positions -->
    <h2 class="mt-4">Angelegte Positionen <span class="badge badge-secondary">{{ $positions->count() }}</span></h2>
        <table class="table table-sm table-striped table-hover">
            <thead class="thead-default">
            <tr>
                <th class="">ID</th>
                <th class="">Name</th>
                <th class="">Typ</th>
                <th class="">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($positions as $position)
                <tr>
                    <td><b>{{ $position->id }}</b></td>
                    <td>
                        {{ $position->name }}
                    </td>
                    <td>
                        @if($position->type == "player")
                            Spieler
                        @elseif($position->type == "staff")
                            Stab
                        @endif
                    </td>
                    <td>
                        @can('read position')
                            <!-- display details -->
                            <a class="btn btn-secondary btn-sm" href="{{ route('positions.show', $position) }}" title="Position anzeigen">
                                <span class="fa fa-search-plus"></span>
                            </a>
                        @endcan
                        @can('update position')
                            <!-- edit -->
                            <a class="btn btn-primary btn-sm" href="{{ route('positions.edit', $position) }}" title="Position bearbeiten">
                                <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

@endsection