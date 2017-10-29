@extends('layouts.app')

@section('content')
    <div class=" jumbotron jumbotron-fluid">
        <div class="display-1 font-italic" style="color: #ff9800">HEADER</div>
    </div>
    <div class="container">

        <div class="row">
            <div class="col-12">
                News?
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                Aktuelle Paarungen über alle Ligen?
            </div>
        </div>
        <div class="row">
            @foreach ($divisions as $division)
                <div class="col-md-4">
                    <h3 class="font-weight-bold">{{ $division->name }}</h3>
                    @php
                        // $c_season = $division->seasons()->published()->current()->first();
                        $c_season = $division->currentSeason();
                        if ($c_season) {
                            $c_matchweek = $c_season->currentMatchweek();
                        }
                    @endphp
                    @if ($c_season && $c_matchweek)
                        <h4 class="text-muted">
                            SW {{ $c_matchweek->number_consecutive ?? null }}
                            <small class="text-muted">
                                {{ $c_matchweek->begin ? $c_matchweek->begin->format('d.m.y') : null }}
                                {{ $c_matchweek->end ? "bis ".$c_matchweek->end->format('d.m.y') : null }}
                            </small>
                        </h4>

                        <table class="table table-hover table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="" colspan="2">Pos</th>
                                    <th class="" colspan="2">Club</th>
                                    <th class=" text-center">Sp</th>
                                    <th class=" text-center">TD</th>
                                    <th class=" text-center">Pkt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($c_season->generateTable($c_matchweek, true, true, true, true, false, true, true, true, true) as $club)
                                    @php
                                        $rank_color = "";
                                        $rank_icon  = "";
                                    @endphp
                                    @if(in_array($club->t_rank, $c_season->ranks_champion) || in_array($club->t_rank, $c_season->ranks_promotion))
                                        @php
                                            $rank_color = "#FFC107";
                                            $rank_icon  = "fa-circle";
                                        @endphp
                                    @elseif(in_array($club->t_rank, $c_season->ranks_relegation))
                                        @php
                                            $rank_color = "#F44336";
                                            $rank_icon  = "fa-circle";
                                        @endphp
                                    @elseif(in_array($club->t_rank, $c_season->playoff_relegation))
                                        @php
                                            $rank_color = "#F44336";
                                            $rank_icon  = "fa-circle-o";
                                        @endphp
                                    @endif
                                    <tr>
                                        <td class="align-middle">
                                            <span class="fa fa-fw {{ $rank_icon }}" style="color: {{ $rank_color }};"></span>
                                        </td>
                                        <td class="align-middle">{{ $club->t_rank }}</td>
                                        <td class="align-middle">
                                            @if($club->logo_url)
                                                <img src="{{ Storage::url($club->logo_url) }}" width="30" class="pr-1">
                                            @else
                                                <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('frontend.clubs.show', $club) }}">
                                                {{ $club->name_code }}
                                            </a>
                                        </td>
                                        <td class="align-middle text-center">{{ $club->t_played }}</td>
                                        <td class="align-middle text-center">{{ $club->t_goals_diff }}</td>
                                        <td class="align-middle text-center">{{ $club->t_points }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-right">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="{{ route('frontend.divisions.fixtures', $division) }}">Spielplan</a></li>
                                <li class="list-inline-item"><a href="{{ route('frontend.divisions.tables', $division) }}">Tabelle</a></li>
                            </ul>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>


@endsection