<nav class="navbar navbar-expand-md navbar-dark" style="background-color: #4CAF50;">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="" height="30" viewBox="0 0 99 41" class="d-inline-block align-top" fill="white">
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
                <li class="nav-item {{ Route::is('home') ? "active" : null }}">
                    <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
                </li>
                @foreach(\HLW\Division::published()->orderBy('name')->get() as $division)
                    <li class="nav-item {{ Request::segment(1) == "division" && Request::segment(2) == $division->id ? "active" : null }}">
                        <a class="nav-link" href="{{ route('frontend.divisions.show', $division ) }}">{{ $division->name }}</a>
                    </li>
                @endforeach
                <li class="nav-item">
                    <a class="nav-link" href="#">Ruhmeshalle</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Vorstand</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Satzung</a>
                </li>
            </ul>
        </div>
    </div>

</nav>