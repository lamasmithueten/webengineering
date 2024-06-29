# Anarchy-Forum
Ein Forum, in welchem Nutzer Nachrichten, Bilder & Memes miteinander teilen können. Wie der Name schon verrät, gibt es keine Regeln, um die Nutzer sich frei entfalten zu lassen.
https://github.com/lamasmithueten/webengineering

## Functions
- [x] Registrierung von neuen Usern
- [x] Login mit Userdaten
- [x] Userverwaltung		
- [x] Themenverwaltung
- [x] Beiträge verfassen
- [ ] (Rechteverwaltung)

## Datenbank

Der Zugriff auf die Datenbank wird über eine Datei php/access_database.php ermöglicht. Dort müssen die eigenen Login Credentials eingetragen werden.
Einen SQL-Dump für die Datenbankstruktur finden Sie unter database.sql

## Userverwaltung

Der erste Nutzer, der erstellt wird (Also mit der ID 1 in der Tabelle Accounts in der Datenbank) ist das Administratorkonto. (In diesem Fall gibt es schon zwei Accounts, admin und user, mit dem gewünschten Passwort)
Er hat ein Adminpanel, wo alle User und ihre Emailadressen aufgelistet sind. Dort kann er manuell neue Passwörter vergeben, die Emailadresse abändern oder sogar Accounts löschen.
Weiterhin können Nutzer selbstständig ihr Passwort zurücksetzen, falls sie es vergessen haben. Emailversand via sendmail muss dafür eingerichtet sein.

## Themenverwaltung

Nutzer können ihre eigenen Threads und Kommentare löschen. Weiterhin gibt es eine Suchfunktion, mit der nach Stichwörtern im Titel oder dem Text von Threads gesucht werden kann.
Weiterhin kann der Admin alle Beiträge löschen (Threads und Kommentare)

## Technologies
- PHP
- HTML
- CSS
- JavaScript
- jQuery
- Apache als Webserver (wichtig für die .htaccess-Datei)
- Mariadb als Datenbank

## Demoseite

Unsere Testseite kann auch zu Demozwecken verwendet werden. Nur der Adminzugang ist nicht öffentlich, da die Anmeldeinformationen für diesen Account vertraulich sind.
https://webeng.mwerr.de/

## Contributors
| Name | Matrikel number | Github account |
|------|-----------------|----------------|
| Moritz Werr | 5401527 | lamasmithueten |
| Phil Richter | 4164342 | 2eez4you |
| Lukas Trapp | 1079406 | Biellbo |
