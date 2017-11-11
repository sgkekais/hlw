@extends('layouts.app')

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

    <div class="container">
        <h2 class="mt-4 font-weight-bold">Aktuelle Teams der {{ $season->division->name }}</h2>
        <h3 class="text-muted">Saison {{ $season->begin ? $season->begin->format('Y') : null }} {{ $season->end ? "/ ".$season->end->format('Y') : null }}</h3>
        @foreach($clubs->chunk(4) as $chunk)
            <div class="row mt-4 p-0 justify-content-center">
                <div class="card-deck w-100">
                    @foreach($chunk as $club)
                        <div class="card text-center">
                            <div class="card-header">
                                <span class="text-uppercase"><b>{{ $club->name }}</b></span>
                            </div>
                            <div class="card-body" style="background-color: {{ $club->colours_club_primary }};">
                                <a href="{{ route('frontend.clubs.show', $club) }}">
                                    @if($club->logo_url)
                                        <img class="card-img w-75" src="{{ Storage::url($club->logo_url) }}" title="{{ $club->name }}" alt="Vereinswappen">
                                    @else
                                        <span class="fa fa-ban text-muted fa-5x"></span>
                                    @endif
                                </a>
                            </div>
                            <div class="card-footer">
                                @if($club->championships()->count() > 0)
                                    @foreach($club->championships()->orderBy('end','desc')->get() as $championship)
                                        @php
                                            if ($championship->division->hierarchy_level == 1) {
                                                $class = "fa-star";
                                                $color = "orange";
                                            } else {
                                                $class = "fa-star-half-o";
                                                $color = "grey";
                                            }
                                        @endphp
                                        <span class="fa fa-lg {{ $class }}" style="color: {{ $color }}" title="{{ $championship->begin && $championship->end ? $championship->begin->format('Y')." / ".$championship->end->format('Y') : null }} {{ $championship->division->name }}"></span>
                                    @endforeach
                                @else
                                    &nbsp;
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

@endsection