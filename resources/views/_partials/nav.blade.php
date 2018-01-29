<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #4CAF50;">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}" title="Startseite">
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
            <ul class="navbar-nav">
                @foreach(\HLW\Division::published()->orderBy('name')->get() as $division)
                    <li class="nav-item {{ Request::segment(1) == "division" && Request::segment(2) == $division->id ? "active" : null }} {{ Request::segment(1) == "season" && \HLW\Season::find(Request::segment(2))->division->id == $division->id ? "active" : null }}">
                        <a class="nav-link" href="{{ $division->competition->isLeague() ? route('frontend.divisions.show', $division ) : route('frontend.divisions.fixtures', $division) }}" title="{{ $division->name }}"> <span class="fa"></span> {{ $division->name }}</a>
                    </li>
                @endforeach
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('chatter.*') ? "active" : null }}" href="{{ route('chatter.home') }}" title="Clubhaus"><span class="fa fa-comments"></span> Clubhaus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('infos') ? "active" : null }}" href="{{ route('infos') }}" title="Vorstand, Satzungen und Infos">Infos</a>
                </li>
                <li>
                    <a class="nav-link {{ Route::is('halloffame') ? "active" : null }}" href="{{ route('halloffame') }}" title="Ruhmeshalle">Ruhmeshalle</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}" title="Anmelden">Login <span class="fa fa-fw fa-sign-in"></span></a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="login-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fa fa-2x fa-user-circle"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <h4 class="px-4 py-1">
                                Hallo, {{ Auth::user()->name }}!
                            </h4>
                            <div class="px-4 py-1">
                                @php
                                    $favorite_clubs = Auth::user()->clubs;
                                @endphp
                                @if(!$favorite_clubs->isEmpty())
                                    <h5 class="font-weight-bold font-italic">Meine Teams</h5>
                                    <ul class="list-unstyled">
                                        @foreach ($favorite_clubs as $club)
                                            <li class=" pt-1 pb-1 {{ !$loop->last ? "border border-left-0 border-top-0 border-right-0" : null }} }}"><a href="{{ route('frontend.clubs.show', $club) }}"><img class="pr-1" src="{{ asset('storage/'.$club->logo_url) }}" title="Vereinswappen" width="25px">{{ $club->name_short }}</a></li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-muted text-center"><small>Füge ein Team als Favorit hinzu!</small></div>
                                @endif
                            </div>
                            <div class="px-4 py-1">
                                <a class="btn btn-primary w-100" href="{{ route('frontend.user.profile.show') }}">
                                    <span class="fa fa-fw fa-user"></span> Profil
                                </a>
                            </div>
                            @hasanyrole('super_admin|admin')
                            <div class="px-4 py-1">
                                <a class="btn btn-secondary w-100" href="{{ route('admin') }}">
                                    <span class="fa fa-fw fa-cogs"></span> HLW-Admin
                                </a>
                            </div>
                            @endrole
                            <div class="px-4 py-1">
                                <form class="" role="form" id="logout-form" action="{{ route('logout') }}" method="POST">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger w-100"><span class="fa fa-fw fa-sign-out"></span> Abmelden</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>