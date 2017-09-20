@include('_partials.head')

<body>
    <div id="app">

        <!-- navigation -->
        @include('_partials.nav')

        <!-- content -->
        @yield('content')

    </div>
    <!-- scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>