@extends('admin.adminlayout')

@section('content')

    <h1 class="">Kartenhistorie</h1>
    <p>
        Verwaltung der Karten.
    </p>
    <hr>
    <div class="row">
        <div class="col">
            <!-- list all cards -->
            <h2 class="">Angelegte Karten <span class="badge badge-secondary">{{ $cards->count() }}</span></h2>
        </div>
    </div>
    <table class="table table-sm table-striped" id="cards">
        <thead class="thead-default">
        <tr>
            <th class="">ID</th>
            <th class="">Spieler</th>
            <th class="">Paarung</th>
            <th class="">Datum</th>
            <th class="text-center">Farbe</th>
            <th class="text-center">Sperre</th>
            <th class="text-center">Minderung</th>
            <th class="">Grund</th>
            <th class="">Notiz</th>
            <th class="">Aktionen</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cards as $card)
            <tr>
                <td class="align-middle"><b>{{ $card->id }}</b></td>
                <td class="align-middle">
                    {{ $card->player->person->full_name }}
                </td>
                <td class="align-middle">
                    {{ $card->fixture->clubHome->name_short }} : {{ $card->fixture->clubAway->name_short }}
                    <br>
                    @can('read fixture')
                        <a href="{{ route('matchweeks.fixtures.show', [$card->fixture->matchweek, $card->fixture]) }}" title="Paarung anzeigen">Paarungs-ID: {{ $card->fixture->id }}</a>
                    @endcan
                    <br>
                    {{ $card->fixture->matchweek->season->division->name }}
                </td>
                <td class="align-middle">
                    {{ $card->fixture->datetime ? $card->fixture->datetime->format('Y-m-d') : null }}
                </td>
                <td class="align-middle text-center">
                    @if($card->color == "gelb")
                        <span style="color: orange">Gelb</span>
                    @elseif($card->color == "gelb-rot")
                        <span style="color: orange">Gelb</span>-<span style="color: red">Rot</span>
                    @elseif($card->color == "rot")
                        <span style="color: red">Rot</span>
                    @else
                        {{ $card->color }}
                    @endif
                </td>
                <td class="align-middle text-center">
                    @if($card->ban_lifetime)
                        Lebenszeit
                    @elseif($card->ban_season)
                        Saison
                    @else
                        {{ $card->ban_matches }}
                    @endif
                </td>
                <td class="align-middle text-center">
                    {{ $card->ban_reduced_by }}
                </td>
                <td class="align-middle" width="15%">
                    {{ $card->ban_reason }}
                </td>
                <td class="align-middle" width="15%">
                    {{ $card->note }}
                </td>
                <td class="align-middle">
                    @can('update card')
                        <!-- edit -->
                        <a class="btn btn-primary btn-sm" href="{{ route('fixtures.cards.edit', [$card->fixture, $card]) }}" title="Karte bearbeiten">
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

@section('pagespecificscripts')
    <script type="text/javascript">
        $(document).ready( function () {

            $('#cards').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
                },
                "order": [[ 3, "asc" ]]
            });

        });
    </script>
@endsection