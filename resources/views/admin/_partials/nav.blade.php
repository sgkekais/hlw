<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top mb-4">
    <!-- toggler -->
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- brand image and text -->
    <a class="navbar-brand" href="{{ route('admin') }}">
        <img src="/images/hlwlogo.png" class="d-inline-block align-top" height="30" alt="HLW-Logo">
        Admin
    </a>

    <!-- toggable navigation bar -->
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ Route::is('admin') ? 'active' : null }}">
                <a class="nav-link" href="{{ route('admin') }}"><span class="fa fa-dashboard"></span> Dashboard</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-soccer-ball-o"></span> Spielbetrieb</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item {{ Route::is('competitions.*') ? 'active' : null }}" href="{{ route('competitions.index') }}">
                        <span class="fa fa-trophy fa-fw"></span> Wettbewerbe
                    </a>
                    <a class="dropdown-item {{ Route::is('divisions.*') ? 'active' : null }}" href="{{ route('divisions.index') }}">
                        <span class="fa fa-exchange fa-rotate-90 fa-fw"></span> Spielklassen
                    </a>
                    <a class="dropdown-item {{ Route::is('seasons.*') ? 'active' : null }}" href="{{ route('seasons.index') }}">
                        <span class="fa fa-line-chart fa-fw"></span> Saisons
                    </a>
                    <a class="dropdown-item {{ Route::is('stadiums.*') ? 'active' : null }}" href="{{ route('stadiums.index') }}">
                        <span class="fa fa-map-marker fa-fw"></span> Spielorte
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item {{ Route::is('people.*') ? 'active' : null }}" href="{{ route('people.index') }}">
                        <span class="fa fa-id-badge fa-fw"></span> Personen
                    </a>
                    <a class="dropdown-item {{ Route::is('clubs.*') ? 'active' : null }}" href="{{ route('clubs.index') }}">
                        <span class="fa fa-shield fa-fw"></span> Mannschaften
                    </a>
                    <a class="dropdown-item {{ Route::is('positions.*') ? 'active' : null }}" href="{{ route('positions.index') }}">
                        <span class="fa fa-hand-o-down fa-fw"></span> Positionen
                    </a>
                    <a class="dropdown-item {{ Route::is('referees.*') ? 'active' : null }}" href="{{ route('referees.index') }}">
                        <span class="fa fa-hand-stop-o fa-fw"></span> Schiedsrichter
                    </a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item {{ Route::is('users.*') ? 'active' : null }}">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <span class="fa fa-users"></span> Users
                </a>
            </li>
            <li class="nav-item {{ Route::is('log') ? 'active' : null }}">
                <a class="nav-link" href="{{ route('log') }}">
                    <span class="fa fa-history"></span> Log
                </a>
            </li>
            <!-- user -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="fa fa-user"></span> Hallo, {{ Auth::user()->name }}!
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdown02">
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <span class="fa fa-sign-out"></span> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
