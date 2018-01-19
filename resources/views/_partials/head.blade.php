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

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=M4yNP8xXXQ">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=M4yNP8xXXQ">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=M4yNP8xXXQ">
    <link rel="manifest" href="/manifest.json?v=M4yNP8xXXQ">
    <link rel="mask-icon" href="/safari-pinned-tab.svg?v=M4yNP8xXXQ" color="#388e3c">
    <link rel="shortcut icon" href="/favicon.ico?v=M4yNP8xXXQ">
    <meta name="apple-mobile-web-app-title" content="HLW">
    <meta name="application-name" content="HLW">
    <meta name="theme-color" content="#388e3c">

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