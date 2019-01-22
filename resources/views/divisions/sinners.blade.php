@extends('layouts.app')

@section('title')
    | {{ $division->name }} | Sünderkartei
@endsection

{{--
@section('subnav')

    @include('_partials.subnav_divisions')

@endsection
--}}

@section('content')

    <div class="container pt-4">
        <div class="row">
            <div class="col">
                <h1 class="font-weight-bold font-italic text-uppercase">Sünderkartei</h1>
                <div class="alert alert-secondary">
                    <ul class="mb-0 pl-2">
                        <li>Die Sperren zählen wettbewerbs- und saisonübergreifend.</li>
                        <li>Für die Sperre sind nur <b>gespielte</b> Spiele relevant.</li>
                        <li>Jede rote Karte führt automatisch zu einer Sperre von mindestens zwei Spielen, auch wenn diese nicht hier aufgeführt ist!</li>
                        <li>Die Zahl in Klammern gibt die Anzahl der Spiele wieder, die der Spieler noch gesperrt ist.</li>
                    </ul>
                </div>
                <div class="mt-2">
                    <span class="align-middle pr-2">
                        Saison auswählen:
                    </span>

                    <button class="btn btn-secondary dropdown-toggle" type="button" id="season_selector_title" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $season->name }}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="season_selector_title">
                        @foreach($division->seasons()->published()->orderBy('end','desc')->get() as $s)
                            <a class="dropdown-item season" href="#" id="{{ $s->id }}">{{ $s->name }}</a>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
        <div id="sinners-container" class="mt-2">

        </div>
    </div>
    @if (!$lifetime_bans->isEmpty())
        <div class="container pt-1">
            <div class="row">
                <div class="col">
                    <h2 class="font-weight-bold font-italic">Gesperrt auf Lebenszeit</h2>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="align-middle"><span class="fa fa-user" title="Name"></span></th>
                            <th class="align-middle"><span class="fa fa-shield" title="Team"></span></th>
                            <th class="align-middle"><span class="fa fa-calendar" title="Datum"></span> </th>
                            <th class="align-middle"><span class="fa fa-handshake-o" title="Paarung"></span> </th>
                            <th class="align-middle text-center"><span class="fa fa-thumbs-o-down" title="Sperre"></span> </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($lifetime_bans as $lifetime_ban)
                            <tr class="">
                                {{-- Name --}}
                                <td class="">
                                    {{ $lifetime_ban->player->person->full_name_shortened }}
                                </td>
                                {{-- Club --}}
                                <td class="">
                                    <a href="{{ route('frontend.clubs.show', $lifetime_ban->player->club) }}" title="Teamdetails">{{ $lifetime_ban->player->club->name_short }}</a>
                                </td>
                                {{-- Date --}}
                                <td class="">
                                    {{ $lifetime_ban->fixture->datetime ? $lifetime_ban->fixture->datetime->format('d.m.Y') : null }}
                                </td>
                                {{-- Match --}}
                                <td class="">
                                    {{ $lifetime_ban->fixture->clubHome ? $lifetime_ban->fixture->clubHome->name_short : "-" }} : {{ $lifetime_ban->fixture->clubAway ? $lifetime_ban->fixture->clubAway->name_short : "-" }}
                                    <span class="pull-right">
                                    <a href="{{ route('frontend.fixtures.show', $lifetime_ban->fixture) }}" title="Spieldetails">
                                        <i class="fa fa-arrow-right"></i>
                                    </a>
                                </span>
                                </td>
                                {{-- Ban --}}
                                <td class="text-center">
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

@endsection

@section('js-footer')

    <script type="text/javascript">
        function getSinners(season){
            // Add loading indicator back
            $('#sinners-container').html(@include('loader'));

            $.ajax({
                method:     'GET',
                url:        '/division/{{ $division->id }}/sinners/ajax-sinners',
                data:       {'season_id' : season},

                success: function(response){
                    $('#sinners-container').html(response);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        }

        $(function() {

            var season_id = {{ $season->id }};
            getSinners(season_id);

            // select another season
            $('.season').click(function () {
                // set the season_id to the selected value
                season_id = $(this).attr('id');
                // replace the selector title
                $('#season_selector_title').text($(this).text());
                // get the full table content
                getSinners(season_id);
            });

        });
    </script>

@endsection