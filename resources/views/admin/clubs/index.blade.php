@extends('admin.adminlayout')

@section('content')

    <h1 class="">Mannschaften</h1>
    <p>
        Verwaltung der Mannschaften.
    </p>
    <!-- CSV Modal -->
    <div class="modal fade" id="csvImport" tabindex="-1" role="dialog" aria-labelledby="csvImportLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Mannschaften importieren</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="csvupload" class="" method="POST" action="{{ route('clubs.import') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="csvfile">CSV-Datei</label>
                            </div>
                            <div class="col-md-4">
                                <input type="file" class="form-control-file" name="csvfile" id="csvfile" aria-describedby="csvfileHelp">
                                <small id="csvfileHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-ban"></span> Schließen</button>
                    <button type="button" class="btn btn-success" onclick="event.preventDefault();
                                             document.getElementById('csvupload').submit();">
                        <span class="fa fa-upload"></span> Hochladen
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- controls -->
            <a class="btn btn-success" href="{{ route('clubs.create') }}" title="Mannschaft anlegen">
                <span class="fa fa-plus-square"></span> Mannschaft anlegen
            </a>
            <a class="btn btn-secondary" data-toggle="modal" data-target="#csvImport">
                <span class="fa fa-file-excel-o"></span> Import
            </a>
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
                        <a href="{{ route('clubs.show', $club ) }}" title="Anzeigen">{{ $club->name }}</a>
                    </td>
                    <td class="align-middle text-center">
                        @if($club->is_real_club)
                            <span class="fa fa-shield text-danger fa-fw" title="Echter Verein"></span>
                        @endif
                    </td>
                    <td class="align-middle">
                        <!-- display details -->
                        <a class="btn btn-secondary" href="{{ route('clubs.show', $club) }}" title="Mannschaft anzeigen">
                            <span class="fa fa-search-plus"></span>
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