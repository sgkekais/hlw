@extends('admin.adminlayout')

@section('content')

    <!-- create a new fixture -->
    <h1 class="mb-4">Paarung anlegen</h1>
    <form method="POST" action="{{ route('matchweeks.fixtures.store', $matchweek) }}">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <!-- only show if rescheduling -->
        @if($fixture->id)
            <h2 class="mb-4">Spiel wird verlegt</h2>
            <div class="form-group row">
                <label for="rescheduled_fixture" class="form-control-label col-md-2">Verlegt von Paarung</label>
                <div class="col-md-10">
                    <input type="hidden" name="rescheduled_from_fixture_id" id="rescheduled_from_fixture_id" value="{{ $fixture->id }}">
                    <input type="text" class="form-control" name="rescheduled_fixture" id="rescheduled_fixture" value="{{ $fixture->datetime  }} | {{ $fixture->clubHome->name_short }} : {{ $fixture->clubAway->name_short }} (ID: {{ $fixture->id }})" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="rescheduled_by_club" class="form-control-label col-md-2">Verlegt von Mannschaft</label>
                <div class="col-md-4">
                    <select class="form-control" name="rescheduled_by_club" id="rescheduled_by_club">
                        <option value="">Keiner</option>
                        @if($fixture->club_id_home)
                            <option value="{{ $fixture->club_id_home }}">{{ $fixture->clubHome->name }}</option>
                        @endif
                        @if($fixture->club_id_away)
                            <option value="{{ $fixture->club_id_away }}">{{ $fixture->clubAway->name }}</option>
                        @endif
                    </select>
                </div>
                <label for="reschedule_reason" class="form-control-label col-md-2">Grund für Verlegung</label>
                {{--
                    <div class="col-md-4">
                        <textarea class="form-control" id="reschedule_reason" name="reschedule_reason" rows="3">{{ old('reschedule_reason') }}</textarea>
                    </div>
                --}}
                {{-- pre-defined reasons --}}
                <div class="col-md-4">
                    <select class="form-control" name="reschedule_reason" id="reschedule_reason">
                        <option value="Spielermangel">Spielermangel</option>
                        <option value="Höhere Gewalt">Höhere Gewalt</option>
                        <option value="Spielverlegung innerhalb der Frist">Spielverlegung innerhalb der Frist</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="reschedule_count" class="form-control-label col-md-2">Verlegung zählen</label>
                <div class="col-md-4">
                    <select class="form-control" name="reschedule_count" id="reschedule_count" aria-describedby="reschedule_countHelp">
                        <option value="1">Ja</option>
                        <option value="0">Nein</option>
                    </select>
                    <small id="reschedule_countHelp" class="form-text text-muted">Zählt die Spielverlegung für die verlegende Mannschaft?</small>
                </div>
            </div>
            <hr>
            <h2 class="mb-4">Neue Paarung</h2>
        @endif
        <!-- matchweek -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="matchweek_id">Spielwoche</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="matchweek_id" aria-describedby="matchweek_idHelp" value="({{ $matchweek->id }}) Nr. {{ $matchweek->number_consecutive }} | {{ $matchweek->begin ? $matchweek->begin->toDateString() : null }} - {{ $matchweek->end ? $matchweek->end->toDateString() : null }}" disabled>
                <small id="matchweek_idHelp" class="form-text text-muted">Zuordnung zu welcher Spielwoche?</small>
            </div>
        </div>
        <!-- date and time -->
        <div class="form-group row">
            <label for="datetime" class="col-md-2 col-form-label">Datum und Uhrzeit</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="datetime" id="singledatetimepicker" aria-describedby="datetimeHelp" placeholder="{{ old('date') }}">
                <small id="datetimeHelp" class="form-text text-muted">Datum und Uhrzeit der Paarung im Format JJJJ-MM-TT HH:MM:SS, bspw. 2018-06-20 20:30:00</small>
            </div>
        </div>
        <!-- stadium -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="stadium_id">Spielort</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" aria-describedby="stadium_idHelp" name="stadium_id" id="stadium_id">
                    <option></option>
                    @foreach($stadiums as $stadium)
                        <option value="{{ $stadium->id }}">{{ $stadium->name }}</option>
                    @endforeach
                </select>
                <small id="stadium_idHelp" class="form-text text-muted">Platz, auf dem das Spiel ausgetragen wird</small>
            </div>
        </div>
        <!-- alternative texts for home and away -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="club_id_home">Heim - Text</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="club_id_home_alt_text" id="club_id_home_alt_text" aria-describedby="club_id_home_alt_textHelp" placeholder="{{ old('club_id_home_alt_text') }}">
                <small id="club_id_home_alt_textHelp" class="form-text text-muted">Alternativer Text für Heim-Team - bspw. "Sieger Spiel X". Wird nur angezeigt, wenn kein Team ausgewählt ist.</small>
            </div>
            <div class="col-md-2">
                <label for="club_id_away">Gast - Text</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="club_id_away_alt_text" id="club_id_away_alt_text" aria-describedby="club_id_away_alt_textHelp" placeholder="{{ old('club_id_away_alt_text') }}">
                <small id="club_id_away_alt_textHelp" class="form-text text-muted">Alternativer Text für Gast-Team - bspw. "Sieger Spiel X". Wird nur angezeigt, wenn kein Team ausgewählt ist.</small>
            </div>
        </div>
        <!-- home and away clubs -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="club_id_home">Heim</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" name="club_id_home" id="club_id_home">
                    <option></option>
                    @if ($fixture->id && $fixture->club_id_home && $fixture->club_id_away)
                        <option value="{{ $fixture->club_id_home }}">{{ $fixture->clubHome->name }}</option>
                        <option value="{{ $fixture->club_id_away }}">{{ $fixture->clubAway->name }}</option>
                    @else
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}">{{ $club->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-2">
                <label for="club_id_away">Gast</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" name="club_id_away" id="club_id_away">
                    <option></option>
                    @if ($fixture->id && $fixture->club_id_home && $fixture->club_id_away)
                        <option value="{{ $fixture->club_id_home }}">{{ $fixture->clubHome->name }}</option>
                        <option value="{{ $fixture->club_id_away }}">{{ $fixture->clubAway->name }}</option>
                    @else
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}">{{ $club->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <!-- goals -->
        <div class="form-group row">
            <label for="goals_home" class="col-md-2 col-form-label">Tore - Heim</label>
            <div class="col-md-4">
                <input type="number" class="form-control" name="goals_home" id="goals_home" aria-describedby="goals_homeHelp" placeholder="{{ old('goals_home') }}">
                <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der Heimmannschaft</small>
            </div>
            <label for="goals_away" class="col-md-2 col-form-label">Tore - Gast</label>
            <div class="col-md-4">
                <input type="number" class="form-control" name="goals_away" id="goals_away" aria-describedby="goals_awayHelp" placeholder="{{ old('goals_away') }}">
                <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der Gastmannschaft</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="goals_home_11m" class="col-md-2 col-form-label">Tore - 11m - Heim</label>
            <div class="col-md-4">
                <input type="number" class="form-control" name="goals_home_11m" id="goals_home_11m" aria-describedby="goals_home_11mHelp" placeholder="{{ old('goals_home_11m') }}">
                <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der Heimmannschaft <b>im</b> Elfmeterschießen</small>
            </div>
            <label for="goals_away_11m" class="col-md-2 col-form-label">Tore - 11m - Gast</label>
            <div class="col-md-4">
                <input type="number" class="form-control" name="goals_away_11m" id="goals_away_11m" aria-describedby="goals_away_11mHelp" placeholder="{{ old('goals_away_11m') }}">
                <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der Gastmannschaft <b>im</b> Elfmeterschießen</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="goals_home_rated" class="col-md-2 col-form-label">Wertung - Heim</label>
            <div class="col-md-1">
                <input type="number" class="form-control" name="goals_home_rated" id="goals_home_rated" aria-describedby="goals_home_ratedHelp" placeholder="{{ old('goals_home_rated') }}">
                <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der <b>Wertung</b> - Heim</small>
            </div>
            <label for="goals_away_rated" class="col-md-2 col-form-label">Wertung - Gast</label>
            <div class="col-md-1">
                <input type="number" class="form-control" name="goals_away_rated" id="goals_away_rated" aria-describedby="goals_away_ratedHelp" placeholder="{{ old('goals_away_rated') }}">
                <small id="goals_homeHelp" class="form-text text-muted">Anzahl Tore der <b>Wertung</b> - Heim</small>
            </div>
            <label for="rated_note" class="col-md-2 col-form-label">Begründung</label>
            <div class="col-md-4">
                <textarea class="form-control" id="rated_note" name="rated_note" rows="3" aria-describedby="rated_noteHelp">{{ old('rated_note') }}</textarea>
                <small id="rated_noteHelp" class="form-text text-muted">Warum wurde gewertet?</small>
            </div>
        </div>
        <!-- note -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="note">Notiz</label>
            </div>
            <div class="col-md-4">
                <textarea class="form-control" id="note" name="note" rows="3" aria-describedby="noteHelp">{{ old('note') }}</textarea>
                <small id="noteHelp" class="form-text text-muted">Interne Notiz</small>
            </div>
        </div>
        <!-- cancelled and published -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="cancelled">Annullierung?</label>
            </div>
            <div class="col-md-2">
                <select class="form-control" id="cancelled" name="cancelled" aria-describedby="cancelledHelp">
                    <option value="0">Nein</option>
                    <option value="1">Ja</option>
                </select>
                <small id="publishedHelp" class="form-text text-muted">Wurde das Spiel annulliert?</small>
            </div>
            <div class="col-md-2">
                <label for="published">Veröffentlichen?</label>
            </div>
            <div class="col-md-2">
                <select class="form-control" id="published" name="published" aria-describedby="publishedHelp">
                    <option value="0">Nein</option>
                    <option value="1">Ja</option>
                </select>
                <small id="publishedHelp" class="form-text text-muted">Paarung auf Seite veröffentlichen?</small>
            </div>
            <div class="col-md-2">
                <label for="counts_in_tables">Berücksichtigung in Tabelle(n)?</label>
            </div>
            <div class="col-md-2">
                <select class="form-control" id="counts_in_tables" name="counts_in_tables" aria-describedby="counts_in_tablesHelp">
                    <option value="1">Ja</option>
                    <option value="0">Nein</option>
                </select>
                <small id="counts_in_tablesHelp" class="form-text text-muted">Wird diese Paarung in der Berechnung der Tabelle berücksichtigt ("Nein", bspw. bei Relegationsspielen)?</small>
            </div>
        </div>
        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Anlegen</button>
        <a class="btn btn-secondary" href="{{ route('seasons.matchweeks.show', [$matchweek->season, $matchweek]) }}"><span class="fa fa-ban"></span> Abbrechen</a>
    </form>

@endsection

@section('pagespecificscripts')

    <!--<script type="text/javascript">
        $(function() {
            var beginDate = $("input[name=datetime]").val();
            if ( !beginDate ) {
                beginDate = moment().format("YYYY-MM-DD HH:mm:ss");
            }

            $('input[id="singledatetimepicker"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                startDate: beginDate,
                timePicker: true,
                timePicker24Hour: true,
                timePickerSeconds: true,
                locale: {
                    "format": "YYYY-MM-DD HH:mm:ss",
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
            $('#datetimenull').click(function (){
                if ( this.checked ){
                    $('#singledatetimepicker').val(null);
                }else{
                    $('#singledatetimepicker').val(beginDate);
                }
            });
        });
    </script>-->

@endsection