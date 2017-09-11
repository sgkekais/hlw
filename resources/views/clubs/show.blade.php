@extends('layouts.app')

@section('content')


<div class="container-fluid pt-4" style="background: url({{ $club->cover_url ? Storage::url($club->cover_url) : Storage::url('public/clubcovers/_default.jpg') }}) repeat-x">
    <!-- cover -->
    <div class="row mx-auto" style="width: 1140px;">
        <div class="col-md-auto" style="min-width: 200px">
            @if($club->logo_url)
                <img src="{{ Storage::url($club->logo_url) }}" title="{{ $club->name }}" alt="Vereinswappen">
            @else
                <span class="fa fa-ban text-muted fa-5x"></span>
            @endif
        </div>
        <div class="col-md-8 text-white">
            <h1>{{ $club->name }}</h1>
            <ul class="list-unstyled">
                <li>{{ $club->regularStadium()->first() ? $club->regularStadium()->first()->name : "Kein Stadion" }}</li>
            </ul>
            @foreach ($club->getLastGames(5) as $lastGame)
                <span class="fa-stack fa-lg">
                    @if ($club->hasWon($lastGame))
                        <i class="fa fa-circle fa-stack-2x text-success"></i>
                        <strong class="fa-stack-1x" style="color:#ffffff">S</strong>
                    @elseif ($club->hasLost($lastGame))
                        <i class="fa fa-circle fa-stack-2x text-danger"></i>
                        <strong class="fa-stack-1x" style="color:#ffffff">N</strong>
                    @elseif ($club->hasDrawn($lastGame))
                        <i class="fa fa-circle fa-stack-2x text-gray-dark"></i>
                        <strong class="fa-stack-1x" style="color:#ffffff">U</strong>
                    @endif
                </span>
            @endforeach
        </div>
    </div>
    <!-- tabs -->
    <div class="row mx-auto pt-4" style="width: 1140px;">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">Resultate</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Kader</a>
            </li>
            <li>
                <a class="nav-link" href="#">Erfolge</a>
            </li>
        </ul>
    </div>
</div>
<!-- content -->
<div class="container">
    <div class="row mt-4 mb-4">
        <form class="form-inline">
            <label class="pr-4" for="inlineFormInputName2">Saison</label>
            <select class="form-control">
                <option>{{ $season->begin->format('Y') }} - {{ $season->end->format('Y') }}</option>
                <option></option>
            </select>
        </form>
    </div>
</div>

<div class="container">
    <div class="row mt-2">
        <div class="col-12">
            @foreach ($season->fixtures()->ofClub($club->id) ->orderBy('datetime')->get() as $fixture)
                <div class="row" style="border-bottom: gray 1px">
                    <h5 class="pt-2">Spielwoche {{ $fixture->matchweek->number_consecutive }}</h5>
                </div>
                <div class="row">
                    <div class="col-1">
                        <span class="fa-stack">
                            @if ($fixture->isPlayed())

                                @if ($club->hasWon($fixture))
                                    <i class="fa fa-circle fa-stack-2x text-success"></i>
                                    <strong class="fa-stack-1x" style="color:#ffffff">S</strong>
                                @elseif ($club->hasLost($fixture))
                                    <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                    <strong class="fa-stack-1x" style="color:#ffffff">N</strong>
                                @elseif ($club->hasDrawn($fixture))
                                    <i class="fa fa-circle fa-stack-2x text-gray-dark"></i>
                                    <strong class="fa-stack-1x" style="color:#ffffff">U</strong>
                                @endif

                            @endif
                        </span>

                    </div>
                    <div class="col-3">
                        @if ( $fixture->datetime )
                            <span class="fa fa-calendar"></span> {{ $fixture->datetime->format('d.m.Y') }}
                            <span class="fa fa-clock-o"></span> {{ $fixture->datetime->format('H:i') }}
                        @else
                            TBD
                        @endif
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5 text-right">
                                @if ($fixture->clubHome)
                                    {{ $fixture->clubHome->name }}
                                    @if ($fixture->clubHome->logo_url)
                                        <img src="{{ Storage::url($fixture->clubHome->logo_url) }}" height="25">
                                    @endif
                                @endif
                            </div>
                            <div class="col-2 text-center">
                                {{ $fixture->goals_home ?? "-" }} : {{ $fixture->goals_away ?? "-" }}
                            </div>
                            <div class="col-5">
                                @if ($fixture->clubAway)
                                    {{ $fixture->clubAway->name }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        Irgendwas
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


@endsection