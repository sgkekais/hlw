@extends('admin.adminlayout')

@section('content')
        <div class="row">
            <div class="col-md-12">
                Aktuelle Paarungen ohne Ergebnis
                <br>
                Alle Paarungen der Vergangenheit der aktuellen Saison, die kein Ergebnis, keine Wertung haben und nicht annulliert sind
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul>
                @foreach($competitions as $competition)
                    <li>{{ $competition->name }}</li>
                    <ul>
                    @foreach($competition->divisions as $division)
                        <li>{{ $division->name }}</li>
                        <ul>
                            @foreach($division->seasons()->current()->get() as $season)
                                <li>{{ $season->begin->format('d.m.Y') }} - {{ $season->end->format('d.m.Y') }}</li>
                                <ul>
                                    @foreach($season->matchweeks()->current()->get() as $matchweek)
                                        <li>{{ $matchweek->begin->format('d.m.Y') }} - {{ $matchweek->end->format('d.m.Y') }}</li>
                                        <ul>
                                            @foreach($matchweek->fixtures as $fixture)
                                                <li>{{ $fixture->datetime }} - {{ $fixture->clubHome->name_short }} vs. {{ $fixture->clubAway->name_short }}</li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                </ul>
                            @endforeach
                        </ul>
                    @endforeach
                    </ul>
                @endforeach
                </ul>
            </div>
        </div>

@endsection