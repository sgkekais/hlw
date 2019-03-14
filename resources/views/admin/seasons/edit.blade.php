@extends('admin.adminlayout')

@section('content')

    <!-- edit the season -->
    <h1 class="">Saison</h1>
    <h2 class="mt-4 text-primary">&mdash; {{ $season->begin->format('d.m.Y') }} bis {{ $season->end->format('d.m.Y') }}</h2>
    <!-- created at -->
    Angelegt: {{ $season->created_at->format('d.m.Y H:i') }} Uhr
    @if($causer = ModelHelper::causerOfAction($season,'created'))
        von {{ $causer->name }}
    @endif
    <br>
    <!-- updated at -->
    @if($season->updated_at != $season->created_at)
        Geändert: {{ $season->updated_at->format('d.m.Y H:i') }} Uhr
        @if($causer = ModelHelper::causerOfAction($season,'updated'))
            von {{ $causer->name }}
        @endif
    @endif
    <hr>
    <h3 class="mt-4 mb-4">Saison ändern</h3>
    <form method="POST" action="{{ route('seasons.update', $season) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <!-- season -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="division_id">Spielklasse</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="season_id" name="division_id" aria-describedby="season_idHelp">
                    @foreach($divisions = \HLW\Division::all() as $division)
                        <option value="{{ $division->id }}" {{ $division->id == $season->division_id ? "selected" : null  }}>
                            {{ $division->competition->name }} | {{ $division->name }}
                        </option>
                    @endforeach
                </select>
                <small id="season_idHelp" class="form-text text-muted">Zuordnung zu welcher Spielklasse?</small>
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
                <input type="date" class="form-control" name="begin" id="singledatepickerfrom" value="{{ $season->begin->toDateString() }}">
            </div>
            <div class="input-group col-md-2">
                <div class="input-group-addon"><span class="fa fa-calendar"></span> </div>
                <input type="date" class="form-control" name="end" id="singledatepickerto" value="{{ $season->end->toDateString() }}">
            </div>
        </div>
        <!-- season nr -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="season_nr">Saison Nr.</label>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" name="season_nr" id="season_nr" aria-describedby="season_nrHelp" value="{{ $season->season_nr }}">
                <small id="season_nrHelp" class="form-text text-muted">Spielzeit, bspw. 24. Es wird automatisch die nächsthöchste festgelegt.</small>
            </div>
        </div>
        <!-- champion -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="champion_id">Sieger</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="champion_id" name="champion_id" aria-describedby="champion_idHelp">
                    <option></option>
                    @foreach ($season->clubs->sortBy('name') as $club)
                        <option value="{{ $club->id }}" {{ $season->champion_id == $club->id ? "selected" : null }} >{{ $club->name }}</option>
                    @endforeacH
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
                <input type="text" class="form-control" name="ranks_champion" id="ranks_champion" aria-describedby="ranks_championHelp" value="{{ $season->ranks_champion ? implode(",", $season->ranks_champion) : null}}" >
                <small id="ranks_championHelp" class="form-text text-muted">Plätze, die Meister werden</small>
            </div>
            <div class="col-md-2">
                <label for="ranks_promotion">Aufstiegsplätze</label>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="ranks_promotion" id="ranks_promotion" aria-describedby="ranks_promotionHelp" value="{{ $season->ranks_promotion ? implode(",", $season->ranks_promotion) : null}}" >
                <small id="ranks_promotionHelp" class="form-text text-muted">Plätze, die aufsteigen</small>
            </div>
            <div class="col-md-2">
                <label for="ranks_relegation">Abstiegsplätze</label>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="ranks_relegation" id="ranks_relegation" aria-describedby="ranks_relegationHelp" value="{{ $season->ranks_relegation ? implode(",", $season->ranks_relegation) : null}}" >
                <small id="ranks_relegationHelp" class="form-text text-muted">Plätze, die absteigen</small>
            </div>
        </div>
        <!-- playoffs -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="playoff_champion">Meisterschafts-Playoff</label>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="playoff_champion" id="playoff_champion" aria-describedby="playoff_championHelp" value="{{ $season->playoff_champion ? implode(",", $season->playoff_champion): null }}">
                <small id="playoff_championHelp" class="form-text text-muted">Playoff-Plätze um die Meisterschaft</small>
            </div>
            <div class="col-md-2">
                <label for="playoff_cup">Pokal-Playoff</label>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="playoff_cup" id="playoff_cup" aria-describedby="playoff_cupHelp" value="{{ $season->playoff_cup ? implode(",", $season->playoff_cup): null }}">
                <small id="playoff_cupHelp" class="form-text text-muted">Playoff-Plätze für Pokal</small>
            </div>
            <div class="col-md-2">
                <label for="playoff_relegation">Relegation</label>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="playoff_relegation" id="playoff_relegation" aria-describedby="playoff_relegationHelp" value="{{ $season->playoff_relegation ? implode(",", $season->playoff_relegation): null }}">
                <small id="playoff_relegationHelp" class="form-text text-muted">Plätze, die in die Relegation gehen</small>
            </div>
        </div>
        <!-- max rescheduling -->
        <div class="form-group row">
            <label class="col-md-2 form-control-label" for="max_rescheduling">Max. Spielverlegungen</label>
            <div class="col-md-4">
                <input type="number" class="form-control" name="max_rescheduling" id="max_rescheduling" aria-describedby="max_reschedulingHelp" value="{{ $season->max_rescheduling}}">
                <small id="playoff_championHelp" class="form-text text-muted">Maximale Anzahl der Spielverlegungen in der Saison</small>
            </div>
        </div>
        <!-- rules and note -->
        <div class="form-group row">
            <label class="col-md-2 form-control-label" for="rules">Regeln</label>
            <div class="col-md-4">
                <textarea class="form-control" id="rules" name="rules" rows="3" aria-describedby="rulesHelp">{{ $season->rules }}</textarea>
                <small id="rulesHelp" class="form-text text-muted">Besondere Regeln, bspw. Anmerkungen zu Auf-/Abstieg</small>
            </div>
            <label class="col-md-2 form-control-label" for="note">Notiz</label>
            <div class="col-md-4">
                <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp">{{ $season->note }}</textarea>
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
                    <option value="1" {{ $season->published ? "selected" : null }}>Ja</option>
                </select>
                <small id="publishedHelp" class="form-text text-muted">Saison auf Seite veröffentlichen?</small>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Ändern</button>
        <a class="btn btn-secondary" href="{{ route('seasons.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>
    <hr>
    <h3 class="mt-4">Saison löschen</h3>
    <form method="POST" action="{{ route('seasons.destroy', $season) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <span class="form-text">Löscht die Saison und <b>alle zugeordneten Objekte <span class="text-danger">unwiderruflich</span></b>.</span>
        <br>
        @can('delete season')
            <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> Löschen</button>
            <a class="btn btn-secondary" href="{{ url()->previous() }}"><span class="fa fa-ban"></span> Abbrechen</a>
        @else
            Keine Berechtigung.
        @endcan
    </form>

