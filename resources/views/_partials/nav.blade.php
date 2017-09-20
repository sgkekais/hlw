<nav class="navbar navbar-expand-md navbar-dark">
    <a class="navbar-brand" href="{{ route('home') }}">
        <img src="/images/hlwlogo_w.png" class="d-inline-block align-top" height="30" alt="HLW-Logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
            </li>
            @foreach(\HLW\Division::all() as $division)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend.divisions.show', $division ) }}">{{ $division->name }}</a>
                </li>
            @endforeach
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
</nav>

@yield('subnav')