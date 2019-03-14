@extends('admin.adminlayout')

@section('content')

    <h1 class="">Wettbewerbe</h1>
    <p>
        Verwaltung der Wettbewerbe.
    </p>
    <div class="row">
        <div class="col-md-3">
            @can('create competition')
                <!-- controls -->
                <a class="btn btn-success" href="{{ route('competitions.create') }}" title="Wettbewerb anlegen">
                    <span class="fa fa-plus-square"></span> Wettbewerb anlegen
                </a>
            @endcan
        </div>
    </div>
    <hr>
    <!-- list all competitions -->
    <h2 class="mt-4">Angelegte Wettbewerbe <span class="badge badge-secondary">{{ $competitions->count() }}</span></h2>
        <table class="table table-sm table-striped table-hover">
            <thead class="thead-default">
            <tr>
                <th class="">ID</th>
                <th class=""></th>
                <th class="">Name</th>
                <th class="">Abk.</th>
                <th class="">Art</th>
                <th class="">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($competitions as $competition)
                <tr>
                    <td class="align-middle"><b>{{ $competition->id }}</b></td>
                    <td class="align-middle">
                        @if($competition->published)
                            <span class="fa fa-eye" title="Öffentlich"></span>
                        @else
                            <span class="fa fa-eye-slash" title="Nicht öffentlich"></span>
                        @endif
                    </td>
                    <td class="align-middle">
                       {{ $competition->name }}
                        <br>Spielklassen: {{ $competition->divisions()->get()->count() }}
                    </td>
                    <td class="align-middle">{{ $competition->name_short }}</td>
                    <td class="align-middle">
                        @if($competition->type == "league")
                            <span class="fa fa-star"></span> Liga
                        @elseif($competition->type == "knockout")
                            <span class="fa fa-trophy"></span> Turnier (K.O.-Modus / Pokal)
                        @elseif($competition->type == "tournament")
                            Turnier Gruppe + K.O.
                        @endif
                    </td>
                    <td class="align-middle">
                       @can('read competition')
                        <!-- display details -->
                        <a class="btn btn-secondary btn-sm" href="{{ route('competitions.show', $competition) }}" title="Wettbewerb anzeigen">
                            <span class="fa fa-search-plus"></span>
                        </a>
                       @endcan
                       @can('update competition')
                        <!-- edit -->
                        <a class="btn btn-primary btn-sm" href="{{ route('competitions.edit', $competition) }}" title="Wettbewerb bearbeiten">
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                       @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

@endsection