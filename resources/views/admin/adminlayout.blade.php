@include('admin._includes.head')

<div id="app">
    <!-- Navigation -->
    @include('admin._includes.nav')

    <!-- ./Navigation -->
    @yield('content')
</div>

@include('admin._includes.footer')
