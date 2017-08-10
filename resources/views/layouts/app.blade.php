<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="application-name" content="Hobbyliga-West Düsseldorf" />
    <meta name="author" content="Hobbyliga-West Düsseldorf" />
    <meta name="robots" content="All" />
    <meta name="description" content="Hobbyliga-West Düsseldorf. Die Fußballliga für Hobby- und Freizeitmannschaften aus Düsseldorf und Umgebung." />
    <meta name="keywords" content="Hobbyliga-West, Düsseldorf, Hobbyliga, Freizeitliga, Freizeitfußballliga, Fußballliga, Thekenmannschaft, Hobbyfußball, Freizeitfußball, Fußball, Liga" />

    <title>{{ config('app.name') }} | </title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

            <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="/images/hlwlogo_w.png" class="d-inline-block align-top" height="30" alt="HLW-Logo">
                </a>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item" >
                            <a class="nav-link active" href="/">Home</a>
                        </li>
                        @foreach(\HLW\Division::all() as $division)
                            <li class="nav-item">
                                <a class="nav-link" href="#">{{ $division->name }}</a>
                            </li>
                        @endforeach
                    </ul>

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Vorstand</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="">Satzung</a>
                        </li>

                    </ul>
                </div>
            </nav>

        <div class="container">
            @yield('content')
        </div>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
