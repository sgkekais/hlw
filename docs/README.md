# HLW-Admin Dokumentation

> Dokumentation ist noch unvollständig und wir von mir nach und nach gepflegt.

> Stand: 05.02.2018

# Einführung
Die Hobbyliga-West Seite lässt sich in zwei Bereiche unterteilen:
1. Das sogenannte "**Front-End**", das alle Besucher der Seite zu Gesicht bekommen, wenn sie https://hobbyligawest.de aufrufen.
2. Das sogenannte "**Back-End**". Das ist die Administrationsoberfläche, "HLW-Admin", auf die sich diese Doku bezieht. Auf diesen Bereich haben nur Mitglieder mit der Rolle __admin__ Zugriff.

> Es lässt sich so gut wie **alles** von mir anpassen. Falls ihr also einen Wunsch habt, dann äußert ihn und ich schaue mir an, ob und wie ich das realisieren kann.

***
# Navigation durch die App
Hauptsächlich bewegt ihr euch durch die Admin-App über zwei Dinge:
1. Die Navigationsleiste oben.
2. Die Aktionen, die euch zu einzelnen Einträgen angzeigt werden. Diese sind fast immer:
    1. Anzeigen (Lupensymbol): Details, wie bspw. Anlege- und Änderungsdatum und alle Zuordnungen, zum Eintrag betrachten. 
    2. Bearbeiten (Bleistiftsymbol): Daten des Eintrags selbst bearbeiten.    
    
## Dashboard
Im Dashboard werden euch drei Listen angezeigt:
1. Die Paarungen der nächsten 14 Tage, ausgehend vom Montag der aktuellen Woche.
2. Die Paarungen der nächsten 30 Tage ohne Schiedsrichterzuweisung, ausgehend vom aktuellen Tag.
3. Zurückliegene Paarungen, für die kein Ergebnis erfasst wurde. 

## Spielbetrieb
Der Spielbetrieb umfasst alle Objekte, die den Spielbetrieb der HLW ausmachen und die Anzeige des Front-End steuern. Das ist der Bereich, in dem ihr euch im Alltag am meisten bewegen werdet.

## User
Zeigt eine Liste aller User und deren Details an, die sich auf unserer Seite registriert haben. Darüber hinaus werden die von mir angelgten Rollen und die Rollen jedes Users angezeigt. 

Hier könnt ihr sehen, dass es vier Rollen gibt:
- Super Admin ("super_admin") - Das bin ich -> Zugriff auf HLW-Admin
- Admin ("admin") - Das seid ihr -> Zugriff auf HLW-Admin
- Mitglied ("member") - Allen Besuchern, die sich auf der Seite registrieren, wird standardmäßig diese Rolle zugewiesen.
- Ansprechpartner ("club_contact") - Zusätzliche Rolle für Ansprechpartner. Können momentan zusätzlich zum "Mitglied" die Schiri-Liste und die Telefonnummern der Ansprechpartner sehen.

## Log
Zeigt ein Protokoll mit Änderungen im HLW-Admin an. Jedes Mal, wenn ihr eine Änderung vornehmt, wird dies im Log mit eurem User protokolliert. Dazu wird angezeigt, welche Felder bei einer Änderung genau geändert wurden. Eine Änderung kann sein:
- Anlegen
- Bearbeiten
- Löschen

## Datenverwaltung
### Anlegen
Neue Einträge legt ihr in der Regel über einen Anlegen-Button, wie bspw. "Person anlegen", auf der Seite des jeweiligen Konzeptes an (bspw. "Person"). Wenn ihr den Button drückt, kommt ihr zu einem Formular, in welchem ihr die entsprechenden Daten eingibt.
> Ich bin leider noch nicht dazu gekommen, obligatorische Felder auch als solche "Muss"-Felder zu kennzeichnen. 

Nach Eingabe der Daten könnt ihr den Anlegen-Button drücken und der Datensatz wird in der entsprechenden Tabelle in der Datenbank abgelegt. Solltet ihr ein Muss-Feld vergessen haben oder es irgendeinen anderen Fehler geben, wird euch eine Fehlermeldung mit Hinweisen angezeigt.  

> Momentan sind die Feldnamen noch auf Englisch, da ich die App auf Englisch schreibe und zu faul bin, für jedes Feld Übersetzungen zu pflegen. Das heißt, dass euch im Log und bei Fehlermeldungen immer die betroffenen Felder auf Englisch angezeigt werden, weil das die jeweilige Bezeichnung der Datenbankspalte ist. Sollte in der Regel aber nicht schwer sein, zu verstehen, welches Feld gemeint ist. 

