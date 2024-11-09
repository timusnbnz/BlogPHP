# BlogPHP

## Beitragen
Wir brauchen diese Regeln sonst wird es absolut katastrophal

### Aufgaben/Issues und Projects
- Unter dem Reiter von unserem Repo auf Github findet ihr `Projects`
- Dort werden Aufgaben erstellt und zugeteilt
- Diese sind mit einem Issue unter dem Reiter `Issues` verknüpft
- In dem Issue stehen Details zur Umsetzung
- Steht noch nichts dort, schreibt selbst rein wie ihr euch das vorstellt

### Programmieren
- Damit es kein Chaos wird müsst ihr sogenannte Branches erstellen
- In VSCode unten links steht `main`, das ist der Haupt-Branch
- UNTER KEINEN UMSTÄNDEN SACHEN IN MAIN ÄNDERN
- Wenn ihr eine Aufgabe beginnt, bspw. Suchleiste, klickt unten auf den Branch, bspw. `Main`
- Danach sollte ganz oben in der Suchleiste von VSCode verschiedene optionen angezeigt werden
- Wählt hier `create new branch` und benennt diesen nach eurer Aufgabe, bspw. `suchleiste`
- Wenn ihr diesen erstellt und in diesen gewechselt seid, so sollte unten links `suchleiste` stehen
- Nun arbeitet ihr in einer abgespaltenen Version von unserem Code und könnt hier euere Aufgabe umsetzen
- Wenn ihr fertig seid könnt ihr eueren branch in den main branch mergen -> Schreibt Tim bitte

## Einrichtung
MacOS Tutorial für David & Johnny
### Installation der Programme
Ihr benötigt folgende Programme:
- Brew -> Im Terminal eingeben: `/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"`
- Git -> NACH BREW! im Terminal eingeben: `brew install git`
- Visual Studio Code -> [Download](https://code.visualstudio.com/download) 

Nach dem herunterladen und installieren prüft bitte folgendes:
- Im Terminal `git --version` eingeben
- Zeigt es Version an? -> Gut
- Gibt es einen Fehler? -> Google oder ChatGPT

Nun müssen wir Git einrichten
- Im Terminal `git config --global user.name "Your Name"` eingeben, setzt in die Anführungszeichen euren Namen ein (Vollständiger Name)
- Im Terminal `git config --global user.email "your.email@example.com"` eingeben, setzt in die Anführungszeichen eure E-Mail ein (Gleiche wie bei GitHub)

### Installation des Repos
- Erstellt einen Ordner für all eure Projekte, bspw. `Coding`
- Öffnet VSCode
- Öffnet den Ordner ins VSCode
- Klickt auf Terminal oben in der Menüleiste
- Nun solltet ihr in dem erstellen Ordner sein
- Gebt nun `git clone https://github.com/timusnbnz/BlogPHP.git` ein
- Nun sollte ein `BlogPHP` Ordner erstellt sein
