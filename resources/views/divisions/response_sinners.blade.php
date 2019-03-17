<div class="row">
    <div class="col">
        {{-- cards from selected season --}}
        <h3 class="font-weight-bold font-italic">
            In Saison {{ $season->name }} erhalten
        </h3>
        @if (!$cards->isEmpty())
            <table class="table">
                <thead>
                <tr>
                    <th class="align-middle"><span class="fa fa-user" title="Name"></span> <span class="fa fa-shield" title="Team"></span></th>
                    <th class="align-middle"><span class="fa fa-calendar" title="Datum"></span></th>
                    <th class="align-middle"><span class="fa fa-handshake-o" title="Paarung"></span></th>
                    <th class="align-middle"><span class=""></span></th>
                    <th class="align-middle text-center"><span class="fa fa-thumbs-o-down" title="Sperre"></span></th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($cards as $card)
                        {{-- check if player is still suspended --}}
                        @php
                            $suspension = $card->player->isSuspended();
                        @endphp
                        <tr class="{{ $suspension && ($suspension->id == $card->id) ? "text-danger" : null }}">
                            {{-- Name --}} {{-- Club --}}
                            <td class="align-middle">
                                {{ $card->player->person->full_name_shortened }}
                                <br>
                                <a href="{{ route('frontend.clubs.show', $card->player->club) }}" title="Teamdetails">
                                    {{-- visible only on xs --}}
                                    <span class="d-inline d-md-none align-middle pr-1">{{ $card->player->club->name_code }}</span>
                                    {{-- visible only on md --}}
                                    <span class="d-none d-md-inline d-lg-none align-middle pr-1">{{ $card->player->club->name_short }}</span>
                                    {{-- hidden on xs, sm, md --}}
                                    <span class="d-none d-lg-inline align-middle pr-1">{{ $card->player->club->name }}</span>
                                </a>
                            </td>
                            {{-- Date --}}
                            <td class="align-middle">
                                {{ $card->fixture->datetime ? $card->fixture->datetime->format('d.m.y') : null }}
                            </td>
                            {{-- Match --}}
                            <td class="align-middle">
                                @if($card->fixture->clubHome)
                                    {{-- visible only on xs --}}
                                    <span class="d-inline d-md-none align-middle pr-1">{{ $card->fixture->clubHome->name_code }}</span>
                                    {{-- visible only on sm and md --}}
                                    <span class="d-none d-md-inline d-lg-none align-middle pr-1">{{ $card->fixture->clubHome->name_short }}</span>
                                    {{-- hidden on xs, sm, md --}}
                                    <span class="d-none d-lg-inline align-middle pr-1">{{ $card->fixture->clubHome->name }}</span>
                                @endif
                                :
                                @if($card->fixture->clubAway)
                                    {{-- visible only on xs --}}
                                    <span class="d-inline d-md-none align-middle pr-1">{{ $card->fixture->clubAway->name_code }}</span>
                                    {{-- visible only on sm and md --}}
                                    <span class="d-none d-md-inline d-lg-none align-middle pr-1">{{ $card->fixture->clubAway->name_short }}</span>
                                    {{-- hidden on xs, sm, md --}}
                                    <span class="d-none d-lg-inline align-middle pr-1">{{ $card->fixture->clubAway->name }}</span>
                                @endif
                                <span class="pull-right align-middle">
                                    <a href="{{ route('frontend.fixtures.show', $card->fixture) }}" title="Spieldetails">
                                        <i class="fa fa-arrow-right"></i>
                                    </a>
                                </span>
                            </td>
                            {{-- Color --}}
                            <td class="align-middle text-center">
                                @if ($card->color == "gelb")
                                    <span class="fa fa-fw fa-square text-warning" title="Gelb"></span>
                                @elseif ($card->color == "gelb-rot")
                                    <span class="fa fa-square text-warning" title="Gelb"></span> <span class="fa fa-fw fa-square text-danger" title="Rot"></span>
                                @elseif ($card->color == "rot")
                                    <span class="fa fa-fw fa-square text-danger" title="Rot"></span>
                                @endif
                            </td>
                            {{-- Ban --}}
                            <td class="align-middle text-center">
                                @if (!$card->ban_season)
                                    {{ $card->ban_matches }} {{ $card->ban_reduced_by ? "- ".$card->ban_reduced_by : null }}
                                    @if ($suspension && ($suspension->id == $card->id))
                                        ({{ $suspension->ban_remaining }})
                                    @else
                                        (0) <span class="fa fa-thumbs-up text-primary" title="wieder spielberechtigt"></span>
                                    @endif
                                @else
                                    Saisonsperre
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="border-top-0 py-0">
                                <small>
                                    Sperre gilt für:
                                    @foreach ($card->divisions as $division)
                                        {{ $division->name }}
                                        @unless ($loop->last)
                                            ,
                                        @endunless
                                    @endforeach
                                </small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-success">
                <span class="fa fa-fw fa-smile-o"></span> Keine Sünder in ausgewählter Saison.
            </div>
        @endif
        @if (!$cards_from_other_season_or_division->isEmpty())
            <h3 class="font-weight-bold font-italic">
                Aus vorheriger Saison oder anderer Spielklasse
            </h3>
            <table class="table">
                <thead>
                <tr>
                    <th class="align-middle"><span class="fa fa-user" title="Name"></span> <span class="fa fa-shield" title="Team"></span></th>
                    <th class="align-middle"><span class="fa fa-calendar" title="Datum"></span></th>
                    <th class="align-middle"><span class="fa fa-handshake-o" title="Paarung"></span></th>
                    <th class="align-middle"><span class=""></span></th>
                    <th class="align-middle text-center"><span class="fa fa-thumbs-o-down" title="Sperre"></span></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cards_from_other_season_or_division as $card)
                    {{-- check if player is still suspended --}}
                    @php
                        $suspension = $card->player->isSuspended();
                    @endphp
                    <tr class="{{ $suspension && ($suspension->id == $card->id) ? "text-danger" : null }}">
                        {{-- Name --}} {{-- Club --}}
                        <td class="align-middle pb-0">
                            {{ $card->player->person->full_name_shortened }}
                            <br>
                            <a href="{{ route('frontend.clubs.show', $card->player->club) }}" title="Teamdetails">
                                {{-- visible only on xs --}}
                                <span class="d-inline d-md-none align-middle pr-1">{{ $card->player->club->name_code }}</span>
                                {{-- visible only on md --}}
                                <span class="d-none d-md-inline d-lg-none align-middle pr-1">{{ $card->player->club->name_short }}</span>
                                {{-- hidden on xs, sm, md --}}
                                <span class="d-none d-lg-inline align-middle pr-1">{{ $card->player->club->name }}</span>
                            </a>
                        </td>
                        {{-- Date --}}
                        <td class="align-middle pb-0">
                            {{ $card->fixture->datetime ? $card->fixture->datetime->format('d.m.y') : null }}
                        </td>
                        {{-- Match --}}
                        <td class="align-middle pb-0">
                            <small>
                                {{ $card->fixture->matchweek->season->division->name }}
                            </small>
                            <br>
                            <a href="{{ route('frontend.fixtures.show', $card->fixture) }}" title="Spieldetails">
                                @if($card->fixture->clubHome)
                                    {{-- visible only on xs --}}
                                    <span class="d-inline d-md-none align-middle pr-1">{{ $card->fixture->clubHome->name_code }}</span>
                                    {{-- visible only on sm and md --}}
                                    <span class="d-none d-md-inline d-lg-none align-middle pr-1">{{ $card->fixture->clubHome->name_short }}</span>
                                    {{-- hidden on xs, sm, md --}}
                                    <span class="d-none d-lg-inline align-middle pr-1">{{ $card->fixture->clubHome->name }}</span>
                                @endif
                                :
                                @if($card->fixture->clubAway)
                                    {{-- visible only on xs --}}
                                    <span class="d-inline d-md-none align-middle pr-1">{{ $card->fixture->clubAway->name_code }}</span>
                                    {{-- visible only on sm and md --}}
                                    <span class="d-none d-md-inline d-lg-none align-middle pr-1">{{ $card->fixture->clubAway->name_short }}</span>
                                    {{-- hidden on xs, sm, md --}}
                                    <span class="d-none d-lg-inline align-middle pr-1">{{ $card->fixture->clubAway->name }}</span>
                                @endif
                            </a>
                        </td>
                        {{-- Color --}}
                        <td class="align-middle pb-0 text-center">
                            @if ($card->color == "gelb")
                                <span class="fa fa-fw fa-square text-warning" title="Gelb"></span>
                            @elseif ($card->color == "gelb-rot")
                                <span class="fa fa-square text-warning" title="Gelb"></span> <span class="fa fa-fw fa-square text-danger" title="Rot"></span>
                            @elseif ($card->color == "rot")
                                <span class="fa fa-fw fa-square text-danger" title="Rot"></span>
                            @endif
                        </td>
                        {{-- Ban --}}
                        <td class="align-middle pb-0 text-center">
                            @if (!$card->ban_season)
                                {{ $card->ban_matches }} {{ $card->ban_reduced_by ? "- ".$card->ban_reduced_by : null }}
                                @if ($suspension && ($suspension->id == $card->id))
                                    ({{ $suspension->ban_remaining }})
                                @else
                                    (0) <span class="fa fa-thumbs-up text-primary" title="wieder spielberechtigt"></span>
                                @endif
                            @else
                                Saisonsperre
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="border-top-0 py-0">
                            <small>
                                Sperre gilt für:
                                @foreach ($card->divisions as $division)
                                    {{ $division->name }}
                                    @unless ($loop->last)
                                        ,
                                    @endunless
                                @endforeach
                            </small>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>