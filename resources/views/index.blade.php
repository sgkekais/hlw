@extends('layouts.app')

@section('content')

    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th></th>
                <th>Sp</th>
                <th>S</th>
                <th>U</th>
                <th>N</th>
                <th>Tore</th>
                <th>Diff.</th>
                <th>Pkt.</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($table as $club)
                <tr>
                    <td>{{ $club->t_rank }}</td>
                    <td>{{ $club->name }}</td>
                    <td>{{ $club->t_played }}</td>
                    <td>{{ $club->t_won }}</td>
                    <td>{{ $club->t_drawn }}</td>
                    <td>{{ $club->t_lost }}</td>
                    <td>{{ $club->t_goals_for }} : {{ $club->t_goals_against }}</td>
                    <td>{{ $club->t_goals_diff }}</td>
                    <td>{{ $club->t_points }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection