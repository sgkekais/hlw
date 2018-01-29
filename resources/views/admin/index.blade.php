@extends('admin.adminlayout')

@section('content')

        <div class="row">
            <div class="col-12">
                <h3 class="font-weight-bold">In dieser Woche</h3>
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
        <div class="row">
            <div class="col-md-12">
                <h3 class="font-weight-bold">Ohne Schiedsrichterzuweisung</h3>
                <h5>Zeitraum: {{ $month_begin->format('d.m.Y') }} - {{ $month_end->format('d.m.Y') }}</h5>
                @if(!$fixtures_without_referee->isEmpty())
                    @include('admin._partials.fixtures', ['fixtures' => $fixtures_this_week])
                @else
                    <div class="alert alert-secondary">
                        Keine Partien in diesem Monat.
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3 class="font-weight-bold">Noch ohne Ergebnis</h3>
                <h5>Zurückliegende Partien</h5>
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