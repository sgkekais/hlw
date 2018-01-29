@include('_partials.head')

<body>
    <div id="app" class="app">
        <!-- top anchor -->
        <a name="top"></a>
        <!-- navigation -->
        @include('_partials.nav')
        <!-- subnavigation -->
        @yield('subnav')

        @if (session('authenticated'))
            <div id="authSuccess" class="container-fluid bg-primary text-center text-white m-0 pb-2">
                &#x1F44B; Willkommen zurück, {{ Auth::user()->name }}!
            </div>
        @endif

        <!-- jumbotron image -->
        @yield('jumbotron')

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
    <script type="text/javascript">
        $(function() {
            @if( session('authenticated') )
                $("#authSuccess").delay(1000).slideUp();
            @endif
        })
    </script>
    @yield('js-footer')
</body>
</html>