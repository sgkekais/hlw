@extends('admin.adminlayout')

@section('content')

    <div class="row">
        <div class="col-12">
            <div id="calendar">

            </div>
        </div>
    </div>

@endsection

@section('pagespecificscripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                locale: 'de',
                events: [
                    @foreach($fixtures as $fixture)
                    {
                        title:  '{{ $fixture->clubHome && $fixture->clubAway ? $fixture->clubHome->name_code.":".$fixture->clubAway->name_code : "-:-" }}',
                        allDay: false,
                        start:  '{{ $fixture->datetime }}'

                    }
                        @if(!$loop->last)
                            ,
                        @endif
                    @endforeach
                ],
                timeFormat: 'H(:mm)'
            })
        });
    </script>

@endsection