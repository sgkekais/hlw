@include('_partials.head')

<body>
    <div id="app">

        <!-- navigation -->
        @include('_partials.nav')
        <!-- subnavigation -->
        @yield('subnav')

        <!-- content -->
        @yield('content')

    </div>
    <!-- scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>