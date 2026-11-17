@include('_partials.head')

<body>
    <div id="app" class="app">
        <!-- top anchor -->
        <a name="top"></a>
        <!-- navigation -->
        @include('_partials.nav')
        <!-- subnavigation -->
        @yield('subnav')

        <!-- jumbotron image -->
        @include('_partials.jumbotron')

        <!-- content -->
        @yield('content')

    </div>
    <!-- footer -->
    @include('_partials.footer')
    <!-- scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('js')
    @yield('js-footer')
</body>
</html>