> Unter Konzepte könnt ihr die Feldnamen nachschlagen.

### Bearbeiten
Fast überall wird euch zu einem Eintrag ein blauer Bearbeiten-Button (Bleistiftsymbol) angezeigt. Damit könnt ihr die Felder eines Datensatzes bearbeiten.

> Hier gilt derselbe Hinweis mit den englischen Feldern.

### Löschen
Über den Bearbeiten-Button könnt ihr viele Datensätze auch löschen.

**Hier ist Vorsicht geboten!** 

Wenn ihr einen Datensatz löscht, werden in der Regel auch **ALLE** Beziehungen gelöscht. Für eine Person heißt das bspw., dass auch Tore, Karten, und Zuordnungen als Spieler, Ansprechpartner und Schiedsrichter gelöscht werden.

**Bitte bei Daten, die ihr nicht selbst angelegt habt, vor dem Löschen daher unbedingt prüfen, ob das Löschen sicher ist!** (oder mich fragen...) 

***
# How-To's
Kurze Anleitungen für die gängisten Vorgänge.

## Ergebnisverwaltung
Am besten vom Dashboard aus auf den Bearbeiten-Button der Paarung klicken und das Ergebnis eintragen. Anschließend könnten über den Anzeigen-Button Torschützen gepflegt werden.

