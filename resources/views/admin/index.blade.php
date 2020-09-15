@extends('admin.adminlayout')

@section('content')

    <div class="row">
        <div class="col">
            <h3 class="font-weight-bold">Aktive Saisons</h3>
            <div class="row">
                @foreach($current_seasons as $current_season)
                    <div class="col col-sd-6">
                        <div class="border border-secondary rounded bg-light p-2">
                            <div class="row">
                                <div class="col-10">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="text-success">{{ $current_season->division->competition->name_short }} - <strong>{{ $current_season->division->name }}</strong></h5>
                                            ID <strong>{{ $current_season->id }}</strong> - <strong>{{ $current_season->season_nr }}</strong>. Saison
                                            <br>
                                            {{ Carbon::createFromTimeString($current_season->begin)->format('d.m.y') }} bis  {{ Carbon::createFromTimeString($current_season->end)->format('d.m.y') }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            {{ $current_season->clubs()->count() }} Teams | {{ $current_season->matchweeks->count() }} Spielwochen | {{ $current_season->fixtures->count() }} Spiele <br>
                                            <ul class="m-0">
                                                <li>davon {{ $current_season->fixtures()->playedOrRated()->count() }} gespielt <br></li>
                                                <li>davon {{ $current_season->fixtures()->rated()->count() }} gewertet <br></li>
                                                <li>{{ $current_season->fixtures()->notCancelled(true)->count() }} Spiele wurden anulliert</li>
                                                <li>{{ $current_season->fixtures()->whereNotNull('rescheduled_from_fixture_id')->count() }} Spiele wurden verlegt</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col d-flex justify-content-end align-content-end">
                                    @can('read season')
                                        <a class="btn btn-secondary btn-sm" href="{{ route('seasons.show', $current_season) }}" title="Saison anzeigen">
                                            <span class="fa fa-search-plus" aria-hidden="true"></span>
                                        </a>
                                    @endcan
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <hr>
    <div class="row mt-2">
        <div class="col">
            <h4 class="font-weight-bold">Springe zu:</h4>
            <a class="btn btn-outline-secondary" href="#nextweeks" role="button">Nächste zwei Wochen <span class="badge badge-primary">{{ $fixtures_this_week->count() }}</span></a>
            <a class="btn btn-outline-secondary" href="#noref" role="button">Ohne Schiedsrichter <span class="badge badge-primary">{{ $fixtures_without_referee->count() }}</span></a>
            <a class="btn btn-outline-secondary" href="#rescheduled" role="button">Nachhol- / Verlegte Spiele <span class="badge badge-primary">{{ $fixtures_rescheduled->count() }}</span></a>
            <a class="btn btn-outline-secondary" href="#noresult" role="button">Ohne Ergebnis <span class="badge badge-primary">{{ $fixtures_without_result->count() }}</span></a>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <div class="alert alert-dark">
                Angezeigt werden nur Spiele, die veröffentlicht und nicht anulliert sind.
                <br>
                Altherren-Spiele aktuell ausgeblendet.
            </div>
        </div>
    </div>
    <div class="row" id="nextweeks">
        <div class="col-12">
            <h4 class="font-weight-bold">In den nächsten zwei Wochen <span class="badge badge-secondary">{{ $fixtures_this_week->count() }}</span></h4>
            <h5>Zeitraum: {{ $monday->format('d.m.Y') }} - {{ $sunday->format('d.m.Y') }}</h5>
            @if(!$fixtures_this_week->isEmpty())
                @include('admin._partials.fixtures', ['fixtures' => $fixtures_this_week, 'id' => 'fixtures_this_week'])
            @else
                <div class="alert alert-secondary">
                    Keine Partien in dieser Woche.
                </div>
            @endif
        </div>
    </div>
    <div class="row" id="noref">
        <div class="col-12">
            <h4 class="font-weight-bold">Ohne Schiedsrichterzuweisung <span class="badge badge-secondary">{{ $fixtures_without_referee->count() }}</span></h4>
            <h5>Zeitraum immer nächste 30 Tage ab Montag der aktuellen Woche: {{ $monday->format('d.m.Y') }} - {{ $in_thirty_days->format('d.m.Y') }}</h5>
            @if(!$fixtures_without_referee->isEmpty())
                @include('admin._partials.fixtures', ['fixtures' => $fixtures_without_referee, 'id' => 'fixtures_without_referee'])
            @else
                <div class="alert alert-secondary">
                    Keine Partien in diesem Monat.
                </div>
            @endif
        </div>
    </div>
    <div class="row" id="rescheduled">
        <div class="col-12">
            <h4 class="font-weight-bold">Nachholspiele / Verlegte Spiele <span class="badge badge-secondary">{{ $fixtures_rescheduled->count() }}</span></h4>
            <h5></h5>
            @if(!$fixtures_rescheduled->isEmpty())
                @include('admin._partials.fixtures', ['fixtures' => $fixtures_rescheduled, 'id' => 'fixtures_rescheduled'])
            @else
                <div class="alert alert-secondary">
                    Keine Partien .
                </div>
            @endif
        </div>
    </div>
    @hasanyrole('super_admin|admin')
        <div class="row" id="noresult">
            <div class="col-12">
                <h4 class="font-weight-bold">Nachholspiele / Noch ohne Ergebnis <span class="badge badge-secondary">{{ $fixtures_without_result->count() }}</span></h4>
                <h5>Zurückliegende Partien (in diesem Jahr)</h5>
                @if($fixtures_without_result)
                    @include('admin._partials.fixtures', ['fixtures' => $fixtures_without_result, 'id' => 'fixtures_without_result'])
                @else
                    <div class="alert alert-secondary">
                        Keine Partien in dieser Woche.
                    </div>
                @endif
            </div>
        </div>
    @endrole

@endsection