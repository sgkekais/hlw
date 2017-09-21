@extends('layouts.app')

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

    <div class="container">
        @foreach($clubs->chunk(4) as $chunk)

            <div class="row mt-4 justify-content-center">
                <div class="card-deck w-100 m-1">
                    @foreach($chunk as $club)

                        <div class="card text-center m-1">
                            <div class="card-header">
                                <span class="text-uppercase"><b>{{ $club->name }}</b></span>
                            </div>
                            <div class="card-body" style="background-color: {{ $club->colours_club_primary }};">
                                @if($club->logo_url)
                                    <img class="card-img w-75" src="{{ Storage::url($club->logo_url) }}" title="{{ $club->name }}" alt="Vereinswappen">
                                @else
                                    <span class="fa fa-ban text-muted fa-5x"></span>
                                @endif
                            </div>
                            <div class="card-footer">
                                <a href="#" class="card-link">Profil</a>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>

        @endforeach
    </div>



@endsection