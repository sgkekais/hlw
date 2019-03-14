<nav class="navbar fixed-top navbar-expand-md navbar-dark bg-dark ">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="/images/hlwlogo_w.png" class="d-inline-block align-top" height="30" alt="HLW-Logo">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- toggable navigation bar -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ Route::is('admin') ? 'active' : null }}">
                    <a class="nav-link" href="{{ route('admin') }}"><span class="fa fa-dashboard"></span> Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-soccer-ball-o"></span> Spielbetrieb</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        @can('list competitions')
                            <a class="dropdown-item {{ Route::is('competitions.*') ? 'active' : null }}" href="{{ route('competitions.index') }}">
                                <span class="fa fa-trophy fa-fw"></span> Wettbewerbe
                            </a>
                        @endcan
                        @can('list divisions')
                            <a class="dropdown-item {{ Route::is('divisions.*') ? 'active' : null }}" href="{{ route('divisions.index') }}">
                                <span class="fa fa-exchange fa-rotate-90 fa-fw"></span> Spielklassen
                            </a>
                        @endcan
                        @can('list seasons')
                            <a class="dropdown-item {{ Route::is('seasons.*') ? 'active' : null }}" href="{{ route('seasons.index') }}">
                                <span class="fa fa-line-chart fa-fw"></span> Saisons
                            </a>
                        @endcan
                        @can('list stadiums')
                            <a class="dropdown-item {{ Route::is('stadiums.*') ? 'active' : null }}" href="{{ route('stadiums.index') }}">
                                <span class="fa fa-map-marker fa-fw"></span> Spielorte
                            </a>
                        @endcan
                        <div class="dropdown-divider"></div>
                        @can('list clubs')
                            <a class="dropdown-item {{ Route::is('clubs.*') ? 'active' : null }}" href="{{ route('clubs.index') }}">
                                <span class="fa fa-shield fa-fw"></span> Mannschaften
                            </a>
                        @endcan
                        @can('list people')
                            <a class="dropdown-item {{ Route::is('people.*') ? 'active' : null }}" href="{{ route('people.index') }}">
                                <span class="fa fa-id-badge fa-fw"></span> Personen
                            </a>
                        @endcan
                        @can('list positions')
                            <a class="dropdown-item {{ Route::is('positions.*') ? 'active' : null }}" href="{{ route('positions.index') }}">
                                <span class="fa fa-hand-o-down fa-fw"></span> Positionen
                            </a>
                        @endcan
                        @can('list divisions_official')
                            <a class="dropdown-item {{ Route::is('divisions-official.*') ? 'active' : null }}" href="{{ route('divisions-official.index') }}">
                                <span class="fa fa-certificate fa-fw"></span> Offizielle Spielklassen
                            </a>
                        @endcan
                        @can('list referees')
                            <a class="dropdown-item {{ Route::is('referees.*') ? 'active' : null }}" href="{{ route('referees.index') }}">
                                <span class="fa fa-hand-stop-o fa-fw"></span> Schiedsrichter
                            </a>
                        @endcan
                    </div>
                </li>
                {{--
                <li class="nav-item {{ Route::is('calendar') ? 'active' : null }}">
                    <a class="nav-link" href="{{ route('calendar') }}"><span class="fa fa-calendar"></span> Kalender</a>
                </li>
                --}}
            </ul>
            <ul class="navbar-nav">
                @can('list users')
                    <li class="nav-item {{ Route::is('users.*') ? 'active' : null }}">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <span class="fa fa-users"></span> Benutzerverwaltung
                        </a>
                    </li>
                @endcan
                <li class="nav-item {{ Route::is('log') ? 'active' : null }}">
                    <a class="nav-link" href="{{ route('log') }}">
                        <span class="fa fa-history"></span> Log
                    </a>
                </li>
                <li class="nav-item {{ Route::is('docs') ? 'active' : null }}">
                    <a class="nav-link" href="{{ route('docs') }}">
                        <span class="fa fa-book"></span> Hilfe
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
    </div>


</nav>
