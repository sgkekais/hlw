<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link pl-0" href="{{ route('frontend.divisions.tables', $division) }}">Tabelle</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.divisions.fixtures', $division) }}">Paarungen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Sünderkartei</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.seasons.clubs', $season ) }}">Teams</a>
            </li>
        </ul>
    </div>
</nav>