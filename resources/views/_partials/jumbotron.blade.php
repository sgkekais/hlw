@if(str_is('frontend.divisions.*', Route::currentRouteName()))

    @php
        // different jumbo backgrounds for different divisions
        $jumbo_bg = asset('storage/grass_green_new.jpg');
        if ($division->competition->name_short == "AHL") {
            $jumbo_bg = asset('storage/grass_bw_new.jpg');
        } elseif ($division->competition->name_short == "Pokal") {
            $jumbo_bg = asset('storage/cup.jpg');
        } elseif ($division->competition->name_short == "Playoffs") {
            $jumbo_bg = asset('storage/cup.jpg');
        }
    @endphp

    <div class="jumbotron jumbotron-fluid p-0 m-0" style="color: #fff9c4; background: url({{ $jumbo_bg }}) {{ $division->competition->name_short != ("Pokal" || "Playoffs") ? "top left repeat" : "center" }}; {{ $division->competition->name_short == "P" ? "background-size: cover" : null }}">
        <div class="container pt-4 pb-4">
            <div class="col-12 p-0">
                <div class="display-4 font-weight-bold">
                    @if ($division->competition_id == 1)
                        {{ $division->competition->name_short }} &#448; {{ $division->name }}
                    @else
                        {{ $division->name }}
                    @endif
                </div>
            </div>
        </div>
    </div>

@endif