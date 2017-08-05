@extends('admin.adminlayout')

@section('content')

    <h1 class="">Spielorte</h1>
    <p>
        Verwaltung der Spielorte.
    </p>
    <!-- CSV Modal -->
    <div class="modal fade" id="csvImport" tabindex="-1" role="dialog" aria-labelledby="csvImportLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Spielort(e) importieren</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="csvupload" class="" method="POST" action="{{ route('stadiums.import') }}" enctype="multipart/form-data">
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
        <div class="col-md-3">
            <!-- controls -->
            <a class="btn btn-success" href="{{ route('stadiums.create') }}" title="Spielort anlegen">
                <span class="fa fa-plus-square"></span> Spielort anlegen
            </a>
            <a class="btn btn-secondary" href="#" data-toggle="modal" data-target="#csvImport">
                <span class="fa fa-file-excel-o"></span> Spielort-Import
            </a>
        </div>
    </div>
    <hr>
    <!-- list all stadiums -->
    <h2 class="mt-4">Angelegte Spielorte <span class="badge badge-default">{{ $stadiums->count() }}</span></h2>
        <table class="table table-sm table-striped table-hover">
            <thead class="thead-default">
            <tr>
                <th class="">ID</th>
                <th></th>
                <th class="">Name</th>
                <th class="">Name - kurz</th>
                <th></th>
                <th class="">Aktionen</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stadiums as $stadium)
                <tr>
                    <td class="align-middle"><b>{{ $stadium->id }}</b></td>
                    <td class="align-middle">
                        @if($stadium->published)
                            <span class="fa fa-eye" title="Öffentlich"></span>
                        @else
                            <span class="fa fa-eye-slash" title="Nicht öffentlich"></span>
                        @endif
                    </td>
                    <td class="align-middle">
                        <a href="{{ route('stadiums.show', $stadium ) }}" title="Anzeigen">{{ $stadium->name }}</a>
                        <br>Mannschaften: {{ $stadium->clubs->count() }}
                    </td>
                    <td class="align-middle">{{ $stadium->name_short }}</td>
                    <td class="align-middle">
                        @if($stadium->gmaps)
                            <span class="fa fa-map-marker fa-fw" title="Google Maps Link vorhanden"></span>
                            @else
                            <span class="fa fa-fw"></span>
                        @endif
                        @if($stadium->note)
                            <span class="fa fa-file-text fa-fw" title="Notiz vorhanden"></span>
                        @endif
                    </td>
                    <td class="align-middle">
                        <!-- display details -->
                        <a class="btn btn-secondary" href="{{ route('stadiums.show', $stadium) }}" title="Spielort anzeigen">
                            <span class="fa fa-search-plus"></span>
                        </a>
                        <!-- edit -->
                        <a class="btn btn-primary" href="{{ route('stadiums.edit', $stadium) }}" title="Spielort bearbeiten">
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

@endsection