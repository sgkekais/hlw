@extends('admin.adminlayout')

@section('content')

    <h1 class="">Details zu Saison</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $season->begin->format('d.m.Y') }} bis {{ $season->end->format('d.m.Y') }} <span class="text-muted">({{ $season->division->name }} - {{ $season->division->competition->name }})</span>
    </h2>
    <div class="row">
        <div class="col-md-6">
            <h3 class="mt-4">Aktionen</h3>
                <a class="btn btn-primary mb-2" href="{{ route('seasons.edit', $season ) }}" title="Saison bearbeiten">
                    <span class="fa fa-pencil"></span> Saison bearbeiten
                </a>
            <br>
                <a class="btn btn-secondary" href="{{ route('seasons.matchweeks.create', $season ) }}" title="Spielwoche hinzufügen">
                    <span class="fa fa-plus-square"></span> Spielwoche
                </a>
                <a class="btn btn-secondary" href="{{ route('createClubAssignment', $season ) }}" title="Mannschaft zuordnen">
                    <span class="fa fa-plus-square"></span> Mannschaft
                </a>
        </div>
        <!-- dates -->
        <div class="col-md-6">
            <h3 class="mt-4">Änderungen</h3>
            <!-- published -->
            @if($season->published)
                <span class="fa fa-eye"></span> Öffentlich
            @else
                <span class="fa fa-eye-slash"></span> <b>Nicht</b> öffentlich
            @endif
            <br>
            <!-- created at -->
            Angelegt am: {{ $season->created_at->format('d.m.Y H:i') }} Uhr
            @if($causer = ModelHelper::causerOfAction($season,'created'))
                von {{ $causer->name }}
            @endif
            <br>
            <!-- updated at -->
            @if($season->updated_at != $season->created_at)
                Geändert am: {{ $season->updated_at->format('d.m.Y H:i') }} Uhr
                @if($causer = ModelHelper::causerOfAction($season,'updated'))
                    von {{ $causer->name }}
                @endif
            @endif
        </div>
    </div>
    <hr>
    <h3 class="mt-4 mb-4">Zuordnungen</h3>
    <!-- show season tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#matchweeks" role="tab">
                Spielwochen
                <span class="badge badge-pill badge-default">{{ $season->matchweeks->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#clubs" role="tab">
                Mannschaften
                <span class="badge badge-pill badge-default">{{ $season->clubs->count() }}</span></a>
        </li>
    </ul>
    <!-- show club details -->
    <div class="tab-content">
        <div class="tab-pane active" id="matchweeks" role="tabpanel">
            <!-- show season details -->
            <h4 class="mt-4">
                Zugeordnete Spielwochen
            </h4>
            @if($season->matchweeks->count() == 0)
                <br>
                <i>Keine Spielwochen zugeordnet</i>
            @else
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th></th>
                        <th class="">Nummer</th>
                        <th class="">Zeitraum</th>
                        <th class="">Name</th>
                        <th class="">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($season->matchweeks as $matchweek)
                        <tr>
                            <td class="align-middle"><b>{{ $matchweek->id }}</b></td>
                            <td class="align-middle">
                                @if($matchweek->published)
                                    <span class="fa fa-eye" title="Öffentlich"></span>
                                @else
                                    <span class="fa fa-eye-slash" title="Nicht öffentlich"></span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <a href="{{ route('seasons.matchweeks.show', [$season, $matchweek]) }}" title="Anzeigen">{{ $matchweek->number_consecutive }}</a>
                                <br>
                                Paarungen: {{ $matchweek->fixtures()->get()->count() }}
                            </td>
                            <td class="align-middle">{{ $matchweek->begin->format('d.m.Y') ?? null }} - {{ $matchweek->end->format('d.m.Y') ?? null }}</td>
                            <td class="align-middle">{{ $matchweek->name }}</td>
                            <td class="align-middle">
                                <!-- display details -->
                                <a class="btn btn-secondary" href="{{ route('seasons.matchweeks.show', [$season, $matchweek]) }}" title="Spielwoche anzeigen">
                                    <span class="fa fa-search-plus"></span>
                                </a>
                                <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('seasons.matchweeks.edit', [$season, $matchweek]) }}" title="Spielwoche bearbeiten">
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <!-- assigned clubs -->
        <div class="tab-pane" id="clubs" role="tabpanel">
            <h4 class="mt-4">
                Zugeordnete Mannschaften
            </h4>
            @if($season->clubs->count() == 0)
                <br>
                <i>Bisher sind keine Mannschaften zugeordnet</i>
            @else
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th class="">Name</th>
                        <th class="text-center"><span class="fa fa-calendar-plus-o" title="Spielverlegungen"></span> </th>
                        <th class="">Rang</th>
                        <th class="">Punktabzug</th>
                        <th class="">Torabzug</th>
                        <th class="">Ausgeschieden</th>
                        <th></th>
                        <th class="">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($season->clubs as $club)
                        <tr>
                            <td class="align-middle"><b>{{ $club->id }}</b></td>
                            <td class="align-middle">
                                <a href="{{ route('clubs.show', $club) }}" title="Mannschaft anzeigen">{{ $club->name }}</a>
                            </td>
                            <td class="align-middle text-center">
                                {{ $club->reschedulings()->where('reschedule_count','1')->get()->count() }}
                            </td>
                            <td class="align-middle">{{ $club->pivot->rank }}</td>
                            <td class="align-middle">{{ $club->pivot->deduction_points }}</td>
                            <td class="align-middle">{{ $club->pivot->deduction_goals }}</td>
                            <td class="align-middle">{{ $club->pivot->withdrawal }}</td>
                            <td class="align-middle">
                                @if($club->pivot->note)
                                    <span class="fa fa-file-text" title="Notiz vorhanden"></span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <!-- edit -->
                                <a class="btn btn-primary" href="{{ route('editClubAssignment',[$season,$club]) }}" title="Zuordnung bearbeiten">
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>

@endsection