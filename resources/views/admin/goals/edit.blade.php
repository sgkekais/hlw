@extends('admin.adminlayout')

@section('content')

    <!-- edit a card -->
    <h1 class="">Torschütze</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $goal->score }} durch {{ $goal->player->person->last_name }}, {{ $goal->player->person->first_name }} ({{ $goal->player->club->name_short }})</h2>
    <!-- created at -->
    Angelegt: {{ $goal->created_at->format('d.m.Y H:i') }} Uhr
    @if($causer = ModelHelper::causerOfAction($goal,'created'))
        von {{ $causer->name }}
    @endif
    <br>
    <!-- updated at -->
    @if($goal->updated_at != $goal->created_at)
        Geändert: {{ $goal->updated_at->format('d.m.Y H:i') }} Uhr
        @if($causer = ModelHelper::causerOfAction($goal,'updated'))
            von {{ $causer->name }}
        @endif
    @endif
    <hr>
    <h3 class="mt-4 mb-4">Torschütze ändern</h3>
    <form method="POST" action="{{ route('fixtures.goals.update',[ $fixture , $goal ]) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group row">
            <div class="col-md-2">
                <label for="fixture">Für Paarung</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="fixture" aria-describedby="fixtureHelp" value="({{ $fixture->id }}) {{ $fixture->datetime->toDateString() }} - {{ $fixture->club_home->name_short }} vs. {{ $fixture->club_away->name_short }}" disabled>
                <small id="matchweek_idHelp" class="form-text text-muted">Zuordnung zu welcher Paarung?</small>
            </div>
        </div>
        <!-- Spieler -->
        <div class="form-group row">
            <label for="player_id" class="col-md-2 col-form-label">Spieler</label>
            <div class="col-md-4">
                <select class="form-control" aria-describedby="player_idHelp" name="player_id" id="player_id">
                    @foreach($players as $player)
                        <option value="{{ $player->id }}" {{ $player->id === $goal->player->id ? "selected" : null }}>{{ $player->club->name_short }} | {{ $player->person->last_name}}, {{ $player->person->first_name }}</option>
                    @endforeach
                </select>
                <small id="player_idHelp" class="form-text text-muted">Welcher Spieler?</small>
            </div>
        </div>
        <!-- score -->
        <div class="form-group row">
            <label for="score" class="col-md-2 col-form-label">Stand</label>
            <div class="col-md-2">
                <input type="text" class="form-control" aria-describedby="scoreHelp" name="score" id="score" value="{{ $goal->score }}">
                <small id="scoreHelp" class="form-text text-muted">Zu welchem Zwischenstand?</small>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Ändern</button>
        <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]) }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>
    <hr>
    <h3 class="mt-4">Torschütze löschen</h3>
    <form method="POST" action="{{ route('fixtures.goals.destroy', [$fixture, $goal]) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <span class="form-text">Löscht den Torschützen-Eintrag.</span>
        <br>
        <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> Löschen</button>
        <a class="btn btn-secondary" href="{{ route('matchweeks.fixtures.show', [$fixture->matchweek, $fixture]) }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>
@endsection