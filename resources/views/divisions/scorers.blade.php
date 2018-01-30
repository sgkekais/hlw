@extends('layouts.app')

@section('title')
    | {{ $division->name }} | Torschützen
@endsection

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

    <div class="container pt-4">
        <div class="row">
            <div class="col">
                <h1 class="font-weight-bold font-italic text-uppercase">Torjäger</h1>
                <div class="text-muted">
                    Es zählen nur die Tore gespielter Spiele. Tore, die in nachträglich gewerteten oder annullierten Spielen erzielt wurden, werden nicht berücksichtigt.
                    Die Angabe von Torschützen erfolgt freiwillig und von den Mannschaften selbst. Daher erhebt diese Liste keinen Anspruch auf Vollständigkeit.
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
        <div id="scorers-container" class="mt-2">

        </div>
    </div>

@endsection

@section('js-footer')

    <script type="text/javascript">
        function getScorers(season){
            // Add loading indicator back
            $('#scorers-container').html(@include('loader'));

            $.ajax({
                method:     'GET',
                url:        '/division/{{ $division->id }}/scorers/ajax-scorers',
                data:       {'season_id' : season},

                success: function(response){
                    $('#scorers-container').html(response);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        }

        $(function() {

            var season_id = {{ $season->id }};
            getScorers(season_id);

            // select another season
            $('.season').click(function () {
                // set the season_id to the selected value
                season_id = $(this).attr('id');
                // replace the selector title
                $('#season_selector_title').text($(this).text());
                // get the full table content
                getScorers(season_id);
            });

        });
    </script>

@endsection

