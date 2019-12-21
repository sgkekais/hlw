@extends('layouts.app')

@section('title', '| Ruhmeshalle')

@section('subnav')

     @include('archive.subnav')

@endsection

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h1 class="font-weight-bold font-italic text-uppercase">HLW-Historie</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="accordion pb-4" id="seasons_accordion">
                    {{-- seasons are grouped by 'name', i.e. year --}}
                    @foreach($seasons as $index => $group)
                        <div class="card">
                            <div class="card-header" id="{{ $loop->index }}">
                                <button class="btn btn-link text-dark d-flex w-100 align-content-center justify-content-between" type="button" data-toggle="collapse" data-target="#collapse{{ $loop->index }}" aria-expanded="true" aria-controls="collapse{{ $loop->index }}">
                                    <span class="h4">Jahr {{ $index }}</span>
                                    <span class="h4">
                                        @foreach ($group as $season)

                                            {{ $season->division->name }}&nbsp; {!! !$loop->last ? '&dash; &nbsp;' : null !!}

                                        @endforeach
                                    </span>
                                </button>
                            </div>
                            <div id="collapse{{ $loop->index }}" class="collapse {{ $loop->first ? 'show' : null }}" data-parent="#seasons_accordion">
                                <div class="card-body">
                                    {{-- individual season --}}
                                    @foreach ($group as $season)

                                        @if ($season->type == 'knockout')
                                            <span class="fa fa-fw fa-trophy"></span>
                                        @else
                                            <span class="fa fa-fw fa-star"></span>
                                        @endif
                                        {{ $season->division->name }}
                                        @if (!$loop->last)
                                            <br>
                                        @endif

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


    </div>

@endsection