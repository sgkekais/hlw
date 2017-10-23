<nav class="navbar navbar-expand-md navbar-light bg-light" style=" box-shadow: inset 0px 5px 5px 0px rgba(173,173,173,0.5);">
    <div class="container">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link pl-0 {{ Route::is('frontend.divisions.tables') ? "active" : null }}" href="{{ route('frontend.divisions.tables', $division) }}">Tabelle</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('frontend.divisions.fixtures') ? "active" : null }}" href="{{ route('frontend.divisions.fixtures', $division) }}">Spielplan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Sünderkartei</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('frontend.seasons.clubs') || Route::is('frontend.clubs.show') ? "active" : null }}" href="{{ route('frontend.seasons.clubs', $season ) }}">Teams</a>
            </li>
        </ul>
    </div>
</nav>