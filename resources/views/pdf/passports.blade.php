<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Spielerpässe</title>
    <style>
        /* fonts and images are local files, see HLW\Support\PlayerPassports */
        @font-face {
            font-family: 'Roboto';
            font-weight: normal;
            src: url("{{ $fonts }}/Roboto-Regular.ttf") format('truetype');
        }
        @font-face {
            font-family: 'Roboto';
            font-weight: bold;
            src: url("{{ $fonts }}/Roboto-Bold.ttf") format('truetype');
        }
        @font-face {
            font-family: 'Barlow Condensed';
            font-weight: bold;
            src: url("{{ $fonts }}/BarlowCondensed-ExtraBold.ttf") format('truetype');
        }

        /* DIN A5 landscape, 210 x 148 mm */
        @page {
            margin: 0;
        }
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            font-size: 13.5pt;
            color: #000;
        }
        .page {
            position: relative;
            width: 210mm;
            height: 148mm;
            page-break-after: always;
        }
        .page-last {
            page-break-after: auto;
        }
        /* the same file for every page, so dompdf embeds it only once */
        .background {
            position: absolute;
            left: 0;
            top: 0;
            width: 210mm;
            height: 148mm;
        }
        .content {
            position: absolute;
            left: 31.5mm;
            top: 0;
            right: 0;
        }
        .fold-mark {
            position: absolute;
            left: 0;
            top: 74mm;
            width: 10mm;
            border-top: 0.3mm solid #000;
        }
        .club {
            margin: 3mm 0 0 5mm;
            padding-bottom: 3mm;
            border-bottom: 0.6mm solid #4caf50;
        }
        .club td {
            vertical-align: middle;
        }
        .club-logo {
            height: 13mm;
            margin-right: 3mm;
        }
        .club-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: bold;
            font-size: 18pt;
            text-transform: uppercase;
            line-height: 1;
        }
        .club-subtitle {
            font-size: 9pt;
        }
        h1 {
            margin: 0;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: bold;
            font-size: 27pt;
            text-transform: uppercase;
        }
        .title {
            width: 100%;
            margin: 0.5mm 0 0 0;
        }
        .title td {
            padding: 0 5mm;
        }
        .details {
            width: 100%;
            margin-top: 6mm;
        }
        .details > tbody > tr > td {
            vertical-align: top;
        }
        .photo-cell {
            width: 40mm;
            padding: 0 5mm 0 10mm;
        }
        .photo {
            width: 40mm;
        }
        /* dompdf ignores a line height as tall as the box, so the text is pushed down by padding */
        .photo-missing {
            width: 40mm;
            height: 28mm;
            padding-top: 24mm;
            border: 0.3mm dashed #999;
            background: #fff;
            color: #999;
            font-size: 10pt;
            text-align: center;
        }
        .fields td {
            padding: 2.2mm 0 0 0;
            vertical-align: middle;
        }
        .field-name {
            width: 38mm;
            font-weight: bold;
        }
        .footer {
            position: absolute;
            right: 3mm;
            bottom: 3mm;
            text-align: right;
            font-size: 9pt;
            color: #999;
            line-height: 1.5;
        }
    </style>
</head>
<body>
@foreach ($players as $player)
    @php
        $person = $player->person;
        $photoFile = $photo($person->photo);
        $logoFile = $photo($player->club->logo_url);
    @endphp
    <div class="page {{ $loop->last ? 'page-last' : '' }}">
        <img class="background" src="{{ $background }}" alt="">
        <div class="fold-mark"></div>
        <div class="content">
            <div class="club">
                <table>
                    <tr>
                        @if ($logoFile)
                            <td><img class="club-logo" src="{{ $logoFile }}" alt="Vereinswappen"></td>
                        @endif
                        <td>
                            <div class="club-name">{{ $player->club->name }}</div>
                            <div class="club-subtitle">Mitglied der Hobbyliga-West</div>
                        </td>
                    </tr>
                </table>
            </div>
            <table class="title">
                <tr>
                    <td><h1>Spielerpass</h1></td>
                    <td style="text-align: right"><h1>no° {{ $player->id }}</h1></td>
                </tr>
            </table>
            <table class="details">
                <tr>
                    <td class="photo-cell">
                        @if ($photoFile)
                            <img class="photo" src="{{ $photoFile }}" alt="Passbild">
                        @else
                            <div class="photo-missing">Kein Foto</div>
                        @endif
                    </td>
                    <td>
                        <table class="fields">
                            <tr>
                                <td class="field-name">Name:</td>
                                <td>{{ $person->last_name }}</td>
                            </tr>
                            <tr>
                                <td class="field-name">Vorname:</td>
                                <td>{{ $person->first_name }}</td>
                            </tr>
                            <tr>
                                <td class="field-name">Geburtsdatum:</td>
                                <td>{{ $person->date_of_birth ? $person->date_of_birth->format('d.m.y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="field-name">Gültig ab:</td>
                                <td>{{ $player->sign_on ? $player->sign_on->format('d.m.y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="field-name">Vereinsspieler:</td>
                                <td>
                                    @if ($person->registered_at_club && $person->realClub)
                                        {{ $person->realClub->name }}@if ($person->realDivision), {{ $person->realDivision->name_short }}@endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="footer">
            Pass erstellt am: {{ $created->format('d.m.Y') }}<br>
            Ersteller: {{ $creator }}
        </div>
    </div>
@endforeach
</body>
</html>
