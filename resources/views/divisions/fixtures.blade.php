@extends('layouts.app')

@section('title')
    | {{ $division->name }} | Spielplan
@endsection

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@if ($division->competition->isKnockout())
    @section('jumbotron')

        <div class="jumbotron jumbotron-fluid p-0 m-0" style="color: #fff9c4; background: url({{ $jumbo_bg }}) {{ $division->competition->type != "knockout" ? "top left repeat" : "center" }}; {{ $division->competition->type == "knockout" ? "background-size: cover" : null }}">
            <div class="container pt-4 pb-4">
                <div class="col-12 p-0">
                    <div class="display-4 font-weight-bold">
                        @if ($division->competition_id == 1)
                            {{ $division->competition->name_short }} &#448; {{ $division->name }}
                        @else
                            {{ $division->name }}
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @endsection
@endif

@section('content')

    <div class="container pt-4">
        <div class="row mb-2">
            <div class="col-12">
                <h1 class="font-weight-bold font-italic">SPIELPLAN</h1>
                <ul class="nav mt-2">
                    <li class="nav-item dropdown pr-2">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="season_selector_title" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Saison: {{ $season->name }} (#{{ $season->season_nr }})
                        </button>
                        <div class="dropdown-menu" aria-labelledby="season_selector_title">
                            @foreach($division->seasons()->published()->orderBy('end','desc')->get() as $s)
                                <a class="dropdown-item season" href="#" id="{{ $s->id }}">{{ $s->name }} (#{{ $s->season_nr }})</a>
                            @endforeach
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="matchweek_selector" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Spielwoche
                        </button>
                        <div class="dropdown-menu" aria-labelledby="matchweek_selector">
                            @foreach($season->matchweeks as $matchweek)
                                <a class="dropdown-item" href="#matchweek{{ $matchweek->number_consecutive }}">
                                    {{ $matchweek->number_consecutive }} {{ $matchweek->name && strlen($matchweek->name) > 0 ? "- ".$matchweek->name : null }}
                                </a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="fixtures-container" class="">

        </div>

    </div>

@endsection

@section('js-footer')

    <script type="text/javascript">
        function getFixtures(season){
            // Add loading indicator back
            $('#fixtures-container').html(@include('loader'));

            $.ajax({
                method:     'GET',
                url:        '/division/{{ $division->id }}/fixtures/ajax-fixtures',
                data:       {'season_id' : season},

                success: function(response){
                    $('#fixtures-container').html(response);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        }

        $(function() {

            var season_id = {{ $season->id }};
            getFixtures(season_id);

            // select another season
            $('.season').click(function () {
                // set the season_id to the selected value
                season_id = $(this).attr('id');
                // select the first 'pill'
                $('#full-table').tab('show');
                // replace the selector title
                $('#season_selector_title').text('Saison: ' + $(this).text());
                // get the full table content
                getFixtures(season_id);
            });

        });
    </script>

@endsection