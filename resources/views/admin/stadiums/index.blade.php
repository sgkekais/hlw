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
                    <th class="">Adresse?</th>
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
                            <br>Spielklassen: {{ $stadium->divisions()->get()->count() }}
                        </td>
                        <td>{{ $stadium->published ? "JA" : "NEIN" }}</td>
                        <td>
                            <!-- display details -->
                            <a class="btn btn-secondary" href="{{ route('stadiums.show', $stadium) }}" title="Wettbewerb anzeigen">
                                <span class="fa fa-eye"></span>
                            </a>
                            <!-- edit -->
                            <a class="btn btn-primary" href="{{ route('stadiums.edit', $stadium) }}" title="Wettbewerb bearbeiten">
                                <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                            </a>
                            <!-- delete
                            <a class="btn btn-danger" href="{{ route('stadiums.destroy', $stadium->id) }}" title="Wettbewerb löschen" onclick="event.preventDefault(); document.getElementById('delete-form{{ $stadium->id }}').submit();">
                                <span class="fa fa-trash"></span>
                            </a>
                            <form id="delete-form{{ $stadium->id }}" action="{{ route('stadiums.destroy', $stadium->id) }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>-->
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