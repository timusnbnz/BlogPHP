# BlogPHP

## Zugriff auf den Blog
- Bitte zuerst Docker Desktop (Siehe Installation) installieren
- Die Docker-compose.yml startet Webserver, PHP, Datenbank & PHPMyAdmin
- Dazu `docker-compose up --build` ausführen
- Webserver: [localhost:80](http://localhost:80)
- PhpMyAdmin: [localhost:8090](http://localhost:8090)
- Datenbank (per PHP): [localhost:3306](http://localhost:3306)

## Zum Projekt beitragen
- Bitte haltet euch an die Regeln, sonst wird es eine Katastrophe
- Die Datenbank und Logs werden nicht in Github hochgeladen
- Die Tabellen der Datenbank werden beim ersten Start erstellt
- Bitte nutzt TailwindCSS, damit brauchen wir keine .css Dateien und haben bessere Optik
- Für TailwindCSS fügt das hier in `<head></head>` auf jeder Seite ein: `<script src="https://cdn.tailwindcss.com"></script>`
- Fragt ChatGPT wie man es benutzt

### Aufgaben/Issues und Projects
- Unter dem Reiter von unserem Repo auf Github findet ihr `Projects`
- Dort werden Aufgaben erstellt und zugeteilt
- Diese sind mit einem Issue unter dem Reiter `Issues` verknüpft
- In dem Issue stehen Details zur Umsetzung
- Steht noch nichts dort, schreibt selbst rein wie ihr euch das vorstellt

### Programmieren
- Damit es kein Chaos gibt, MÜSST ihr sogenannte Branches erstellen
- In VSCode unten links steht `main`, das ist der Haupt-Branch
- UNTER KEINEN UMSTÄNDEN SACHEN IN MAIN ÄNDERN
- Wenn ihr eine Aufgabe beginnt, bspw. Suchleiste, klickt unten auf den Branch, bspw. `Main`
- Danach sollte ganz oben in der Suchleiste von VSCode verschiedene optionen angezeigt werden
- Wählt hier `create new branch` und benennt diesen nach eurer Aufgabe, bspw. `suchleiste`
- Wenn ihr diesen erstellt und in diesen gewechselt seid, so sollte unten links `suchleiste` stehen
- Nun arbeitet ihr in einer abgespaltenen Version von unserem Code und könnt hier euere Aufgabe umsetzen
- Wenn ihr fertig seid könnt ihr eueren branch in den main branch mergen -> Schreibt Tim bitte

## Ersteinrichtung

### Installation der Programme auf MacOS
Ihr benötigt folgende Programme für MacOS:
- Brew -> Im Terminal eingeben: `/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"`
- Git -> NACH BREW! im Terminal eingeben: `brew install git`
- Docker -> NACH BREW! im Terminal eingeben: `brew install docker`
- Visual Studio Code -> [Download](https://code.visualstudio.com/download) 

### Installation der Programme auf Windows
Ihr benötigt folgende Programme für Windows:
- Git -> [Download](https://git-scm.com/downloads/win)
- Visual Studio Code -> [Download](https://code.visualstudio.com/download) 
- Docker Desktop -> [Download](https://www.docker.com/products/docker-desktop/)

### Installation prüfen
Nach dem herunterladen und installieren prüft bitte folgendes:
- Im Terminal `git --version` eingeben
- Zeigt es Version an? -> Gut
- Gibt es einen Fehler? -> Google oder ChatGPT

### Einrichtung Git
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

### Installation der Docker Container
- Wir müssen Docker Container nutzen um den Webserver, PHP, Datenbank & PHPMyAdmin auszuführen
- Dazu in das Projekt navigieren
- Dann `docker-compose up --build` ausführen
- Nun in Docker Desktop prüfen ob die 4 Container laufen
- Beim ersten Start wird eine Datenbank mit richtigen Tabellen angelegt
