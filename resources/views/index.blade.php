@extends('layouts.app')

@section('content')

    <table class="table table-hover">
        <thead>
            <tr>
                <th class="align-middle text-center">#</th>
                <th class="align-middle text-center">+ / -</th>
                <th></th>
                <th class="align-middle text-center">Sp</th>
                <th class="align-middle text-center">S</th>
                <th class="align-middle text-center">U</th>
                <th class="align-middle text-center">N</th>
                <th class="align-middle text-center">Tore</th>
                <th class="align-middle text-center">Diff.</th>
                <th class="align-middle text-center">Pkt.</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($table as $club)
                <tr>
                    <td class="align-middle text-center">{{ $club->t_rank }}</td>
                    <td class="align-middle text-center">
                        @if($table_previous_mw->count() > 0)
                            @if($previous_rank = $table_previous_mw->where('id', $club->id)->first()->t_rank)
                                @if ($previous_rank < $club->t_rank)
                                    <span class="fa fa-fw fa-arrow-circle-down"></span>
                                @elseif ($previous_rank == $club->t_rank)
                                    <span class="fa fa-fw fa-minus-circle"></span>
                                @else
                                    <span class="fa fa-fw fa-arrow-circle-up"></span>
                                @endif
                                {{ $previous_rank }}
                            @endif
                        @endif
                    </td>
                    <td class="align-middle">
                        @if($club->logo_url)
                            <img src="{{ Storage::url($club->logo_url) }}" width="30" class="pr-1">
                            @else
                            <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                        @endif
                            <a href="{{ route('frontend.clubs.show', $club) }}">
                                {{ $club->name }}
                            </a>
                    </td>
                    <td class="align-middle text-center">{{ $club->t_played }}</td>
                    <td class="align-middle text-center">{{ $club->t_won }}</td>
                    <td class="align-middle text-center">{{ $club->t_drawn }}</td>
                    <td class="align-middle text-center">{{ $club->t_lost }}</td>
                    <td class="align-middle text-center">{{ $club->t_goals_for }} : {{ $club->t_goals_against }}</td>
                    <td class="align-middle text-center">{{ $club->t_goals_diff }}</td>
                    <td class="align-middle text-center">{{ $club->t_points }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection