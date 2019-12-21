@extends('layouts.app')

@section('title', '| Ruhmeshalle')

@section('subnav')

    @include('archive.subnav')

@endsection

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h1 class="font-weight-bold font-italic text-uppercase">Ruhmeshalle</h1>
                <p class="text-muted">
                    <span class="badge badge-primary">{{ $champions->count() }}</span> Titelträger. Ehre, wem Ehre gebührt.
                </p>
            </div>
        </div>
        <div class="row mt-1 mb-4">
            <div class="col">
                <ul class="list-group">
                    @if (!$champions->isEmpty())
                        <li class="list-group-item d-flex justify-content-between font-weight-bold">
                            <div class="col text-left">
                                <span class="fa fa-shield" title="Verein"></span>
                            </div>
                        </li>
                        @foreach ($champions as $club)
                            <li class="list-group-item d-flex justify-content-between {{ $loop->iteration % 2 == 0 ? 'bg-light' : null }}">
                                <div class="col text-left">
                                    <div class="d-flex align-content-center">
                                        <a href="{{ route('frontend.clubs.show', $club) }}" class="text-dark" title="Teamdetails">{{ $club->name }}</a>
                                        &nbsp;
                                        <span class="badge badge-pill badge-warning align-self-center">
                                            {{ $club->championships_count }} Titel
                                        </span>
                                    </div>
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
                                                        $class = "fa-star";
                                                        $color = "grey";
                                                    }
                                                @endphp
                                            @elseif ($championship->type == "knockout")
                                                @php
                                                    $class = "fa-trophy";
                                                    $color = "orange";
                                                @endphp
                                            @endif
                                            <span class="fa fa-lg {{ $class }} " data-toggle="tooltip" style="color: {{ $color }}" title="{{ $championship->name }} {{ $championship->division->name }}"></span>
                                        @endforeach
                                    @endforeach

                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>

@endsection

@section('js-footer')

    <script type="text/javascript">
        $(document).ready(function() {

            // activate tooltips for this page
            $("body").tooltip({
                selector: '[data-toggle="tooltip"]'
            });

        });
    </script>

@endsection