## Spielverlegung
Sollte ein Spiel verlegt werden, dann:
1. Gelben "Verlegen"-Button neben der Paarung drücken
2. Es erscheinen zusätzliche Felder oben, die Details zur Verlegung enthalten (siehe Konzept [Paarung](#Paarung))
3. Im unteren Bereich werden die Details der neuen Paarung eingegeben
4. Dadurch bleibt eine nachverfolgbare Historie erhalten

## Wertung & Annullierung
1. Auf Bearbeiten-Button der Paarung klicken
2. Wertung eingeben ("Egebnis" und Grund) oder Annullierung Ja auswählen
3. Ursprünglich Daten so lassen. Damit können auch gespielte Spiele nachträglich gewertet / annulliert werden und die Daten bleiben erhalten. Torschützen gehen nicht mehr in die Wertung mit ein.

## Kaderpflege
1. Person muss vorhanden sein. Es können nur **aktive** Personen einer Mannschaft zugeordnet werden.
2. In den Mannschaftsdetails auf "+ Spieler" klicken, um eine Person zuzuordnen. Details ausfüllen, soweit bekannt.

## Vereinsspieler kennzeichnen
1. Person bearbeiten und unter "Vereinsspieler" den Verein (Mannschaft mit Kennzeichen "echter Verein") auswählen
2. Klasse auswählen
3. Wenn Klasse nicht bekannt, dann unter "offizielle Spielklassen" anlegen

## Karten
1. Über den Anzeigen-Button eine Paarung aufrufen und anschließend auf "Karte eintragen" klicken.
2. Es können nur Karten für Spieler gepflegt werden, die den teilnehmenden Mannschaften zugeordnet wurden. 

## Torschützen
Siehe Karten. Haken bei **"Ignorieren"** machen, für Einträge, die nicht gespeichert werden sollen.

## Wie komme ich zur Übersicht einer Spielwoche?
1. Saisons über das Menü auswählen
2. Saison anzeigen, zu der die Spielwoche gehört 
3. In der Liste der Spielwochen auf den Anzeige-Button der gewünschten Spielwoche klicken

***
# Konzepte
Hier werden die verwendeten Konzepte und die zugehörigen Felder erklärt. Die Navigation durch die App spiegelt genau diese Konzepte wieder.

> Schaut euch am besten immer irgendeinen bestehenden Datensatz vorher an, wenn ihr euch bei der Anlage oder Bearbeitung nicht sicher seid.

## Wettbewerb
Der Wettbewerb stellt die oberste Ebene der "Hierarchie" dar. Fast alle nachfolgenden Konzepte sind einem Wettbewerb zugeordnet. 
Ein Wettbewerb hat folgende Felder:

### Beziehungen
- Ein Wettbewerb hat beliebig viele Spielklassen.
- Jede Spielklasse ist genau einem Wettbewerb zugeordnet.

### Felder
Bezeichnung | Muss-Feld? | Werte
--- | --- | --- |
(name) Name | Ja | Zeichenkette        
(name_short) Name - kurz |  Nein | Zeichenkette
(type) Art des Wettbewerbs | Ja | Liga / "Turnier / Pokal"
(published) Veröffentlichen | Ja | Ja / Nein  

## Spielklasse
Die Spielklasse folgt nach dem Wettbewerb. Spielklassen fassen Saison, Spielwochen und Begegnungen organisatorisch zusammen.

### Beziehungen
- Eine Spielklasse ist genau einem Wettbewerb zugeordnet.
- Einer Spielklasse sind beliebig viele Saisons zugeordnet.

### Felder
Bezeichnung | Muss-Feld? | Werte
--- | --- | --- |
(name) Name | Ja | Zeichenkette (bspw. "1. Liga")
(hierarchy_level) Hierarchieebene | Ja | positive Zahl (bspw. "1" für 1. Liga)
(competition_id) Wettbewerb | Ja | ein Wettbewerb
(published) Veröffentlichen | Ja | Ja / Nein

## "Offizielle" Spielklassen
Spielklassen, die Vereinsspielern zugeordnet werden.

### Beziehungen
- Einer offizielle Spielklasse sind beliebig viele Personen zugeordnet
- Einer Person kann genau eine offizielle Spielklasse zugeordnet werden 

### Felder
Bezeichnung | Muss-Feld? | Bedeutung | Werte
--- | --- | --- |
(name) Name | Ja | Bezeichnung, bspw. "Kreisliga A" | Zeichenkette
(name_short) Name kurz | Nein | Abkürzung, bspw. "Kl. A" | Zeichenkette 

## Saison
Eine Saison fasst u.a. Spielwochen und Begegnungen organisatorisch zusammen.
 
### Beziehungen
- Eine Saison ist genau einer Spielklasse zugeordnet. 
- Einer Saison sind beliebig viele Spielwochen zugeordnet.
- Einer Saison sind beliebig viele Mannschaften zugeordnet. 
- Eine Saison hat genau einen Titelträger.

### Felder
Bezeichnung | Muss-Feld? | Bedeutung | Werte
--- | --- | --- |
(division_id) Spielklasse | Ja | Die Spieklasse der Saison | Auswählen
(begin) Zeitraum von | Ja | Anfangsdatum der Saison | Datum
(end) - bis | Ja | Enddatum der Saison | Datum 
(season_nr) Saison Nr. | Nein | Fortlaufende Nummerierung der Saisons einer Spielklasse. Wenn leer, dann wird automatisch die nächsthöhere Nummer genommen. | positive Zahl 
(champion_id) Sieger | Nein | Titelträger | **Zugeordnete** Mannschaft auswählen
(ranks_champion) Meisterplätze | Nein | Titelrang. Wird in der Tabelle farbig hervorgehoben. | Platzierungen mit Kommata getrennt
(ranks_promotion) Aufstiegsplätze | Nein | " | "
(ranks_relegation) Abstiegsplätze | Nein | " | "
(playoff_champion) Meisterschafts-Playoff | Nein | " | "
(playoff_cup) Pokal-Playoff | Nein | " | "
(playoff_relegation) Relegation | Nein | " | "
(max_rescheduling) Max. Spielverlegungen | Nein | Maximal erlaubte Anzahl Spielverlegungen | positive Zahl
(rules) Regeln | Nein | Regeln, die unter der Tabelle angezeigt werden sollen. | Text
(note) Notiz | Nein | Notiz für interne Zwecke | Text
(published) Veröffentlichen | Ja | Im Front-End veröffentlichen | Ja / Nein

### Zuordnung zwischen Saison und Mannschaft(en)
Über die Details einer Saison (Anzeigen-Button) können mit dem "+ Mannschaft"-Button" Mannschaften einer Saison zugeordnet werden. Dadurch "spielen" diese in dieser Saison. Über diesen Button lassen sich auch Strafen für eine Mannschaft für diese Saison pflegen.

Die zugeordneten Mannschaften werden auf dem Reiter "Mannschaften" angezeigt. Hier wird auch die Summe der Spielverlegungen angezeigt.

#### Felder 
Bei der Zuordnung einer Mannschaft können bestimmte Felder ausgefüllt werden.

Bezeichnung | Muss-Feld? | Bedeutung | Werte
--- | --- | --- | ---
(club_id) Mannschaft | Ja | | Mannschaft auswählen
(rank) Endplatzierung | Nein | Platzierung am Ende der Saison. I.d.R. auch erst am Ende zu pflegen. | positive Zahl
(deduction_points) Punktabzug | Nein | Evtl. Punktabzug. Wird in der Berechnung der Tabelle berücksichtigt und unten angezeigt. | positive Zahl
(deduction_goals) Torabzug | Nein | Evtl. Torabzug. | positive Zahl
(withdrawal) Ausgeschieden | Nein | Datum des Rücktritts. Dadurch werden alle Spiele annulliert. Die Daten bleiben aber erhalten. Sollte die Mannschaft komplett aus der HLW ausscheiden (nicht nur aus der Saison) dann ebenfalls Austrittsdatum in den Mannschaftsdetails pflegen. | Datum JJJJ-MM-TT
(note) Notiz | Nein | Interne Notiz | Text

## Spielwoche
Eine Spielwoche steht für einen Spieltag. Spielwochen folgen in der Regel einer durchgehenden Nummerierung (1. Spieltag, 2. Spieltag, etc.). Die Relegation gilt als eigener Spieltag. Spielwochen können in der Saisonübersicht angelegt werden.

### Beziehungen
- Eine Spielwoche ist genau einer Saison zugeordnet.
- Einer Spielwoche können beliebig viele Paarungen zugeordnet sein.

### Felder
Bezeichnung | Muss-Feld? | Bedeutung | Werte
--- | --- | --- | ---
(season_id) Saison | Ja | Zuordnung zur Saison | Saison auswählen
(number_consecutive) Nummer | Nein | Nummer der Spielwoche für Sortierung. Auch einer Relegation wird bspw. eine Nummer zugewiesen. | Positive Nummer
(name) Name | Nein | Optionale Bezeichnung für eine Spielwoche, bspw. im Fall der "Relegation". | Zeichenkette
(begin) Beginn | Nein | Anfangsdatum | JJJJ-MM-TT
(end) Ende | Nein | Enddatum. Bei Einzelterminen (Relegation, Finale, etc.) **leer** lassen. | JJJJ-MM-TT
(published) Veröffentlichen | Ja | | Ja / Nein

## Paarung
Eine Paarung ist eine Begegnung zwischen zwei Mannschaften. 

### Beziehungen
- Eine Paarung ist genau einer Spielwoche zugeordnet
- Einer Paarung ist genau ein Heimteam und genau ein Gastteam zugeordnet
- Einer Paarung ist genau ein Spielort zugeordnet
- Eine Paarung kann eine Beziehung zu einem verlegten Spiel haben
- Einer Paarung sind beliebig viele Schiedsrichter zugeordnet
- Einer Paarung sind beliebig viele Torschützen zugeordnet
- Einer Paarung sind beliebig viele Karten zugeordnet

### Felder
Bezeichnung | Muss-Feld? | Bedeutung | Werte
--- | --- | --- | ---
(matchweek_id) Spielwoche | Ja | Zuordnung zur Spielwoche | Auswählen
(datetime) Datum und Uhrzeit | Nein | Kann leer bleiben durch Haken setzen | JJJJ-MM-TT hh:mm:ss 
(stadium_id) Spielort | Nein | Zuordnung zum Spielort | Auswählen
(club_id_home) Heim | Nein | Heimmannschaft, muss der Saison zugeordnet sein | Auswählen
(club_id_away) Gast | Nein | Gastmannschaft, muss der Saison zugeordnet sein | Auswählen
(goals_home) Tore - Heim | Nein | Heimtore | positive Zahl
(goals_away) Tore - Gast | Nein | Gasttore | positive Zahl
(goals_home_11m) Tore - 11m - Heim | Nein | 11m - Heim, (**im**)  | positive Zahl
(goals_away_11m) Tore - 11m - Gast | Nein | 11m - Gast, (**im**) | positive Zahl
(goals_home_rated) Wertung - Heim | Nein | | positive Zahl
(goals_away_rated) Wertung - Gast | Nein | | positive Zahl
(rated_note) Begründung | Nein | Grund für Wertung (optional), erscheint im Front-End | Text 
(note) Notiz | Nein | | Text
(cancelled) Annullierung | Ja | | Ja / Nein (Standard)
(published) Veröffentlicehn | Ja | Es können Paarungen angelegt werden, die im Front-End noch nicht angezeigt werden sollen. | Ja / Nein (Standard)
(counts_in_tables) Berücksichtigung in Tabelle | Ja | Ja auswählen bspw. bei Relegation oder Pokalspiel | Ja (Standard) / Nein

### Spielverlegung
Sollte Spiel verlegt werden, erscheinen zusätzliche Felder, die Details zur Verlegung erfassen.

Bezeichnung | Muss-Feld? | Bedeutung | Werte
--- | --- | --- | ---
(rescheduled_from_fixture_id) Verlegt von Paarung | Nein | Ursprüngliche Paarung | 
(rescheduled_by_club) Verlegt von Mannschaft | Nein | Mannschaft, die das Spiel verlegt hat. Leer lassen bspw. bei höherer Gewalt. | Auswählen
(reschedule_reason) Grund für Verlegung | Nein | Wird im Front-End in Spieldetails angezeigt | Text
(reschedule_count) Verlegung zählen | Nein | Zählt die Verlegung zu den max. Verlegungen? | Ja (Standard) / Nein

### Schiedsrichterzuordnung
Einer Paarung können beliebig viele Schiedsrichter zugeordnet werden. 

#### Felder
Bezeichnung | Muss-Feld? | Bedeutung | Werte
--- | --- | --- | ---
(referee_id) Schiedsrichter | Ja | Schiedsrichter, der vorher angelegt wurde | Auswählen
(confirmed) Bestätigt | Ja | Hinweis, ob Schiedsrichter die Zuordnung bestätigt hat | Nein (Standard / Ja
(note) Notiz | Nein | | Text

## Karte

### Beziehungen

### Felder

## Torschütze

### Beziehungen

### Felder

## Spielort

### Beziehungen
- Ein Spielort kann beliebig vielen Paarungen zugeordnet werden. Dazu den Spielort in den Details (Bearbeiten-Button) einer Paarung auswählen.
- Ein Spielort kann beliebig vielen Mannschaften zugeordnet werden. Dazu den Spielort in den Details einer Mannschaft (Anzeigen-Button) über den "+ Spielort"-Button hinzufügen. 

### Felder
Bezeichnung | Muss-Feld? | Bedeutung | Werte
--- | --- | --- | ---
(name) Name | Nein | | Zeichenkette
(name_short) Kurzname | Nein | | Zeichenkette
(gmaps) Google Maps URL | Nein | **wird noch nicht verwendet** | URL
(lat) Breitengrad | Nein | **wird noch nicht verwendet** | 
(long) Längengrad | Nein | **wird noch nicht verwendet** | 
(note) | Nein | Interne Notiz | Text
(published) | Ja | Veröffentlichen | Ja / Nein

## Mannschaft

### Beziehungen

### Felder

### Zuordnung zwischen Mannschaft und Spielort(en)

### Zuordnung zwischen Mannschaft und Spieler(n)
Ein Spieler ist eine **Person** die einer Mannschaft für einen bestimmten Zeitraum zugeordnet ist.

#### Felder

### Zuordnung zwischen Mannschaft und Ansprechpartner(n)
Eine **Person** kann außerdem als Ansprechpartner einer Mannschaft zugeordnet sein. 

#### Felder

## Person
Die Repräsentation einer realen Person. Eine Person existiert nur einmal, kann aber Spieler und Ansprechpartner bei beliebig vielen Mannschaften und zugleich Schiedsrichter sein. 

### Beziehungen
- Eine Person kann beliebig viele Spieler sein
- Eine Person kann beliebig viele Ansprechpartner sein
- Eine Person kann ein Schiedsrichter sein
- Eine Person kann einer "echten" Mannschaft als Vereinsspieler zugeordnet sein
- Eine Person kann als Vereinsspieler einer "offiziellen" Spielklasse zugeordnet sein

### Felder

## Schiedsrichter


### Beziehungen
- Ein Schiedsrichter ist genau einer Person zugeordnet.
- Ein Schiedsrichter kann beliebig vielen Paarungen zugeordnet werden. 

### Felder
Bezeichnung | Muss-Feld? | Bedeutung | Werte
--- | --- | --- | ---
(person_id) Person | Ja | Die echte Person | Auswählen 
(mail) E-Mail | Nein | Wird in der Schiri-Liste auf der Info-Seite angezeigt | Zeichenkette
(mobile) Mobilnr. | Nein | Wird in der Schiri-Liste auf der Info-Seite angezeigt | Zeichenkette
Notiz | Nein | | Text

## Position
Wird noch nicht verwendet. 

### Beziehungen

### Felder

