@extends('admin.adminlayout')

@section('content')

    <h1 class="">Mannschaften</h1>
    <p>
        Verwaltung der Mannschaften.
    </p>
    <div class="row">
        <div class="col-md-3">
            <!-- controls -->
            <a class="btn btn-primary" href="{{ route('clubs.create') }}" title="Mannschaft anlegen">
                <span class="fa fa-plus-circle"></span> Mannschaft anlegen
            </a>
        </div>
    </div>
    <hr>
    <!-- list all clubs -->
    <h2 class="mt-4">Angelegte Mannschaften <span class="badge badge-default">{{ $clubs->count() }}</span></h2>
        <table class="table table-sm table-striped table-hover ">
            <thead class="thead-default">
            <tr>
                <th class="">ID</th>
                <th></th>
                <th class="">Name</th>
                <th class="">Echter Verein?</th>
                <th class="">Veröffentlicht?</th>
                <th class="">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clubs as $club)
                <tr>
                    <td><b>{{ $club->id }}</b></td>
                    <td class="align-middle text-center">
                        @if($club->logo_url)
                            <img src="{{ Storage::url($club->logo_url) }}" class="w-25 img-fluid" title="Vereinswappen" alt="Vereinswappen">
                        @else
                            <span class="fa fa-circle-o"></span>
                        @endif
                    </td>
                    <td class="align-middle">
                        <a href="{{ route('clubs.show', $club ) }}" title="Anzeigen">{{ $club->name }}</a>
                        <br>Spieler: {{ $club->players()->get()->count() }}
                    </td>
                    <td>{{ $club->is_real_club ? "JA" : null }}</td>
                    <td>{{ $club->published ? "JA" : "NEIN" }}</td>
                    <td>
                        <!-- display details -->
                        <a class="btn btn-secondary" href="{{ route('clubs.show', $club) }}" title="Mannschaft anzeigen">
                            <span class="fa fa-eye"></span>
                        </a>
                        <!-- edit -->
                        <a class="btn btn-primary" href="{{ route('clubs.edit', $club) }}" title="Mannschaft bearbeiten">
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

@endsection