@extends('admin.adminlayout')

@section('content')

    <h1 class="">Mannschaften</h1>
    <p>
        Verwaltung der Mannschaften.
    </p>

    <div class="row">
        <div class="col-md-6">
            <!-- controls -->
            @can('create club')
                <a class="btn btn-success" href="{{ route('clubs.create') }}" title="Mannschaft anlegen">
                    <span class="fa fa-plus-square"></span> Mannschaft anlegen
                </a>
            @endcan
        </div>
    </div>
    <hr>
    <!-- list all clubs -->
    <h2 class="mt-4">Angelegte Mannschaften <span class="badge badge-secondary">{{ $clubs->count() }}</span></h2>
        <table class="table table-sm table-striped table-hover " id="clubs">
            <thead class="thead-default">
            <tr>
                <th class="">ID</th>
                <th></th>
                <th></th>
                <th class="">Name</th>
                <th class=""></th>
                <th class="">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clubs as $club)
                <tr>
                    <td class="align-middle"><b>{{ $club->id }}</b></td>
                    <td class="align-middle text-center">
                        @if($club->published)
                            <span class="fa fa-eye" title="Öffentlich"></span>
                        @else
                            <span class="fa fa-eye-slash" title="Nicht öffentlich"></span>
                        @endif
                    </td>
                    <td class="align-middle text-center">
                        @if($club->logo_url)
                            <img src="{{ asset('storage/'.$club->logo_url) }}" class="img-fluid" title="Vereinswappen" alt="Vereinswappen" width="25">
                        @else
                            <span class="fa fa-circle-o"></span>
                        @endif
                    </td>
                    <td class="align-middle">
                        @can('read club')
                            <a href="{{ route('clubs.show', $club ) }}" title="Anzeigen">{{ $club->name }}</a>
                        @else
                            {{ $club->name }}
                        @endcan
                    </td>
                    <td class="align-middle text-center">
                        @if($club->is_real_club)
                            <span class="fa fa-shield text-danger fa-fw" title="Echter Verein"></span>
                        @endif
                    </td>
                    <td class="align-middle">
                        @can('read club')
                            <!-- display details -->
                            <a class="btn btn-secondary btn-sm" href="{{ route('clubs.show', $club) }}" title="Mannschaft anzeigen">
                                <span class="fa fa-search-plus"></span>
                            </a>
                        @endcan
                        @can('update club')
                            <!-- edit -->
                            <a class="btn btn-primary btn-sm" href="{{ route('clubs.edit', $club) }}" title="Mannschaft bearbeiten">
                                <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

@endsection

@section('pagespecificscripts')

    <script type="text/javascript">
        $(document).ready( function () {

            $('#clubs').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
                },
                "order": [[ 3, "asc" ]]
            });

        });
    </script>

@endsection