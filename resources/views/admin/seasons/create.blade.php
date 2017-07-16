@extends('admin.adminlayout')

@section('content')

    <!-- create a new season -->
    <h1 class="mb-4">Saison anlegen</h1>
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
        <!-- timeframe -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="begin">Zeitraum von</label>
                <label for="end"> &dash; bis</label>
            </div>
            <div class="input-group col-md-2">
                <div class="input-group-addon"><span class="fa fa-calendar"></span> </div>
                <input type="date" class="form-control" name="begin" id="singledatepickerfrom" placeholder="{{ old('begin') }}">
            </div>
            <div class="input-group col-md-2">
                <div class="input-group-addon"><span class="fa fa-calendar"></span> </div>
                <input type="date" class="form-control" name="end" id="singledatepickerto" placeholder="{{ old('end') }}">
            </div>
        </div>
        <!-- season nr -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="season_nr">Saison Nr.</label>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" name="season_nr" id="season_nr" aria-describedby="season_nrHelp" placeholder="{{ old('season_nr') }}">
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
                <input type="text" class="form-control" name="ranks_champion" id="ranks_champion" aria-describedby="ranks_championHelp" placeholder="{{ old('ranks_champion') }}">
                <small id="ranks_championHelp" class="form-text text-muted">Plätze, die Meister werden (1)</small>
            </div>
            <div class="col-md-2">
                <label for="ranks_promotion">Aufstiegsplätze</label>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="ranks_promotion" id="ranks_promotion" aria-describedby="ranks_promotionHelp" placeholder="{{ old('ranks_promotion') }}">
                <small id="ranks_promotionHelp" class="form-text text-muted">Plätze, die aufsteigen (1,2)</small>
            </div>
            <div class="col-md-2">
                <label for="ranks_relegation">Abstiegsplätze</label>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="ranks_relegation" id="ranks_relegation" aria-describedby="ranks_relegationHelp" placeholder="{{ old('ranks_relegation') }}">
                <small id="ranks_relegationHelp" class="form-text text-muted">Plätze, die absteigen (11,12)</small>
            </div>
        </div>
        <!-- playoffs -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="playoff_champion">Meisterschafts-Playoff</label>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="playoff_champion" id="playoff_champion" aria-describedby="playoff_championHelp" placeholder="{{ old('playoff_champion') }}">
                <small id="playoff_championHelp" class="form-text text-muted">Playoff-Plätze um die Meisterschaft (1,2,3,4)</small>
            </div>
            <div class="col-md-2">
                <label for="playoff_cup">Pokal-Playoff</label>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="playoff_cup" id="playoff_cup" aria-describedby="playoff_cupHelp" placeholder="{{ old('playoff_cup') }}">
                <small id="playoff_cupHelp" class="form-text text-muted">Playoff-Plätze für Pokal (5,6,7,8)</small>
            </div>
            <div class="col-md-2">
                <label for="playoff_relegation">Relegation</label>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="playoff_relegation" id="playoff_relegation" aria-describedby="playoff_relegationHelp" placeholder="{{ old('playoff_relegation') }}">
                <small id="playoff_relegationHelp" class="form-text text-muted">Plätze, die in die Relegation gehen (10)</small>
            </div>
        </div>
        <!-- max rescheduling -->
        <div class="form-group row">
            <label class="col-md-2 form-control-label" for="max_rescheduling">Max. Spielverlegungen</label>
            <div class="col-md-4">
                <input type="number" class="form-control" name="max_rescheduling" id="max_rescheduling" aria-describedby="max_reschedulingHelp" placeholder="{{ old('max_rescheduling') }}">
                <small id="playoff_championHelp" class="form-text text-muted">Maximale Anzahl der Spielverlegungen in der Saison</small>
            </div>
        </div>
        <!-- rules and note -->
        <div class="form-group row">
            <label class="col-md-2 form-control-label" for="rules">Regeln</label>
            <div class="col-md-4">
                <textarea class="form-control" id="rules" name="rules" rows="3" aria-describedby="rulesHelp"></textarea>
                <small id="rulesHelp" class="form-text text-muted">Besondere Regeln, bspw. Anmerkungen zu Auf-/Abstieg</small>
            </div>
            <label class="col-md-2 form-control-label" for="note">Notiz</label>
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
        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Anlegen</button>
        <a class="btn btn-secondary" href="{{ route('seasons.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection