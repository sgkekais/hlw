<div class="row">
    <div class="col">
        @if (!$cards->isEmpty())
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="align-middle"><span class="fa fa-user" title="Name"></span></th>
                    <th class="align-middle"><span class="fa fa-shield" title="Team"></span></th>
                    <th class="align-middle"><span class="fa fa-calendar" title="Datum"></span> </th>
                    <th class="align-middle"><span class="fa fa-handshake-o" title="Paarung"></span> </th>
                    <th class="align-middle"><span class=""></span> </th>
                    <th class="align-middle text-center"><span class="fa fa-thumbs-o-down" title="Sperre"></span> </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cards as $card)
                    {{-- check if player is still suspended --}}
                    @php
                        $suspension = $card->player->isSuspended();
                    @endphp
                    <tr class="{{ $suspension && ($suspension->id == $card->id) ? "text-danger" : null }}">
                        {{-- Name --}}
                        <td class="">
                            {{ $card->player->person->full_name_shortened }}
                        </td>
                        {{-- Club --}}
                        <td class="">
                            <a href="{{ route('frontend.clubs.show', $card->player->club) }}" title="Teamdetails">{{ $card->player->club->name_short }}</a>
                        </td>
                        {{-- Date --}}
                        <td class="">
                            {{ $card->fixture->datetime ? $card->fixture->datetime->format('d.m.Y') : null }}
                        </td>
                        {{-- Match --}}
                        <td class="">
                            {{ $card->fixture->clubHome ? $card->fixture->clubHome->name_short : "-" }} : {{ $card->fixture->clubAway ? $card->fixture->clubAway->name_short : "-" }}
                            <span class="pull-right">
                                        <a href="{{ route('frontend.fixtures.show', $card->fixture) }}" title="Spieldetails">
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </span>
                        </td>
                        {{-- Color --}}
                        <td class="text-center">
                            @if ($card->color == "yellow")
                                <span class="fa fa-fw fa-square text-warning" title="Gelb"></span>
                            @elseif ($card->color == "yellow-red")
                                <span class="fa fa-square text-warning" title="Gelb"></span> <span class="fa fa-fw fa-square text-danger" title="Rot"></span>
                            @elseif ($card->color == "red")
                                <span class="fa fa-fw fa-square text-danger" title="Rot"></span>
                            @endif
                        </td>
                        {{-- Ban --}}
                        <td class="text-center">
                            @if (!$card->ban_season)
                                {{ $card->ban_matches - $card->ban_reduced_by }}
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
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-success">
                <span class="fa fa-fw fa-smile-o"></span> Keine Sünder.
            </div>
        @endif
    </div>
</div>