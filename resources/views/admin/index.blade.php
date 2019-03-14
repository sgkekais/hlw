@extends('admin.adminlayout')

@section('content')

    <a class="btn btn-outline-secondary" href="#nextweeks" role="button">Nächste zwei Wochen <span class="badge badge-primary">{{ $fixtures_this_week->count() }}</span></a>
    <a class="btn btn-outline-secondary" href="#noref" role="button">Ohne Schiedsrichter <span class="badge badge-primary">{{ $fixtures_without_referee->count() }}</span></a>
    <a class="btn btn-outline-secondary" href="#noresult" role="button">Ohne Ergebnis <span class="badge badge-primary">{{ $fixtures_without_result->count() }}</span></a>
    <hr>
    <div class="row" id="nextweeks">
        <div class="col-12">
            <h3 class="font-weight-bold">In den nächsten zwei Wochen <span class="badge badge-secondary">{{ $fixtures_this_week->count() }}</span></h3>
            <h5>Zeitraum: {{ $monday->format('d.m.Y') }} - {{ $sunday->format('d.m.Y') }}</h5>
            @if(!$fixtures_this_week->isEmpty())
                @include('admin._partials.fixtures', ['fixtures' => $fixtures_this_week])
            @else
                <div class="alert alert-secondary">
                    Keine Partien in dieser Woche.
                </div>
            @endif
        </div>
    </div>
    <div class="row" id="noref">
        <div class="col-12">
            <h3 class="font-weight-bold">Ohne Schiedsrichterzuweisung <span class="badge badge-secondary">{{ $fixtures_without_referee->count() }}</span></h3>
            <h5>Zeitraum immer nächste 30 Tage ab Montag der aktuellen Woche: {{ $monday->format('d.m.Y') }} - {{ $in_thirty_days->format('d.m.Y') }}</h5>
            @if(!$fixtures_without_referee->isEmpty())
                @include('admin._partials.fixtures', ['fixtures' => $fixtures_without_referee])
            @else
                <div class="alert alert-secondary">
                    Keine Partien in diesem Monat.
                </div>
            @endif
        </div>
    </div>
    <div class="row" id="noresult">
        <div class="col-12">
            <h3 class="font-weight-bold">Noch ohne Ergebnis <span class="badge badge-secondary">{{ $fixtures_without_result->count() }}</span></h3>
            <h5>Zurückliegende Partien (in diesem Jahr)</h5>
            @if($fixtures_without_result)
                @include('admin._partials.fixtures', ['fixtures' => $fixtures_without_result])
            @else
                <div class="alert alert-secondary">
                    Keine Partien in dieser Woche.
                </div>
            @endif
        </div>
    </div>

@endsection