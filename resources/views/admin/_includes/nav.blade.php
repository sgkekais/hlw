<nav class="navbar navbar-toggleable-md fixed-top navbar-inverse bg-inverse">
    <div class="container">
        <!-- toggler -->
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- brand image and text -->
        <a class="navbar-brand" href="/">
            <img src="/images/hlwlogo.png" class="d-inline-block align-top" height="30" alt="HLW-Logo">
            Admin
        </a>

        <!-- toggable navigation bar -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/admin/">Dashboard <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Spielbetrieb</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="{{ route('competitions.index') }}">Wettbewerbe</a>
                        <a class="dropdown-item" href="{{ route('divisions.index') }}">Spielklassen</a>
                        <a class="dropdown-item" href="{{ route('seasons.index') }}">Saisons</a>
                        <a class="dropdown-item" href="{{ route('matchweeks.index') }}">Spielwochen</a>
                        <a class="dropdown-item" href="{{ route('fixtures.index') }}">Paarungen</a>
                        <a class="dropdown-item" href="{{ route('stadiums.index') }}">Spielorte</a>
                    </div>
                </li>

            </ul>
        </div>
    </div>

</nav>