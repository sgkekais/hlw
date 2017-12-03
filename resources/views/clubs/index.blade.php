@extends('layouts.app')

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

    <div class="container pt-4">
        <h1 class="font-weight-bold font-italic">TEAMS der Saison {{ $season->name }}</h1>

        @foreach($clubs->chunk(4) as $chunk)
            <div class="row mt-4 p-0 justify-content-center">
                <div class="card-deck w-100">
                    @foreach($chunk as $club)
                        <div class="card text-center">
                            <div class="card-header ">
                                <h4 class="text-uppercase">{{ $club->name }}</h4>
                            </div>
                            <div class="card-body" style="background-color: {{ $club->colours_club_primary }};">
                                <a href="{{ route('frontend.clubs.show', $club) }}">
                                    @if ($club->logo_url)
                                        <img class="card-img w-75" src="{{ Storage::url($club->logo_url) }}" title="{{ $club->name }}" alt="Vereinswappen">
                                    @else
                                        <span class="fa fa-ban text-muted fa-5x"></span>
                                    @endif
                                </a>
                            </div>
                            <div class="card-footer">
                                @if ($club->championships()->count() > 0)
                                    @foreach ($club->championships()->orderBy('end','desc')->get() as $championship)
                                        @php
                                            $class = null;
                                            $color = null;
                                        @endphp
                                        @if ($division->competition->isLeague())
                                            @php
                                                if ($championship->division->competition->isLeague()) {
                                                    if ($championship->division->hierarchy_level == 1) {
                                                        $class = "fa-star";
                                                        $color = "orange";
                                                    } else {
                                                        $class = "fa-star-half-o";
                                                        $color = "grey";
                                                    }
                                                }
                                            @endphp
                                        @elseif ($division->competition->isKnockout())
                                            @php
                                                if ($championship->division->competition->isKnockout()) {
                                                    $class = "fa-trophy";
                                                    $color = "orange";
                                                }
                                            @endphp
                                        @endif
                                        <span class="fa fa-lg {{ $class }}" style="color: {{ $color }}" title="{{ $championship->name }} {{ $championship->division->name }}"></span>
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