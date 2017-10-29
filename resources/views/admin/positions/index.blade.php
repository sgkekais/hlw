@extends('admin.adminlayout')

@section('content')

    <h1 class="">Positionen</h1>
    <p>
        Verwaltung der Positionen.
    </p>
    <div class="row">
        <div class="col-md-3">
            <!-- controls -->
            <a class="btn btn-success" href="{{ route('positions.create') }}" title="Position anlegen">
                <span class="fa fa-plus-square"></span> Position anlegen
            </a>
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
                            <span class="fa fa-search-plus"></span>
                        </a>
                        <!-- edit -->
                        <a class="btn btn-primary" href="{{ route('positions.edit', $position) }}" title="Position bearbeiten">
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

@endsection