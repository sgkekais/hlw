@extends('layouts.app')

@section('title')

    | Infos

@endsection

@section('css')

@endsection

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h1 class="font-weight-bold font-italic text-uppercase">Infos</h1>
                <ul class="nav nav-pills nav-fill d-flex flex-column flex-md-row">
                    @auth
                        @hasanyrole('super_admin|admin|club_contact')
                            <li class="nav-item mr-md-2">
                                <a class="nav-link border border-success rounded" href="#referees">Schiedsrichter</a>
                            </li>
                        @endhasanyrole
                    @endauth
                    <li class="nav-item mt-2 mt-md-0">
                        <a class="nav-link border border-success rounded" href="#hlw">HLW-Satzung</a>
                    </li>
                    <li class="nav-item ml-md-2 mt-2 mt-md-0">
                        <a class="nav-link border border-success rounded" href="#ah">AH-Satzung</a>
                    </li>
                    <li class="nav-item ml-md-2 mt-2 mt-md-0">
                        <a class="nav-link border border-success rounded" href="#join">Mitmachen</a>
                    </li>
                    @auth
                        <li class="nav-item ml-lg-2 mt-2 mt-lg-0">
                            <a class="nav-link border border-success rounded" href="{{ route('frontend.static.matchreport') }}" title="Herunterladen"><span class="fa fa-fw fa-download" title="Herunterladen"></span> Spielberichtsbogen</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
        {{-- Vorstand --}}
        <div class="row mt-4">
            <div class="col">
                <h2 class="font-weight-bold font-italic">Vorstand der Hobbyliga-West</h2>
                <div class="alert alert-secondary bg-light d-flex align-items-center">
                    <h2 class="mb-0 pr-3">
                        <span class="fa fa-fw fa-warning"></span>
                    </h2>
                    <div class="">
                        Anfragen und Infos bitte immer an die Vorstandsadresse (<b><a href="mailto:vorstand@hobbyligawest.de" title="Mail an Vorstand">vorstand@hobbyligawest.de</a></b>), damit der gesamte Vorstand die Info erhält und schneller reagieren kann.
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <div class="card-deck">
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-weight-bold">Daniel Alberty</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Aufgaben</h5>
                                    <p class="card-text">Schiedsrichteransetzungen & Ansprechpartner Teams</p>
                                    <div class="mt-auto">
                                        <span class="fa fa-fw fa-envelope-o"></span> <a href="mailto:vorstand@hobbyligawest.de" title="Mail an D. Alberty">vorstand</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-weight-bold">Jürgen Kaiser</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Aufgaben</h5>
                                    <p class="card-text">Spielpläne HLW + AH & Ansprechpartner Teams</p>
                                    <div class="mt-auto">
                                        <span class="fa fa-fw fa-envelope-o"></span> <a href="mailto:vorstand@hobbyligawest.de" title="Mail an J. Kaiser">vorstand</a>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 my-2 d-block d-md-none"><!-- wrap every 2 below md --></div>
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-weight-bold">Harald Scholz</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Aufgaben</h5>
                                    <p class="card-text">Spielerpässe & Ansprechpartner Teams</p>
                                    <div class="mt-auto">
                                        <span class="fa fa-fw fa-envelope-o"></span> <a href="mailto:vorstand@hobbyligawest.de" title="Mail an H. Scholz">vorstand</a>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 my-2 d-none d-md-block d-lg-none"><!-- wrap every 3 at md --></div>
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-weight-bold">Klaus Wynants</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Aufgaben</h5>
                                    <p class="card-text">Verantwortlich für die Altherren-Liga</p>
                                    <div class="mt-auto">
                                        <span class="fa fa-fw fa-envelope-o"></span> <a href="mailto:kwynants@hobbyligawest.de" title="Mail an K. Wynants">kwynants</a>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 my-2 d-block d-md-none"><!-- wrap every 2 below md --></div>
                            <div class="w-100 my-2 d-none d-lg-block"><!-- wrap every 4 above md --></div>
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-weight-bold">Erwin Scholz</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Aufgaben</h5>
                                    <p class="card-text">Kassierer & Ansprechpartner Teams</p>
                                    <div class="mt-auto">
                                        <span class="fa fa-fw fa-envelope-o"></span> <a href="mailto:vorstand@hobbyligawest.de" title="Mail an E. Scholz">vorstand</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-weight-bold">Johannes Kasten</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Aufgaben</h5>
                                    <p class="card-text">Social Media</p>
                                    <div class="mt-auto">
                                        <span class="fa fa-fw fa-envelope-o"></span> <a href="mailto:vorstand@hobbyligawest.de" title="Mail an S. Abels">vorstand</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-weight-bold">Stefan Abels</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Aufgaben</h5>
                                    <p class="card-text">Vertretung Spielerpässe</p>
                                    <div class="mt-auto">
                                        <span class="fa fa-fw fa-envelope-o"></span> <a href="mailto:vorstand@hobbyligawest.de" title="Mail an S. Abels">vorstand</a>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 my-2 d-block d-md-none"><!-- wrap every 2 below md --></div>
                            <div class="w-100 my-2 d-none d-md-block d-lg-none"><!-- wrap every 3 at md --></div>
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-weight-bold">Kevin Kaiser</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Aufgaben</h5>
                                    <p class="card-text">Webmaster</p>
                                    <div class="mt-auto">
                                        <span class="fa fa-fw fa-envelope-o"></span> <a href="mailto:webmaster@hobbyligawest.de" title="Mail an Webmaster">webmaster</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @auth
            @hasanyrole('super_admin|admin|club_contact')
                @if (!$referees->isEmpty())
                    <a id="referees"></a>
                    <div class="row mt-4">
                        <div class="col">
                            <h2 class="font-weight-bold font-italic">Schiedsrichter</h2>
                            <p class="text-muted">
                                Diese Daten sind nur für Admins und die Ansprechpartner der Teams einsehbar.
                            </p>
                            <ul class="list-group">
                                <li class="list-group-item d-flex flex-column flex-md-row justify-content-between">
                                    <div class="col-md-4 text-left">
                                        <span class="fa fa-user" title="Schiedsrichter"></span>
                                    </div>
                                    <div class="col-md-4 text-left">
                                        <span class="fa fa-envelope" title="E-Mail"></span>
                                    </div>
                                    <div class="col-md-4 text-md-right">
                                        <span class="fa fa-phone" title="Telefon"></span>
                                    </div>
                                </li>
                                @foreach ($referees->sortBy('person.last_name') as $referee)
                                    <li class="list-group-item d-flex flex-column flex-md-row justify-content-between">
                                        <div class="col-md-4 text-left">
                                            {{ $referee->person->full_name_shortened }}
                                        </div>
                                        <div class="col-md-4 text-left">
                                            {{ $referee->mail }}
                                        </div>
                                        <div class="col-md-4 text-md-right">
                                            {{ $referee->mobile }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            @endhasanyrole
        @endauth
        {{-- HLW-Satzung --}}
        <a id="hlw"></a>
        <div class="row mt-4">
            <div class="col">
                <h2 class="font-weight-bold font-italic">Satzung der Hobbyliga-West</h2>
                <h5>Stand: 21.08.2024</h5>
                <ol id="list" class="list-unstyled">
                    <li>
                        <span class="h4 font-weight-bold">0. Allgemeines</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Der Spaß steht im Vordergrund unserer Liga. Die Mannschaften spielen nicht gegen-, sondern miteinander. Die Teams sind fair zueinander und zu den Schiedsrichtern, sowohl vor, während als auch nach dem Spiel. Die Satzung wurde von allen Teams gemeinsam mit dem Vorstand entworfen.
                            </li>
                            <li>
                                Der Vorstand ist die Vertretung der Hobbyliga-West und zuständig für Finanzen, Verwaltung, Öffentlichkeitsarbeit und Ligaentwicklung. Der Vorstand behält sich vor, Spieler, die in grober Weise die Gesundheit anderer Spieler gefährden oder sich in ebenso grobem Maße unsportlich verhalten, zu sperren oder gar vom Spielbetrieb der Hobbyliga-West zu suspendieren. Dies gilt auch für Teams, die sich in grober Art und Weise der Satzung der Hobbyliga-West widersetzen. Um jegliches Konfliktpotenzial zu vermeiden, wird kein Vorstandsmitglied in irgendeiner Weise in eine Entscheidung eingreifen, die seine eigene Mannschaft betrifft.
                            </li>
                            <li>
                                In der Hobbyliga-West können Hobby-, Freizeit-, und Betriebsportmannschaften teilnehmen. Seit der Saison 2013 dürfen die teilnehmenden Mannschaften jedoch <strong>nur noch vereinslose Spieler</strong> anmelden (bereits vor diesem Zeitpunkt gemeldete Spieler genießen Bestandsschutz, siehe auch 4.6).
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">1. Startgeld</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Das Startgeld beträgt aktuell pro Mannschaft 80,- € und ist am Tag der Jahreshauptversammlung beim Kassierer zu bezahlen oder vor der JHV pünktlich zu überweisen.
                                <br>
                                <strong>IBAN: DE73300400000272242991</strong>
                            </li>
                            <li>
                                Bei Ausschluss oder Austritt verbleibt das Startgeld bei der Hobbyliga-West und wird der Mannschaft nicht - auch nicht anteilig - zurückerstattet.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">2. Spielermeldungen</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Jede Mannschaft erhält rechtzeitig vor der angekündigten Jahreshauptversammlung (JHV) die digitale Passmappe mit allen aktiven Spielern.
                            </li>
                            <li>
                                Nicht mehr aktive Spieler und Neuanmeldungen müssen bis zur JHV gemeldet werden.
                            </li>
                            <li>
                                Die aktualisierte Mappe wir vor Saisonbeginn versendet.
                            </li>
                            <li>
                                Neue Teams müssen eine Liste mit Namen, Vornamen und Geburtsdaten zur Anmeldung der Spieler erstellen. Diese ist zusammen mit den digitalen Portraitfotos, einer Kopie (Foto) vom Personalausweis (Vorderseite, mit „schwärzen“ aller Daten außer Name, Vorname, Geburtsdatum, Foto) der Spieler spätestens 14 Tage vor der JHV an den Vorstand zu senden.
                            </li>
                            <li>
                                Weitere Regeln:
                                <br>
                                <ul>
                                    <li>
                                        Alle Spieler, die angemeldet werden, müssen sich beim jeweiligen Spielverantwortlichen mit einem gültigen Identitätsnachweis (Personalausweis, Reisepass, etc.) ausweisen. Der Spielverantwortliche ist somit für die Richtigkeit aller Angaben verantwortlich und hat die Daten des Identitätsnachweises mit dem Spielerpass abzugleichen.
                                    </li>
                                    <li>
                                        Spieler, die nicht das 18. Lebensjahr erreicht haben, dürfen nicht in der HLW mitspielen.
                                    </li>
                                    <li>
                                        Nachmeldungen sind jederzeit möglich.
                                    </li>
                                    <li>
                                        Nachgemeldete Spieler sind erst dann spielberechtigt, wenn der Spielerpass vorliegt.
                                    </li>
                                    <li>
                                        Neu anzumeldende Spieler dürfen nicht in einem Verein spielen (siehe 0.3.) und auch nur in einer Mannschaft der HLW angemeldet werden.
                                    </li>
                                    <li>
                                        Neuanmeldungen sind <strong>ausschließlich PER E-MAIL an vorstand@hobbyligawest.de</strong> zu senden.
                                    </li>
                                    <li>
                                        Vereinsspielern mit Bestandsschutz (siehe 0.3) ist erlaubt innerhalb der Hobbyliga den Verein zu wechseln.
                                    </li>
                                    <li>
                                        Am Spieltag werden keine Pässe ausgestellt bzw. Passmappen versendet!
                                    </li>
                                    <li>
                                        Wechselt ein Spieler während der Saison den Verein innerhalb der Liga, erfolgt ein Pflichtspiel Sperre. Bei Saisons mit PlayOff-Modus darf nur bis zum Ende der „Vorrunde“ gewechselt werden.
                                    </li>
                                </ul>
                            </li>
                            <li>
                                Falls eine Mannschaft einen nicht spielberechtigten Spieler einsetzt, wird das Spiel für diese Mannschaft als verloren gewertet (0 Punkte / 0:5 Tore). Beim ersten Verstoß werden zusätzlich 6 Punkte abgezogen. Ab dem zweiten Verstoß kann der Ausschluss aus der Hobbyliga-West erfolgen. Die Entscheidung trifft der Vorstand.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">3. Pässe und Spielberichtsbögen</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Es wird jeder Mannschaft eine digitale Passmappe (pdf-Datei) vom Vorstand ausgestellt. Die Schiedsrichter sind verpflichtet, vor jedem Spiel die Spielberechtigung der anwesenden Spieler anhand der <strong>Spielerpässe</strong> zu prüfen, die von den Mannschaften <strong>zwingend mitzuführen</strong> sind.
                            </li>
                            <li>
                                Die Spielberichtsbögen stehen auf der Website unter <strong>Infos</strong> als PDF zum Download zur Verfügung. Diese sind ordnungsgemäß von beiden Teams ausgefüllt vor jedem Spiel dem Schiedsrichter zu übergeben.
                            </li>
                            <li>
                                Der Schiedsrichter ergänzt den Spielberichtsbogen nach dem Spiel mit den Spieldaten (Spielergebnis, gelb-rote und rote Karten, bes. Vorkommnisse, etc.). Die Heimmannschaft fotografiert den ausgefüllten und von allen Parteien (Kapitän / Verantwortlicher Heim, Kapitän / Verantwortlicher Gast, Schiedsrichter) unterschriebenen Spielbericht ab und sendet diesen - spätestens am Folgetag - per Mail an den Vorstand (vorstand@hobbyligawest.de). Sollte der Spielbericht nicht an den Vorstand gesendet werden, wird das Spiel mit 5:0 Toren für die Gastmannschaft gewertet.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">4. Spielbetrieb</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Der Spielplan wird vom Vorstand erstellt und ist für alle teilnehmenden Mannschaften verbindlich. Gespielt wird in den angegebenen Wochen.
                                <br>
                                Basis für die Erstellung sind:
                                <ul>
                                    <li>Heimplatz, Wochentag, Anstoßzeit aus der Vorsaison</li>
                                    <li>der Rahmen-Terminkalender, welcher die Spielwochen der Saison vorgibt</li>
                                </ul>
                                Der Modus für die aktuelle Saison wird auf der JHV durch Abstimmung der anwesenden Mannschaftsverantwortlichen festgelegt.
                                <br>
                                Der Vorstand erstellt dazu Vorschläge, Basis dafür sind:
                                <ul>
                                    <li>die Anzahl der teilnehmenden Teams</li>
                                    <li>die Anzahl der möglichen Spielwochen</li>
                                </ul>
                                Die Mannschaften erhalten den <i>vorläufigen</i> Spielplan umgehend nach der JHV, Änderungen bzgl. der Heimspiele sind umgehend an den Vorstand zu melden. . Dazu wird eine angemessene Frist eingeräumt, in der die Änderungen nicht als Verlegung gewertet werden.
                                <br>
                                <strong>Bindend ist ausschließlich der auf der Website veröffentlichte finale Spielplan!</strong>
                            </li>
                            <li>
                                Eine Spielansetzung kann in der Woche frühestens um 19:00 Uhr und spätestens um 21:00 Uhr erfolgen. Samstags zwischen 11:00 Uhr und 17:00 Uhr.
                            </li>
                            <li>
                                <strong>Spielverlegungen</strong>
                                <ol>
                                    <li>
                                        <strong>Grundsätzlich sind jeder Mannschaft pro Saison 2 Verlegungen erlaubt.</strong>
                                        <br>
                                        <strong>Gegen eine Mannschaft sind pro Saison nur 3 Verlegungen erlaubt.</strong>
                                        <br>
                                        Über den Stand (Anzahl) der Verlegungen wird vom Vorstand regelmäßig informiert.
                                    </li>
                                    <li>
                                        Änderungen dieser Anzahl können nur gemeinsam mit den Mannschaftsverantwortlichen bei einer JHV beschlossen werden.
                                    </li>
                                    <li>
                                        Die Absage des geplanten Spiels muss spätestens 48 Stunden vor der Anstoßzeit an den Vorstand und den Gegner erfolgen, Beispiele:
                                        <ul>
                                            <li>Spiel Freitag 20.00h, Absage bis Mittwoch 19:59h</li>
                                            <li>Spiel Montag 19:30h, Absage bis Samstag der Vorwoche bis 19:29h</li>
                                        </ul>
                                        Wird die Frist nicht eingehalten, erfolgt die Wertung (5:0 Tore, 3 Punkte) für
                                        den Gegner. Das Spiel wird nicht nachgeholt.
                                    </li>
                                    <li>Spielausfälle aufgrund höherer Gewalt (Witterung, Platzsperre,
                                        Doppelbelegung etc.) zählen nicht zu dieser Regelung)
                                    </li>
                                    <li>
                                        Bei einem Saisonmodus mit Meisterschafts-Play-Offs ist für diese Spiele eine Verlegung <strong>nur in Ausnahmefällen und mit Genehmigung des Vorstands erlaubt</strong> damit die Austragung der nächsten K.O.-Runde nicht gefährdet ist.
                                    </li>
                                </ol>
                            </li>
                            <li>
                                <strong>Nachholspiele</strong>
                                <ol>
                                    <li>
                                        Ein Nachholspieltermin ist von der Heimmannschaft innerhalb von <strong>einer Woche</strong> mit dem Gegner abzustimmen und innerhalb dieser Frist an den Vorstand zu melden. Sollten sich beide Mannschaften nicht auf einen Termin einigen, so wird der Vorstand einen Termin ansetzen an dem gespielt werden muss (außer 8.5 Pokalbetrieb).
                                    </li>
                                    <li>
                                        Nachholspiele können jederzeit gespielt werden. Die dafür im Rahmenspielplan reservierten Wochen sind mögliche Spieltage – jedoch nicht zwingend. Nachholspiele für bis zur Winterpause angesetzte Spiele müssen bis zum Ende der Winterpause durchgeführt werden. Auch können die Ferien für die Nachholspiele genutzt werden.
                                    </li>
                                    <li>
                                        Bei witterungsbedingten Ausfällen erfolgt ein Nachholspiel. Sollte dies absehbar sein, so sind der Gegner und der Vorstand frühzeitig zu informieren.
                                    </li>
                                </ol>
                            </li>
                            <li>
                                Grundsätzlich wird nach den aktuellen Regeln des DFB gespielt.
                            </li>
                            <li>
                                Die veralteten Regeln für Spieler mit Bestandsschutz entfallen (Beschluss JHV 2022).
                            </li>
                            <li>
                                Während eines Spiels dürfen 6 Auswechslungen vorgenommen werden. Bereits ausgewechselte Spieler dürfen wieder eingewechselt werden, solange die Auswechselgrenze von 6 Wechseln nicht erreicht ist. (<strong>Achtung</strong>: Anzahl Vereinsspieler! Siehe 4.6).
                            </li>
                            <li>
                                Die Wartezeit für den Anpfiff bei Verspätung einer Mannschaft beträgt 20 Minuten.
                            </li>
                            <li>
                                Tritt eine Mannschaft nicht an, wird das ausgefallene Spiel mit 3 Punkten und 2:0 Toren für den Gegner gewertet.
                            </li>
                            <li>
                                Die Kosten für den Schiedsrichter trägt immer die nicht angetretene Mannschaft.
                                <br>
                                Bei einer Absage am Spieltag erhält der entsprechende Schiedsrichter 50 % des Betrages als Entschädigung. Ist der Schiedsrichter bereits auf dem Platz, bzw. wird das Spiel während seiner Anreise abgesagt, erhält er 100 % Erstattung.
                                <br>
                                Tritt die Auswärtsmannschaft ohne rechtzeitige Abmeldung nicht an, so hat sie der Heimmannschaft die Kosten für den Platz zu ersetzen, wenn dieser nicht anderweitig genutzt werden kann (durch andere Mannschaft oder Trainingsspiel).
                            </li>
                            <li>
                                Die Kosten für den Schiedsrichter müssen vor dem Spiel gezahlt werden. Bei Nicht-Einhaltung kann der Schiedsrichter den Platz wieder verlassen und bekommt die Kosten von der HLW ersetzt. Die Mannschaft, die den Schiedsrichter nicht bezahlt hat, muss das Geld an die HLW bezahlen. Bei Wiederholung wird die Mannschaft aus der HLW ausgeschlossen.
                            </li>
                            <li>
                                Die Heimmannschaft hat immer folgende Voraussetzungen zu erfüllen:
                                <ul>
                                    <li>Der Platz muss mindestens 2 Stunden zur Verfügung stehen (Pokalspiel: 3 Stunden).</li>
                                    <li>Erscheint der Schiedsrichter nicht, stellt die Heimmannschaft eine geeignete Person zur Leitung des Spiels.</li>
                                    <li>Ist dies nicht möglich, versucht der Gast eine geeignete Person zu stellen - auch eine Teilung „jeder eine Halbzeit“ ist möglich. Kommt es zu keiner Einigung, so findet ein Nachholspiel statt und die anfallenden Kosten (Platz/Schiedsrichter) werden von beiden Mannschaften zur Hälfte getragen.</li>
                                    <li>Bei Trikotgleichheit sorgt die Heimmannschaft für eine Möglichkeit zur Unterscheidung (2.Trikotsatz oder Leibchen etc.).</li>
                                </ul>
                            </li>
                            <li>Trikots mit Rückennummern sind Pflicht, Mannschaften dürfen nicht mit doppelten (bzw. mehrfach gleichen) Rückennummern spielen.</li>
                            <li>Ein abgebrochenes Spiel wird normal gewertet, wenn 75 % der regulären Spielzeit abgelaufen sind.</li>
                            <li>Ein Spieler darf keine Kleidungsstücke oder Ausrüstungsgegenstände tragen, die ihn oder einen anderen Spieler gefährden könnten (einschließlich jeder Art von Schmuck). Im Gegensatz zu den geltenden DFB-Regeln, ist das Abkleben von Schmuck erlaubt.</li>
                            <li>Das Tragen von Schienbeinschützern ist zwingend vorgeschrieben.</li>
                            <li>Scheidet eine Mannschaft aus dem laufenden Wettbewerb aus, werden alle Spiele dieser Mannschaft <strong>annulliert</strong>.</li>
                            <li><strong>Je nach Spielmodus</strong> wird über evtl. Auf- und Abstiege bei der JHV je nach Teilnehmerzahl und Spielmodus der nächsten Saison entschieden.</li>
                            <li>
                                Bei Punktgleichheit in der Tabelle entscheidet zuerst der direkte Vergleich, danach das Torverhältnis über den Tabellenplatz.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">5. Strafen</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Alle Karten gelten <un>saison- und wettbewerbsübergreifend</un>, d.h. für Meisterschafts- und Pokalspiele!
                            </li>
                            <li>
                                Sperren aufgrund Platzverweises im <strong>Pokal</strong> für Spieler, die in der HLW und AH spielen, gelten „übergreifend“, d.h. sowohl in der HLW als auch in der AH-Liga werden die Spieler nach 5.1. gesperrt. Die Sperre kann also durch Spiele in beiden Ligen und im Pokal „abgesessen“ werden.                            </li>
                            <li>
                                Karten:
                                <ul>
                                    <li>Zeitstrafe = 10 Minuten</li>
                                    <li>Gelb-Rote Karte = Matchstrafe + 1 Spiel Sperre</li>
                                    <li>Rote Karte (gespielte Spiele):
                                        <ul>
                                            <li>
                                                mindestens <strong>2</strong> Spiele Sperre (z.B. bei absichtlichem Handspiel, Notbremse, grobem oder wiederholtem Foulspiel)
                                            </li>
                                            <li>
                                                bei Schiedsrichterbeleidigung mindetens <strong>3</strong> Spiele Sperre
                                            </li>
                                            <li>
                                                je nach Schwere des Verstoßes behält sich der Vorstand auf Basis des Spielberichts und der Aussagen des Schiedsrichters und des Mannschafts-Verantwortlichen eine Straferhöhung vor
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        Wertigkeit/Reihenfolge der Strafen:
                                        <ul>
                                            <li>1. Gelb / Zeitstrafe 10 Min.</li>
                                            <li>Gelb-Rot</li>
                                            <li>Rot</li>
                                        </ul>
                                        Dies bedeutet, dass nach einer Strafe bei weiteren Vergehen nur eine <strong>höhere</strong> Strafe folgen kann.
                                    </li>

                                </ul>
                            </li>
                            <li>
                                Im Wiederholungsfall wird ein Spieler immer um ein Spiel mehr als vorher gesperrt.
                            </li>
                            <li>
                                Bei Prügeleien, rassistischen, antisemitischen oder sonstigen fremdenfeindlichen oder diffamierenden Äußerungen werden Spieler aus der HLW ausgeschlossen.
                            </li>
                            <li>
                                Diese Strafen gelten auch, wenn sie nicht auf der Website vermerkt sind.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">6. Schiedsrichter</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Die Schiedsrichter werden vom Schiedsrichterobmann eingeteilt und sind auf der Website beim jeweiligen Spiel für Mannschaftsverantwortliche sichtbar.
                            </li>
                            <li>
                                Die angesetzten Schiedsrichter können nicht abgelehnt werden.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">7. Kosten</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Die Heimmannschaft trägt die Kosten für den Platz und zahlt dem Schiedsrichter aktuell 35,- € pro Spiel.
                            </li>
                            <li>
                                Jede Mannschaft hinterlegt am Tag der Jahreshauptversammlung eine Kaution in Höhe von aktuell 70,- € als Schiedsrichterkaution, bzw. füllt diese entsprechend wieder auf. Hieraus wird der Kassierer notwendige Schiedsrichterkosten für eventuelle Spielausfälle bezahlen. Diese Kaution ist im Laufe des Jahres bitte immer bei mindestens aktuell 35,- € pro Mannschaft zu halten.
                            </li>
                            <li>
                                Die Kosten (Platz und 3 Schiedsrichter) für das Pokalendspiel und - je nach Saisonmodus - für ein Meisterschaftsendspiel werden von der Liga übernommen.
                            </li>
                            <li>
                                Die Kosten (Platz und 3 Schiedsrichter), je nach Saisonmodus, für ein Entscheidungsspiel zur Meisterschaft oder für ein Relegationsspiel werden ebenfalls von der Liga übernommen.
                            </li>
                            <li>
                                Die Kosten für Pokalspiele (Platz & Schiedsrichter) werden von den beiden Mannschaften geteilt.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">8. Pokalwettbewerb</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Es gelten beim Pokal dieselben Melderegeln für spielberechtigte Spieler wie im Ligaspielbetrieb
                            </li>
                            <li>
                                Für teilnehmende Teams der AH-Liga gelten die Melderegeln wie in der Liga der AH.
                            </li>
                            <li>
                                Ein Spielbericht ist auch dann zwingend erforderlich, wenn einer der Teilnehmer ein AH-Team oder eine Gastmannschaft ist.
                            </li>
                            <li>
                                Die Pokalspiele werden ohne Verlängerung gespielt. Es gibt bei unentschiedenem Spielausgang sofort ein Elfmeterschießen.
                            </li>
                            <li>
                                Pokalwochen müssen <strong>grundsätzlich</strong> eingehalten werden, ansonsten ist die absagende Mannschaft ausgeschieden. <strong>Ausnahmen sind nur mit Genehmigung des Vorstands möglich.</strong>
                            </li>
                            <li>
                                Evtl. Ausnahmen für AH-Teams aufgrund deren Spielplan werden vor jeder Pokalsaison festgelegt. Die Termine für betroffene Spiele müssen vom Vorstand genehmigt werden.
                            </li>
                            <li>
                                Sollten Vereine mit 2 Teams (HLW und AH) teilnehmen, dürfen maximal <strong>5</strong> Spieler in beiden Teams spielen. Diese sind vor Beginn der Pokalrunde an den Vorstand zu melden und gelten für die <strong>gesamte</strong> laufende Pokalsaison.
                                <br>
                                Die Teams können ab dem Viertelfinale auch gegeneinander ausgelost werden.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">9. Haftung</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Die Hobbyliga-West Düsseldorf ist eine Eigeninitiative von mehreren Freizeit- und Hobbyfußballmannschaften. Sie ist <strong>nicht</strong> Veranstalter der Spiele, sondern verwaltet und organisiert lediglich den Spielbetrieb und die Ergebnisse der Spielrunden. Sie ist weder für Körper- noch für Sachschäden haftbar zu machen.
                            </li>
                        </ol>
                    </li>
                </ol>
                <span class="pull-right"><a href="#top"><span class="fa fa-arrow-up"></span> nach oben</a></span>
                <div class="clearfix"></div>
            </div>
        </div>
        <a id="ah"></a>
        <div class="row mt-2">
            <div class="col">
                <h2 class="font-weight-bold font-italic">Satzung der Altherren-Liga</h2>
                <h5>Stand: 22.12.2017</h5>
                <ul class="list-unstyled">
                    <li><span class="h4 font-weight-bold">1. Spielberechtigung</span>
                        <ol class="py-2">
                            <li>Spielberechtigt sind alle Spieler, die das <b>30.</b> Lebensjahr vollendet haben.</li>
                            <li>Spielerpässe werden nicht ausgestellt. Auf Verlangen muss sich der Spieler dem Schiedsrichter gegenüber ausweisen können.</li>
                            <li>Vereinsspieler sind nicht spielberechtigt (Spieler die <b>regelmäßig</b> in einer Vereinsmannschaft spielen)</li>
                            <li>Findet ein Vereinswechsel im Laufe der Saison statt, ist der Spieler für ein Spiel gesperrt.</li>
                            <li>Eine Spielerliste ist bei der Ligaleitung vor Beginn der Saison zu hinterlegen. Neue Spieler müssen nachgemeldet werden.</li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">2. Durchführung</span>
                        <ol class="py-2">
                            <li>Grundsätzlich wird nach den aktuellen Regeln des DFB gespielt.</li>
                            <li>Es dürfen während eines Spiels 6 Auswechslungen vorgenommen werden. Bereits ausgewechselte Spieler dürfen wieder eingewechselt werden, solange die Auswechselgrenze von 6 Wechseln nicht erreicht ist.</li>
                            <li>15 Minuten beträgt die Wartezeit, falls der Gegner nicht pünktlich zum Anstoß erschienen ist.
                                <ol>
                                    <li>Evtl. anfallende Schiedsrichterkosten bei einem Spielausfall trägt der Verursacher.</li>
                                </ol>
                            </li>
                            <li>Tritt eine Mannschaft nicht an, wird das Spiel mit 3:0 Punkten und 5:0 Toren gewertet.</li>
                            <li>Sind in der Abschlusstabelle zwei Mannschaften punkt- und Torgleich zählt der direkte Vergleich. Erst dann erfolgt ein Entscheidungsspiel. Diese Regelung gilt nur für Platz 1 und 2.</li>
                            <li>Jede Mannschaft kann zwei Spielverlegungen vornehmen. Weitere Spielverlegungen sind nicht möglich, auch wenn das Einverständnis des Gegners vorliegt. Diese Regelung gilt nicht für Spielausfälle wegen höherer Gewalt.
                                <ol>
                                    <li>
                                        Eine Spielverlegung muss mit einer Vorlaufzeit von mindestens 1 Tag erfolgen - Zwischen der Absage/Verlegung und dem Spieltag muss 1 Tag liegen.
                                        <br><b>Beispiele</b><br>
                                        Spiel Samstag, Absage bis Donnerstag<br>
                                        Spiel Freitag, Absage bis Mittwoch<br>
                                        Die Verlegung muss folgenden Personen mitgeteilt werden:<br>
                                        A) gegnerische Mannschaft<br>
                                        B) Ligaleitung<br>
                                        C) Schiedsrichterobmann
                                    </li>
                                    <li>Ein Nachholspieltermin ist von der Heimmannschaft innerhalb von zwei
                                        Wochen mit dem Gegner abzustimmen und innerhalb dieser Frist an die
                                        Ligaleitung zu melden. Sollten sich beide Mannschaften nicht auf einen Termin
                                        einigen, so wird die Ligaleitung einen Termin vorschreiben, an dem gespielt
                                        werden muss.
                                    </li>
                                    <li>Nachholspiele können jederzeit gespielt werden. Die dafür reservierten
                                        Wochen sind mögliche Spieltage, aber nicht zwingend.
                                        Nachholspiele aus der Hinrunde sind bis zum Ende der Sommerferien
                                        nachzuholen.
                                    </li>
                                    <li>
                                        Bis zum Beginn der ersten Spielwoche und während der Sommerpause (bis
                                        zum Beginn der ersten Rückrundenspielwoche) dürfen Spiele unbegrenzt
                                        verlegt werden. Diese Spielverlegungen zählen nicht zu 2.6.
                                    </li>
                                </ol>
                            </li>
                            <li>Heimmannschaft müssen zwei Trikotsätze vor Ort haben, damit im Bedarfsfall eine
                                Ausweichmöglichkeit existiert.</li>
                            <li>Sämtliche Trikotsätze müssen mit Rückennummern ausgestattet sein.</li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">3. Übermittlung der Spielergebnisse</span>
                        <ol class="py-2">
                            <li>Das Spielergebnis wird von der Heimmannschaft in der gemeinsamen Chat-
                                Gruppe eingestellt.</li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">4. Strafen</span>
                        <ol class="py-2">
                            <li>Gelb-Rot = Matchstrafe</li>
                            <li>Rote Karte = 1 Pflichtspiele Sperre</li>
                            <li>Bei roter Karte wegen außergewöhnlichen Vergehen entscheidet der Ligaleiter über die Dauer der Sperre.</li>
                            <li>Setzt eine Mannschaft einen oder mehrere nicht spielberechtigte Spieler ein (z.B. Vereinsspieler siehe 1.3., keine 30 Jahre alt, nicht gemeldet) werden beim
                                <ol>
                                    <li>Vergehen das Spiel mit 5:0 Toren für den Gegner gewertet und zusätzlich werden 3 Punkte abgezogen</li>
                                    <li>Vergehen das Spiel mit 5:0 Toren für den Gegner gewertet und zusätzlich werden 6 Punkte abgezogen</li>
                                    <li>Vergehen der Ausschluss aus der Liga ausgesprochen</li>
                                </ol>
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">5. Schiedsrichter</span>
                        <ol class="py-2">
                            <li>Der vom Veranstalter angesetzte Schiedsrichter erhält
                                vor dem Spiel von der Heimmannschaft 35,00 EURO und kann
                                nicht abgelehnt werden.</li>
                            <li>Erscheint der Schiedsrichter nicht, stellt die
                                Heimmannschaft eine geeignete Person zur Leitung des Spiels ab.
                                Ist dies nicht möglich, versucht der Gast
                                eine geeignete Person zu stellen. Kommt es zu keiner
                                Einigung, so findet ein Nachholspiel statt und die
                                Kosten müssen geteilt werden.</li>
                        </ol>
                    </li>
                </ul>
                <span class="pull-right"><a href="#top"><span class="fa fa-arrow-up"></span> nach oben</a></span>
                <div class="clearfix"></div>
            </div>
        </div>
        {{-- how to join --}}
        <a id="join"></a>
        <div class="row mt-2">
            <div class="col">
                <h2 class="font-weight-bold font-italic">Ihr wollt mitmachen?</h2>
                Ihr seid eine Hobby- / Theken- / Betriebsmannschaft aus Düsseldorf oder der näheren Umgebung? Dann braucht ihr folgendes um mitzumachen:
                <ul>
                    <li>
                        <span class="font-weight-bold">Eine motivierte Mannschaft mit ausreichend zuverlässigen Spielern</span>
                        <ul>
                            <li>Ihr solltet also allermindestens 11 Spieler plus Reserve sein</li>
                            <li>Keiner dieser Spieler darf in einem Verein spielen</li>
                            <li>Seid euch sicher, dass ihr mindestens eine Saison hinbekommt. Erspart euch die Peinlichkeit vieler Spielabsagen oder sogar den Rücktritt aus einer laufenden Saison.</li>
                        </ul>
                    </li>
                    <li>
                        <span class="font-weight-bold">Einen Platz, auf dem ihr einen regelmäßigen Heimspieltermin organisieren könnt</span>
                        <ul>
                            <li>Der Platz sollte den DFB-Vorgaben entsprechen und mindestens zwei Stunden zur Verfügung stehen (inkl. Flutlicht-Möglichkeit)</li>
                            <li>Der Platz muss euch die gesamte Saison über zur Verfügung stehen (schaut euch die Spielpläne als Beispiel an)</li>
                        </ul>
                    </li>
                    <li>
                        <span class="font-weight-bold">Einen Satz passender Ausrüstung</span>
                        <ul>
                            <li>Denkt an Trikots, Bälle, Torwartausrüstung, etc...</li>
                        </ul>
                    </li>
                    <li>
                        <span class="font-weight-bold">Einen Namen und ein Vereinswappen</span>
                    </li>
                    <li><span class="font-weight-bold">Startgeld und Schiedsrichterkaution</span></li>
                </ul>
                <p>
                    Einsteigen könnt ihr vor jedem Saisonbeginn (nicht während einer laufenden Saison). Da wir unsere Saisons von Frühling bis Herbst ausspielen, solltet ihr uns euer Interesse für die nächste Saison spätestens bis Ende November des laufenden Jahres mitteilen, damit wir planen können. Schreibt dazu eine Mail den Vorstand (vorstand@...).
                </p>

                <span class="pull-right"><a href="#top"><span class="fa fa-arrow-up"></span> nach oben</a></span>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

@endsection