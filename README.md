# BlogPHP

## Zugriff auf den Blog

- Bitte zuerst Docker Desktop (Siehe Installation) installieren
- Die Docker-compose.yml startet Webserver, PHP, Datenbank & PHPMyAdmin
- Dazu `docker-compose up --build` ausführen
- [localhost:80](http://localhost:80) Webserver
- [localhost:8090](http://localhost:8090) PhpMyAdmin
- [localhost:3306](http://localhost:3306) Datenbank (per PHP) Passwort: `fortniteballs`

## Wie ihr zum Projekt beitragt

- Bitte haltet euch an die Regeln, sonst wird es eine Katastrophe
- Die Datenbank und Logs werden nicht in Github hochgeladen
- Die Tabellen der Datenbank werden beim ersten Start erstellt
- Bitte nutzt TailwindCSS, damit brauchen wir keine .css Dateien und haben bessere Optik
- Für TailwindCSS fügt das hier in `<head></head>` auf jeder Seite ein: `<script src="https://cdn.tailwindcss.com"></script>`
- Fragt ChatGPT wie man es benutzt

### Aufgaben, Issues & Projects

- Unter dem Reiter von unserem Repo auf Github findet ihr `Projects`
- Dort werden Aufgaben erstellt und zugeteilt
- Diese sind mit einem Issue unter dem Reiter `Issues` verknüpft
- In dem Issue stehen Details zur Umsetzung
- Steht noch nichts dort, schreibt selbst rein wie ihr euch das vorstellt

### Richtig Programmieren

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

Ihr könnnt alle Programme mit einem Command installieren: `/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)" && brew install git && brew install --cask docker && brew install --cask visual-studio-code`

### Installation der Programme auf Windows

Ihr benötigt folgende Programme für Windows:

- [Download](https://git-scm.com/downloads/win) Git
- [Download](https://code.visualstudio.com/download) Visual Studio Code
- [Download](https://www.docker.com/products/docker-desktop/) Docker Desktop

### Installation prüfen

Nach dem herunterladen und installieren prüft bitte folgendes:

- Im Terminal `git --version` eingeben
- Zeigt es die Version an? Gut
- Gibt es einen Fehler? Google oder ChatGPT

### Einrichtung Git

Nun müssen wir Git einrichten:

- Im Terminal `git config --global user.name "Your Name"` eingeben, setzt in die Anführungszeichen euren Namen ein (Vollständiger Name)
- Im Terminal `git config --global user.email "your.email@example.com"` eingeben, setzt in die Anführungszeichen eure E-Mail ein (Gleiche wie bei GitHub)

### Installation des Repos

- Erstellt einen Ordner für all eure Projekte, bspw. `Coding`
- Öffnet den Ordner ins VSCode
- Klickt auf Terminal oben in der Menüleiste
- Nun solltet ihr in dem erstellen Ordner sein
- Gebt nun `git clone https://github.com/timusnbnz/php-blog.git` ein
- Nun sollte ein `BlogPHP` Ordner erstellt sein

### Installation der Docker Container

- Wir müssen Docker Container nutzen um den Webserver, PHP, Datenbank & PHPMyAdmin auszuführen
- Dazu in das Projekt navigieren
- Dann `docker-compose up --build` ausführen
- Nun in Docker Desktop prüfen ob die 4 Container laufen
- Beim ersten Start wird eine Datenbank mit richtigen Tabellen angelegt
