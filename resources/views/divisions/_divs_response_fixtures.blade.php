@foreach($season->matchweeks as $matchweek)
    <div class="row">
        <a name="matchweek{{ $matchweek->number_consecutive }}"></a>
        <div class="col">
            <h4>Spielwoche <b>{{ $matchweek->number_consecutive }}</b>
                <small class="text-muted d-inline-block">
                    {{ $matchweek->name ? $matchweek->name." | " : null }}
                    {{ $matchweek->begin ? $matchweek->begin->format('d.m.Y') : null }}
                    {{ $matchweek->end ? " bis ".$matchweek->end->format('d.m.Y') : null }}
                </small>
            </h4>
        </div>
    </div>
    <div class="row d-flex align-items-stretch" style="height: 31px">
        <div class="col-1 text-center">
            <div class="h-100 border border-left-0 border-top-0 border-right-0">
                <span class="fa fa-info align-middle"></span>
            </div>
        </div>
        <div class="col-2">
            <div class="h-100 border border-left-0 border-top-0 border-right-0">
                <span class="fa fa-calendar align-middle"></span>
            </div>
        </div>
        <div class="col-7 text-center">
            <div class="h-100 border border-left-0 border-top-0 border-right-0">
                <span class="fa fa-handshake-o align-middle"></span>
            </div>
        </div>
        <div class="col-2">
            <div class="h-100 border border-left-0 border-top-0 border-right-0">
                @svg('arena', ['class' => 'align-middle pr-1', 'style' => 'fill: #343a40', 'width' => '30', 'height' => '30'])
            </div>
        </div>
    </div>
    @foreach($matchweek->fixtures()->published()->orderBy('datetime')->get() as $fixture)
        <div class="row mt-2 mb-1 d-flex align-items-center" style="height: 35px;">
            <div class="col-1 text-center">
                @if($fixture->isCancelled())
                    <span class="fa fa-fw fa-ban text-danger" title="Annulliert"></span>
                @elseif($fixture->isRated())
                    <span class="fa fa-fw fa-gavel text-warning"title="Gewertet"></span>
                @elseif($fixture->rescheduledTo)
                    <span class="fa fa-fw fa-calendar-plus-o text-danger" title="Verlegt"></span>
                @elseif($fixture->rescheduledFrom)
                    <span class="fa fa-fw fa-calendar-plus-o" title="Verlegte Begegnung"></span>
                @else
                    <span class="fa fa-fw"></span>
                @endif
            </div>
            <div class="col-2">
                {{-- date - day of week --}}
                {{ $fixture->datetime ? $fixture->datetime->formatLocalized('%a').", " : null }}
                @if($fixture->datetime)
                    {{ $fixture->datetime->format('d.m.') }}
                @else
                    <span class="text-muted">o. D.</span>
                @endif
                {{-- date - date and time --}}
                {{ $fixture->datetime ? $fixture->datetime->format('H:i') : null }}
            </div>
            <div class="col-7 d-flex justify-content-between align-items-center">
                {{-- home team --}}
                <div class="text-left" style="width: 45% !important;">
                    @if($fixture->clubHome)
                        @if($fixture->clubHome->logo_url)
                            <img src="{{ Storage::url($fixture->clubHome->logo_url) }}" height="25" class="pl-1 d-none d-md-inline">
                        @else
                            <span class="fa fa-ban text-muted d-none d-md-inline" title="Kein Vereinswappen vorhanden" style="width: 29px; height: 25px"></span>
                        @endif
                        {{-- visible only on xs --}}
                        <span class="d-inline d-sm-none">{{ $fixture->clubHome->name_code }}</span>
                        {{-- visible only on sm and md --}}
                        <span class="d-none d-sm-inline d-lg-none">{{ $fixture->clubHome->name_short }}</span>
                        {{-- hidden on xs, sm, md --}}
                        <span class="d-none d-lg-inline">{{ $fixture->clubHome->name }}</span>
                    @else
                        {{ $fixture->club_home }}
                    @endif
                </div>
                {{-- result --}}
                <div class="text-center">
                    <div class="text-white rounded bg-dark d-inline-block p-1" style="word-break: keep-all">
                        {{-- cancelled? --}}
                        @if($fixture->isCancelled())
                            <span class="text-danger">Ann.</span>
                            {{-- played and *not* rated? --}}
                        @elseif($fixture->isPlayed() && !$fixture->isRated())
                            {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
                            {{-- rated? --}}
                        @elseif($fixture->isRated())
                            <span class="text-warning">{{ $fixture->goals_home_rated }} : {{ $fixture->goals_away_rated }}</span>
                        @else
                            -&nbsp;:&nbsp;-
                        @endif
                    </div>
                </div>
                {{-- away team --}}
                <div class="text-right" style="width: 45% !important;">
                    @if($fixture->clubAway)
                        {{-- visible only on xs --}}
                        <span class="d-inline d-sm-none">{{ $fixture->clubAway->name_code }}</span>
                        {{-- visible only on sm and md --}}
                        <span class="d-none d-sm-inline d-lg-none">{{ $fixture->clubAway->name_short }}</span>
                        {{-- hidden on xs, sm, md --}}
                        <span class="d-none d-lg-inline">{{ $fixture->clubAway->name }}</span>
                        @if($fixture->clubAway->logo_url)
                            <img src="{{ Storage::url($fixture->clubAway->logo_url) }}" height="25" class="pr-1 d-none d-md-inline">
                        @else
                            <span class="fa fa-ban text-muted d-none d-md-inline" title="Kein Vereinswappen vorhanden"></span>
                        @endif
                    @else
                        {{ $fixture->club_away }}
                    @endif
                </div>
            </div>
            <div class="col-2">
                {{-- TODO: mark non-regular stadium --}}
                @if($fixture->stadium)
                    {{ $fixture->stadium->name_short }}
                @endif
            </div>
        </div>

    @endforeach
    <div class="row">
        <div class="col">
            <span class="pull-right"><a href="#top"><span class="fa fa-arrow-up"></span> nach oben</a></span>
        </div>
    </div>
@endforeach