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

</div>
    <!-- content -->
<div class="container">

</div>


@endsection