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
                        <li>Die Sperren gelten i.d.R. wettbewerbs- und saisonübergreifend.</li>
                        <li>Für die Sperre sind nur <b>gespielte</b> Spiele relevant.</li>
                        <li>Jede rote Karte führt automatisch zu einer Sperre von mindestens zwei Spielen, auch wenn diese nicht hier aufgeführt ist!</li>
                        <li>Die Zahl in Klammern gibt die Anzahl der Spiele wieder, die der Spieler noch gesperrt ist.</li>
                    </ul>
                </div>
                <div class="mt-2">
                    <span class="align-middle pr-2 font-weight-bold">
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
    @include('divisions._lifetime_bans')

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