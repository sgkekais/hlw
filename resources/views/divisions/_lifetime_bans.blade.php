    @if (!$lifetime_bans->isEmpty())
        <div class="container pt-1">
            <div class="row">
                <div class="col">
                    <h3 class="font-weight-bold font-italic">Gesperrt auf Lebenszeit</h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="align-middle"><span class="fa fa-user" title="Name"></span> <span class="fa fa-shield" title="Team"></span></th>
                            <th class="align-middle"><span class="fa fa-calendar" title="Datum"></span> </th>
                            <th class="align-middle"><span class="fa fa-handshake-o" title="Paarung"></span> </th>
                            <th class="align-middle text-center"><span class="fa fa-thumbs-o-down" title="Sperre"></span> </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($lifetime_bans as $lifetime_ban)
                            <tr class="">
                                {{-- Name --}}
                                <td class="align-middle">
                                    {{ $lifetime_ban->player->person->full_name_shortened }}
                                    <br>
                                    <a href="{{ route('frontend.clubs.show', $lifetime_ban->player->club) }}" title="Teamdetails">
                                        {{-- visible only on xs --}}
                                        <span class="d-inline d-md-none align-middle">{{ $lifetime_ban->player->club->name_code }}</span>
                                        {{-- visible only on md --}}
                                        <span class="d-none d-md-inline d-lg-none align-middle">{{ $lifetime_ban->player->club->name_short }}</span>
                                        {{-- hidden on xs, sm, md --}}
                                        <span class="d-none d-lg-inline align-middle">{{ $lifetime_ban->player->club->name }}</span>
                                    </a>
                                </td>
                                {{-- Date --}}
                                <td class="align-middle">
                                    {{ $lifetime_ban->fixture->datetime ? $lifetime_ban->fixture->datetime->format('d.m.y') : null }}
                                </td>
                                {{-- Match --}}
                                <td class="align-middle">
                                    @if($lifetime_ban->fixture->clubHome)
                                        {{-- visible only on xs --}}
                                        <span class="d-inline d-md-none align-middle pr-1">{{ $lifetime_ban->fixture->clubHome->name_code }}</span>
                                        {{-- visible only on sm and md --}}
                                        <span class="d-none d-md-inline d-lg-none align-middle pr-1">{{ $lifetime_ban->fixture->clubHome->name_short }}</span>
                                        {{-- hidden on xs, sm, md --}}
                                        <span class="d-none d-lg-inline align-middle pr-1">{{ $lifetime_ban->fixture->clubHome->name }}</span>
                                    @endif
                                    :
                                    @if($lifetime_ban->fixture->clubAway)
                                        {{-- visible only on xs --}}
                                        <span class="d-inline d-md-none align-middle pr-1">{{ $lifetime_ban->fixture->clubAway->name_code }}</span>
                                        {{-- visible only on sm and md --}}
                                        <span class="d-none d-md-inline d-lg-none align-middle pr-1">{{ $lifetime_ban->fixture->clubAway->name_short }}</span>
                                        {{-- hidden on xs, sm, md --}}
                                        <span class="d-none d-lg-inline align-middle pr-1">{{ $lifetime_ban->fixture->clubAway->name }}</span>
                                    @endif
                                    <span class="pull-right">
                                        <a href="{{ route('frontend.fixtures.show', $lifetime_ban->fixture) }}" title="Spieldetails">
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </span>
                                </td>
                                {{-- Ban --}}
                                <td class="align-middle text-center">
                                    Lebenszeit
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
