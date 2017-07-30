@extends('admin.adminlayout')

@section('content')

    <h1 class="">Details zu Schiedsrichter</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $referee->person->last_name }}, {{ $referee->person->first_name }}</h2>
    <div class="row">
        <div class="col-md-6">
            <h3 class="mt-4">Aktionen</h3>
            <a class="btn btn-primary mb-4" href="{{ route('referees.edit', $referee ) }}" title="Schiedsrichter bearbeiten">
                <span class="fa fa-pencil"></span> Bearbeiten
            </a>
        </div>
        <!-- dates -->
        <div class="col-md-6">
            <h3 class="mt-4">Änderungen</h3>
            <!-- created at -->
            Angelegt am: {{ $referee->created_at->format('d.m.Y H:i') }} Uhr
            @if($causer = ModelHelper::causerOfAction($referee,'created'))
                von {{ $causer->name }}
            @endif
            <br>
            <!-- updated at -->
            @if($referee->updated_at != $referee->created_at)
                Geändert am: {{ $referee->updated_at->format('d.m.Y H:i') }} Uhr
                @if($causer = ModelHelper::causerOfAction($referee,'updated'))
                    von {{ $causer->name }}
                @endif
            @endif
        </div>
    </div>
    <hr>
    <!-- show referee details -->
    <h3 class="mt-4">
        Zugeordnete Paarungen
        <span class="badge badge-default">{{ $referee->fixtures->count() }}</span>
    </h3>
    <div class="row">
        <div class="col-md-12">
            @if($referee->fixtures->count() == 0)
                <br>
                <i>Keine Paarungen zugeordnet</i>
            @else
                <table class="table table-sm table-striped table-hover">
                    <thead class="thead-default">
                    <tr>
                        <th class="">ID</th>
                        <th></th>
                        <th class="">Name</th>
                        <th class="">Hierarchieebene</th>
                        <th class="">Aktionen</th>
                    </tr>
                    </thead>
                    <tbody>

                </table>
            @endif
        </div>
    </div> <!-- ./assigned fixtures -->

@endsection