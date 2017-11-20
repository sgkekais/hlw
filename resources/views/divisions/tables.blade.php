@extends('layouts.app')

@section('subnav')

    @include('_partials.subnav_divisions')

@endsection

@section('content')

    <div class="container pt-4">
        <div class="row">
            <div class="col-12">
                <h2 style="font-weight: bold">Tabelle</h2>
                <ul class="nav nav-pills">
                    <li class="nav-item dropdown pr-2">
                        <a class="nav-link dropdown-toggle bg-secondary text-white" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Saison: {{ $season->end ? $season->end->format('Y') :null }}</a>
                        <div class="dropdown-menu">
                            @foreach($division->seasons->sortBy('end') as $s)
                                <a class="dropdown-item" href="#">{{ $s->begin ?? $s->begin->format('Y') }} / {{ $s->end ?? $s->end->format('Y') }}</a>
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
            $('#tables-container').html(@include('loader'));
            getTable('full');

            //  change the arrow's orientation on click
            $('.table-entry-details').click(function(){
                $(this).find('span').toggleClass('fa-angle-down fa-angle-up');
            });

            // Click on full table link
            $('#full-table').click(function () {
                // Add loading indicator back
                $('#tables-container').html(@include('loader'));
                // Get the table content
                getTable('full');
            });

            // Click on home table link
            $('#home-table').click(function () {
                // Add loading indicator back
                $('#tables-container').html(@include('loader'));
                // Get the table content
                getTable('home');
            });

            // Click on away table link
            $('#away-table').click(function () {
                // Add loading indicator back
                $('#tables-container').html(@include('loader'));
                // Get the table content
                getTable('away');
            });

            // Click on cross table link
            $('#cross-table').click(function () {
                // add loading indicator back
                $('#tables-container').html(@include('loader'));
                // Get the table content
                getCrossTable();
            });
        });

    </script>

@endsection