@foreach($season->matchweeks as $matchweek)
    <div class="row">
        <a name="matchweek{{ $matchweek->number_consecutive }}"></a>
        <div class="col-12">
            <h4>Spielwoche <b>{{ $matchweek->number_consecutive }}</b>
                <small class="text-muted d-inline-block">
                    {{ $matchweek->name ? $matchweek->name." | " : null }}
                    {{ $matchweek->begin ? $matchweek->begin->format('d.m.Y') : null }}
                    {{ $matchweek->end ? " bis ".$matchweek->end->format('d.m.Y') : null }}
                </small>
            </h4>
            <table class="table table-hover table-striped table-sm">
                <thead>
                    <tr class="align-middle">
                        <th class="text-center" style="width: 5%">
                            <span class="fa fa-info"></span>
                        </th>
                        <th class="text-right" style="width: 20%">
                            <span class="fa fa-calendar"></span>
                        </th>
                        <th class="" style="width: 25%">&nbsp;</th>
                        <th class="text-center" style="width: 10%">
                            <span class="fa fa-fw fa-handshake-o"></span>
                        </th>
                        <th class="" style="width: 25%"></th>
                        <th class="text-left" style="width: 15%">
                            @svg('arena', ['class' => 'align-middle pr-1', 'style' => 'fill: #343a40', 'width' => '30', 'height' => '30'])
                        </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($matchweek->fixtures()->published()->orderBy('datetime')->get() as $fixture)
                    <tr class="" style="{{ $fixture->rescheduledTo || $fixture->isCancelled() ? "text-decoration: line-through" : null }}">
                        <td class="align-middle text-center">
                            @if($fixture->isCancelled())
                                <span class="fa fa-fw fa-ban text-danger" title="Annulliert"></span>
                            @elseif($fixture->isRated())
                                <span class="fa fa-fw fa-gavel text-warning" title="Gewertet"></span>
                            @elseif($fixture->rescheduledTo)
                                <span class="fa fa-fw fa-calendar-times-o text-danger" title="Verlegt"></span>
                            @elseif($fixture->rescheduledFrom)
                                <span class="fa fa-fw fa-calendar-plus-o" title="Verlegte Begegnung"></span>
                            @else
                                <span class="fa fa-fw"></span>
                            @endif
                        </td>
                        {{-- date - day of week, date, time --}}
                        <td class="align-middle text-right">
                            {{ $fixture->datetime ? $fixture->datetime->formatLocalized('%a').", " : null }}
                            @if($fixture->datetime)
                                {{ $fixture->datetime->format('d.m. H:i') }}
                            @else
                                <span class="text-muted">o. D.</span>
                            @endif
                        </td>
                        {{-- home team --}}
                        <td class="align-middle text-right">
                            @if($fixture->clubHome)
                                {{-- visible only on xs --}}
                                <span class="d-inline d-sm-none">{{ $fixture->clubHome->name_code }}</span>
                                {{-- visible only on sm and md --}}
                                <span class="d-none d-sm-inline d-lg-none">{{ $fixture->clubHome->name_short }}</span>
                                {{-- hidden on xs, sm, md --}}
                                <span class="d-none d-lg-inline">{{ $fixture->clubHome->name }}</span>
                                @if($fixture->clubHome->logo_url)
                                    <img src="{{ Storage::url($fixture->clubHome->logo_url) }}" height="25" class="pl-1 d-none d-md-inline">
                                @else
                                    <span class="fa fa-ban text-muted d-none d-md-inline" title="Kein Vereinswappen vorhanden"></span>
                                @endif
                            @else
                                {{ $fixture->club_home }}
                            @endif
                        </td>
                        {{-- result --}}
                        <td class="align-middle text-center">
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
                        </td>
                        {{-- away team --}}
                        <td class="align-middle">
                            @if($fixture->clubAway)
                                @if($fixture->clubAway->logo_url)
                                    <img src="{{ Storage::url($fixture->clubAway->logo_url) }}" height="25" class="pr-1 d-none d-md-inline">
                                @else
                                    <span class="fa fa-ban text-muted d-none d-md-inline" title="Kein Vereinswappen vorhanden"></span>
                                @endif
                                {{-- visible only on xs --}}
                                <span class="d-inline d-sm-none">{{ $fixture->clubAway->name_code }}</span>
                                {{-- visible only on sm and md --}}
                                <span class="d-none d-sm-inline d-lg-none">{{ $fixture->clubAway->name_short }}</span>
                                {{-- hidden on xs, sm, md --}}
                                <span class="d-none d-lg-inline">{{ $fixture->clubAway->name }}</span>
                            @else
                                {{ $fixture->club_away }}
                            @endif
                        </td>
                        {{-- stadium --}}
                        <td class="align-middle">
                            {{-- TODO: mark non-regular stadium --}}
                            @if($fixture->stadium)
                                {{ $fixture->stadium->name_short }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <span class="pull-right"><a href="#top"><span class="fa fa-arrow-up"></span> nach oben</a></span>
        </div>

    </div>
@endforeach