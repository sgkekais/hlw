@extends ('layouts.app')

@section ('content')

    <div class="w-100 bg-dark">
        <div class="container" style="background: url({{ asset('storage/clubcovers/default.jpg') }}) bottom; background-size: cover">
            <div class="row pt-4">
                <div class="col-4 d-flex">
                    @if ($fixture->clubAway)
                        @if ($fixture->clubHome->logo_url)
                            <img src="{{ asset('storage/'.$fixture->clubHome->logo_url) }}" class="img-fluid align-self-end p-2 pull-left bg-black-transparent" style="width: 150px">
                        @endif
                    @endif
                </div>
                <div class="col-4 d-flex flex-column text-center text-white ">
                    <div class="mt-auto bg-black-transparent">
                        @if ($fixture->datetime)
                            <span class="fa fa-fw fa-calendar"></span>
                            {{ $fixture->datetime->format('d.m.y') }}
                            <br>
                            <span class="fa fa-fw fa-clock-o"></span>
                            @if ($fixture->datetime->format('H:i') != "00:00")
                                {{ $fixture->datetime->format('H:i') }}
                            @else
                                --:--
                            @endif
                        @else
                            <span class="fa fa-fw fa-calendar"></span>
                            <span class="">ohne Datum</span>
                        @endif
                    </div>
                    <div class="mb-0 bg-black-transparent">
                        @svg('arena', ['class' => 'align-middle pr-1', 'style' => 'fill: #fff', 'width' => '30', 'height' => '30'])
                        @if ($fixture->stadium)
                            @if ($fixture->clubHome)
                                @if (!$fixture->clubHome->regularStadium->isEmpty())
                                    @if ($fixture->clubHome->regularStadium->first()->id != $fixture->stadium->id)
                                        <span class="text-warning">{{ $fixture->stadium->name }}</span>
                                    @else
                                        {{ $fixture->stadium->name }}
                                    @endif
                                @else
                                    {{ $fixture->stadium->name }}
                                @endif
                            @else
                                {{ $fixture->stadium->name }}
                            @endif
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    @if ($fixture->clubAway)
                        @if ($fixture->clubAway->logo_url)
                            <img src="{{ asset('storage/'.$fixture->clubAway->logo_url) }}" class="img-fluid align-self-end p-2 bg-black-transparent" style="width: 150px">
                        @endif
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-4 col-sm-5 pr-0">
                    <h1 class="p-2 text-white font-weight-bold font-italic bg-black-transparent">
                        @if ($fixture->clubHome)
                            {{-- visible only on xs --}}
                            <span class="d-inline d-sm-none">{{ $fixture->clubHome->name_code }}</span>
                            {{-- visible only on sm and md --}}
                            <span class="d-none d-sm-inline d-lg-none">{{ $fixture->clubHome->name_short }}</span>
                            {{-- hidden on xs, sm, md --}}
                            <span class="d-none d-lg-inline">{{ $fixture->clubHome->name }}</span>
                        @else
                            {{ $fixture->club_id_home }}
                        @endif
                    </h1>
                </div>
                <div class="col-4 col-sm-2 px-0 text-center">
                    <div class="h1 p-2 text-white bg-dark">
                        {{-- cancelled? --}}
                        @if ($fixture->isCancelled())
                            <span class="text-danger">Ann.</span>
                            {{-- rated? --}}
                        @elseif ($fixture->isRated())
                            <span class="text-warning">{{ $fixture->goals_home_rated }} : {{ $fixture->goals_away_rated }}</span>
                            {{-- played and *not* rated? --}}
                        @elseif ($fixture->isPlayed() && !$fixture->isRated())
                            {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
                            @if ($fixture->isPenalty())
                                <br><small>({{ $fixture->goals_home_11m }} : {{ $fixture->goals_away_11m }})</small>
                            @endif
                        @else
                            -&nbsp;:&nbsp;-
                        @endif
                    </div>
                </div>
                <div class="col-4 col-sm-5 pl-0 text-right">
                    <h1 class="p-2 text-white font-weight-bold font-italic bg-black-transparent">
                        @if ($fixture->clubAway)
                            {{-- visible only on xs --}}
                            <span class="d-inline d-sm-none">{{ $fixture->clubAway->name_code }}</span>
                            {{-- visible only on sm and md --}}
                            <span class="d-none d-sm-inline d-lg-none">{{ $fixture->clubAway->name_short }}</span>
                            {{-- hidden on xs, sm, md --}}
                            <span class="d-none d-lg-inline">{{ $fixture->clubAway->name }}</span>
                        @else
                            {{ $fixture->club_id_away }}
                        @endif
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                Gewertet -> Wertungsnotiz<br>
                Annulliert? <br>
                Torschützen, wenn vorhanden, links, rechts<br>
                Karten, wenn vorhanden<br>
                Statistiken (S U N gegeneinander, letzte fünf Spiele, Serie)<br>
            </div>
        </div>
    </div>

@endsection