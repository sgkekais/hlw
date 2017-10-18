@extends('layouts.app')

@section('content')


<div class="container-fluid pt-4" style="background: url({{ $club->cover_url ? Storage::url($club->cover_url) : Storage::url('public/clubcovers/_default.jpg') }}) repeat-x">
    <!-- cover -->
    <div class="container">
        <div class="row">
            <div class="col-md-auto" style="min-width: 200px">
                @if($club->logo_url)
                    <img src="{{ Storage::url($club->logo_url) }}" title="{{ $club->name }}" alt="Vereinswappen">
                @else
                    <span class="fa fa-ban text-muted fa-5x"></span>
                @endif
            </div>
            <div class="col-md-8 text-white">
                <h1 style="font-weight: bold">{{ $club->name }}</h1>
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
        <div class="row pt-4">
            <div class="col-12">
                <!-- tabs -->
                <nav class="nav nav-tabs" id="tab" role="tablist"
                     style="background-color: {{ $club->colours_club_primary }};
                             border-top-left-radius: 5px;
                             border-top-right-radius: 5px">
                    <a class="nav-item nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-expanded="true">Übersicht</a>
                    <a class="nav-item nav-link" id="results-tab" data-toggle="tab" role="tab" aria-controls="results" href="#results">Resultate</a>
                    <a class="nav-item nav-link" href="#">Kader</a>
                    <a class="nav-item nav-link" href="#">Erfolge</a>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- content -->
<div class="container">
    <div class="row pt-4">
        <div class="tab-content col-12" id="tabcontent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                Home
            </div>
            <div class="tab-pane fade" id="results" role="tabpanel" aria-labelledby="">
                <h2 style="color: {{ $club->colours_club_primary }}"><b>Resultate</b></h2>
                <hr>
                <form class="form-inline pb-2">
                    <label class="pr-4" for=""><b>Saison</b></label>
                    <select id="" name="" class="form-control" aria-labelledby="">
                        <option>{{ $season->begin->format('Y') }} - {{ $season->end->format('Y') }}</option>
                        <option></option>
                    </select>
                </form>
                <!-- results -->
                <div class="col-12">
                    <div class="row">
                        <table class="table table-sm table-hover">
                            <thead>
                            <tr>
                                <th class="text-right">SW</th>
                                <th class=""></th>
                                <th colspan="2" class="">Datum</th>
                                <th colspan="3" class="text-center">Paarung</th>
                                <th class=""></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($season->fixtures()->ofClub($club->id)->orderBy('datetime')->get() as $fixture)
                                <tr>
                                    <td class="align-middle text-right">
                                        {{ $fixture->matchweek->number_consecutive }}
                                    </td>
                                    <td class="align-middle text-center">
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
                                    </td>
                                    <td class="align-middle">
                                        @if ( $fixture->datetime )
                                            <span class="fa fa-calendar"></span>
                                            {{ $fixture->datetime->formatLocalized('%a') }},
                                            {{ $fixture->datetime->format('d.m.y') }}
                                        @else
                                            TBD
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if ( $fixture->datetime )
                                            <span class="fa fa-clock-o"></span>
                                            {{ $fixture->datetime->format('H:i') }} Uhr
                                        @endif
                                    </td>
                                    <td class="align-middle text-right">
                                        @if ($fixture->clubHome)
                                            {{ $fixture->clubHome->name }}
                                            @if ($fixture->clubHome->logo_url)
                                                <img src="{{ Storage::url($fixture->clubHome->logo_url) }}" height="25">
                                            @endif
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ $fixture->goals_home ?? "-" }} : {{ $fixture->goals_away ?? "-" }}
                                    </td>
                                    <td class="align-middle text-left">
                                        @if ($fixture->clubAway)
                                            @if ($fixture->clubHome->logo_url)
                                                <img src="{{ Storage::url($fixture->clubAway->logo_url) }}" height="25">
                                            @endif
                                            {{ $fixture->clubAway->name }}
                                        @endif
                                    </td>
                                    <td class="align-middle">Irgendwas</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection