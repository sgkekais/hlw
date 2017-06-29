@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <h1 class="mt-4">Spielorte</h1>
        <p>
            Verwaltung der Spielorte.
        </p>
        <div class="row">
            <div class="col-md-3">
                <!-- controls -->
                <a class="btn btn-primary" href="{{ route('stadiums.create') }}" title="Spielort anlegen">
                    <span class="fa fa-plus-circle"></span> Spielort anlegen
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
                    <th class="">Name</th>
                    <th class="">Name - kurz</th>
                    <th class="">gmaps?</th>
                    <th class="">Veröffentlicht?</th>
                    <th class="">Aktionen</th>
                    <th class="">Änderungen</th>
                </tr>
                </thead>
                <tbody>
                @foreach($stadiums as $stadium)
                    <tr>
                        <td><b>{{ $stadium->id }}</b></td>
                        <td>
                            <a href="{{ route('stadiums.show', $stadium ) }}" title="Anzeigen">{{ $stadium->name }}</a>
                            <br>Mannschaften: {{ $stadium->clubs()->get()->count() }}
                        </td>
                        <td>{{ $stadium->name_short }}</td>
                        <td>{{ $stadium->gmaps ? "JA" : "NEIN" }}</td>
                        <td>{{ $stadium->published ? "JA" : "NEIN" }}</td>
                        <td>
                            <!-- display details -->
                            <a class="btn btn-secondary" href="{{ route('stadiums.show', $stadium) }}" title="Spielort anzeigen">
                                <span class="fa fa-eye"></span>
                            </a>
                            <!-- edit -->
                            <a class="btn btn-primary" href="{{ route('stadiums.edit', $stadium) }}" title="Spielort bearbeiten">
                                <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                            </a>
                        </td>
                        <td>
                            angelegt am {{ $stadium->created_at->format('d.m.Y \\u\\m H:i') }} Uhr
                            @if($causer = ModelHelper::causerOfAction($stadium,'created'))
                                von {{ $causer->name }}
                            @endif
                            <br>
                            @if($stadium->updated_at != $stadium->created_at)
                                geändert am {{ $stadium->updated_at->format('d.m.Y \\u\\m H:i') }} Uhr
                                @if($causer = ModelHelper::causerOfAction($stadium,'updated'))
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