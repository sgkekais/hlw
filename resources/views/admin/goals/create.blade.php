@extends('admin.adminlayout')

@section('content')

    <!-- create a new card for a fixture -->
    <h1 class="mb-4">Torschütze(n) eintragen</h1>
    <form method="POST" action="{{ route('fixtures.goals.store', $fixture ) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        @for($i = 0; $i < ($fixture->goals_home + $fixture->goals_away - $fixture->goals->count()); $i++)
            <div class="form-group row">
                <div class="col-md-1">
                    <span class="h2"># {{ $i+1+$fixture->goals->count() }}</span>
                </div>
                <div class="col-md-11">
                    <div class="form-check">
                        <label class="form-check-label mt-2">
                            <input class="form-check-input" type="checkbox" id="ignore" name="entities[{{ $i }}][ignore]" value="1"> Ignorieren?
                        </label>
                    </div>
                </div>

            </div>
            <hr>
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="fixture">Für Paarung</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="fixture" aria-describedby="fixtureHelp" value="({{ $fixture->id }}) {{ $fixture->datetime->toDateString() }} - {{ $fixture->clubHome->name_short }} vs. {{ $fixture->clubAway->name_short }}" disabled>
                    <small id="matchweek_idHelp" class="form-text text-muted">Zuordnung zu welcher Paarung?</small>
                </div>
            </div>
            <!-- Spieler -->
            <div class="form-group row">
                <label for="player_id" class="col-md-2 col-form-label">Spieler</label>
                <div class="col-md-4">
                    <select class="form-control" aria-describedby="player_idHelp" name="entities[{{ $i }}][player_id]" id="player_id">
                        @foreach($players as $player)
                            <option value="{{ $player->id }}">{{ $player->club->name_short }} | {{ $player->person->last_name}}, {{ $player->person->first_name }}</option>
                        @endforeach
                    </select>
                    <small id="player_idHelp" class="form-text text-muted">Welcher Spieler?</small>
                </div>
            </div>
            <!-- score -->
            <div class="form-group row">
                <label for="score" class="col-md-2 col-form-label">Stand</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" aria-describedby="scoreHelp" name="entities[{{ $i }}][score]" id="score">
                    <small id="scoreHelp" class="form-text text-muted">Zu welchem Zwischenstand?</small>
                </div>
            </div>
        @endfor
        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Eintragen</button>
        <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]) }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection