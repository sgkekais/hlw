@extends('layouts.app')

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

    <div class="container">
        <a name="top"></a>
        <div class="row">
            <div class="col-12">
                <h1 class="pt-4"><b>Spielplan</b> der {{ $season->season_nr ? $season->season_nr."." : null }} Saison</h1>
                <h2 class="text-muted">{{ $season->begin ? $season->begin->format('Y') : null }} / {{ $season->end ? $season->end->format('Y') : null }}</h2>
                <nav aria-label="pagination">
                    <ul class="pagination">
                        @foreach($season->matchweeks as $matchweek)
                            <li class="page-item">
                                <a class="page-link" href="#matchweek{{ $matchweek->number_consecutive }}">
                                    {{ $matchweek->name ?? $matchweek->number_consecutive }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
        @foreach($season->matchweeks as $matchweek)
            <hr>
            <div class="row">
                <a name="matchweek{{ $matchweek->number_consecutive }}"></a>
                <div class="col-12">
                    <h2>Spielwoche {{ $matchweek->number_consecutive }}
                        <small>{{ $matchweek->name ?? null }}</small>
                        <small class="text-muted">
                            {{ $matchweek->begin ? $matchweek->begin->format('d.m.Y') : null }}
                            {{ $matchweek->end ? " bis ".$matchweek->end->format('d.m.Y') : null }}
                        </small>
                    </h2>
                    <table class="table table-striped table-sm">
                        <tbody>
                        @foreach($matchweek->fixtures as $fixture)
                            <tr>
                                <td class="align-middle text-right">
                                    {{ $fixture->datetime ? $fixture->datetime->formatLocalized('%a') : "&nbsp;" }}
                                </td>
                                <td class="align-middle">
                                    @if($fixture->datetime)
                                        {{ $fixture->datetime->format('d.m.') }}
                                        -
                                        {{ $fixture->datetime->format('H:i') }}
                                    @else
                                    <span class="text-muted">TBD</span>
                                    @endif
                                </td>
                                <td class="align-middle text-right">
                                    @if($fixture->clubHome)
                                        {{ $fixture->clubHome->name }}
                                        @if($fixture->clubHome->logo_url)
                                            <img src="{{ Storage::url($fixture->clubHome->logo_url) }}" width="30" class="pr-1">
                                        @else
                                            <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                        @endif
                                    @else
                                        {{ $fixture->club_home }}
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <!-- cancelled? -->
                                    @if($fixture->isCancelled())
                                        Ann.
                                    @endif
                                    <!-- rated? -->
                                    @if($fixture->isRated())
                                        {{ $fixture->goals_home_rated }} : {{ $fixture->goals_away_rated }}
                                        <span class="fa fa-gavel" title="Gewertet"></span>
                                    @endif
                                    <!-- result -->
                                    @if($fixture->isPlayed())
                                        {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
                                        @else
                                        - : -
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($fixture->clubAway)
                                        @if($fixture->clubAway->logo_url)
                                            <img src="{{ Storage::url($fixture->clubAway->logo_url) }}" width="30" class="pr-1">
                                        @else
                                            <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                        @endif
                                        {{ $fixture->clubAway->name }}
                                    @else
                                        {{ $fixture->club_away }}
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <span class="fa fa-location-arrow"></span>
                                    {{ $fixture->stadium ? $fixture->stadium->name_short : "-" }}
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