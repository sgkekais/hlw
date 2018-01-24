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
        {{-- referees TODO: nur fuer super_admin, admin, club_contact --}}
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
                <h5>Stand: 11.01.2018</h5>
                <ol class="text-justify">
                    <li><span class="h4 font-weight-bold">Allgemeines</span>
                        <ol>
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
                    <li><span class="h4 font-weight-bold">Startgeld</span>
                        <ol>
                            <li>
                                Das Startgeld beträgt pro Mannschaft <b>80,- €</b> und ist am Tag der Jahreshauptversammlung beim Kassierer zu bezahlen.
                            </li>
                            <li>
                                Bei Ausschluss oder Austritt verbleibt das Startgeld bei der Hobbyliga-West und wird der Mannschaft nicht zurückerstattet.
                            </li>
                        </ol>
                    </li>
                    <li><span class="h4 font-weight-bold">Meldungen</span>
                        <ol>
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
                        </ol>
                    </li>
                    <li><span class="h4 font-weight-bold">Pässe und Spielberichtsbögen</span>
                        <ol>
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
                        </ol>
                    </li>
                    <li><span class="h4 font-weight-bold">Spielbetrieb</span>
                        <ol>
                            <li>
                                Der Spielplan wird von der Ligaleitung erstellt und ist für alle teilnehmenden Mannschaften verbindlich.
                                <br>
                                Gespielt wird in den angegebenen Wochen. Die Mannschaften erhalten den Spielplan im Dezember und senden diesen – ergänzt um die Termine und Anstoßzeiten ihrer Heimspiele – bis zu dem von der Ligaleitung angegebenen Termin an diese zurück.
                            </li>
                            <li>
                                Eine Spielansetzung kann in der Woche frühestens um 19:00 Uhr und spätestens um 21:00 Uhr erfolgen. Samstags zwischen 11:00 Uhr und 17:00 Uhr.
                            </li>
                            <li>
                                Eine Spielverlegung muss bis <b>spätestens 24 h vor dem Spiel</b>, durch die verlegende Mannschaft, an die Ligaleitung, den Gegner und den Schiedsrichterobmann gemeldet werden.
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
                                <b>Auf- und Abstieg:</b> Der Vorstand wird im Laufe der Saison (frühzeitig) über den Auf- und Abstieg (erneut) entscheiden, nachdem abzusehen ist, wie viele Mannschaften in der kommenden Saison an den Start gehen.
                            </li>
                            <li>
                                Scheidet eine Mannschaft aus dem laufenden Wettbewerb aus, werden alle Spiele dieser Mannschaft annulliert.
                            </li>
                            <li>
                                Der Aufstieg von der 2. in die 1. Liga kann nicht abgelehnt werden.
                            </li>
                        </ol>
                    </li>
                    <li><span class="h4 font-weight-bold">Übermittlung der Spielergebnisse</span>
                        <ol>
                            <li>
                                Die Spielergebnisse und besonderen Vorkommnisse werden vom Schiedsrichter im Spielberichtsbogen notiert, von der Heimmannschaft abfotografiert und per Mail an den Vorstand übermittelt.
                            </li>
                        </ol>
                    </li>
                    <li><span class="h4 font-weight-bold">Strafen</span>
                        <ol>
                            <li>
                                <b>Alle Karten gelten wettbewerbsübergreifend, d.h. für Pokal- und Meisterschaftsspiele!</b>
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
                    <li><span class="h4 font-weight-bold">Schiedsrichter</span>
                        <ol>
                            <li>
                                Die Schiedsrichter werden vom Schiedsrichterobmann angesetzt und können nicht abgelehnt werden.
                            </li>
                        </ol>
                    </li>
                    <li><span class="h4 font-weight-bold">Kosten</span>
                        <ol>
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
                    <li><span class="h4 font-weight-bold">Nachholspiele</span>
                        <ol>
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
                    <li><span class="h4 font-weight-bold">Pokalwettbewerb</span>
                        <ol>
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
                    <li><span class="h4 font-weight-bold">Haftung</span>
                        <ol>
                            <li>
                                Die Hobbyliga-West Düsseldorf ist eine Eigeninitiative von mehreren Freizeit- und  Hobbyfußballmannschaften. Sie ist nicht Veranstalter der Spiele sondern verwaltet lediglich die Ergebnisse der Spielrunde. Sie ist weder für Körper- noch für Sachschäden haftbar zu machen.
                            </li>
                        </ol>
                    </li>
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