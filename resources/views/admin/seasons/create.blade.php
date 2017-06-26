@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <!-- create a new season -->
        <h1 class="mt-4 mb-4">Saison anlegen</h1>

        <form method="POST" action="{{ route('seasons.store') }}">
            <!-- protection against CSRF (cross-site request forgery) attacks-->
            {{ csrf_field() }}
            <!-- division -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="division_id">Spielklasse</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="division_id" name="division_id" aria-describedby="division_idHelp">
                        @foreach($divisions = \App\Division::all() as $division)
                            <option value="{{ $division->id }}">{{ $division->competition->name }} | {{ $division->name }}</option>
                        @endforeach
                    </select>
                    <small id="division_idHelp" class="form-text text-muted">Zuordnung zu welcher Spielklasse?</small>
                </div>
            </div>
            <!-- year -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="year_begin">Jahr von</label>
                    <label for="year_end"> &dash; bis</label>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="year_begin" id="year_begin" placeholder="{{ old('year_begin', date('Y')) }}">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="year_end" id="year_end" placeholder="{{ old('year_end', date('Y')) }}">
                </div>
            </div>
            <!-- season nr -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="season_nr">Saison Nr.</label>
                </div>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="season_nr" id="season_nr" aria-describedby="season_nrHelp" placeholder="{{ old('season_nr', '1') }}">
                    <small id="season_nrHelp" class="form-text text-muted">Spielzeit, bspw. 24. Es wird automatisch die nächsthöchste festgelegt.</small>
                </div>
            </div>
            <!-- champion -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="champion">Sieger</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="champion" name="champion" aria-describedby="championHelp">
                        <option></option>
                        <option>Nur der Saison zugeordnete uber many-to-many</option>
                    </select>
                    <small id="championHelp" class="form-text text-muted">Meister bzw. Pokalsieger, falls schon gegeben, sonst leer lassen</small>
                </div>
            </div>
            <!-- ranks -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="ranks_champion">Meisterplätze</label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="ranks_champion" id="ranks_champion" aria-describedby="ranks_championHelp" placeholder="{{ old('ranks_champion', '1') }}">
                    <small id="ranks_championHelp" class="form-text text-muted">Plätze, die Meister werden</small>
                </div>
                <div class="col-md-2">
                    <label for="ranks_promotion">Aufstiegsplätze</label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="ranks_promotion" id="ranks_promotion" aria-describedby="ranks_promotionHelp" placeholder="{{ old('ranks_promotion', '1,2') }}">
                    <small id="ranks_promotionHelp" class="form-text text-muted">Plätze, die aufsteigen</small>
                </div>
                <div class="col-md-2">
                    <label for="ranks_relegation">Abstiegsplätze</label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="ranks_relegation" id="ranks_relegation" aria-describedby="ranks_relegationHelp" placeholder="{{ old('ranks_relegation', '11,12') }}">
                    <small id="ranks_relegationHelp" class="form-text text-muted">Plätze, die absteigen</small>
                </div>
            </div>
            <!-- playoffs -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="playoff_champion">Meisterschafts-Playoff</label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="playoff_champion" id="playoff_champion" aria-describedby="playoff_championHelp" placeholder="{{ old('playoff_champion', '1,2,3,4') }}">
                    <small id="playoff_championHelp" class="form-text text-muted">Playoff-Plätze um die Meisterschaft</small>
                </div>
                <div class="col-md-2">
                    <label for="playoff_cup">Pokal-Playoff</label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="playoff_cup" id="playoff_cup" aria-describedby="playoff_cupHelp" placeholder="{{ old('playoff_cup', '5,6,7,8') }}">
                    <small id="playoff_cupHelp" class="form-text text-muted">Playoff-Plätze für Pokal</small>
                </div>
                <div class="col-md-2">
                    <label for="playoff_relegation">Relegation</label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="playoff_relegation" id="playoff_relegation" aria-describedby="playoff_relegationHelp" placeholder="{{ old('playoff_relegation', '10') }}">
                    <small id="playoff_relegationHelp" class="form-text text-muted">Plätze, die in die Relegation gehen</small>
                </div>
            </div>
            <!-- rules -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="rules">Regeln</label>
                </div>
                <div class="col-md-4">
                    <textarea class="form-control" id="rules" name="rules" rows="3" aria-describedby="rulesHelp"></textarea>
                    <small id="rulesHelp" class="form-text text-muted">Besondere Regeln, bspw. Anmerkungen zu Auf-/Abstieg</small>
                </div>
            </div>
            <!-- note -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="note">Notiz</label>
                </div>
                <div class="col-md-4">
                    <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp"></textarea>
                    <small id="noteHelp" class="form-text text-muted">Interne Notiz</small>
                </div>
            </div>
            <!-- published -->
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="published">Veröffentlichen?</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="published" name="published" aria-describedby="publishedHelp">
                        <option value="0">Nein</option>
                        <option value="1">Ja</option>
                    </select>
                    <small id="publishedHelp" class="form-text text-muted">Saison auf Seite veröffentlichen?</small>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Anlegen</button>
            <a class="btn btn-secondary" href="{{ route('seasons.index') }}">Abbrechen</a>
        </form>
    </div>

@endsection