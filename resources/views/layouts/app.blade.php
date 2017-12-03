@include('_partials.head')

<body>
    <div id="app" class="app">
        <!-- top anchor -->
        <a name="top"></a>
        <!-- navigation -->
        @include('_partials.nav')
        <!-- subnavigation -->
        @yield('subnav')
        <!-- content -->
        @yield('content')

    </div>
    <!-- footer -->
    @include('_partials.footer')
    <!-- scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- chatter js --}}
    @yield('js')
    {{-- section for side-specific scripts --}}
    @yield('js-footer')
</body>
</html>