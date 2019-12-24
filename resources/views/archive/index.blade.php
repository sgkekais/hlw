@extends('layouts.app')

@section('title', '| Ruhmeshalle')

@section('subnav')

     @include('archive.subnav')

@endsection

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h1 class="font-weight-bold font-italic text-uppercase">Historie</h1>
                <ul class="nav nav-pills nav-fill d-flex flex-column flex-md-row">
                    <li class="nav-item mt-2 mt-md-0">
                        <a class="nav-link border border-success rounded" href="#divisionen">Divisionen</a>
                    </li>
                    <li class="nav-item ml-md-2 mt-2 mt-md-0">
                        <a class="nav-link border border-success rounded" href="#chronik">Chronik</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h2 id="divisionen" class="font-weight-bold font-italic text-uppercase">Divisionen</h2>

                @foreach($divisions as $division)
                    <div class="h4 font-weight-bold text-uppercase">{{ $division->name }}</div>
                    <div class="alert alert-light">
                        <ul class="list-unstyled p-0 m-0">
                            <li>
                                <span class="fa fa-fw fa-calendar"></span><a class="" href="{{ route('frontend.divisions.fixtures', $division) }}"> Alle <strong>Spielpläne</strong> dieser Division aufrufen</a>
                            </li>
                            <li>
                                <span class="fa fa-fw fa-list-ol"></span><a class="" href="{{ route('frontend.divisions.tables', $division) }}"> Alle <strong>Tabellen</strong> dieser Division aufrufen</a>
                            </li>
                            <li>
                                <span class="fa fa-fw fa-soccer-ball-o"></span><a class="" href="{{ route('frontend.divisions.scorers', $division) }}"> Alle <strong>Torjäger</strong> dieser Division aufrufen</a>
                            </li>
                            <li>
                                <span class="fa fa-fw fa-thumbs-o-down"></span><a class="" href="{{ route('frontend.divisions.sinners', $division) }}"> Alle <strong>Sünder</strong> dieser Division aufrufen</a>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h2 id="chronik" class="font-weight-bold font-italic text-uppercase">Chronik</h2>

                <div class="accordion pb-4" id="seasons_accordion">
                    {{-- seasons are grouped by 'name', i.e. year --}}
                    @foreach($seasons as $index => $group)
                        <div class="card">
                            <div class="card-header" id="{{ $loop->index }}">
                                <button class="btn btn-link text-dark d-flex w-100 align-content-center justify-content-between" type="button" data-toggle="collapse" data-target="#collapse{{ $loop->index }}" aria-expanded="true" aria-controls="collapse{{ $loop->index }}">
                                    <span class="h4 font-weight-bold text-uppercase">Jahr {{ $index }}</span>
                                    <span class="h5">
                                        @foreach ($group->sortBy('division.name') as $season)

                                            {{ $season->division->name }}&nbsp; {!! !$loop->last ? '&dash; &nbsp;' : null !!}

                                        @endforeach
                                    </span>
                                </button>
                            </div>
                            <div id="collapse{{ $loop->index }}" class="collapse" data-parent="#seasons_accordion">
                                <div class="card-body">
                                    {{-- individual season --}}
                                    @foreach ($group->sortBy('division.name') as $season)

                                        @if ($season->type == 'knockout')
                                            <span class="fa fa-fw fa-trophy text-warning"></span>
                                        @else
                                            <span class="fa fa-fw fa-star text-warning"></span>
                                        @endif
                                        <span class="h5 font-weight-bold text-primary"> {{ $season->division->name }}</span>

                                            <div class="alert alert-secondary">
                                                <div class="d-flex ">
                                                    @isset($season->matchweeks_count)
                                                        <div class="pr-3"><span class="font-weight-bold">{{ $season->matchweeks_count }}</span> Spielwochen</div>
                                                    @endisset
                                                    @isset($season->clubs_count)
                                                        <div class="pr-3"><span class="font-weight-bold">{{ $season->clubs_count }}</span> Teilnehmer</div>
                                                    @endisset
                                                    @isset($season->fixtures_count)
                                                        <div class="pr-3"><span class="font-weight-bold">{{ $season->fixtures_count }}</span> Paarungen</div>
                                                    @endisset
                                                </div>
                                                @isset($season->rules)
                                                    {{ $season->rules }}
                                                @endisset
                                            </div>

                                        @isset($season->champion)
                                            <h5>Meister / Pokalsieger: <span class="font-weight-bold">{{ $season->champion->name }}</span></h5>

                                        @endisset

                                        @isset($season->clubs_count)
                                            @if($season->clubs_count > 0)
                                                <table class="table table-sm table-striped">
                                                    <thead>
                                                    <tr>
                                                        @if($season->type == 'league')
                                                            <th scope="col" class="col-1">Platz</th>
                                                        @endif
                                                        <th scope="col">Team</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if($season->type == 'league')
                                                        @foreach($season->clubs->sortBy('pivot.rank') as $club)
                                                            <tr>
                                                                <th scope="row">{{ $club->pivot->rank }}</th>
                                                                <td>{{ $club->name }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        @foreach($season->clubs->sortBy('name') as $club)
                                                            <tr>
                                                                @if($season->type == 'league')
                                                                    <th scope="row">{{ $club->pivot->rank }}</th>
                                                                @endif
                                                                <td>{{ $club->name }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                    </tbody>
                                                </table>
                                            @endif
                                        @endisset

                                        @if (!$loop->last)
                                            <hr>
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