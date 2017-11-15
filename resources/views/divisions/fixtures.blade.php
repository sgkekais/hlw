@extends('layouts.app')

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="pt-4 font-weight-bold">Spielplan</h2>
                <h3 class="text-muted">{{ $season->season_nr ? $season->season_nr."." : null }} Saison - {{ $season->begin ? $season->begin->format('Y') : null }} / {{ $season->end ? $season->end->format('Y') : null }}</h3>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Spielwoche
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach($season->matchweeks as $matchweek)
                            <a class="dropdown-item" href="#matchweek{{ $matchweek->number_consecutive }}">
                                {{ $matchweek->name && strlen($matchweek->name) > 0 ? $matchweek->name : $matchweek->number_consecutive }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @foreach($season->matchweeks as $matchweek)
            <hr>
            <div class="row">
                <a name="matchweek{{ $matchweek->number_consecutive }}"></a>
                <div class="col-12">
                    <h4>Spielwoche {{ $matchweek->number_consecutive }}
                        <small>{{ $matchweek->name ?? null }}</small>
                        <small class="text-muted d-inline-block">
                            {{ $matchweek->begin ? $matchweek->begin->format('d.m.Y') : null }}
                            {{ $matchweek->end ? " bis ".$matchweek->end->format('d.m.Y') : null }}
                        </small>
                    </h4>
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr class="">
                                <th class="text-center" style="width: 5%"></th>
                                <th class="text-right" style="width: 10%"><span class="fa fa-fw fa-calendar"></span></th>
                                <th class="text-left" style="width: 10%"></th>
                                <th class="" style="width: 25%">&nbsp;</th>
                                <th class="text-center" style="width: 10%"><span class="fa fa-fw fa-handshake-o"></span></th>
                                <th class="" style="width: 25%">&nbsp;</th>
                                <th class="text-left" style="width: 15%">@svg('arena', ['class' => 'align-middle pr-1', 'style' => 'fill: #343a40', 'width' => '30', 'height' => '30'])</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($matchweek->fixtures()->orderBy('datetime')->get() as $fixture)
                            <tr class="">
                                <td class="align-middle text-center">
                                    @if($fixture->isRated())
                                        <span class="fa fa-fw fa-gavel text-warning"></span>
                                    @elseif($fixture->rescheduledTo)
                                        <span class="fa fa-fw fa-level-up fa-rotate-90"></span>
                                    @endif
                                </td>
                                {{-- date - day of week --}}
                                <td class="align-middle text-right">
                                    {{ $fixture->datetime ? $fixture->datetime->formatLocalized('%a').", " : "&nbsp;" }}
                                    @if($fixture->datetime)
                                        {{ $fixture->datetime->format('d.m.') }}
                                    @else
                                        <span class="text-muted">o. D.</span>
                                    @endif
                                </td>
                                {{-- date - date and time --}}
                                <td class="align-middle">
                                    {{ $fixture->datetime ? $fixture->datetime->format('H:i') : null }}
                                </td>
                                {{-- home team --}}
                                <td class="align-middle text-right">
                                    @if($fixture->clubHome)
                                        {{-- visible only on xs --}}
                                        <span class="d-inline d-sm-none">{{ $fixture->clubHome->name_code }}</span>
                                        {{-- visible only on sm and md --}}
                                        <span class="d-none d-sm-inline d-lg-none">{{ $fixture->clubHome->name_short }}</span>
                                        {{-- hidden on xs, sm, md --}}
                                        <span class="d-none d-lg-inline">{{ $fixture->clubHome->name }}</span>
                                    @if($fixture->clubHome->logo_url)
                                            <img src="{{ Storage::url($fixture->clubHome->logo_url) }}" height="25" class="pl-1 d-none d-md-inline">
                                        @else
                                            <span class="fa fa-ban text-muted d-none d-md-inline" title="Kein Vereinswappen vorhanden"></span>
                                        @endif
                                    @else
                                        {{ $fixture->club_home }}
                                    @endif
                                </td>
                                {{-- result --}}
                                <td class="align-middle text-center">
                                    <div class="text-white rounded bg-dark d-inline-block p-1" style="word-break: keep-all">
                                        {{-- cancelled? --}}
                                        @if($fixture->isCancelled())
                                            Ann.
                                        @elseif($fixture->isPlayed() && !$fixture->isRated())
                                            {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
                                        {{-- rated? --}}
                                        @elseif($fixture->isRated())
                                            <span class="text-warning">{{ $fixture->goals_home_rated }} : {{ $fixture->goals_away_rated }}</span>
                                        @else
                                            -&nbsp;:&nbsp;-
                                        @endif
                                    </div>
                                </td>
                                {{-- away team --}}
                                <td class="align-middle">
                                    @if($fixture->clubAway)
                                        @if($fixture->clubAway->logo_url)
                                            <img src="{{ Storage::url($fixture->clubAway->logo_url) }}" height="25" class="pr-1 d-none d-md-inline">
                                        @else
                                            <span class="fa fa-ban text-muted d-none d-md-inline" title="Kein Vereinswappen vorhanden"></span>
                                        @endif
                                        {{-- visible only on xs --}}
                                        <span class="d-inline d-sm-none">{{ $fixture->clubAway->name_code }}</span>
                                        {{-- visible only on sm and md --}}
                                        <span class="d-none d-sm-inline d-lg-none">{{ $fixture->clubAway->name_short }}</span>
                                        {{-- hidden on xs, sm, md --}}
                                        <span class="d-none d-lg-inline">{{ $fixture->clubAway->name }}</span>
                                    @else
                                        {{ $fixture->club_away }}
                                    @endif
                                </td>
                                {{-- stadium --}}
                                <td class="align-middle">
                                    {{-- TODO: mark non-regular stadium --}}
                                    @if($fixture->stadium)
                                        {{ $fixture->stadium->name_short }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <span class="pull-right"><a href="#top"><span class="fa fa-arrow-up"></span> nach oben</a></span>
                </div>

            </div>
        @endforeach

    </div>

@endsection