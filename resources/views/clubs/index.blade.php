@extends('layouts.app')

@section('title')
    | {{ $season->name }} | Teams
@endsection

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

    <div class="container py-4">
        <h1 class="font-weight-bold font-italic">TEAMS der Saison {{ $season->name }}</h1>
        <div class="row mt-4 d-flex justify-content-center">
            <div class="col">
                <div class="card-deck">
                    @foreach($clubs as $club)
                        <div class="card text-center">
                            <div class="card-header px-1">
                                <h4 class="text-uppercase font-weight-bold my-0">
                                    <a href="{{ route('frontend.clubs.show', $club) }}" class="text-dark" title="Mannschaftsdetails">{{ $club->name }}</a>
                                </h4>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-center" style="background-color: {{ $club->colours_club_primary }};">
                                <a href="{{ route('frontend.clubs.show', $club) }}">
                                    @if ($club->logo_url)
                                        <img class="card-img w-75" src="{{ Storage::url($club->logo_url) }}" title="{{ $club->name }}" alt="Vereinswappen">
                                    @else
                                        <span class="fa fa-ban text-muted fa-5x"></span>
                                    @endif
                                </a>
                            </div>
                            @if ($club->regularStadium->first())
                                <div class="card-body py-1">
                                    @svg('arena', ['class' => 'align-middle pr-1', 'style' => 'fill: #343a40', 'width' => '25', 'height' => '25'])
                                    {{ $club->regularStadium->first()->name_short }}
                                </div>
                            @endif
                            <div class="card-footer py-1">
                                @if ($club->championships()->count() > 0)
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
                                                        $color = "orange";
                                                    }
                                                @endphp
                                            @elseif ($championship->type == "knockout")
                                                @php
                                                    $class = "fa-trophy";
                                                    $color = "orange";
                                                @endphp
                                            @endif
                                            <span class="fa fa-lg {{ $class }}" style="color: {{ $color }}" data-toggle="tooltip" title="{{ $championship->name }} | {{ $championship->division->name }}"></span>
                                        @endforeacH
                                    @endforeach
                                @else
                                    &nbsp;
                                @endif
                            </div>
                        </div>
                        @if ($loop->iteration % 2 == 0)
                            <div class="w-100 my-2 d-block d-md-none"><!-- wrap every 2 below md --></div>
                        @endif
                        @if ($loop->iteration % 3 == 0)
                            <div class="w-100 my-2 d-none d-md-block d-lg-none"><!-- wrap every 3 at md --></div>
                        @endif
                        @if ($loop->iteration % 4 == 0)
                            <div class="w-100 my-2 d-none d-lg-block"><!-- wrap every 4 above md --></div>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>
    </div>

@endsection

@section('js-footer')

    <script type="text/javascript">
        $(function() {

            // activate tooltips for this page
            $("body").tooltip({
                selector: '[data-toggle="tooltip"]'
            });

        });
    </script>

@endsection