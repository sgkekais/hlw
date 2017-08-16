<nav class="navbar navbar-toggleable-md navbar-inverse ">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand" href="{{ route('home') }}">
        <img src="/images/hlwlogo_w.png" class="d-inline-block align-top" height="30" alt="HLW-Logo">
    </a>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item" >
                <a class="nav-link active" href="/">Home</a>
            </li>
            @foreach(\HLW\Division::all() as $division)
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ $division->name }}</a>
                </li>
            @endforeach
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="#">Vorstand</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="">Satzung</a>
            </li>
        </ul>
    </div>
</nav>
<ul class="nav">
    <li class="nav-item">
        <a class="nav-link" href="#">Tabelle & Paarungen</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('frontend.seasons.clubs', HLW\Season::find(1)) }}">Mannschaften</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Spieler</a>
    </li>
</ul>