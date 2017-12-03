<nav class="navbar navbar-expand-md navbar-dark" style="background-color: #4CAF50;">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="74" height="30" viewBox="0 0 99 41" class="d-inline-block align-top" fill="white">
                <path class="hlw-logo" d="M0 4h7v13h14V4h7v32h-7V23H7v13L0 41V4z"/>
                <path class="hlw-logo" d="M33 4v32h22l4-6H40V0L33 4z"/>
                <path class="hlw-logo" d="M53 4l13 32h6l3-7h2l2 7h7L99 4h-7l-8 19h-2l-2-4v-2L85 4H78l-1 3h-1l-1-3h-8l5 13v2l-2 4h-2L61 4H53z"/>
            </svg>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                @foreach(\HLW\Division::published()->orderBy('name')->get() as $division)
                    <li class="nav-item {{ Request::segment(1) == "division" && Request::segment(2) == $division->id ? "active" : null }} {{ Request::segment(1) == "season" && \HLW\Season::find(Request::segment(2))->division->id == $division->id ? "active" : null }}">
                        <a class="nav-link" href="{{ route('frontend.divisions.show', $division ) }}"> <span class="fa {{ $division->competition->isLeague() ? "fa-star" : null }} {{ $division->competition->isKnockout() ? "fa-trophy" : null }}"></span> {{ $division->name }}</a>
                    </li>
                @endforeach
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#">Ruhmeshalle</a>
                </li>
                --}}
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('chatter.*') ? "active" : null }}" href="{{ route('chatter.home') }}"><span class="fa fa-comments"></span> Schänke</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="login-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-2x fa-user-circle"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @guest
                            <div class="dropdown-item">Hallo, Gast!</div>
                            <form class="px-4 py-3" role="form" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="email@beispiel.de">
                                </div>
                                @if ($errors->has('email'))
                                    <div class="form-control-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="password">Passwort</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Passwort eingeben">
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="remember">
                                        Merken
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">Anmelden</button>
                            </form>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Neu hier? Registrier dich!</a>
                            <a class="dropdown-item" href="{{ route('password.request') }}">Passwort vergessen?</a>
                        @endguest

                        @auth
                            <div class="dropdown-item">Hallo, {{ Auth::user()->name }}!</div>
                            <form class="px-4 py-3" role="form" id="logout-form" action="{{ route('logout') }}" method="POST">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger">Abmelden</button>
                            </form>
                        @endauth
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>