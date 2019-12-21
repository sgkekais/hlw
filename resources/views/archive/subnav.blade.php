<nav class="navbar navbar-expand-sm navbar-light bg-light" style="box-shadow: inset 0px 5px 5px 0px rgba(173,173,173,0.5);">
    <div class="container">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
                <a class="nav-link pl-0 {{ Route::is('frontend.archive.index') ? "active" : null }}" href="{{ route('frontend.archive.index') }}" title="HLW-Historie">HLW-Historie</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::is('frontend.static.halloffame') ? "active" : null }}" href="{{ route('frontend.static.halloffame') }}" title="Titelträger">Ruhmeshalle</a>
            </li>
            <li>
                <a class="nav-link {{ Route::is('frontend.archive.formerclubs') ? "active" : null }}" href="{{ route('frontend.archive.formerclubs') }}" title="Ehemalige Teams">Ehemalige</a>
            </li>
        </ul>
    </div>
</nav>