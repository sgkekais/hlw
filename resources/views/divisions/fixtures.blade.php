@extends('layouts.app')

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="pt-4"><b>Spielplan</b> der {{ $season->season_nr ? $season->season_nr."." : null }} Saison</h1>
                <h2 class="text-muted">{{ $season->begin ? $season->begin->format('Y') : null }} / {{ $season->end ? $season->end->format('Y') : null }}</h2>
            </div>
        </div>
        @foreach($season->matchweeks as $matchweek)
            <hr>
            <div class="row">
                <div class="col-12">
                    <h2>Spielwoche {{ $matchweek->number_consecutive }}
                        <small class="text-muted">
                            {{ $matchweek->begin ? $matchweek->begin->format('d.m.Y') : null }}
                            {{ $matchweek->end ? " bis ".$matchweek->end->format('d.m.Y') : null }}
                        </small>
                    </h2>
                    <table class="table table-striped">
                        <tbody>
                        @foreach($matchweek->fixtures as $fixture)
                            <tr>
                                <td>
                                    {{ $fixture->datetime ? $fixture->datetime->formatLocalized('%a') : "&nbsp;" }}
                                </td>
                                <td>
                                    @if($fixture->datetime)
                                        {{ $fixture->datetime->format('d.m.') }}
                                        -
                                        {{ $fixture->datetime->format('H:i') }}
                                    @else
                                    TBD
                                    @endif
                                </td>
                                <td class="text-right">{{ $fixture->clubHome ? $fixture->clubHome->name : $fixture->club_home }}</td>
                                <td>
                                    <!-- cancelled? -->

                                    <!-- rated? -->

                                    <!-- result -->

                                </td>
                                <td class="">{{ $fixture->clubAway ? $fixture->clubAway->name : $fixture->club_away }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        @endforeach

    </div>

@endsection