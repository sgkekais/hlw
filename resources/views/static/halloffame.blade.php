@extends('layouts.app')

@section('title')

    | Ruhmeshalle

@endsection

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h1 class="font-weight-bold font-italic text-uppercase">Ruhmeshalle</h1>
                <p class="text-muted">
                    Ehre, wem Ehre gebührt.
                </p>
            </div>
        </div>
        <div class="row mt-1 mb-4">
            <div class="col">
                <ul class="list-group">
                    @if (!$former_clubs->isEmpty())
                        @foreach ($former_clubs as $club)
                            <li class="list-group-item d-flex justify-content-between ">
                                <div class="col-4 text-left">
                                    <a href="{{ route('frontend.clubs.show', $club) }}" title="Teamdetails">{{ $club->name }}</a>
                                </div>
                                <div class="col-3 text-center text-md-right">
                                    {{ $club->league_exit->format('d.m.Y') }} -
                                    {{ $club->league_entry->format('d.m.Y') }}
                                </div>
                                <div class="col-5 text-left w-50">
                                    @if (!$club->championships->isEmpty())
                                        @foreach ($club->championships()->orderBy('end','desc')->get()->groupBy('type') as $championship_competitions)
                                            @foreach ($championship_competitions as $championship)
                                                @php
                                                    $class = null;
                                                    $color = null;
                                                @endphp
                                                @if ($championship->type == "league")
                                                    @php
                                                        if ($championship->division->hierarchy_level == 1) {
                                                            $class = "fa-star";
                                                            $color = "orange";
                                                        } else {
                                                            $class = "fa-star-half-o";
                                                            $color = "grey";
                                                        }
                                                    @endphp
                                                @elseif ($championship->type == "knockout")
                                                    @php
                                                        $class = "fa-trophy";
                                                        $color = "orange";
                                                    @endphp
                                                @endif
                                                <span class="fa fa-lg {{ $class }}" style="color: {{ $color }}" title="{{ $championship->name }} {{ $championship->division->name }}"></span>
                                            @endforeacH
                                        @endforeach
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>

@endsection