<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="application-name" content="Hobbyliga-West Düsseldorf" />
    <meta name="author" content="Hobbyliga-West Düsseldorf" />
    <meta name="description" content="Hobbyliga-West Düsseldorf. Die Fußballliga für Hobby- und Freizeitmannschaften aus Düsseldorf und Umgebung." />

    <title>{{ config('app.name') }} @yield('title') </title>

    <style>
        * {
            box-sizing: border-box;
        }
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .sidebar {
            padding: 1rem;
            float: left;
            width: 25%;
            background-color: #4caf50;
        }
        .main {
            padding: 1rem;
            float: left;
            width: 75%;
            background-color: #4caf50;
        }
        .main-inner {
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="sidebar" style="">
        <img src="{{ asset('storage/hlwlogo.png') }}" height="30">
    </div>
    <div class="main">
        {{ $player->club->logo_url }}
        {{ $player->club->name }}
        <hr>
        <div class="main-inner">
            <h1>{{ $player->id }}</h1>
            {{ $player->person->first_name }}
            {{ $player->person->last_name }}
            {{ $player->person->date_of_birth ? $player->person->date_of_birth->format('d.m.Y') : "-" }}
        </div>
    </div>
</body>