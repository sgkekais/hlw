@extends('layouts.app')

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

    <div class="container pt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="font-weight-bold font-italic">TABELLE</h1>
                <ul class="nav nav-pills">
                    <li class="nav-item dropdown pr-2">
                        <a class="nav-link dropdown-toggle bg-secondary text-white" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="season_selector_title">Saison: {{ $season->name }} (#{{ $season->season_nr }})</a>
                        <div class="dropdown-menu season_selector">
                            @foreach($division->seasons()->published()->orderBy('end','desc')->get() as $s)
                                <a class="dropdown-item" href="#" id="{{ $s->id }}">{{ $s->name }} (#{{ $s->season_nr }})</a>
                            @endforeach
                        </div>
                    </li>
                    <li class="nav-item">
                        <a id="full-table" href="#" class="nav-link active" data-toggle="pill">Tabelle</a>
                    </li>
                    <li class="nav-item">
                        <a id="home-table" href="#" class="nav-link" data-toggle="pill">Heim</a>
                    </li>
                    <li class="nav-item">
                        <a id="away-table" href="#" class="nav-link" data-toggle="pill">Auswärts</a>
                    </li>
                    <li class="nav-item">
                        <a id="cross-table" href="#" class="nav-link" data-toggle="pill">Kreuztabelle</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mt-4">
            <div id="tables-container" class="col-12">

            </div>
        </div>
    </div>

@endsection

@section('js-footer')

    <script type="text/javascript">

        function getTable(scope, season){
            // Add loading indicator back
            $('#tables-container').html(@include('loader'));
            // get content via ajax
            $.ajax({
                method:     'GET',
                url:        '/division/{{ $division->id }}/tables/ajax-'+scope+'-table',
                data:       {'season_id' : season},

                success: function(response){
                    $('#tables-container').html(response);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        }

        // get the cross table for a specified division
        function getCrossTable(season){
            // add loading indicator back
            $('#tables-container').html(@include('loader'));

            $.ajax({
                method:     'GET',
                url:        '/division/{{ $division->id }}/tables/ajax-cross-table',
                data:       {'season_id' : season},

                success: function(response){
                    $('#tables-container').html(response);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        }

        $(function() {

            // set the season id to the initial value and get the full table content when the page is loaded for the first time
            var season_id = {{ $season->id }};
            getTable('full', season_id);

            //  change the arrow's orientation on click
            $('.table-entry-details').click(function(){
                $(this).find('span').toggleClass('fa-angle-down fa-angle-up');
            });

            // select another season
            $('.dropdown-item').click(function () {
                // set the season_id to the selected value
                season_id = $(this).attr('id');
                // select the first 'pill'
                $('#full-table').tab('show');
                // replace the selector title
                $('#season_selector_title').text('Saison: ' + $(this).text());
                // get the full table content
                getTable('full', season_id);
            });

            // Click on full table link
            $('#full-table').click(function () {
                // Get the table content
                getTable('full', season_id);
            });

            // Click on home table link
            $('#home-table').click(function () {
                // Get the table content
                getTable('home', season_id);
            });

            // Click on away table link
            $('#away-table').click(function () {
                // Get the table content
                getTable('away', season_id);
            });

            // Click on cross table link
            $('#cross-table').click(function () {
                // Get the table content
                getCrossTable(season_id);
            });

            // activate tooltips for this page
            $("body").tooltip({
                selector: '[data-toggle="tooltip"]'
            });
        });

    </script>

@endsection