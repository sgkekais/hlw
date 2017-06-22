<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
    <div class="container">
        <!-- toggler -->
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse1" aria-controls="navbarCollapse1" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- brand image and text -->
        <a class="navbar-brand" href="/">
            <img src="/images/hlwlogo.png" class="d-inline-block align-top" height="30" alt="HLW-Logo">
            Admin
        </a>

        <!-- toggable navigation bar -->
        <div class="collapse navbar-collapse" id="navbarCollapse1">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ Route::is('admin') ? 'active' : null }}">
                    <a class="nav-link" href="{{ route('admin') }}"><span class="fa fa-dashboard"></span> Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-soccer-ball-o"></span> Spielbetrieb</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item {{ Route::is('competitions.*') ? 'active' : null }}" href="{{ route('competitions.index') }}">Wettbewerbe</a>
                        <a class="dropdown-item {{ Route::is('divisions.*') ? 'active' : null }}" href="{{ route('divisions.index') }}">Spielklassen</a>
                        <a class="dropdown-item {{ Route::is('seasons.*') ? 'active' : null }}" href="{{ route('seasons.index') }}">Saisons</a>
                        <a class="dropdown-item {{ Route::is('matchweeks.*') ? 'active' : null }}" href="{{ route('matchweeks.index') }}">Spielwochen</a>
                        <a class="dropdown-item {{ Route::is('fixtures.*') ? 'active' : null }}" href="{{ route('fixtures.index') }}">Paarungen</a>
                        <a class="dropdown-item {{ Route::is('stadiums.*') ? 'active' : null }}" href="{{ route('stadiums.index') }}">Spielorte</a>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="fa fa-users"></span> Users
                    </a>
                </li>
                <li class="nav-item {{ Route::is('log') ? 'active' : null }}">
                    <a class="nav-link" href="{{ route('log') }}">
                        <span class="fa fa-history"></span> Log
                    </a>
                </li>

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
    </div>
</nav>
<!-- secondary navigation -->
<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
    <!-- toggler -->
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse2" aria-controls="navbarCollapse2" aria-expanded="false" aria-label="toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarCollapse2">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('competitions.index') }}">Wettbewerbe</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('divisions.index') }}">Spielklassen</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('seasons.index') }}">Saisons</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('matchweeks.index') }}">Spielwochen</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('fixtures.index') }}">Paarungen</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('stadiums.index') }}">Spielorte</a></li>
            </ul>
        </div>
    </div>
</nav>