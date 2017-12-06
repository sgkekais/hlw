
<table class="table table-striped table-responsive-md">
    <thead>
        <tr>
            <th class="text-left">&nbsp;</th>
            @foreach($season->clubs->sortBy('name') as $club)
                <th class="text-center">
                    @if($club->logo_url)
                        <a href="{{ route('frontend.clubs.show', $club->id) }}" title="Zur Teamseite"><img src="{{ asset('storage/'.$club->logo_url) }}" width="30" title="{{ $club->name }}"></a>
                    @else
                        <span class="fa fa-fw fa-ban text-secondary"></span>
                    @endif
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($season->clubs->sortBy('name') as $club_a)
            <tr>
                <td class="align-middle text-left">
                    @if($club_a->logo_url)
                        <a href="{{ route('frontend.clubs.show', $club_a->id) }}" title="Zur Teamseite"><img src="{{ asset('storage/'.$club_a->logo_url) }}" width="30" title="{{ $club_a->name }}"></a>
                    @else
                        <span class="fa fa-fw fa-ban text-secondary"></span>
                    @endif
                </td>
                @foreach($season->clubs->sortBy('name') as $club_b)
                    @if($club_b->id == $club_a->id)
                        <td class="align-middle text-center">=</td>
                    @else
                        <td class="align-middle text-center">
                            @php
                                $fixture = $season->fixtures->where('club_id_home', $club_a->id)->where('club_id_away', $club_b->id)->first();
                            @endphp
                            @if($fixture)
                                @if($fixture->isPlayed() && !$fixture->isRated())
                                    <span class="badge badge-pill font-weight-normal {{ $club_a->hasWon($fixture) ? "badge-success" : null  }} {{ $club_a->hasDrawn($fixture) ? "badge-secondary" : null }} {{ $club_a->hasLost($fixture) ? "badge-danger" : null }}" style="font-size: 100%">{{ $fixture->goals_home }}:{{ $fixture->goals_away }}</span>
                                @elseif($fixture->isRated())
                                    <span class="badge badge-pill font-weight-normal badge-warning" style="font-size: 100%">{{ $fixture->goals_home_rated }}:{{ $fixture->goals_away_rated }}</span>
                                @else
                                    <span class="badge badge-pill font-weight-normal" style="font-size: 100%">-:-</span>
                                @endif
                            @else
                                <span class="badge badge-pill font-weight-normal" style="font-size: 100%">-:-</span>
                            @endif
                        </td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>