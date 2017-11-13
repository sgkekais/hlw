@extends('layouts.app')

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

    <div class="container pt-4">
        <div class="row">
            <div class="col-12">
                <h2 style="font-weight: bold">Tabelle</h2>
                <h3 class="text-muted">
                    Spielwoche {{ $c_matchweek->number_consecutive ?: null }}
                    | {{ $c_matchweek->begin ? $c_matchweek->begin->format('d.m.') : null }} - {{ $c_matchweek->end ? $c_matchweek->end->format('d.m.') : null }}
                    {{ $c_matchweek->name ? "| ".$c_matchweek->name : null }}
                </h3>
                {{-- TODO: links for home, away, tables, do via ajax--}}
                <nav class="nav nav-pills nav-justified mb-4">
                    <a id="full-table" class="nav-item nav-link active" href="#" data-toggle="pill">Tabelle</a>
                    <a id="home-table" class="nav-item nav-link" href="#" data-toggle="pill">Heim</a>
                    <a id="away-table" class="nav-item nav-link" href="#" data-toggle="pill">Auswärts</a>
                    <a id="cross-table" class="nav-item nav-link" href="#" data-toggle="pill">Kreuztabelle</a>
                </nav>
            </div>
        </div>
        <div class="row">
            <div id="tables-container" class="col-12">
                <i class='fa fa-circle-o-notch fa-spin fa-3x fa-fw text-success'></i><span class='sr-only'>Loading...</span>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="text-secondary">
                    {{ $season->rules }}
                </p>
            </div>
        </div>
    </div>

@endsection

@section('js-footer')


    <script type="text/javascript">

        function getTable(scope){
            $.ajax({
                method:     'GET',
                url:        '/division/{{ $division->id }}/tables/ajax-'+scope+'-table',

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
        function getCrossTable(){
            $.ajax({
                method:     'GET',
                url:        '/division/{{ $division->id }}/tables/ajax-cross-table',

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
            // Get the full table content when the page is loaded for the first time
            getTable('full');

            //  change the arrow's orientation on click
            $('.table-entry-details').click(function(){
                $(this).find('span').toggleClass('fa-angle-down fa-angle-up');
            });

            // Click on full table link
            $('#full-table').click(function () {
                // Add loading indicator back
                $('#tables-container').html("<span class='fa fa-circle-o-notch fa-spin fa-3x fa-fw text-success'></span><span class='sr-only'>Loading...</span>");

                // Get the table content
                getTable('full');
            });

            // Click on home table link
            $('#home-table').click(function () {
                // Add loading indicator back
                $('#tables-container').html("<span class='fa fa-circle-o-notch fa-spin fa-3x fa-fw text-success'></span><span class='sr-only'>Loading...</span>");

                // Get the table content
                getTable('home');
            });

            // Click on away table link
            $('#away-table').click(function () {
                // Add loading indicator back
                $('#tables-container').html("<span class='fa fa-circle-o-notch fa-spin fa-3x fa-fw text-success'></span><span class='sr-only'>Loading...</span>");

                // Get the table content
                getTable('away');
            });

            // Click on cross table link
            $('#cross-table').click(function () {
                // add loading indicator back
                $('#tables-container').html("<span class='fa fa-circle-o-notch fa-spin fa-3x fa-fw text-success'></span><span class='sr-only'>Loading...</span>");

                // Get the table content
                getCrossTable();
            });
        });

    </script>

@endsection