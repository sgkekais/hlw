<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="application-name" content="Hobbyliga-West Düsseldorf" />
    <meta name="author" content="Hobbyliga-West Düsseldorf" />
    <meta name="robots" content="All" />
    <meta name="description" content="Hobbyliga-West Düsseldorf. Die Fußballliga für Hobby- und Freizeitmannschaften aus Düsseldorf und Umgebung." />
    <meta name="keywords" content="Hobbyliga-West, Düsseldorf, Hobbyliga, Freizeitliga, Freizeitfußballliga, Fußballliga, Thekenmannschaft, Hobbyfußball, Freizeitfußball, Fußball, Liga" />

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" sizes="32x32">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    {{-- chatter css --}}
    @yield('css')

    <title>{{ config('app.name') }} @yield('title') </title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>