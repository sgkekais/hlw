@extends('layouts.app')

@section('content')

    <table class="table table-hover">
        <thead>
            <tr>
                <th class="align-middle text-center">#</th>
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
                    <td class="align-middle">
                        <img src="{{ Storage::url($club->logo_url) }}" height="25" class="pr-1">
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