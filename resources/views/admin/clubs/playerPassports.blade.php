<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="application-name" content="Hobbyliga-West Düsseldorf" />
    <meta name="author" content="Hobbyliga-West Düsseldorf" />
    <meta name="description" content="Hobbyliga-West Düsseldorf. Die Fußballliga für Hobby- und Freizeitmannschaften aus Düsseldorf und Umgebung." />
    <title>{{ config('app.name') }} @yield('title') </title>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@800&family=Roboto&display=swap" rel="stylesheet">
    <style>
        /* DIN A5 Masse 148 x 210mm */
        * {
            margin: 0;
        }
        body, html {
            font-family: 'Roboto', sans-serif;
            background: url({{ asset('storage/passportbg.png') }}) no-repeat;
            width: 595.28pt;
            height: 419.53pt;
        }
        h1 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 36px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .page-break {
            page-break-after: always;
        }
        .passport {
            width: 100%;
        }
        .passportLeft {
            width: 15%;
        }
        .passportRight {

        }
        .passportHeader {
            height: 50px;
        }

        .divTable { display: table; }
        .divTableRow { display: table-row; }
        .divTableCell { display: table-cell; }
        .divTableBody { display: table-row-group;}

        .logo-hlw {
            margin-top: 20px;
            text-align: center;
        }
        .fieldName {
            width: 25%;
            padding: 10px 20px 0px 10px;
            font-weight: bold;
            font-size: 18px;
            vertical-align: center;
        }
        .fieldValue {
            width: 75%;
            padding: 10px 0px 0px 0px;
            font-size: 18px;
            vertical-align: center;
        }
        .fieldGroup {

        }
        .footer {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100%;
            text-align: right;
            font-size: 12px;
            color: #999999;
        }
        .clubNameContainer {
            margin: 20px 0px 10px 20px;
            border-bottom: 2px solid #4caf50;
            padding-bottom: 10px;
        }
        .clubName {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 24px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .clubLogo {
            display: block;
        }
        .clubSubtitle {
            font-size: 12px;
        }

    </style>
</head>
<body>
@foreach($active_players as $player)
        <div class="divTable passport">
            <div class="divTableBody">
                <div class="divTableRow">
                    <div class="divTableCell passportLeft" style="position: relative">
                        <div style="position: absolute; left: 0; top: 50%; height: 1px; width: 33%; background-color: #000">
                            &nbsp;
                        </div>
                        <div class="logo-hlw">
                            <img src="{{ asset('storage/hlwlogo_w.png') }}" height="30">
                        </div>
                    </div>

                    <div class="divTableCell passportRight">
                        <div class="clubNameContainer">
                            <div style="display: inline-block; vertical-align: middle">
                                @if($player->club->logo_url)
                                    <img class="clubLogo" src="{{ asset('storage/'.$player->club->logo_url) }}" title="Vereinswappen" alt="Vereinswappen" height="50">
                                @endif
                            </div>
                            <div style="display: inline-block; vertical-align: middle">
                                <div class="clubName">{{ $player->club->name }}</div>
                                <div class="clubSubtitle">Mitglied der Hobbyliga-West</div>
                            </div>
                        </div>
                        <div class="divTable passport">
                            <div class="divTableBody">
                                <div class="divTableRow passportHeader">
                                    <div class="divTableCell" style="width: 25%; padding: 0px 0px 20px 20px">
                                        <h1>Spielerpass </h1>
                                    </div>
                                    <div class="divTableCell" style="text-align: right; padding: 0px 20px 20px 20px">
                                        <h1>_no° {{ $player->id }}</h1>
                                    </div>
                                </div>
                                <div class="divTableRow">
                                    <div class="divTableCell" style="padding-left: 20px ">
                                        @if($player->person->photo)
                                            <img src="{{ asset('storage/'.$player->person->photo) }}" class="" title="Passbild" alt="Passbild" width="150">
                                        @else
                                            &nbsp;
                                        @endif
                                    </div>
                                    <div class="divTableCell" style="vertical-align: top">
                                        <div class="divTable">
                                            <div class="divTableBody">
                                                <div class="divTableRow">
                                                    <div class="divTableCell fieldName">Vorname:</div>
                                                    <div class="divTableCell fieldValue">{{ $player->person->first_name }}</div>
                                                </div>
                                                <div class="divTableRow">
                                                    <div class="divTableCell fieldName">Nachname:</div>
                                                    <div class="divTableCell fieldValue">{{ $player->person->last_name }}</div>
                                                </div>
                                                <div class="divTableRow">
                                                    <div class="divTableCell fieldName">Geburtsdatum:</div>
                                                    <div class="divTableCell fieldValue">{{ $player->person->date_of_birth ? $player->person->date_of_birth->format('d.m.y') : "-" }}</div>
                                                </div>
                                                <div class="divTableRow">
                                                    <div class="divTableCell fieldName">Gültig ab:</div>
                                                    <div class="divTableCell fieldValue">{{ $player->sign_on ? $player->sign_on->format('d.m.y') : "-" }}</div>
                                                </div>
                                                <div class="divTableRow">
                                                    <div class="divTableCell fieldName">Vereinsspieler:</div>
                                                    <div class="divTableCell fieldValue">
                                                        @if ($player->person->registered_at_club)
                                                            {{ $player->person->realClub->name }}
                                                            @if ($player->person->realDivision)
                                                                , {{ $player->person->realDivision->name_short }}
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="divTableRow">
                                                    <div class="divTableCell fieldName" style="height: 80px">
                                                        &nbsp;
                                                    </div>
                                                    <div class="divTableCell fieldValue" style="border-bottom: 1px solid #666">
                                                        &nbsp;
                                                    </div>
                                                </div>
                                                <div class="divTableRow" >
                                                    <div class="divTableCell fieldName" >

                                                    </div>
                                                    <div class="divTableCell fieldValue" style="font-weight: normal; font-size: 12px; text-align: right">
                                                        <strong>Unterschrift des Spielers</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <span style="display: block; padding: 5px 10px 5px 10px; text-align: right">Pass erstellt am: {{ date('d.m.Y') }}</span>
                <span style="display: block; padding: 0px 10px 10px 10px; text-align: right">Ersteller: {{ auth()->user()->name }}</span>
            </div>
        </div>
    <div class="page-break"></div>
@endforeach
</body>
</html>