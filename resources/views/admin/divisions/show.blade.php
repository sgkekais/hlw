@extends('admin.adminlayout')

@section('content')

    <h1 class="">Details zu Spielklasse</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $division->name }}</h2>

    <div class="row">
        <div class="col-md-6">
            <h3 class="mt-4">Aktionen</h3>
            <a class="btn btn-primary mb-4" href="{{ route('divisions.edit', $division ) }}" title="Spielklasse bearbeiten">
                <span class="fa fa-pencil"></span> Bearbeiten
            </a>
        </div>
        <!-- dates -->
        <div class="col-md-6">
            <h3 class="mt-4">Änderungen</h3>
            <!-- published -->
            @if($division->published)
                <span class="fa fa-eye"></span> Öffentlich
            @else
                <span class="fa fa-eye-slash"></span> <b>Nicht</b> öffentlich
            @endif
            <br>
            <!-- created at -->
            Angelegt am: {{ $division->created_at->format('d.m.Y H:i') }} Uhr
            @if($causer = ModelHelper::causerOfAction($division,'created'))
                von {{ $causer->name }}
            @endif
            <br>
            <!-- updated at -->
            @if($division->updated_at != $division->created_at)
                Geändert am: {{ $division->updated_at->format('d.m.Y H:i') }} Uhr
                @if($causer = ModelHelper::causerOfAction($division,'updated'))
                    von {{ $causer->name }}
                @endif
            @endif
        </div>
    </div>
    <hr>
    <!-- show division details -->
    <h3 class="mt-4">
        Zugeordnete Saisons
        <span class="badge badge-default">{{ $division->seasons->count() }}</span>
    </h3>
    <div class="row">
        <div class="col-md-12">
            @if($division->seasons->count() == 0)
                <br>
                <i>Keine Saisons zugeordnet</i>
            @else
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th></th>
                        <th class="">Jahr</th>
                        <th class="">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($division->seasons as $season)
                        <tr>
                            <td class="align-middle"><b>{{ $season->id }}</b></td>
                            <td class="align-middle">
                                @if($season->published)
                                    <span class="fa fa-eye" title="Öffentlich"></span>
                                @else
                                    <span class="fa fa-eye-slash" title="Nicht öffentlich"></span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <a href="{{ route('seasons.show', $season ) }}" title="Anzeigen">
                                    {{ $season->begin->format('d.m.Y') }} bis {{ $season->end->format('d.m.Y') }}
                                </a>
                                <br>
                                <span class="text-muted">{{ $season->division->name }}</span>
                                <br>
                                Spielwochen: {{ $season->matchweeks()->get()->count() }}
                            </td>
                            <td class="align-middle">
                                <!-- display details -->
                                <a class="btn btn-secondary" href="{{ route('seasons.show', $season) }}" title="Saison anzeigen">
                                    <span class="fa fa-search-plus"></span>
                                </a>
                                <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('seasons.edit', $season) }}" title="Saison bearbeiten">
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div> <!-- ./assigned seasons -->

@endsection