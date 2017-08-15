<!-- TODO: blocks view <footer class="footer bg-faded">
    <div class="container">
        <div class="row justify-content-end no-gutters">
            <span class="text-muted">&copy; {{ date('Y') }} - Zeitzone: {{ config('app.timezone') }}, Autor: Kevin Kaiser</span>
        </div>
    </div>
</footer>-->

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

<!-- page-specific scripts -->
@yield('pagespecificscripts')

</body>
</html>