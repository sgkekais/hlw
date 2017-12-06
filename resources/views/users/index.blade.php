@extends('layouts.app')

@section('title')

    Profil

@endsection

@section('content')

    <div class="container">

        {{ Auth::user()->name }}

    </div>

@endsection