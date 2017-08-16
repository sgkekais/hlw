@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- cover -->
    <div class="row mx-auto" style="width: 1140px;">
        <div class="col-md-auto">
            <img src="{{ Storage::url($club->logo_url) }}" title="{{ $club->name }}" alt="Vereinswappen">
        </div>
        <div class="col-md-8">
            <h1>{{ $club->name }}</h1>
            <ul>
                <li>{{ $club->regularStadium()->first()->name }}</li>
            </ul>
        </div>
    </div>
    <!-- tabs -->
    <div class="row mx-auto" style="width: 1140px;">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">Resultate</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Kader</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Bla</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Bla</a>
            </li>
        </ul>
    </div>
</div>
    <!-- content -->
<div class="container">

</div>


@endsection