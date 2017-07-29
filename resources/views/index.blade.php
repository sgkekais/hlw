@extends('layouts.app')

@section('content')

    <ul>
    @foreach($clubs as $club)
        <li>{{ $club->name }}</li>
    @endforeach
    </ul>

@endsection