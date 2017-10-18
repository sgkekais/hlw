@extends('layouts.app')

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

    <div class="container">
        <h2 class="mt-4">
            <b>Aktuelle Teams der {{ $season->division->name }}</b>
        </h2>
        <hr>
        <h3>Saison {{ $season->begin ? $season->begin->format('Y') : null }} {{ $season->end ? "/ ".$season->end->format('Y') : null }}</h3>
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
                                2 <span class="fa fa-star" style="color: orange"></span>
                                <span class="fa fa-star-half-full"></span>
                                <span class="fa fa-trophy"></span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        @endforeach

        <hr>
        <h3>Alle Teams der {{ $season->division->name }}</h3>

    </div>



@endsection