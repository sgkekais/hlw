@extends('admin.adminlayout')

@section('content')

    <!-- create a new person -->
    <h1 class="mb-4">Person anlegen</h1>
    <div class="alert alert-info">
        <ul class="p-0 m-0 pl-2">
            <li>Eine Person repräsentiert eine "echte" Person.</li>
            <li>Bitte immer vorher mit der Suche prüfen, ob die Person nicht schon angelegt ist!</li>
            <li>Nach der Anlage kann eine Person als Spieler einer oder mehrerer Mannschaften, als Ansprechpartner, oder als Schiedsrichter zugeordnet werden.</li>
            <li>Diese Zuordnungen sind in der Betrachtungsfunktion (Lupensymbol) aufgelistet.</li>
            <li>Geburtsdatum und Passbild sind optional.</li>
            <li>Personen können als Vereinsspieler gekennzeichnet werden.</li>
        </ul>
    </div>
    <form method="POST" action="{{ route('people.store') }}" enctype="multipart/form-data">
        <!-- protection against CSRF (cross-site request forgery) attacks-->
        {{ csrf_field() }}
        <!-- person is active -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="active">Person ist "aktiv"?</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="active" name="active" aria-describedby="activeHelp">
                    <option value="1">Aktiv</option>
                    <option value="0">Inaktiv</option>
                </select>
                <small id="activeHelp" class="form-text text-muted">Standard: Aktiv. Auf inaktiv setzen für Personen, die nicht mehr in der HLW aktiv sind (zu Archivierungszwecken). Die Person kann dann bspw. keiner (neuen) Mannschaft mehr zugeordnet werden.</small>
            </div>
        </div>
        <!-- names -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="first_name">Vorname</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}">
            </div>
            <div class="col-md-2">
                <label for="last_name">Nachname</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}">
            </div>
        </div>
        <!-- date of birth -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="date_of_birth">Geburtsdatum</label>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="date_of_birth" id="singledatepicker" aria-describedby="date_of_birthHelp" value="{{ old('date_of_birth') }}">
                <small id="date_of_birthHelp" class="form-text text-muted">JJJJ-MM-TT</small>
            </div>
            <div class="form-check col-md-2">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" id="datetimenull">
                    Leer lassen
                </label>
            </div>
        </div>
        <!-- photo -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="photo">Passbild</label>
            </div>
            <div class="col-md-4">
                <input type="file" name="photo" id="photo" aria-describedby="photoHelp">
                <small id="photoHelp" class="form-text text-muted">Passbild</small>
            </div>
            <div class="col-md-2">
                <label for="photo_public">Passbild öffentlich?</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="photo_public" name="photo_public" aria-describedby="photo_publicHelp">
                    <option value="0">Nein</option>
                    <option value="1">Ja</option>
                </select>
                <small id="photo_publicHelp" class="form-text text-muted">Darf das Passbild auf der Mannschaftsseite angezeigt werden?</small>
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
        <!-- photo is public and person is registered at club -->
        <div class="form-group row">
            <div class="col-md-2">
                <label for="registered_at_club">Vereinsspieler?</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="registered_at_club" name="registered_at_club" aria-describedby="competition_idHelp">
                    <option></option>
                    @foreach($real_clubs as $real_club)
                        <option value="{{ $real_club->id }}">{{ $real_club->name }}</option>
                    @endforeach
                </select>
                <small id="registered_at_clubHelp" class="form-text text-muted">Verein des Spielers auswählen</small>
            </div>
            <div class="col-md-2">
                <label for="registered_at_club">Klasse?</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" id="official_division_id" name="official_division_id" aria-describedby="official_division_idHelp">
                    <option></option>
                    @foreach($official_divisions as $official_division)
                        <option value="{{ $official_division->id }}">{{ $official_division->name }}</option>
                    @endforeach
                </select>
                <small id="official_division_idHelp" class="form-text text-muted">Offizielle Spielklasse des Spielers auswählen</small>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Anlegen</button>
            <a class="btn btn-secondary" href="{{ route('people.index') }}"><span class="fa fa-ban"></span> Abbrechen</a>
        </div>
    </form>

@endsection

@section('pagespecificscripts')

    <script type="text/javascript">
        $(function() {
            var beginDate = $("input[name=date_of_birth]").val();
            if ( !beginDate ) {
                beginDate = moment().format("YYYY-MM-DD");
            }

            $('input[id="singledatepicker"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
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
            $('#datetimenull').click(function (){
                if ( this.checked ){
                    $('#singledatepicker').val(null);
                }else{
                    $('#singledatepicker').val(beginDate);
                }
            });
        });

    </script>

@endsection