@endsection

@section('pagespecificscripts')

    <script type="text/javascript">
        $(function() {
            var beginDate = $("input[name=begin]").val();
            if ( !beginDate ) {
                beginDate = new Date().getDate();
            }

            var endDate   = $("input[name=end]").val();
            if ( !endDate ) {
                endDate = new Date().getDate();
            }

            $('input[id="singledatepickerfrom"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                startDate: beginDate,
                locale: {
                    "format": "YYYY-MM-DD",
                    "separator": " - ",
                    "applyLabel": "Anwenden",
                    "cancelLabel": "Abbrechen",
                    "fromLabel": "Von",
                    "toLabel": "Bis",
                    "customRangeLabel": "Custom",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "So",
                        "Mo",
                        "Di",
                        "Mi",
                        "Do",
                        "Fr",
                        "Sa"
                    ],
                    "monthNames": [
                        "Januar",
                        "Februar",
                        "März",
                        "April",
                        "Mai",
                        "Juni",
                        "Juli",
                        "August",
                        "September",
                        "Oktober",
                        "November",
                        "Dezember"
                    ],
                    "firstDay": 1
                }
            });
            $('input[id="singledatepickerto"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                startDate: endDate,
                locale: {
                    "format": "YYYY-MM-DD",
                    "separator": " - ",
                    "applyLabel": "Anwenden",
                    "cancelLabel": "Abbrechen",
                    "fromLabel": "Von",
                    "toLabel": "Bis",
                    "customRangeLabel": "Custom",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "So",
                        "Mo",
                        "Di",
                        "Mi",
                        "Do",
                        "Fr",
                        "Sa"
                    ],
                    "monthNames": [
                        "Januar",
                        "Februar",
                        "März",
                        "April",
                        "Mai",
                        "Juni",
                        "Juli",
                        "August",
                        "September",
                        "Oktober",
                        "November",
                        "Dezember"
                    ],
                    "firstDay": 1
                }
            });
        });
    </script>

@endsection