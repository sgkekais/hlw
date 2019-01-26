
@if(str_is('home', Route::currentRouteName()))

    <div class="jumbotron jumbotron-fluid p-0" style="color: #fff9c4; background: url({{ asset('storage/duesseldorf.jpg') }}) left; background-size: cover;">
        <div class="pt-4 pb-4" style="box-shadow: inset 0px 5px 5px 0px rgba(173,173,173,0.5); width: 100%; height: 100%">
            <div class="container pt-4 pb-4">
                <div class="col-12 p-0">
                    <div class="display-4 font-weight-bold">
                        <span class="px-1 bg-black-transparent" {{--style="font-size: 3rem !important;"--}}>Hobbyliga-West Düsseldorf</span>
                    </div>
                    <h1>
                        <span class="px-1 bg-black-transparent" {{--style="font-size: 2rem !important;"--}}>Die Fußballliga für Hobby- und Freizeitmannschaften aus Düsseldorf und Umgebung.</span>
                    </h1>
                </div>
            </div>
        </div>
    </div>

@endif

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

    <div class="jumbotron jumbotron-fluid p-0 m-0" style="color: #fff9c4; background: url({{ $jumbo_bg }}) {{ $division->competition->name_short != ("Pokal" || "Playoffs") ? "top left repeat" : "center" }}; {{ $division->competition->name_short == "P" ? "background-size: cover;" : null }}
            box-shadow: inset 0px 10px 10px 0px rgba(0,0,0,0.2);">
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