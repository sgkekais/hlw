@extends('layouts.app')

@section('title')

    | Infos

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
                                    <h4 class="card-title font-weight-bold">Michael Leest</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">1. Vorsitzender</h5>
                                    <p class="card-text">Ansprechpartner für die Teams.</p>
                                    <div class="mt-auto">
                                        <span class="fa fa-fw fa-envelope-o"></span> <a href="mailto:mleest@hobbyligawest.de" title="Mail an M. Leest">mleest</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-weight-bold">Sven Kienert</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">2. Vorsitzender</h5>
                                    <p class="card-text">Ansprechpartner für die Teams und zusätzlich verantwortlich für Spielerpässe.</p>
                                    <div class="mt-auto">
                                        <span class="fa fa-fw fa-envelope-o"></span> <a href="mailto:skienert@hobbyligawest.de" title="Mail an S. Kienert">skienert</a>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 my-2 d-block d-md-none"><!-- wrap every 2 below md --></div>
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-weight-bold">Stefan Abels</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Schiedsrichterobmann</h5>
                                    <p class="card-text">Verantwortlich für die Schiedsrichterzuteilung und zusätzlich verantwortlich für Spielerpässe.</p>
                                    <div class="mt-auto">
                                        <span class="fa fa-fw fa-envelope-o"></span> <a href="mailto:sabels@hobbyligawest.de" title="Mail an S. Abels">sabels</a>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 my-2 d-none d-md-block d-lg-none"><!-- wrap every 3 at md --></div>
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-weight-bold">Erwin Scholz</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Kassierer</h5>
                                    <p class="card-text">Kassierer der HLW.</p>
                                    <div class="mt-auto">
                                        <span class="fa fa-fw fa-envelope-o"></span> <a href="mailto:escholz@hobbyligawest.de" title="Mail an E. Scholz">escholz</a>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 my-2 d-block d-md-none"><!-- wrap every 2 below md --></div>
                            <div class="w-100 my-2 d-none d-lg-block"><!-- wrap every 4 above md --></div>
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-weight-bold">Klaus Wynants</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">AH-Vorstand</h5>
                                    <p class="card-text">Verantwortlich für die Altherren-Liga.</p>
                                    <div class="mt-auto">
                                        <span class="fa fa-fw fa-envelope-o"></span> <a href="mailto:kwynants@hobbyligawest.de" title="Mail an K. Wynants">kwynants</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-weight-bold">Jürgen Kaiser</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Spielplan</h5>
                                    <p class="card-text">Verantwortlich für den Spielplan von HLW und AH-Liga.</p>
                                    <div class="mt-auto">
                                        <span class="fa fa-fw fa-envelope-o"></span> <a href="mailto:jkaiser@hobbyligawest.de" title="Mail an J. Kaiser">jkaiser</a>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 my-2 d-block d-md-none"><!-- wrap every 2 below md --></div>
                            <div class="w-100 my-2 d-none d-md-block d-lg-none"><!-- wrap every 3 at md --></div>
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title font-weight-bold">Kevin Kaiser</h4>
                                    <h5 class="card-subtitle mb-2 text-muted">Webmaster</h5>
                                    <p class="card-text"></p>
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
                <h5>Stand: 09.01.2019</h5>
                <ul class="list-unstyled">
                    <li>
                        <span class="h4 font-weight-bold">0. Allgemeines</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Der Spaß steht im Vordergrund unserer Liga. Die Mannschaften spielen nicht gegen-, sondern miteinander. Die Teams sind fair zueinander, und zu den Schiedsrichtern, sowohl vor, als auch während und nach dem Spiel.
                                Die Satzung wurde von allen Teams gemeinsam mit dem Vorstand entworfen.
                            </li>
                            <li>
                                Der Vorstand ist die Vertretung der Hobbyliga-West und zuständig für Finanzen, Verwaltung, Öffentlichkeitsarbeit und Ligaentwicklung. Der Vorstand behält sich vor, Spieler, die in grober Weise die Gesundheit anderer Spieler gefährden oder sich in ebenso grobem Maße unsportlich verhalten, zu sperren oder gar vom Spielbetrieb der Hobbyliga-West zu suspendieren. Dies gilt auch für Teams, die sich in grober Art und Weise der Satzung der Hobbyliga-West widersetzen. Um jegliches Konfliktpotenzial zu vermeiden, wird kein Vorstandsmitglied in irgendeiner Weise in eine Entscheidung eingreifen, die seine eigene Mannschaft betrifft.
                            </li>
                            <li>
                                In der Hobbyliga-West können <b>Hobby-, Freizeit-, und Betriebsportmannschaften</b> teilnehmen. Ab der Saison 2013 dürfen die teilnehmenden Mannschaften jedoch nur noch <b>vereinslose</b> Spieler anmelden (bereits gemeldete Spieler genießen Bestandsschutz).
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">1. Startgeld</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Das Startgeld beträgt pro Mannschaft <b>80,- €</b> und ist am Tag der Jahreshauptversammlung beim Kassierer zu bezahlen.
                            </li>
                            <li>
                                Bei Ausschluss oder Austritt verbleibt das Startgeld bei der Hobbyliga-West und wird der Mannschaft nicht zurückerstattet.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">2. Meldungen</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Jede Mannschaft stellt der Ligaleitung eine Mannschaftsliste zur Verfügung aus der Zu-, Vorname, Geburtsdatum und Vereinszugehörigkeit eines jeden Spielers hervorgehen. Nur die Spieler, zu denen alle Daten vorliegen, sind spielberechtigt. Diese Mannschaftsliste muss der Ligaleitung <u>spätestens 1 Woche</u> vor dem 1. Spieltag vorliegen!
                            </li>
                            <li>
                                <b>Zusatz - gültig ab 11.08.2013:</b>
                                <br>
                                Alle Spieler, die nach dem 11.08.2013 angemeldet werden, müssen sich beim jeweiligen Spielverantwortlichen mit einem gültigen Identitätsnachweis (Personalausweis, Reisepass, etc.) ausweisen. Der Spielverantwortliche ist somit für die Richtigkeit aller Angaben verantwortlich und hat die Daten des Identitätsnachweises mit dem Spielerpass abzugleichen. Der neuangemeldete Spieler ist spielberichtigt, sobald der Mannschaft der entsprechende Spielerpass vorliegt.
                            </li>
                            <li>
                                <b>Neuregelung ab der Saison 2013:</b>
                                <br>
                                <ul>
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
                                        <b><u>Neu</u>angemeldete Spieler dürfen nicht in einem Verein spielen.</b>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                Falls eine Mannschaft einen nicht spielberechtigten Spieler einsetzt, wird das Spiel für diese Mannschaft als verloren (0 Punkte / 0:2 Tore) gewertet. Beim ersten Verstoß werden zusätzlich 6 Punkte abgezogen. Beim zweiten Verstoß erfolgt der Ausschluss aus der Hobbyliga-West.
                            </li>
                            <li>
                                Vereinsspielern, die zum Altbestand zählen, ist es ab der Saison 2016 erlaubt, innerhalb der Hobbyliga den Verein zu wechseln.
                            </li>
                            <li>
                                <b>Zusatz - gültig ab 09.01.2019:</b>
                                <br>
                                Neuanmeldungen PER E-MAIL an vorstand@hobbyligawest.de senden.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">3. Pässe und Spielberichtsbögen</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Es wird jeder Mannschaft ein Satz Spielerpässe von der Ligaleitung ausgestellt. Die Schiedsrichter sind verpflichtet, vor jedem Spiel die Spielberechtigung der anwesenden Spieler anhand der <u>Spielerpässe</u> zu prüfen, die von den jeweiligen Mannschaften <u>zwingend mitzuführen</u> sind.
                            </li>
                            <li>
                                Von der Ligaleitung ausgehändigte Pässe dürfen in keiner Weise nachträglich ohne die Zustimmung der Ligaleitung verändert werden. Das heißt, dass weder ein Passfoto geändert werden darf, noch dürfen handschriftliche oder sonstige nachträgliche Änderungen eigenhändig vorgenommen werden. Derartige Pässe sind ungültig, dürfen auch vom Schiedsrichter nicht akzeptiert werden und müssen bei der Ligaleitung neu beantragt werden.
                            </li>
                            <li>
                                Ab der Saison 2013 werden von der Ligaleitung Spielberichtsbögen an die Mannschaften ausgegeben, die ordnungsgemäß von beiden Teams ausgefüllt, vor jedem Spiel dem Schiedsrichter zu übergeben sind. Der Schiedsrichter wird diesen nach dem Spiel um die fehlenden Details ergänzen (Spielergebnis, Karten, bes. Vorkommnisse, etc.). Die Heimmannschaft wird den ausgefüllten, und von allen Parteien (Käpten Heim / Käpten Gast / Schiedsrichter) unterschriebenen Spielbericht, abfotografieren und per Mail am selben Tag an den Vorstand senden. Sollte der Spielbericht nicht an den Vorstand gesendet werden, wird das Spiel mit 2:0 für die Gastmannschaft gewertet.
                                <br>
                                Vorstands-EmaiL: vorstand [AT] hobbyligawest [DOT] DE
                            </li>
                            <li>
                                <b>Zusatz - gültig ab 09.01.2019:</b>
                                <br>
                                Spielerpässe sind jetzt auch digital erlaubt (auch zur Passkontrolle beim Spiel), müssen aber den Stempel der aktuellen Saison enthalten.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">4. Spielbetrieb</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Der Spielplan wird von der Ligaleitung erstellt und ist für alle teilnehmenden Mannschaften verbindlich.
                                <br>
                                Gespielt wird in den angegebenen Wochen. Die Mannschaften erhalten den Spielplan im Dezember und senden diesen – ergänzt um die Termine und Anstoßzeiten ihrer Heimspiele – bis zu dem von der Ligaleitung angegebenen Termin an diese zurück.
                            </li>
                            <li>
                                Eine Spielansetzung kann in der Woche frühestens um 19:00 Uhr und spätestens um 21:00 Uhr erfolgen. Samstags zwischen 11:00 Uhr und 17:00 Uhr.
                            </li>
                            <li>
                                <del>Eine Spielverlegung muss bis <b>spätestens 24 h vor dem Spiel</b>, durch die verlegende Mannschaft, an die Ligaleitung, den Gegner und den Schiedsrichterobmann gemeldet werden.</del>
                            </li>
                            <li>
                                Bei Unbespielbarkeit des Platzes erfolgt ein Nachholspiel. Sollte eine Unbespielbarkeit absehbar sein, so sind der Gegner, der Schiedsrichterobmann und die Ligaleitung frühzeitig zu informieren.
                            </li>
                            <li>
                                Grundsätzlich wird nach den aktuellen Regeln des DFB gespielt.
                            </li>
                            <li>
                                Es dürfen während eines Spiels 6 Auswechslungen vorgenommen werden. Bereits ausgewechselte Spieler dürfen wieder eingewechselt werden, solange die Auswechselgrenze von 6 Wechseln nicht erreicht ist. (Achtung: Vereinsspieler!).
                            </li>
                            <li>
                                Die Wartezeit für den Anpfiff bei Verspätung einer Mannschaft beträgt 20 Minuten.
                            </li>
                            <li>
                                Tritt eine Mannschaft nicht an, wird das ausgefallene Spiel mit 3 Punkten und 2:0 Toren für den Gegner gewertet.
                            </li>
                            <li>
                                Die Kosten für den Schiedsrichter trägt immer die nicht angetretene Mannschaft. Tritt die Auswärtsmannschaft ohne rechtzeitige Abmeldung nicht an, so hat sie der Heimmannschaft die Kosten für den Platz zu ersetzen, wenn dieser nicht anderweitig genutzt werden kann (durch andere Mannschaft oder Trainingsspiel).
                            </li>
                            <li>
                                Die Kosten für den Schiedsrichter müssen <b><u>vor</u></b> dem Spiel gezahlt werden. Bei Nicht-Einhaltung kann der Schiedsrichter den Platz wieder verlassen und bekommt die Kosten von der HLW ersetzt. Die Mannschaft, die den Schiedsrichter nicht bezahlt hat, muss das Geld an die HLW bezahlen. Bei Wiederholung, wird die Mannschaft aus der HLW ausgeschlossen.
                            </li>
                            <li>
                                Sind am Saisonende zwei oder mehr Mannschaften punktgleich, so entscheidet die Tordifferenz über die Vergabe des Meistertitels bzw. die Platzierung.
                            </li>
                            <li>
                                Die Heimmannschaft hat immer folgende Voraussetzungen zu erfüllen:
                                <ul>
                                    <li>
                                        Der Platz muss mindestens 2 Stunden zur Verfügung stehen (Pokalspiel: 3 Stunden).
                                    </li>
                                    <li>
                                        Erscheint der Schiedsrichter nicht, stellt die Heimmannschaft eine geeignete Person zur Leitung des Spiels.
                                        <br>
                                        Ist dies nicht möglich, versucht der Gast eine geeignete Person zu stellen. Kommt es zu keiner Einigung, so findet ein Nachholspiel statt und die anfallenden Kosten (Platz/Schiedsrichter) werden von beiden Mannschaften zur Hälfte getragen.
                                    </li>
                                    <li>
                                        Bei Trikotgleichheit sorgt die Heimmannschaft für eine Möglichkeit zur Unterscheidung (2.Trikotsatz oder Leibchen etc.).
                                    </li>
                                    <li>
                                        Mannschaften dürfen nicht mit doppelten (bzw. mehrfach gleichen) Rückennummern gleichzeitig spielen.
                                    </li>
                                </ul>
                            </li>
                            <li>
                                Ein Spieler darf keine Kleidungsstücke oder Ausrüstungsgegenstände tragen, die ihn oder einen anderen Spieler gefährden könnten (einschließlich jeder Art von Schmuck). Im Gegensatz zu den geltenden DFB-Regeln, ist das Abkleben von Schmuck erlaubt.
                            </li>
                            <li>
                                Ein abgebrochenes Spiel wird normal gewertet, wenn 75 % der regulären Spielzeit abgelaufen sind.
                            </li>
                            <li>
                                An dieser Stelle soll noch einmal darauf hingewiesen werden, dass das Tragen von Schienbeinschützern zwingend vorgeschrieben ist.
                            </li>
                            <li>
                                <b>In 2019 aufgrund des aktuellen Modus nicht gültig</b>
                                <br>
                                <del><b>Auf- und Abstieg:</b> Der Vorstand wird im Laufe der Saison (frühzeitig) über den Auf- und Abstieg (erneut) entscheiden, nachdem abzusehen ist, wie viele Mannschaften in der kommenden Saison an den Start gehen.</del>
                            </li>
                            <li>
                                Scheidet eine Mannschaft aus dem laufenden Wettbewerb aus, werden alle Spiele dieser Mannschaft annulliert.
                            </li>
                            <li>
                                <b>In 2019 aufgrund des aktuellen Modus  nicht gültig</b>
                                <br>
                                <del>Der Aufstieg von der 2. in die 1. Liga kann nicht abgelehnt werden.</del>
                            </li>
                            <li>
                                <b>Zusatz - gültig ab 09.01.2019:</b>
                                <br>
                                <strong style="color: red">Nachholspiele sind nicht mehr erlaubt!</strong> Ausnahme bleiben Ausfälle wegen „höherer Gewalt“ (unbespielbar, Platz doppelt belegt etc.). Die Möglichkeit zur Verlegung vor Saisonstart
                                (= 1. Spielwoche) und in den Sommerferien (vor der „Rückrunde“) bleibt wie gehabt.
                                Zwischen dem Ende der „Hauptrunde“ und dem Start der Meisterschaft-Playoffs wird eine Pufferwoche für o.g. Ausnahmen eingebaut.

                            </li>
                        </ol>

                    </li>
                    <li>
                        <span class="h4 font-weight-bold">5. Übermittlung der Spielergebnisse</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Die Spielergebnisse und besonderen Vorkommnisse werden vom Schiedsrichter im Spielberichtsbogen notiert, von der Heimmannschaft abfotografiert und per Mail an den Vorstand übermittelt.
                            </li>
                            <li>
                                Spielerpässe sind jetzt auch digital erlaubt (auch zur Passkontrolle beim Spiel), müssen aber den Stempel der aktuellen Saison enthalten.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">6. Strafen</span>
                        <ol class="py-2 text-justify">
                            <li>
                                <b>Alle Karten gelten wettbewerbsübergreifend, d.h. für Pokal- und Meisterschaftsspiele!</b>
                            </li>
                            <li>
                                Sperren aufgrund Platzverweis im Pokal für Spieler, die in der HLW <strong>und</strong> AH spielen, gelten „übergreifend“, d.h. sowohl in der HLW als auch in der AH-Liga. Für x Spiele und begrenzt auf x Wochen.
                            </li>
                            <li>
                                Zeitstrafe = 10 Minuten
                            </li>
                            <li>
                                Gelb-Rote Karte = Matchstrafe + 1 Spiel Sperre
                            </li>
                            <li>
                                Rote Karte mit 2 Spielen Sperre, bspw. bei:
                                <ul>
                                    <li>
                                        absichtlichem Handspiel
                                    </li>
                                    <li>
                                        Notbremse
                                    </li>
                                    <li>
                                        Grobem oder wiederholtem Foulspiel
                                    </li>
                                </ul>
                            </li>
                            <li>
                                Rote mit 5 Spielen Sperre bei Schiedsrichterbeleidigung
                            </li>
                            <li>
                                Je nach Schwere des Verstoßes behält sich der Vorstand eine Straferhöhung vor.
                            </li>
                            <li>
                                Im Wiederholungsfall wird ein Spieler immer um ein Spiel mehr als vorher gesperrt.
                            </li>
                            <li>
                                Bei Prügeleien oder <b>rassistischen</b>, <b>antisemitischen</b> und sonstigen <b>fremdenfeindlichen</b> oder <b>diffamierenden</b> Äußerungen werden Spieler aus der HWL ausgeschlossen.
                            </li>
                            <li>
                                Diese Strafen gelten auch, wenn sie nicht auf der HP vermerkt sind.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">7. Schiedsrichter</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Die Schiedsrichter werden vom Schiedsrichterobmann angesetzt und können nicht abgelehnt werden.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">8. Kosten</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Die Heimmannschaft trägt die Kosten für den Platz und zahlt dem Schiedsrichter <b>30,- €</b> pro Spiel.
                            </li>
                            <li>
                                Porto, Telefon und sonstige Kosten, die in Verbindung mit dem Spielbetrieb stehen gehen zu Lasten der teilnehmenden Mannschaften.
                            </li>
                            <li>
                                Jede Mannschaft hinterlegt am Tag der Jahreshauptversammlung eine Kaution in Höhe von <b>60,- €</b> als Schiedsrichterkaution. Hieraus wird der Kassierer notwendige Schiedsrichterkosten für eventuelle Spielausfälle bezahlen. Diese Kaution ist im Laufe des Jahres bitte immer bei mindestens 30,- € pro Mannschaft zu halten.
                            </li>
                            <li>
                                Die Kosten (Platz und 3 Schiedsrichter) für das Pokalendspiel werden von der Liga übernommen.
                            </li>
                            <li>
                                Die Kosten (Platz und 3 Schiedsrichter) für ein notwendiges Entscheidungsspiel zur Meisterschaft und für das Relegationsspiel werden ebenfalls von der Liga übernommen.
                            </li>
                            <li>
                                Die Kosten für Pokalspiele (Platz & Schiedsrichter) werden von den beiden Mannschaften geteilt.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">9. Nachholspiele</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Ein Nachholspieltermin ist von der Heimmannschaft innerhalb von einer Woche mit dem Gegner abzustimmen und innerhalb dieser Frist an den Schiedsrichterobmann und die Ligaleitung zu melden. Sollten sich beide Mannschaften nicht auf einen Termin einigen, so wird die Ligaleitung einen Termin vorschreiben, an dem gespielt werden muss (ansonsten 10.3).
                            </li>
                            <li>
                                Nachholspiele können jederzeit gespielt werden. Die dafür reservierten Wochen sind mögliche Spieltage, aber nicht zwingend.
                                <br>
                                Nachholspiele aus der Hinrunde sind bis zum Ende der Sommerferien nachzuholen!
                                <br>
                                Auch können die Ferien für die Nachholspiele genutzt werden.
                            </li>
                            <li>
                                Ab der Saison 2016 dürfen in der gesamten Saison pro Mannschaft maximal <b>2</b> Spiele verlegt werden.
                                <br>
                                Spielausfälle aufgrund höherer Gewalt (Platz nicht bespielbar, gesperrt, etc.) zählen nicht zu dieser Regelung.
                            </li>
                            <li>
                                Bis zum Beginn der ersten Spielwoche und während der Sommerpause (bis zum Beginn der ersten Rückrundenspielwoche) dürfen Spiele unbegrenzt verlegt werden. Diese Spielverlegungen zählen nicht zu 10.3.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">10. Pokalwettbewerb</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Es gelten beim Pokal, sowie beim Endspiel, dieselben Melderegeln für spielberechtigte Spieler, wie im Ligaspielbetrieb.
                            </li>
                            <li>
                                Die Pokalspiele werden ohne Verlängerung gespielt. Es gibt bei unentschiedenem Spielausgang sofort ein Elfmeterschießen.
                            </li>
                            <li>
                                Pokalwochen müssen eingehalten werden, ansonsten ist die absagende Mannschaft ausgeschieden.
                            </li>
                        </ol>
                    </li>
                    <li>
                        <span class="h4 font-weight-bold">11. Haftung</span>
                        <ol class="py-2 text-justify">
                            <li>
                                Die Hobbyliga-West Düsseldorf ist eine Eigeninitiative von mehreren Freizeit- und  Hobbyfußballmannschaften. Sie ist nicht Veranstalter der Spiele sondern verwaltet lediglich die Ergebnisse der Spielrunde. Sie ist weder für Körper- noch für Sachschäden haftbar zu machen.
                            </li>
                        </ol>
                    </li>
                </ul>
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