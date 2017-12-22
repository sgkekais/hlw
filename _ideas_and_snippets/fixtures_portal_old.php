<!-- fixtures of the current week -->
        @if($fixtures->count() > 0)
            <div class="row">
                <div class="col">
                    <h1 class="font-weight-bold font-italic">In dieser Woche</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @foreach ($fixtures->chunk(6) as $chunk)
                        <div class="row">
                            @foreach($chunk as $fixture)
                                <div class="col-6 col-sm-4 col-md-3 col-lg-2 {{ !$loop->last ? "border border-left-0 border-top-0 border-bottom-0" : null }} mt-2 mb-2">
                                    {{-- details --}}
                                    <div class="row">
                                        <div class="col-6 pr-0 text-muted">
                                            <small>{{ $fixture->datetime ? $fixture->datetime->format('d.m.') : "-" }}</small>
                                        </div>
                                        <div class="col-6 pl-0 text-muted text-right">
                                            <small>{{ $fixture->datetime ? $fixture->datetime->format('H:i') : "-" }}</small>
                                        </div>
                                    </div>
                                    {{-- top row --}}
                                    <div class="row">
                                        <div class="col-9 pr-0">
                                            @if($fixture->clubHome)
                                                @if($fixture->clubHome->logo_url)
                                                    <img src="{{ Storage::url($fixture->clubHome->logo_url) }}" width="30">
                                                @else
                                                    <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                                @endif
                                                <span class="pl-1 d-none d-lg-inline align-middle">{{ $fixture->clubHome->name_short }}</span>
                                                <span class="pl-1 d-lg-none align-middle">{{ $fixture->clubHome->name_code }}</span>
                                            @else
                                                -
                                            @endif
                                        </div>
                                        <div class="col-3 pl-0 text-right">
                                            @if($fixture->isPlayed() && !$fixture->isRated())
                                                {{ $fixture->goals_home ?? "-" }}
                                            @elseif($fixture->isRated())
                                                {{ $fixture->goals_home_rated ?? "-" }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    {{-- bottom row --}}
                                    <div class="row pt-1">
                                        <div class="col-9 pr-0">
                                            @if($fixture->clubAway)
                                                @if($fixture->clubAway->logo_url)
                                                    <img src="{{ Storage::url($fixture->clubAway->logo_url) }}" width="30">
                                                @else
                                                    <span class="fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                                @endif
                                                <span class="pl-1 d-none d-lg-inline align-middle">{{ $fixture->clubAway->name_short }}</span>
                                                <span class="pl-1 d-lg-none align-middle">{{ $fixture->clubAway->name_code }}</span>
                                            @else
                                                -
                                            @endif
                                        </div>
                                        <div class="col-3 pl-0 text-right">
                                            @if($fixture->isPlayed() && !$fixture->isRated())
                                                {{ $fixture->goals_away ?? "-" }}
                                            @elseif($fixture->isRated())
                                                {{ $fixture->goals_away_rated ?? "-" }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @unless ($loop->last)
                            <hr class="d-none d-lg-block">
                        @endunless
                    @endforeach
                </div>
            </div>
        @endif
        <!-- end fixtures of the current week -->