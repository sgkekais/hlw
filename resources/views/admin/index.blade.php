@extends('admin.adminlayout')

@section('content')

        <div class="row">
            <div class="col-12">
                <h3 class="font-weight-bold">In dieser Woche</h3>
                @if($fixtures_this_week)
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
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3 class="font-weight-bold">Noch ohne Ergebnis</h3>
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