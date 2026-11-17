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
                <?php
                        // TODO: controller for nav...?
                    // Nav menu by published division
                    /*
                     *  @foreach(\HLW\Division::published()->orderBy('name')->get() as $division)
                            <li class="nav-item {{ Request::segment(1) == "division" && Request::segment(2) == $division->id ? "active" : null }} {{ Request::segment(1) == "season" && \HLW\Season::find(Request::segment(2))->division->id == $division->id ? "active" : null }}">
                                <a class="nav-link" href="{{ $division->competition->isLeague() ? route('frontend.divisions.show', $division ) : route('frontend.divisions.fixtures', $division) }}" title="{{ $division->name }}"> <span class="fa"></span> {{ $division->name }}</a>
                            </li>
                        @endforeach
                     */

                    /*$division_ids = [5, 6, 3, 4, 12];

                    $divisions = HLW\Division::find($division_ids);
                    $divisions->load('seasons');
                    $divisions_ordered = $divisions->sortBy(function($model) use ($division_ids) {
                        return array_search($model->getKey(), $division_ids);
                    });*/

                    $divisions = HLW\Division::navShow()->orderBy('nav_order')->get()->load('seasons');
                ?>
                <!-- Manual menu for 2019 TODO: make menu builder -->

                {{--@foreach($divisions_ordered as $division)
                    <li class="nav-item dropdown {{ Request::segment(1) == "division" && Request::segment(2) == $division->id ? "active" : null }} {{ Request::segment(1) == "season" && \HLW\Season::find(Request::segment(2))->division->id == $division->id ? "active" : null }}">
                        <a class="nav-link" href="{{ $division->competition->isLeague() ? route('frontend.divisions.tables', $division ) : route('frontend.divisions.fixtures', $division) }}" title="{{ $division->name }} " id="navbarDropdown{{ $loop->index }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fa"></span> {{ $division->competition->isLeague() ? $division->competition->name_short : null }}
                            @switch($division->id)
                                @case(5)
                                    Gr. A
                                    @break
                                @case(6)
                                    Gr. B
                                    @break
                                @case(8)
                                    HLW Playoffs
                                    @break
                                @case(9)
                                    Gr. A
                                    @break
                                @case(10)
                                    Gr. B
                                    @break
                                @case(11)
                                    AH Playoffs
                                    @break
                                @case(12)
                                    AH Cup
                                    @break
                                @case(3)
                                    {{ $division->name }}
                                    @break
                            @endswitch
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $loop->index }}">
                            @if ($division->competition->isLeague())
                                <a class="dropdown-item" href="{{ route('frontend.divisions.tables', $division) }}">
                                    <span class="fa fa-fw fa-list-ol"></span> Tabelle
                                </a>
                            @endif
                            <a class="dropdown-item" href="{{ route('frontend.divisions.fixtures', $division) }}"><span class="fa fa-fw fa-calendar"></span> Spielplan</a>
                            @if (config('hlw.public_personal_data'))
                                <a class="dropdown-item" href="{{ route('frontend.divisions.scorers', $division) }}"><span class="fa fa-fw fa-soccer-ball-o"></span> Torjäger</a>
                                <a class="dropdown-item" href="{{ route('frontend.divisions.sinners', $division) }}"><span class="fa fa-fw fa-thumbs-o-down"></span> Sünderkartei</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('frontend.seasons.clubs',
                                $division->seasons()->current()->first()
                                ?: $division->seasons()->where('begin','>=',Carbon::now())->orderBy('begin')->get()->first()
                                ?: $division->seasons()->orderBy('end', 'desc')->first()
                                ) }}
                            ">
                                <span class="fa fa-fw fa-shield"></span> Teams
                            </a>
                        </div>
                    </li>
                @endforeach--}}

                @foreach($divisions as $division)
                    <li class="nav-item dropdown {{ Request::segment(1) == "division" && Request::segment(2) == $division->id ? "active" : null }} {{ Request::segment(1) == "season" && \HLW\Season::find(Request::segment(2))->division->id == $division->id ? "active" : null }}">
                        <a class="nav-link" href="{{ $division->competition->isLeague() ? route('frontend.divisions.tables', $division ) : route('frontend.divisions.fixtures', $division) }}" title="{{ $division->name }} " id="navbarDropdown{{ $loop->index }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $division->nav_text }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $loop->index }}">
                            @if ($division->competition->isLeague())
                                <a class="dropdown-item" href="{{ route('frontend.divisions.tables', $division) }}">
                                    <span class="fa fa-fw fa-list-ol"></span> Tabelle
                                </a>
                            @endif
                            <a class="dropdown-item" href="{{ route('frontend.divisions.fixtures', $division) }}"><span class="fa fa-fw fa-calendar"></span> Spielplan</a>
                            @if (config('hlw.public_personal_data'))
                                <a class="dropdown-item" href="{{ route('frontend.divisions.scorers', $division) }}"><span class="fa fa-fw fa-soccer-ball-o"></span> Torjäger</a>
                                <a class="dropdown-item" href="{{ route('frontend.divisions.sinners', $division) }}"><span class="fa fa-fw fa-thumbs-o-down"></span> Sünderkartei</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('frontend.seasons.clubs',
                                $division->seasons()->current()->first()
                                ?: $division->seasons()->where('begin','>=',Carbon::now())->orderBy('begin')->get()->first()
                                ?: $division->seasons()->orderBy('end', 'desc')->first()
                                ) }}
                            ">
                                <span class="fa fa-fw fa-shield"></span> Teams
                            </a>
                        </div>
                    </li>
                @endforeach

                <li class="nav-item">
                    <a class="nav-link {{ Route::is('frontend.static.infos') ? "active" : null }}" href="{{ route('frontend.static.infos') }}" title="Vorstand, Satzungen und Infos">Infos</a>
                </li>
                <li>
                    <a class="nav-link {{ Route::is('frontend.archive.index') ? "active" : null }}" href="{{ route('frontend.archive.index') }}" title="Archiv">Historie</a>
                </li>
            </ul>
        </div>
    </div>
</nav>