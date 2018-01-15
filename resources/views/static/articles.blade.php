@extends('layouts.app')

@section('title')

    Infos

@endsection

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h1 class="font-weight-bold font-italic text-uppercase">Infos</h1>
                <ul class="nav nav-pills nav-fill">
                    @auth
                        <li class="nav-item mr-2">
                            <a class="nav-link border border-success rounded" href="#referees">Schiedsrichter</a>
                        </li>
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link border border-success rounded" href="#hlw">HLW-Satzung</a>
                    </li>
                    <li class="nav-item ml-2">
                        <a class="nav-link border border-success rounded" href="#ah">AH-Satzung</a>
                    </li>
                    <li class="nav-item ml-2">
                        <a class="nav-link border border-success rounded" href="#join">Mitmachen</a>
                    </li>
                </ul>
            </div>
        </div>
        {{-- Vorstand --}}
        <div class="row mt-4">
            <div class="col">
                <h2 class="font-weight-bold font-italic">Vorstand der Hobbyliga-West</h2>
                <span class="text-muted">An alle E-Mail-Adressen ist selbständig "@hobbyligawest.de" anzuhängen.</span>
                <div class="row mt-2">
                    <div class="col">
                        <div class="card-deck">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title font-weight-bold">Michael Leest</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">1. Vorsitzender</h5>
                                    <p class="card-text">Ansprechpartner für die Teams.</p>
                                    <span class="text-success card-link">
                                        <i class="fa fa-fw fa-envelope-o"></i> mleest
                                    </span>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title font-weight-bold">Sven Kienert</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">2. Vorsitzender</h5>
                                    <p class="card-text">Ansprechpartner für die Teams und zusätzlich verantwortlich für Spielerpässe.</p>
                                    <span class="text-success card-link">
                                        <i class="fa fa-fw fa-envelope-o"></i> skienert
                                    </span>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title font-weight-bold">Stefan Abels</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Schiedsrichterobmann</h5>
                                    <p class="card-text">Verantwortlich für die Schiedsrichterzuteilung und zusätzlich verantwortlich für Spielerpässe.</p>
                                    <span class="text-success card-link">
                                        <i class="fa fa-fw fa-envelope-o"></i> sabels
                                    </span>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title font-weight-bold">Erwin Scholz</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Kassierer</h5>
                                    <p class="card-text">Kassierer der HLW.</p>
                                    <span class="text-success card-link">
                                        <i class="fa fa-fw fa-envelope-o"></i> escholz
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-deck mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title font-weight-bold">Klaus Wynants</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">AH-Vorstand</h5>
                                    <p class="card-text">Verantwortlich für die Altherren-Liga.</p>
                                    <span class="text-success card-link">
                                        <i class="fa fa-fw fa-envelope-o"></i> kwynants
                                    </span>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title font-weight-bold">Jürgen Kaiser</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Spielplan</h5>
                                    <p class="card-text">Verantwortlich für den Spielplan von HLW und AH-Liga.</p>
                                    <span class="text-success card-link">
                                        <i class="fa fa-fw fa-envelope-o"></i> jkaiser
                                    </span>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title font-weight-bold">Kevin Kaiser</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Webmaster</h5>
                                    <p class="card-text"></p>
                                    <span class="text-success card-link">
                                        <i class="fa fa-fw fa-envelope-o"></i> webmaster
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- referees --}}
        @auth
            @if (!$referees->isEmpty())
                <a id="referees"></a>
                <div class="row mt-4">
                    <div class="col">
                        <h2 class="font-weight-bold font-italic">Schiedsrichter</h2>
                        <ul class="list-group">
                            @foreach ($referees->sortBy('person.last_name') as $referee)
                                <li class="list-group-item d-flex justify-content-between">
                                    <div class="text-left">
                                        {{ $referee->person->full_name_shortened }}
                                    </div>
                                    <div class="">
                                        {{ $referee->mail }}
                                    </div>
                                    <div class="text-right">
                                        {{ $referee->mobile }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        @endauth
        {{-- HLW-Satzung --}}
        <a id="hlw"></a>
        <div class="row mt-4">
            <div class="col">
                <h2 class="font-weight-bold font-italic">Satzung der Hobbyliga-West</h2>
                <h5>Stand: </h5>
                <ol>
                    <li class="h4 font-weight-bold">Allgemeines</li>
                    <li class="h4 font-weight-bold">Startgeld</li>
                    <li class="h4 font-weight-bold">Meldungen</li>
                    <li class="h4 font-weight-bold">Pässe</li>
                    <li class="h4 font-weight-bold">Spielbetrieb</li>
                    <li class="h4 font-weight-bold">Spielergebnisse</li>
                    <li class="h4 font-weight-bold">Strafen</li>
                    <li class="h4 font-weight-bold">Schiedsrichter</li>
                    <li class="h4 font-weight-bold">Kosten</li>
                    <li class="h4 font-weight-bold">Nachholspiele</li>
                    <li class="h4 font-weight-bold">Haftung</li>
                </ol>
            </div>
        </div>
        <a id="ah"></a>
        <div class="row mt-4">
            <div class="col">
                <h2 class="font-weight-bold font-italic">Satzung der Altherren-Liga</h2>
                <h5>Stand: </h5>
                <ol>
                    <li class="h4 font-weight-bold">Allgemeines</li>
                    <li class="h4 font-weight-bold">Startgeld</li>
                    <li class="h4 font-weight-bold">Meldungen</li>
                    <li class="h4 font-weight-bold">Pässe</li>
                    <li class="h4 font-weight-bold">Spielbetrieb</li>
                    <li class="h4 font-weight-bold">Spielergebnisse</li>
                    <li class="h4 font-weight-bold">Strafen</li>
                    <li class="h4 font-weight-bold">Schiedsrichter</li>
                    <li class="h4 font-weight-bold">Kosten</li>
                    <li class="h4 font-weight-bold">Nachholspiele</li>
                    <li class="h4 font-weight-bold">Haftung</li>
                </ol>
            </div>
        </div>
        {{-- how to join --}}
        <a id="join"></a>
        <div class="row mt-4">
            <div class="col">
                <h2 class="font-weight-bold font-italic">Mitmachen</h2>
                <p>
                    - "Was brauchen wir um mitzumachen"-Seite? Mit Infos:
                    - Eine Mannschaft, die zuverlässig ist, um Spielabsagen zu vermeiden
                    - Umkreis Düsseldorf + direkte Nachbarstädte
                    - Startgeld + Schiedsrichterkaution
                    - Einstieg (nur) vor jedem Saisonbeginn in der 2. Liga möglich
                    - Einen Platz, auf dem ihr einen regelmäßigen Heimspieltermin organisieren könnt
                    ○ Der Platz muss x Stunden, siehe Satzung
                    -geht eine Saison immer halbjährig oder ganzjährig
                    -wie viele Spieler müssen pro Mannschaft gemeldet sein
                    -Spielt man im Bereich der DFB-Regeln (2x45min)
                    -Bis wann muss man seine Mannschaft gemeldet haben
                    -werden die Spiele wöchentlich ausgetragen

                </p>
                <p>
                    Kurze Zusammenfassung unserer Satzung:
                    Wir spielen nach DFB-Regeln, d.h. 2 x 45 Minuten auf Großfeld.

                </p>
                <ul class="list-unstyled">
                    <li class="font-weight-bold">F: Wie können wir mitmachen?</li>
                    <li class="">A: fdsghjkl</li>
                    <li class="font-weight-bold">F: Was kostet die Teilnahme?</li>
                    <li class="font-weight-bold">F: Was brauchen wir?</li>
                    <li class="">A: Ihr braucht:
                        <ul>
                            <li>
                                Einen Platz, auf dem ihr regelmäßig Heimspiele austragen könnt. Dieser Platz muss mindestens x Stunden zur Verfügung stehen.
                            </li>
                            <li>
                                Genügend Spieler im Kader. Also allermindestens 11, plus Auswechselspieler. Keiner dieser Spieler darf in einem Verein spielen.
                            </li>
                        </ul>
                    </li>
                    <li class="font-weight-bold">F: Wann können wir mitmachen?</li>
                </ul>
            </div>
        </div>
    </div>

@endsection