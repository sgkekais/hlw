@include('_partials.head')

<body>
    <div id="app" class="app">
        <!-- top anchor -->
        <a name="top"></a>
        <!-- navigation -->
        @include('_partials.nav')
        <!-- subnavigation -->
        @yield('subnav')

        @if( session('authenticated') )
            <div id="authSuccess" class="container-fluid alert alert-success w-100 border-0 text-center m-0">
                &#x1F44B; Willkommen zurück, {{ Auth::user()->name }}!
            </div>
        @endif

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
                $("#authSuccess").delay(2500).fadeOut();
            @endif
        })
    </script>
    @yield('js-footer')
</body>
</html>